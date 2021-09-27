<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailCodeMailable;
use Illuminate\Support\Facades\Mail;

class IdentifyController extends Controller
{

    public function index(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            return redirect()->to('admin');
        } else {
            return view('auth.identify');
        }
    }

    public function valid(Request $request)
    {
        $user = DB::selectOne('SELECT * FROM Persona WHERE CIP = ?', [
            $request->cip,
        ]);
        if ($user !== null) {
            if ($user->Clave === null || $user->Clave === "") {
                return response()->json([
                    'estatus' => 2,
                    'message' => "Usted tiene que crear una cuenta para continuar por favor."
                ]);
            } else {
                try {
                    DB::beginTransaction();
                    $random = rand(1000, 9999);
                    $time = 10;

                    DB::insert('INSERT INTO Token(Codigo,Fecha,Hora,Tiempo)VALUES(?,CAST(GETDATE() AS DATE),CAST(GETDATE() AS TIME),?)', [
                        $random,
                        $time
                    ]);

                    $email = DB::selectOne('SELECT TOP 1 Direccion FROM Web WHERE idDNI = ?', [
                        $user->idDNI
                    ]);

                    if ($email->Direccion !== null) {
                        $send = new EmailCodeMailable($random);
                        Mail::to($email->Direccion)->send($send);
                    }

                    DB::commit();
                    $idToken = DB::getPdo()->lastInsertId();

                    return response()->json([
                        'estatus' => 1,
                        'message' => "Se generó el código de verificación.",
                        'user' => $user,
                        'token' => $idToken
                    ]);
                } catch (\PDOException $ex) {
                    DB::rollBack();
                    return response()->json([
                        'estatus' => 0,
                        'message' => "33",
                    ]);
                }
            }
        } else {
            return response()->json([
                'estatus' => 0,
                'message' => "Detectamos que usted no se encuentra registrado.",
            ]);
        }
    }


    public function code(Request $request)
    {
        try {
            $user = DB::selectOne('SELECT * FROM 
            Token 
            WHERE 
            Codigo = ? 
            AND Fecha = CAST(GETDATE() AS DATE) 
            AND DATEADD(MINUTE, 10, Hora) >= CAST(GETDATE() AS TIME) 
            AND IdToken = ?', [
                $request->code,
                $request->idToken
            ]);
            if ($user !== null) {
                return response()->json([
                    'estatus' => 1,
                    'message' => "El código se valido correctamente.",
                ]);
            } else {
                return response()->json([
                    'estatus' => 0,
                    'message' => "El código no existe o ha expirado.",
                ]);
            }
        } catch (\PDOException $ex) {
            return response()->json([
                'estatus' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        }
    }

    public function save(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::update('UPDATE Persona SET Clave = ? WHERE idDNI = ?', [
                Hash::make($request->password),
                $request->idDNI
            ]);
            DB::commit();
            return response()->json([
                'estatus' => 1,
                'message' => "Se guardo correctamente su contraseña, ahora puede ingresar al sistema usando su n° cip y su clave.",
            ]);
        } catch (\PDOException $ex) {
            DB::rollBack();
            return response()->json([
                'estatus' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        }
    }
}
