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
            p.NumDoc,
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

            $web = DB::selectOne("SELECT TOP 1 w.Direccion FROM Persona AS p
            INNER JOIN Web AS w
            ON p.idDNI = w.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $email = "";
            if ($web != null) {
                $email = $web->Direccion;
            }

            $direccion = DB::selectOne("SELECT TOP 1 d.Direccion FROM Persona AS p
            INNER JOIN Direccion AS d
            ON p.idDNI = d.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $ubicacion = "";
            if ($direccion != null) {
                $ubicacion = $direccion->Direccion;
            }

            $dolar = 0;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.apis.net.pe/v1/tipo-cambio-sunat');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($http_code == 200) {
                $tipoCambioSunat = json_decode($response);
                $dolar =  $tipoCambioSunat->venta;
            }
            return view('admin.service', ["persona" => $persona, "email" => $email, "direccion" => $ubicacion, "dolar" => $dolar]);
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
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado) AS DATE) AS UltimoPago     
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON p.idDNI = ul.idDNI
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

                                if (count($cmdConceptos) != 0) {
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
                                }

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

                                if (count($cmdConceptos) != 0) {
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
                                }

                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return response()->json([
                'status' => 1,
                'data' => $array,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }

    public function certificado(Request $request)
    {
        try {

            $session = $request->session()->get('LoginSession');

            $cmdIngeniero = DB::selectOne("SELECT Condicion FROM Persona WHERE idDNI = ?", [
                $session->idDNI
            ]);
            $resultIngeniero =  $cmdIngeniero;

            if ($resultIngeniero->Condicion == "T") {
                $cmdConcepto = DB::selectOne("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 1");
                $resultConcepto = $cmdConcepto;
                if ($resultConcepto == null) {
                    throw new Exception('No se encontro ningún concepto para obtener.');
                }
            } else {
                $cmdConcepto = DB::selectOne("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 0");
                $resultConcepto = $cmdConcepto;
                if ($resultConcepto == null) {
                    throw new Exception('No se encontro ningún concepto para obtener.');
                }
            }

            $cmdEspecialidad = DB::select("SELECT c.idColegiado, c.idEspecialidad, e.Especialidad FROM Colegiatura AS c 
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?", [
                $session->idDNI
            ]);

            $arrayEspecialidades = array();
            foreach ($cmdEspecialidad as $row) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row->idColegiado,
                    "idEspecialidad" => $row->idEspecialidad,
                    "Especialidad" => $row->Especialidad
                ));
            }

            if (empty($arrayEspecialidades)) {
                throw new Exception('Error en cargar en las espcialidad(es).');
            }

            return response()->json([
                "status" => 1,
                "data" => $resultConcepto,
                "especialidades" => $arrayEspecialidades,
                "tipoColegiado" => $resultIngeniero->Condicion
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }

    public function allComprobantes()
    {
        try {
            $array = array();
            $comandoConcepto = DB::select("SELECT * FROM TipoComprobante 
            WHERE Estado = 1 AND ComprobanteAfiliado = 2 AND (Destino = 1 OR Destino = 3)");
            foreach ($comandoConcepto as $row) {
                array_push($array, array(
                    "IdTipoComprobante" => $row->IdTipoComprobante,
                    "Nombre" => $row->Nombre,
                    "Serie" => $row->Serie,
                    "Predeterminado" => $row->Predeterminado,
                    "UsarRuc" => $row->UsarRuc
                ));
            }
            return response()->json([
                'status' => 1,
                'data' => $array,
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }

    public function savePay(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            try {
                $session = $request->session()->get('LoginSession');

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

                // $headers = array(
                //     'Content-Type: application/json',
                //     'Authorization: Bearer pk_live_1a97fceff3c6af2b'
                // );
                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Bearer pk_test_26dcfdea67bea7fa'
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

                    // $headers = array(
                    //     'Content-Type: application/json',
                    //     'Authorization: Bearer sk_live_a5979cee8160335b'
                    // );
                    $headers = array(
                        'Content-Type: application/json',
                        'Authorization: Bearer sk_test_77dae825c0fe1175'
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

                            $idEmpresa = null;

                            if ($request->empresa != null) {
                                $empresa = DB::selectOne("SELECT * FROM EmpresaPersona WHERE NumeroRuc = ?", [
                                    $request->empresa["numero"]
                                ]);

                                if ($empresa != null) {
                                    $idEmpresa = $empresa->IdEmpresa;
                                } else {
                                    DB::insert("INSERT INTO EmpresaPersona(NumeroRuc,Nombre,Direccion,Telefono,PaginaWeb,Email)VALUES(?,?,?,'','','')", [
                                        $request->empresa["numero"],
                                        $request->empresa["cliente"],
                                        is_null($request->empresa["direccion"]) ? "" : $request->empresa["direccion"],
                                    ]);

                                    $idEmpresa = DB::getPdo()->lastInsertId();
                                }
                            }

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
                                )VALUES(?,?,?,?,?,GETDATE(),GETDATE(),?,?,0,?,?,?,?)", [
                                $session->idDNI,
                                $idEmpresa,
                                $request->idTipoDocumento,
                                $serie_numeracion[0],
                                $serie_numeracion[1],
                                $request->idUsuario,
                                $request->estado,
                                is_null($request->descripcion) ? "" : is_null($request->descripcion),
                                $request->tipo,
                                $request->idBanco,
                                is_null($request->numOperacion) ? "" : $request->numOperacion
                            ]);

                            $idIngreso = DB::getPdo()->lastInsertId();

                            if ($request->estadoCuotas == true) {
                                DB::insert("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)", [
                                    $idIngreso,
                                    $request->cuotasInicio,
                                    $request->cuotasFin
                                ]);
                            }

                            if ($request->estadoCertificadoHabilidad == true) {

                                if ($request->estadoCuotas == true) {
                                    $resultPago = $request->cuotasFin;
                                } else {
                                    $cmdUltimoPago = DB::selectOne("SELECT 
                                    CAST(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado) AS DATE) AS UltimoPago     
                                    FROM Persona AS p INNER JOIN Colegiatura AS c
                                    ON p.idDNI = c.idDNI AND c.Principal = 1
                                    LEFT OUTER JOIN ULTIMACuota AS ul
                                    ON p.idDNI = ul.idDNI
                                    WHERE p.idDNI = ?", [
                                        $session->idDNI
                                    ]);
                                    if ($cmdUltimoPago == null) {
                                        throw new Exception("Erro en obtener la fecha del ultimo pago.");
                                    }
                                    $resultPago = $cmdUltimoPago->UltimoPago;
                                }

                                $cmdIngeniero = DB::selectOne("SELECT Condicion FROM Persona WHERE idDNI = ?", [
                                    $session->idDNI
                                ]);
                                $resultIngeniero =  $cmdIngeniero;

                                $date = new DateTime($resultPago);
                                if ($resultIngeniero->Condicion == "V") {
                                    $date->modify('+9 month');
                                    $date->modify('last day of this month');
                                } else if ($resultIngeniero->Condicion == "T") {
                                    $fechanow = new DateTime('now');
                                    $date =  $fechanow;
                                    $date->modify('+3 month');
                                    $date->modify('last day of this month');
                                } else {
                                    $date->modify('+3 month');
                                    $date->modify('last day of this month');
                                }
                                $ultimoPago = $date->format('Y-m-d');

                                $cmdCorrelativo = DB::selectOne("SELECT * FROM CorrelativoCERT WHERE TipoCert = 1");
                                if ($cmdCorrelativo == null) {
                                    $resultCorrelativo = 1;
                                } else {
                                    $cmdCorrelativo = DB::selectOne("SELECT MAX(Numero)+1 AS 'Numero' FROM CorrelativoCERT WHERE TipoCert = 1");
                                    $resultCorrelativo = $cmdCorrelativo->Numero;
                                }

                                DB::insert("INSERT INTO CERTHabilidad(idIUsuario,idColegiatura,Numero,Asunto,Entidad,Lugar,Fecha,HastaFecha,Anulado,idIngreso) VALUES(?,?,?,?,?,?,GETDATE(),?,?,?)", [
                                    $request->idUsuario,
                                    $request->objectCertificadoHabilidad["idEspecialidad"],
                                    $resultCorrelativo,
                                    $request->objectCertificadoHabilidad["asunto"],
                                    $request->objectCertificadoHabilidad["entidad"],
                                    $request->objectCertificadoHabilidad["lugar"],
                                    $ultimoPago,
                                    $request->objectCertificadoHabilidad["anulado"],
                                    $idIngreso
                                ]);

                                DB::insert("INSERT INTO CorrelativoCERT(TipoCert,Numero) VALUES(1,?)", [
                                    $resultCorrelativo
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
                                'status' => 1,
                                'message' => "Se registro correctamente el pago."
                            ]);
                        } catch (PDOException $ex) {
                            DB::rollback();
                            return response()->json([
                                'status' => 0,
                                'message' => $ex->getMessage(),
                            ]);
                        } catch (Exception $ex) {
                            DB::rollback();
                            return response()->json([
                                'status' => 0,
                                'message' => $ex->getMessage(),
                            ]);
                        }
                    } else {
                        return response()->json([
                            "status" => 0,
                            "message" => ((object)json_decode($resp))->merchant_message
                        ]);
                    }
                } else {
                    return response()->json([
                        "status" => 0,
                        "message" => ((object)json_decode($resp))->merchant_message
                    ]);
                }
            } catch (Exception $ex) {
                return response()->json([
                    "status" => 0,
                    "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
                ]);
            }
        } else {
            return view('welcome');
        }
    }
}
