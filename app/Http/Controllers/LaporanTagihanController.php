<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DataTables;

class LaporanTagihanController extends Controller
{
  public function index(){
    if (Session::get('menu_siswa')) {
      $menu_siswa = Session::get('menu_siswa');
      return view('SiswaModul.Umum.laporan-tagihan')->with('menu_siswa' , $menu_siswa);
    }else {
      $menu_admin = Session::get('menu_admin');
      return view('SiswaModul.Umum.laporan-tagihan')->with('menu_admin' , $menu_admin);
    }
  }
}
