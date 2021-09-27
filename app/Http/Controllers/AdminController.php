<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Illuminate\Support\Facades\DB;
use DateTime;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('LoginSession')) {

            $mes = 0;
            $yearCurrentView = "";
            $monthCurrentView = "";

            $session = $request->session()->get('LoginSession');

            $persona = DB::selectOne("SELECT 
            p.idDNI,
            p.Nombres,
            p.Apellidos,
            p.CIP ,
            e.Especialidad,
            ca.Capitulo,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion,
            CAST(ISNULL(uc.FechaUltimaCuota,C.FechaColegiado) AS DATE) AS FechaUltimaCuota,
            CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota,C.FechaColegiado)) AS DATE) AS HabilitadoHasta,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota, C.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 1
            ELSE 0 END AS Habilidad,
            DATEDIFF(YEAR,GETDATE(),DATEADD(MONTH,c.MesAumento,DATEADD(YEAR,30,c.FechaColegiado))) CumplirTreinta
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

            $montodeuda = 0;

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

                                foreach ($cmdConceptos as $rowc) {
                                    $montodeuda += floatval($rowc->Precio);
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

                                foreach ($cmdConceptos as $rowc) {
                                    $montodeuda += floatval($rowc->Precio);
                                }
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return view('admin.admin', ["persona" => $persona, "deuda" => $montodeuda]);
        } else {
            return view('welcome');
        }
    }
}
