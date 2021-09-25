<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('LoginSession')) {
            return view('admin.admin');
        } else {
            return redirect()->to('login');
        }
    }
}
