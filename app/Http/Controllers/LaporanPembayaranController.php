<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DataTables;

class LaporanPembayaranController extends Controller
{
  public function index(){
    if (Session::get('menu_siswa')) {
      $menu_siswa = Session::get('menu_siswa');
      $form_siswa = Session::get('form_siswa');
      return view('laporan-pembayaran.laporan-pembayaran')->with('menu_siswa' , $menu_siswa)->with('form_siswa' , $form_siswa);
    }else {
      $menu_admin = Session::get('menu_admin');
      $form_admin = Session::get('form_admin');
      return view('laporan-pembayaran.laporan-pembayaran')->with('menu_admin' , $menu_admin)->with('form_admin' , $form_admin);
    }
  }
}
