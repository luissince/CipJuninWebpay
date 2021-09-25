<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function create(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            return redirect()->to('admin');
        } else {
            return view('auth.register');
        }
    }

    public function data()
    {
        $persona = DB::select('SELECT * FROM users');
        return json_encode($persona);
        // return view('auth.register', ['data' => $persona]);
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = DB::insert('INSERT INTO users(name,email ,password) VALUES(?,?,?)', [
                $request->name,
                $request->email,
                Hash::make($request->password)
            ]);
            DB::commit();
            return "OK";
        } catch (\PDOException $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
