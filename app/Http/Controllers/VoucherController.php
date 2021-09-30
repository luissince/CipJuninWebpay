<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;
use DateTime;

class VoucherController extends Controller
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

            return view('admin.voucher', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function invoice(Request $request)
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

            return view('admin.invoice', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function invoiceall(Request $request)
    {
        try {
            $session = $request->session()->get('LoginSession');

            $opcion = $request->opcion;
            $buscar = $request->buscar;
            $fechaInicio = $request->fechaInicio;
            $fechaFinal = $request->fechaFinal;
            $posicionPagina = $request->posicionPagina;
            $filasPorPagina = $request->filasPorPagina;


            $arrayIngresos = array();

            $cmdConcepto = DB::select("SELECT 
            i.idIngreso,
            convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,
            i.Hora,
            CASE 
            WHEN NOT u.idUsuario IS NULL THEN CONCAT(UPPER(u.Nombres),', ', UPPER(u.Apellidos)) 
            ELSE 'USUARIO LIBRE' END AS Usuario,
            CASE
            WHEN NOT r.Nombre IS NULL THEN r.Nombre 
            ELSE 'NO ROL' END AS Rol,
            tc.Nombre AS Comprobante,
            i.Serie, 
            i.NumRecibo,
            i.Estado,
            p.CIP,
            i.Tipo,
            isnull(i.NumOperacion,'') AS NumOperacion,    
            isnull(b.Nombre,'') as BancoName,        
            CASE 
            WHEN NOT e.IdEmpresa IS NULL THEN 'RUC' 
            ELSE 'DNI' END AS NombreDocumento,
            isnull(e.NumeroRuc,p.NumDoc) AS NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ', p.Nombres)) AS Persona,
            sum(d.Monto) AS Total
            FROM Ingreso AS i 
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante
            LEFT JOIN Persona AS p ON i.idDNI = p.idDNI
            LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN Detalle AS d ON d.idIngreso = i.idIngreso
            LEFT JOIN Usuario AS u ON u.idUsuario = i.idUsuario
            LEFT JOIN Rol AS r ON r.idRol = u.Rol
            LEFT JOIN Banco AS b ON b.idBanco = i.idBanco
            WHERE
            p.idDNI = ? AND i.Estado = 'C'
            AND
            (
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND i.Serie like CONCAT(?,'%')
            OR
            $opcion = 1 AND i.NumRecibo like CONCAT(?,'%')
            OR
            $opcion = 1 AND CONCAT(i.Serie,'-',i.NumRecibo) like CONCAT(?,'%')
            )
            GROUP BY 
            i.idIngreso,
            u.idUsuario,
            u.Nombres, 
            u.Apellidos,
            i.Fecha,
            i.Hora,
            i.Serie,
            i.NumRecibo,
            i.Estado,
            p.CIP,
            i.Tipo,
            i.NumOperacion,
            b.Nombre,
            p.NumDoc,
            p.Apellidos,
            r.Nombre, 
            p.Nombres,
            e.NumeroRuc,
            e.Nombre,
            i.Xmlsunat,
            i.Xmldescripcion,
            e.IdEmpresa,
            tc.Nombre
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only", [
                $session->idDNI,

                $fechaInicio,
                $fechaFinal,

                $buscar,
                $buscar,
                $buscar,

                $posicionPagina,
                $filasPorPagina
            ]);
            $count = 0;

            foreach ($cmdConcepto as $row) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row->idIngreso,
                    "fecha" => $row->Fecha,
                    "hora" => $row->Hora,
                    "usuario" => $row->Usuario,
                    "rol" => $row->Rol,
                    "comprobante" => $row->Comprobante,
                    "serie" => $row->Serie,
                    "numRecibo" => $row->NumRecibo,
                    "estado" => $row->Estado,
                    "cip" => $row->CIP,
                    "tipo" => $row->Tipo,
                    "numOperacion" => $row->NumOperacion,
                    "bancoName" => $row->BancoName,
                    "nombreDocumento" => $row->NombreDocumento,
                    "numeroDocumento" => $row->NumeroDocumento,
                    "persona" => $row->Persona,
                    "total" => $row->Total,
                ));
            }

            $comandoTotal = DB::selectOne("SELECT COUNT(*) AS Total 
            FROM Ingreso AS i 
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante
            LEFT JOIN Persona AS p ON i.idDNI = p.idDNI
            LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            LEFT JOIN Usuario AS u ON u.idUsuario = i.idUsuario
            LEFT JOIN Rol AS r ON r.idRol = u.Rol
            WHERE
            p.idDNI = ? AND i.Estado = 'C'
            AND
            (
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND i.Serie like CONCAT(?,'%')
            OR
            $opcion = 1 AND i.NumRecibo like CONCAT(?,'%')
            OR
            $opcion = 1 AND CONCAT(i.Serie,'-',i.NumRecibo) like CONCAT(?,'%')
            )
            ", [
                $session->idDNI,

                $fechaInicio,
                $fechaFinal,

                $buscar,
                $buscar,
                $buscar,

                $posicionPagina,
                $filasPorPagina
            ]);
            $resultTotal =  $comandoTotal->Total;

            return response()->json([
                "status" => 1,
                "data" => $arrayIngresos,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => 0,
                "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        } catch (PDOException $ex) {
            return response()->json([
                "status" => 0,
                "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        }
    }

    public function certhabilidad(Request $request)
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

            return view('admin.certhabilidad', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function certhabilidadall(Request $request)
    {
        try {
            $session = $request->session()->get('LoginSession');

            $opcion = $request->opcion;
            $buscar = $request->buscar;
            $fechaInicio = $request->fechaInicio;
            $fechaFinal = $request->fechaFinal;
            $posicionPagina = $request->posicionPagina;
            $filasPorPagina = $request->filasPorPagina;

            $arrayCertHabilidad = array();
            $cmdCertHabilidad = DB::select("SELECT 
            p.NumDoc, 
            p.Nombres,
            p.Apellidos,
			p.CIP,
            e.Especialidad, 
            ch.Numero, 
            ch.Asunto, 
            ch.Entidad, 
            ch.Lugar, 
            convert(VARCHAR, CAST(ch.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(ch.HastaFecha AS DATE),103) AS HastaFecha, 
            ch.idIngreso,ch.Anulado AS Estado 
            FROM CERTHabilidad AS ch
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = ch.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            WHERE
            p.idDNI = ? AND i.Estado = 'C'
            AND
            (
                $opcion = 0 AND i.Fecha BETWEEN ? AND ?
                OR
                $opcion = 1 AND ch.Numero LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Asunto LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Entidad LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Lugar LIKE CONCAT(?,'%')
            )
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only", [
                $session->idDNI,

                $fechaInicio,
                $fechaFinal,

                $buscar,
                $buscar,
                $buscar,
                $buscar,

                $posicionPagina,
                $filasPorPagina
            ]);
            $count = 0;

            foreach ($cmdCertHabilidad as $row) {
                $count++;
                array_push($arrayCertHabilidad, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row->idIngreso,
                    "dni" => $row->NumDoc,
                    "usuario" => $row->Nombres,
                    "apellidos" => $row->Apellidos,
                    "numeroCip" => $row->CIP,
                    "especialidad" => $row->Especialidad,
                    "numCertificado" => $row->Numero,
                    "asunto" => $row->Asunto,
                    "entidad" => $row->Entidad,
                    "lugar" => $row->Lugar,
                    "fechaPago" => $row->Fecha,
                    "fechaVencimiento" => $row->HastaFecha,
                    "estado" => $row->Estado == 0
                ));
            }

            $comandoTotal = DB::selectOne("SELECT COUNT(*) AS Total FROM CERTHabilidad AS ch
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = ch.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            WHERE
            p.idDNI = ? AND i.Estado = 'C'
            AND
            (
                $opcion = 0 AND i.Fecha BETWEEN ? AND ?
                OR
                $opcion = 1 AND ch.Numero LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Asunto LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Entidad LIKE CONCAT(?,'%')
                OR
                $opcion = 1 AND ch.Lugar LIKE CONCAT(?,'%')
            )", [
                $session->idDNI,

                $fechaInicio,
                $fechaFinal,

                $buscar,
                $buscar,
                $buscar,
                $buscar,
            ]);
            $resultTotal = $comandoTotal->Total;

            return response()->json([
                "status" => 1,
                "data" => $arrayCertHabilidad,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            return response()->json([
                "status" => 0,
                "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        } catch (PDOException $ex) {
            return response()->json([
                "status" => 0,
                "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        }
    }

    public function certobra(Request $request)
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

            return view('admin.certobra', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function certproyecto(Request $request)
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

            return view('admin.certproyecto', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }
}
