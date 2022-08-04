<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;
// use DateTime;

class CourseController extends Controller
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

            return view('admin.course', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function allcourses(Request $request)
    {
        try {

            $text = $request->buscar;
            $opcion = $request->opcion;
            $posicionPagina = $request->posicionPagina;
            $filasPorPagina = $request->filasPorPagina;

            $arrayCourse = array();

            $course = DB::select("SELECT 
                c.idCurso,
                c.Nombre, 
                c.Instructor, 
                c.Organizador, 
                c.idCapitulo, 
                cap.Capitulo, 
                c.Modalidad, 
                c.Direccion, 
                CAST(c.FechaInicio AS DATE) AS FechaInicio,
                c.HoraInicio,
                c.PrecioCurso, 
                c.PrecioCertificado, 
                c.Celular, 
                c.Correo,
                c.Descripcion, 
                c.Estado,
                ISNULL(ins.Registro,'') AS Registro
                FROM Curso AS c 
                INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
                LEFT JOIN Inscripcion AS ins ON c.idCurso = ins.idCurso
                WHERE
                0 = ? AND c.Estado = 1
                OR
                1 = ? AND c.Nombre like concat('%', ?,'%') AND c.Estado = 1
                OR
                1 = ? AND cap.Capitulo like concat('%', ?,'%') AND c.Estado = 1
                order by c.FechaInicio desc
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

            foreach ($course as $row) {
                $count++;
                array_push($arrayCourse, array(
                    "id" => $count + $posicionPagina,
                    "idCurso" => $row->idCurso,
                    "Nombre" => $row->Nombre,
                    "Instructor" => $row->Instructor,
                    "Organizador" => $row->Organizador,
                    "idCapitulo" => $row->idCapitulo,
                    "Capitulo" => $row->Capitulo,
                    "Modalidad" => $row->Modalidad,
                    "Direccion" => $row->Direccion,
                    "FechaInicio" => $row->FechaInicio,
                    "HoraInicio" => $row->HoraInicio,
                    "PrecioCurso" => $row->PrecioCurso,
                    "PrecioCertificado" => $row->PrecioCertificado,
                    "Celular" => $row->Celular,
                    "Correo" => $row->Correo,
                    "Descripcion" => $row->Descripcion,
                    "Estado" => $row->Estado,
                    "Registro" => $row->Registro
                ));
            }

            $comandoTotal = DB::selectOne("SELECT COUNT(*) AS Total FROM Curso AS c 
                INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
                LEFT JOIN Inscripcion AS ins ON c.idCurso = ins.idCurso
                WHERE 
                0 = ? AND c.Estado = 1
                OR
                1 = ? AND c.Nombre LIKE concat('%', ?,'%') AND c.Estado = 1
                OR
                1 = ? AND cap.Capitulo like concat('%', ?,'%') AND c.Estado = 1", [
                $opcion,
                $opcion,
                $text,
                $opcion,
                $text
            ]);

            $resultTotal =  $comandoTotal->Total;

            return response()->json([
                "cursos" => $arrayCourse,
                "total" => $resultTotal
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        } catch (PDOException $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        }
    }

    public function dataid(Request $request)
    {
        try {

            $idCurso = $request->idCurso;

            $curso = DB::selectOne("SELECT 
            c.idCurso,
            c.Nombre, 
            c.Instructor, 
            c.Organizador, 
            c.idCapitulo, 
            cap.Capitulo, 
            c.Modalidad, 
            c.Direccion, 
            convert(VARCHAR, CAST(c.FechaInicio AS DATE), 103) AS FechaInicio, 
            c.HoraInicio,
            c.PrecioCurso, 
            c.PrecioCertificado, 
            c.Celular, 
            c.Correo,
            c.Descripcion 
            FROM Curso AS c INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
            WHERE c.idCurso = ?", [$idCurso]);

            return response()->json([
                "objet" => $curso,
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        } catch (PDOException $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        }
    }

    public function addinscription(Request $request)
    {
        try {
            DB::beginTransaction();

            $idCurso = $request->idCurso;
            $idParticipante = $request->idParticipante;

            $isRegistered = DB::selectOne("SELECT idCurso, idParticipante FROM Inscripcion WHERE idCurso = ? AND idParticipante = ?", [$idCurso, $idParticipante]);

            if ($isRegistered !== null) {
                DB::rollback();
                return response()->json([
                    'status' => 2,
                    'message' => "Usted ya se encuentra registro en el curso."
                ]);
            } else {
                DB::insert("INSERT INTO Inscripcion (
                idCurso, 
                idParticipante, 
                Fecha, 
                Hora, 
                Registro, 
                Estado, 
                idUsuario)
                VALUES(?,?,GETDATE(),GETDATE(),?,?,?) ", [$idCurso, $idParticipante, 'CIPVIRTUAL', 1, -1]);

                DB::commit();
                return response()->json([
                    'status' => 1,
                    'message' => "Se registró correctamente al curso."
                ]);
            }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'message' => $ex->getMessage(),
            ]);
        } catch (PDOException $ex) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function mycourses(Request $request)
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

            return view('admin.mycourses', ["persona" => $persona]);
        } else {
            return view('welcome');
        }
    }

    public function allmycourses(Request $request){
        try {

            $text = $request->buscar;
            $opcion = $request->opcion;
            $posicionPagina = $request->posicionPagina;
            $filasPorPagina = $request->filasPorPagina;

            $idParticipante = $request->idParticipante;

            $arrayCourse = array();

            $course = DB::select("SELECT 
                ins.idCurso,
                c.Nombre, 
                c.Instructor, 
                c.Organizador, 
                c.idCapitulo, 
                cap.Capitulo, 
                c.Modalidad, 
                c.Direccion, 
                CONVERT(VARCHAR, CAST(c.FechaInicio AS DATE), 103) AS FechaInicio,
                c.HoraInicio,
                c.PrecioCurso, 
                c.PrecioCertificado, 
                c.Celular, 
                c.Correo,
                c.Descripcion, 
                c.Estado,
                ISNULL(ins.Registro,'') AS Registro
                FROM Inscripcion AS ins 
                INNER JOIN Curso AS c ON ins.idCurso = c.idCurso
                INNER JOIN Persona as p ON ins.idParticipante = p.idDNI
                INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
                WHERE
                0 = ? AND ins.idParticipante = ?
                OR
                1 = ? AND c.Nombre like concat('%', ?,'%') AND ins.idParticipante = ?
                OR
                1 = ? AND cap.Capitulo like concat('%', ?,'%') AND ins.idParticipante = ?
                order by c.FechaInicio desc
                offset ? rows fetch next ? rows only", [
                $opcion,
                $idParticipante,

                $opcion,
                $text,
                $idParticipante,
                
                $opcion,
                $text,
                $idParticipante,

                $posicionPagina,
                $filasPorPagina
            ]);

            $count = 0;

            foreach ($course as $row) {
                $count++;
                array_push($arrayCourse, array(
                    "id" => $count + $posicionPagina,
                    "idCurso" => $row->idCurso,
                    "Nombre" => $row->Nombre,
                    "Instructor" => $row->Instructor,
                    "Organizador" => $row->Organizador,
                    "idCapitulo" => $row->idCapitulo,
                    "Capitulo" => $row->Capitulo,
                    "Modalidad" => $row->Modalidad,
                    "Direccion" => $row->Direccion,
                    "FechaInicio" => $row->FechaInicio,
                    "HoraInicio" => $row->HoraInicio,
                    "PrecioCurso" => $row->PrecioCurso,
                    "PrecioCertificado" => $row->PrecioCertificado,
                    "Celular" => $row->Celular,
                    "Correo" => $row->Correo,
                    "Descripcion" => $row->Descripcion,
                    "Estado" => $row->Estado,
                    "Registro" => $row->Registro
                ));
            }

            $comandoTotal = DB::selectOne("SELECT COUNT(*) AS Total 
                FROM Inscripcion AS ins 
                INNER JOIN Curso AS c ON ins.idCurso = c.idCurso
                INNER JOIN Persona as p ON ins.idParticipante = p.idDNI
                INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
                WHERE
                0 = ? AND ins.idParticipante = ?
                OR
                1 = ? AND c.Nombre like concat('%', ?,'%') AND ins.idParticipante = ?
                OR
                1 = ? AND cap.Capitulo like concat('%', ?,'%') AND ins.idParticipante = ?", [
                $opcion,
                $idParticipante,

                $opcion,
                $text,
                $idParticipante,

                $opcion,
                $text,
                $idParticipante
            ]);

            $resultTotal =  $comandoTotal->Total;

            return response()->json([
                "cursos" => $arrayCourse,
                "total" => $resultTotal
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        } catch (PDOException $ex) {
            return response()->json([
                "message" => "Error de conexión, intente nuevamente en un parte de minutos."
            ], 500);
        }
    }
}
