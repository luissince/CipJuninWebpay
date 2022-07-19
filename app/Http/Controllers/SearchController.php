<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;
use DateTime;


class SearchController extends Controller
{

    public function index()
    {
        return view('auth.search');
    }

    public function data(Request $request)
    {
        try {

            $text = $request->text;

            $cmdPersona = DB::selectOne("SELECT 
            p.idDNI, 
            p.NumDoc,
            p.Nombres, 
            p.Apellidos, 
            p.CIP, 
            CASE p.Condicion
            WHEN 'T' THEN 'Transeunte'
            WHEN 'F' THEN 'Fallecido'
            WHEN 'R' THEN 'Retirado'
            WHEN 'V' THEN 'Vitalicio'
            ELSE 'Ordinario' END AS Condicion, 
            CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
            ELSE 'No Habilitado' END AS Habilidad
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE 
            p.CIP = ?
            OR
            p.Apellidos LIKE concat('%', ?,'%')", [
                $text,
                $text
            ]);

            if ($cmdPersona !== null) {
                $idDNI = $cmdPersona->idDNI;

                $cmdColegiatura = DB::select("SELECT 
                ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo, 
                UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
                convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
                c.Principal 
                FROM Colegiatura  AS c
                LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                WHERE c.idDNI = ?
                ORDER BY c.FechaColegiado ASC", [$idDNI]);

                return response()->json([
                    'status' => 1,
                    'person' => $cmdPersona,
                    'colegiatura' => $cmdColegiatura
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => "Datos no encontrados."
                ]);
            }
        } catch (Exception $ex) {
            return response()->json([
                'status' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos."
            ]);
        }
    }
}
