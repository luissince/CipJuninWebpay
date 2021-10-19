<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use PDOException;
use DateTime;


class InformationController extends Controller
{

    public function index()
    {
        return view('auth.information');
    }
}
