<?php

namespace App\Http\Controllers\MenuSekolah;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DataTables;

class KalenderAkademikController extends Controller
{
  public function index(){
    $menu_sekolah = Session::get('menu_sekolah');
    return view('SiswaModul.Sekolah.data-tahun-ajaran')->with('menu_sekolah' , $menu_sekolah);
  }
}
