<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;

class ProfileController extends Controller
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
            p.CIP,
            p.FechaNac,
            cast(p.FechaNac as date) as FechaNacimiento,
            p.Sexo,
            p.EstadoCivil,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
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

            $telefono = DB::selectOne("SELECT TOP 1 t.Telefono FROM Persona AS p
            INNER JOIN Telefono AS t
            ON p.idDNI = t.idDNI
            WHERE p.idDNI = ?", [
                $session->idDNI
            ]);

            $phone = "";
            if ($telefono != null) {
                $phone = $telefono->Telefono;
            }

            $cmdImage = DB::selectOne("SELECT TOP 1 
                Foto
                FROM PersonaImagen WHERE idDNI = ?", [
                $session->idDNI
            ]);

            $image = "";
            if ($cmdImage != null) {
                $image = 'data:image/(png|jpg|jpeg|gif);base64,' . base64_encode($cmdImage->Foto);
            }

            return view('admin.profile', ["persona" => $persona, "email" => $email, "direccion" =>  $ubicacion, "telefono" => $phone, "image" => $image]);
        } else {
            return view('welcome');
        }
    }

    public function update(Request $request)
    {
        if ($request->session()->has('LoginSession')) {

            try {
                $session = $request->session()->get('LoginSession');

                DB::beginTransaction();

                DB::delete("DELETE FROM Telefono WHERE idDNI = ?", [$session->idDNI]);

                DB::insert("INSERT INTO Telefono(idDNI,Tipo,Telefono) VALUES(?,7,?)", [$session->idDNI, $request->phone]);

                DB::delete("DELETE FROM Direccion WHERE idDNI = ?", [$session->idDNI]);

                DB::insert("INSERT INTO Direccion(idDNI,Tipo,Ubigeo,Direccion)VALUES(?,1,1224,?)", [$session->idDNI, $request->address]);

                DB::delete("DELETE FROM Web WHERE idDNI = ?", [$session->idDNI]);

                DB::insert("INSERT INTO Web(idDNI,Tipo,Direccion)values(?,16,?)", [$session->idDNI, $request->email]);

                DB::update("UPDATE Persona SET Nombres=?, Apellidos=?, NumDoc=?, Sexo=?, FechaNac=? WHERE idDNI=?", [$request->names, $request->lastName, $request->numDoc, $request->sexo, $request->fechaNac, $session->idDNI]);

                DB::commit();
                return response()->json([
                    'status' => 1,
                    'message' => "Sus datos se actualizaron correctamente.",
                ]);
            } catch (Exception $ex) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
                ]);
            } catch (PDOException $ex) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
                ]);
            }
        } else {
            return view('welcome');
        }
    }
}
