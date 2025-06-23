<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeSiswaController extends Controller
{
    public function index(){
        return view("siswa.home"  );
    }
}
