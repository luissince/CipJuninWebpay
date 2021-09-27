<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            return redirect()->to('/');
        } else {
            return view('auth.login');
        }
    }

    public function valid(Request $request)
    {
        try {
            $persona = DB::selectOne(
                'SELECT  
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP,
            p.Clave
            FROM Persona AS p
            WHERE p.CIP = ?',
                [$request->cip]
            );
            if ($persona !== null) {
                if (Hash::check($request->password, $persona->Clave)) {
                    $request->session()->put('LoginSession', $persona);
                    return response()->json([
                        'estatus' => 1,
                        'message' => 'Datos correctos',
                    ]);
                } else {
                    return response()->json([
                        'estatus' => '0',
                        'message' => 'Usuario o contraseña incorrectas.',
                    ]);
                }
            } else {
                return response()->json([
                    'estatus' => '0',
                    'message' => 'Usuario o contraseña incorrectas.',
                ]);
            }
        } catch (\PDOException $e) {
            return response()->json([
                'estatus' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            ]);
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            $request->session()->forget('LoginSession');
            return redirect()->to('login');
        } else {
            return redirect()->to('login');
        }
    }
}
