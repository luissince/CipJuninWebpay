<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;
// use DateTime;

class JobsController extends Controller
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

            return view('admin.jobs', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function alljobs(Request $request)
    {
        try {

            $text = $request->buscar;
            $opcion = $request->opcion;
            $posicionPagina = $request->posicionPagina;
            $filasPorPagina = $request->filasPorPagina;

            $arrayEmpleo = array();

            $jobs = DB::select("SELECT 
                idEmpleo, 
                Titulo,
                Descripcion,
                Empresa,
                Celular, 
                Telefono,
                Correo,
                Direccion,
                convert(VARCHAR, CAST(Fecha AS DATE),103) AS Fecha,
                Hora, 
                Estado, 
                Tipo 
                FROM Empleo
                WHERE
                0 = ? AND Estado = 1
                OR
                1 = ? AND Titulo like concat('%', ?,'%') AND Estado = 1
                OR
                1 = ? AND Descripcion like concat('%', ?,'%') AND Estado = 1
                order by Fecha desc, Hora desc
                offset ? rows fetch next ? rows only", [
                $opcion,
                $opcion,
                $text,
                $opcion,
                $text,
                $posicionPagina,
                $filasPorPagina
            ]);

            $count = 0;

            foreach ($jobs as $row) {
                $count++;
                array_push($arrayEmpleo, array(
                    "id" => $count + $posicionPagina,
                    "idEmpleo" => $row->idEmpleo,
                    "Titulo" => $row->Titulo,
                    "Descripcion" => $row->Descripcion,
                    "Empresa" => $row->Empresa,
                    "Celular" => $row->Celular,
                    "Telefono" => $row->Telefono,
                    "Correo" => $row->Correo,
                    "Direccion" => $row->Direccion,
                    "Fecha" => $row->Fecha,
                    "Hora" => $row->Hora,
                    "Estado" => $row->Estado,
                    "Tipo" => $row->Tipo
                ));
            }

            $comandoTotal = DB::selectOne("SELECT COUNT(*) AS Total FROM Empleo 
                WHERE 
                0 = ? AND Estado = 1
                OR
                1 = ? AND Titulo LIKE concat('%', ?,'%') AND Estado = 1
                OR
                1 = ? AND Descripcion LIKE concat('%', ?,'%') AND Estado = 1", [
                $opcion,
                $opcion,
                $text,
                $opcion,
                $text
            ]);

            $resultTotal =  $comandoTotal->Total;

            return response()->json([
                "empleos" => $arrayEmpleo,
                "total" => $resultTotal
            ],200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ],500);
        } catch (PDOException $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ],500);
        }
    }

    public function dataid(Request $request){
        try {

            $idEmpleo = $request->idEmpleo;

            $empleo = DB::selectOne("SELECT * FROM Empleo WHERE idEmpleo = ?", [$idEmpleo]);

            return response()->json([
                "objet" => $empleo,
            ],200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ],500);
        } catch (PDOException $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ],500);
        }
    }
}
