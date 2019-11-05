<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DataTables;

class AuthController extends Controller
{

  public function json(){

    try {

      $client = new Client();
      $response = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/siswa',[
          'headers' => [
              'Authorization' => 'Bearer '.Session::get('api_token'),
              'Accept'     => 'application/json',
          ]
      ]);


      if ($response->getStatusCode() == 200) { // 200 OK
          $response_data = $response->getBody()->getContents();

          $data = json_decode($response_data,true);
          $siswa = $data['value'];
      }

    } catch (ClientException $e) {
      echo "<script>alert('Session Habis Login Dulu')</script>";
      return view('SiswaModul.login');
    }

    return Datatables::of($siswa)
    ->addColumn('action', function($siswa){
    return '<a style="color:#fff;" onclick="editForm('. $siswa['id'] .')" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i></a> ' .
           '<a style="color:#fff;" onclick="deleteData('. $siswa['id'] .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
    })->make(true);

    }

  public function index(){
    if(!Session::get('login')){
        return redirect('login')->with('alert','Kamu harus login dulu');
    }
    else{

      if (Session::get('menu_siswa')) {
        $menu_siswa = Session::get('menu_siswa');
        $form_siswa = Session::get('form_siswa');
        return view('SiswaModul.siswa')->with('menu_siswa' , $menu_siswa)->with('form_siswa' , $form_siswa);
      }else {
        $menu_admin = Session::get('menu_admin');
        $form_admin = Session::get('form_admin');
        return view('SiswaModul.siswa')->with('menu_admin' , $menu_admin)->with('form_admin' , $form_admin);
      }

    }

  }

  public function login(){
    if (!Session::get('login')) {
      return view('SiswaModul.login');
    }else {
      return view('SiswaModul.siswa');
    }
  }

  public function login_store(Request $request){

    $email = $request->email;
    $pass = $request->password;

    $client = new Client();

    try {

      $response = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/login',[
          'form_params' => [
              'email' => $email,
              'password' => $pass
          ]
      ]);

    } catch (ClientException  $e) {
      echo "<script>alert('Email Atau Password Salah')</script>";
      return view('SiswaModul.login');
    }


    if ($response->getStatusCode() == 200) { // 200 OK
        $response_data = $response->getBody()->getContents();

        $data = json_decode($response_data,true);
        $token = $data["success"]["token"];
        if($token){

          try {

            $response_details = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/details',[
              'headers' => [
                  'Authorization' => 'Bearer '.$token,
                  'Accept'     => 'application/json',
              ]
            ]);

          } catch (ClientException  $e) {
            echo "<script>alert('Email Atau Password Salah')</script>";
            return view('SiswaModul.login');
          }

          // If Focus
          if ($response_details->getStatusCode() == 200) {
            $data_detail = $response_details->getBody()->getContents();
            $detail = json_decode($data_detail,true);
            $kode_menu = $detail['success']['kode_menu'];

            if ($kode_menu === 'SISWA') {
              try {

                $cari_menu = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/menu/'.$kode_menu,[
                  'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                  ]
                ]);

              } catch (ClientException  $e) {
                echo "<script>alert('Terjadi Kesalahan')</script>";
                return view('SiswaModul.login');
              }

              try {

                $cari_form = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/mform/siswa/',[
                  'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                  ]
                ]);

              } catch (ClientException  $e) {
                echo "<script>alert('Terjadi Kesalahan')</script>";
                return view('SiswaModul.login');
              }

              if ($cari_menu->getStatusCode() == 200 && $cari_form->getStatusCode() == 200 ) { // 200 OK
                $response_menu = $cari_menu->getBody()->getContents();
                $reponse_form = $cari_form->getBody()->getContents();
                $menu_siswa = json_decode($response_menu,true);
                $form_siswa = json_decode($reponse_form,true);

                Session::put('api_token',$data["success"]["token"]);
                Session::put('menu_siswa',$menu_siswa);
                Session::put('form_siswa',$form_siswa);
                Session::put('nama' , $detail['success']['name']);
                Session::put('daftar_menu' , $menu_siswa);
                Session::put('login',TRUE);
                return redirect('/');
              }
            }

            if ($kode_menu === 'ADM') {
              try {

                $cari_menu = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/menu/'.$kode_menu,[
                  'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                  ]
                ]);

              } catch (ClientException  $e) {
                echo "<script>alert('Terjadi Kesalahan')</script>";
                return view('SiswaModul.login');
              }

              try {

                $admin_form = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/mform/admin/',[
                  'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                  ]

                ]);

              } catch (ClientException  $e) {
                echo "<script>alert('Terjadi Kesalahan')</script>";
                return view('SiswaModul.login');
              }

              if ($cari_menu->getStatusCode() == 200 && $admin_form->getStatusCode() == 200) { // 200 OK
                $response_menu = $cari_menu->getBody()->getContents();
                $response_admin = $admin_form->getBody()->getContents();
                $menu_admin = json_decode($response_menu,true);
                $form_admin = json_decode($response_admin,true);

                Session::put('api_token',$data["success"]["token"]);
                Session::put('menu_admin',$menu_admin);
                Session::put('form_admin',$form_admin);
                Session::put('nama' , $detail['success']['name']);
                Session::put('daftar_menu' , $menu_admin);
                Session::put('login',TRUE);
                return redirect('/');
              }
            }

            // Akhir Mencari Data Menu
          }
          // If Focus

        }else{
            return view('SiswaModul.login');
        }
    }else{
        return view('SiswaModul.login');
    }

  }

  public function logout(){
    Session::flush();
    return redirect('login')->with('alert','Kamu sudah logout');
  }

  public function cek(){
    return response('anjing');
  }

}
