<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use DateTime;
use PDOException;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            $session = $request->session()->get('LoginSession');

            $persona = DB::selectOne("SELECT 
            p.idDNI,
            p.Nombres,
            p.Apellidos,
            p.CIP ,
            e.Especialidad,
            ca.Capitulo,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca ON ca.idCapitulo = e.idCapitulo
            LEFT OUTER JOIN ULTIMACuota AS uc ON uc.idDNI = p.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $direccion = DB::selectOne("SELECT TOP 1 w.Direccion FROM Persona AS p
            INNER JOIN Web AS w
            ON p.idDNI = w.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $email = "";
            if ($direccion != null) {
                $email = $direccion->Direccion;
            }

            return view('admin.service', ["persona" => $persona, "email" => $email]);
        } else {
            return view('welcome');
        }
    }

    public function cuotas(Request $request)
    {
        try {
            $array = array();

            $mes = $request->mes;
            $yearCurrentView = $request->yearCurrentView;
            $monthCurrentView = $request->monthCurrentView;

            $session = $request->session()->get('LoginSession');

            $persona = DB::selectOne("SELECT 
            p.idDNI,
            p.Nombres,
            p.Apellidos,
            p.CIP ,
            e.Especialidad,
            ca.Capitulo,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca ON ca.idCapitulo = e.idCapitulo
            LEFT OUTER JOIN ULTIMACuota AS uc ON uc.idDNI = p.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $cmdCuota = DB::selectOne("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
            from Persona as p inner join Colegiatura as c
            on p.idDNI = c.idDNI and c.Principal = 1
            left outer join ULTIMACuota as ul
            on p.idDNI = ul.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            if ($persona->Condicion == "ORDINARIO") {
                $condicion =  1;
            } else if ($persona->Condicion == "VITALICIO") {
                $condicion =  3;
            } else {
                $condicion =  0;
            }

            if ($cmdCuota != null) {
                $date = new DateTime($cmdCuota->UltimoPago);
                $date->setDate($date->format("Y"), $date->format("m"), 1);

                $fechaactual = new DateTime('now');
                if ($fechaactual < $date) {
                    $fechaactual = new DateTime($cmdCuota->UltimoPago);
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
                    $fechaactual->modify('+ ' . $mes  . ' month');
                } else {
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
                    $fechaactual->modify('+ ' . $mes  . ' month');
                }

                $cmdAltaColegiado = DB::selectOne("SELECT * FROM Persona AS  p
                INNER JOIN Ingreso AS i ON i.idDNI = p.idDNI
                INNER JOIN Cuota as c on c.idIngreso = i.idIngreso
                WHERE i.idDNI = ? ", [$session->idDNI]);
                if ($cmdAltaColegiado != null) {
                    if ($fechaactual >= $date) {
                        $inicio = $date->modify('+ 1 month');
                        if ($inicio <= $fechaactual) {
                            while ($inicio <= $fechaactual) {
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = DB::select("SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
                                FROM Concepto as co
                                WHERE  Categoria = ? and ? between Inicio and Fin", [
                                    $condicion,
                                    $inicioFormat
                                ]);

                                $arryConcepto = array();
                                foreach ($cmdConceptos as $rowc) {
                                    array_push($arryConcepto, array(
                                        "IdConcepto" => $rowc->idConcepto,
                                        "Categoria" => $rowc->Categoria,
                                        "Concepto" => $rowc->Concepto,
                                        "Precio" => $rowc->Precio,
                                    ));
                                }
                                array_push($array, array(
                                    "day" => $inicio->format('d'),
                                    "mes" => $inicio->format('m'),
                                    "year" => $inicio->format('Y'),
                                    "concepto" => $arryConcepto
                                ));
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                } else {
                    if ($fechaactual >= $date) {
                        $inicio = $date;
                        if ($inicio <= $fechaactual) {

                            while ($inicio <= $fechaactual) {
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = DB::select("SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin", [
                                    $condicion,
                                    $inicioFormat
                                ]);

                                $arryConcepto = array();
                                foreach ($cmdConceptos as $rowc) {
                                    array_push($arryConcepto, array(
                                        "IdConcepto" => $rowc->idConcepto,
                                        "Categoria" => $rowc->Categoria,
                                        "Concepto" => $rowc->Concepto,
                                        "Precio" => $rowc->Precio,
                                    ));
                                }
                                array_push($array, array(
                                    "day" => $inicio->format('d'),
                                    "mes" => $inicio->format('m'),
                                    "year" => $inicio->format('Y'),
                                    "concepto" => $arryConcepto
                                ));
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return response()->json([
                'estatus' => 1,
                'data' => $array,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'estatus' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }

    public function allComprobantes()
    {
        try {
            $array = array();
            $comandoConcepto = DB::select("SELECT * FROM TipoComprobante WHERE Estado = 1 and ComprobanteAfiliado = 2 and Destino = 2");
            foreach ($comandoConcepto as $row) {
                array_push($array, array(
                    "IdTipoComprobante" => $row->IdTipoComprobante,
                    "Nombre" => $row->Nombre,
                    "Predeterminado" => $row->Predeterminado,
                    "UsarRuc" => $row->UsarRuc
                ));
            }
            return response()->json([
                'estatus' => 1,
                'data' => $array,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'estatus' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }

    public function savePay(Request $request)
    {
        try {
            $fechaactual = new DateTime('now');
            $yearinicio = substr($fechaactual->format("Y"), 0, 2);

            $data =  array(
                'card_number' => $request->card_number,
                'cvv' => $request->cvv,
                'expiration_month' => $request->expiration_month,
                'expiration_year' => $yearinicio . $request->expiration_year,
                'email' => $request->email,
            );

            $data_string = json_encode($data);

            $url = "https://secure.culqi.com/v2/tokens";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer pk_test_69979cc0fa24d426'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);

            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_code == 201) {
                $result = (object)json_decode($resp);

                $total = floatval($request->monto) * 100;

                $data =  array(
                    "amount" => $total,
                    "currency_code" => "PEN",
                    "email" => $request->email,
                    "source_id" =>  $result->id
                );

                $data_string = json_encode($data);

                $url = "https://api.culqi.com/v2/charges";

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer sk_test_6d00f5f32b58adea'
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
                //for debug only!
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $resp = curl_exec($curl);

                $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);

                if ($http_code == 201) {
                    try {
                        DB::beginTransaction();

                        $codigoSerieNumeracion = DB::selectOne("SELECT dbo.Fc_Serie_Numero(?)", [
                            $request->idTipoDocumento
                        ]);
                        $serie_numeracion = explode("-", ((array)$codigoSerieNumeracion)[""]);

                        DB::insert("INSERT INTO Ingreso(
                            idDni,
                            idEmpresaPersona,
                            TipoComprobante,
                            Serie,
                            NumRecibo,
                            Fecha,
                            Hora,
                            idUsuario,
                            Estado,
                            Deposito,
                            Observacion,
                            Tipo,
                            idBanco,
                            NumOperacion
                            )VALUES(?,?,?,?,?,GETDATE(),GETDATE(),?,?,0,'',?,?,?)", [
                            $request->idCliente,
                            $request->idEmpresaPersona,
                            $request->idTipoDocumento,
                            $serie_numeracion[0],
                            $serie_numeracion[1],
                            $request->idUsuario,
                            $request->estado,
                            $request->tipo,
                            $request->idBanco,
                            $request->numOperacion
                        ]);

                        $idIngreso = DB::getPdo()->lastInsertId();

                        if ($request->estadoCuotas == true) {
                            DB::insert("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)", [
                                $idIngreso,
                                $request->cuotasInicio,
                                $request->cuotasFin
                            ]);
                        }

                        foreach ($request->ingresos as $value) {
                            DB::insert("INSERT INTO Detalle(
                            idIngreso,
                            idConcepto,
                            Cantidad,
                            Monto
                            )VALUES(?,?,?,?)", [
                                $idIngreso,
                                $value['idConcepto'],
                                $value['cantidad'],
                                $value['monto'],
                            ]);
                        }

                        DB::commit();
                        return response()->json([
                            'estatus' => 1,
                            'message' => "Se registro correctamente el ingreso."
                        ]);
                    } catch (PDOException $ex) {
                        DB::rollback();
                        return response()->json([
                            'estatus' => 0,
                            'message' => $ex->getMessage(),
                        ]);
                    } catch (Exception $ex) {
                        DB::rollback();
                        return response()->json([
                            'estatus' => 0,
                            'message' => $ex->getMessage(),
                        ]);
                    }
                } else {
                    return response()->json([
                        "estado" => 0,
                        "message" => "Error en procesar el pago, intente nuevamente en un par de minutos.",
                    ]);
                }
            } else {
                $result = (object)json_decode($resp);
                return response()->json([
                    "status" => 0,
                    "message" => "Error al crear el token id, intente nuevamente porfavor."
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                "status" => 0,
                "message" => "Error interno",
                "error" => $ex->getMessage(),
            ]);
        }
    }
}
