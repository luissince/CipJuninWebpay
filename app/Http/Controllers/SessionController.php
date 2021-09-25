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
            return redirect()->to('admin');
        } else {
            return view('auth.login');
        }
    }

    public function valid(Request $request)
    {
        $persona = DB::selectOne(
            'SELECT  
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP
            FROM Persona AS p
            WHERE p.CIP = ? AND p.CIP = ? OR p.NumDoc = ? AND p.NumDoc = ?',
            [$request->user, $request->password, $request->user, $request->password]
        );
        if (is_object($persona)) {
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
