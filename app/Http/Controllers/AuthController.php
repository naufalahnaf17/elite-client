<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DataTables;
use Illuminate\Support\Facades\File;

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
      return view('SiswaModul.Umum.login');
    }

    return Datatables::of($siswa)
    ->addColumn('action', function($siswa){
    return '<a style="color:#fff;" onclick="editForm('. $siswa['nis'] .')" class="btn btn-primary btn-xs"><i class="fa fa-pencil-alt"></i></a> ' .
           '<a style="color:#fff;" onclick="deleteData('. $siswa['nis'] .')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
    })->make(true);

    }

  public function index(){
    if(!Session::get('login')){
        return redirect('login')->with('alert','Kamu harus login dulu');
    }
    else{

      if (Session::get('menu_siswa')) {
        $menu_siswa = Session::get('menu_siswa');
        return view('SiswaModul.Umum.dashboard')->with('menu_siswa' , $menu_siswa);
      }else if(Session::get('menu_admin')) {
        $menu_admin = Session::get('menu_admin');
        return view('SiswaModul.Umum.dashboard')->with('menu_admin' , $menu_admin);
      }else {
        $menu_sekolah = Session::get('menu_sekolah');
        return view('SiswaModul.Umum.dashboard')->with('menu_sekolah' , $menu_sekolah);
      }

    }

  }

  public function login(){
    if (!Session::get('login')) {
      return view('SiswaModul.Umum.login');
    }else {
      return view('SiswaModul.Umum.siswa');
    }
  }

  public function register(){
    return view('SiswaModul.Umum.register');
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
      return view('SiswaModul.Umum.login');
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
            return view('SiswaModul.Umum.login');
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
                return view('SiswaModul.Umum.login');
              }

              if ($cari_menu->getStatusCode() == 200 ) { // 200 OK
                $response_menu = $cari_menu->getBody()->getContents();
                $menu_siswa = json_decode($response_menu,true);

                Session::put('api_token',$data["success"]["token"]);
                Session::put('menu_siswa',$menu_siswa);
                Session::put('nama' , $detail['success']['name']);
                Session::put('url',$detail['success']['url_photo']);
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
                return view('SiswaModul.Umum.login');
              }

              if ($cari_menu->getStatusCode() == 200) { // 200 OK
                $response_menu = $cari_menu->getBody()->getContents();
                $menu_admin = json_decode($response_menu,true);

                Session::put('api_token',$data["success"]["token"]);
                Session::put('menu_admin',$menu_admin);
                Session::put('nama' , $detail['success']['name']);
                Session::put('url' , $detail['success']['url_photo']);
                Session::put('login',TRUE);
                return redirect('/');
              }

            }

            if ($kode_menu === 'SEKOLAH') {
              try {

                $sekolah_form = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/menu/'.$kode_menu,[
                  'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                  ]
                ]);

              } catch (ClientException  $e) {
                echo "<script>alert('Terjadi Kesalahan')</script>";
                return view('SiswaModul.Umum.login');
              }


              if ($sekolah_form->getStatusCode() == 200) { // 200 OK
                $res_menu = $sekolah_form->getBody()->getContents();
                $menu_sekolah = json_decode($res_menu,true);

                Session::put('api_token',$data["success"]["token"]);
                Session::put('menu_sekolah',$menu_sekolah);
                Session::put('nama' , $detail['success']['name']);
                Session::put('url' , $detail['success']['url_photo']);
                Session::put('login',TRUE);
                return redirect('/');
              }

            }

            // Akhir Mencari Data Menu
          }
          // If Focus

        }else{
            return view('SiswaModul.Umum.login');
        }
    }else{
        return view('SiswaModul.Umum.login');
    }

  }

  public function logout(){
    Session::flush();
    return redirect('login')->with('alert','Kamu sudah logout');
  }

  public function myprofile(){

    $client = new Client;

      try {

        $response_details = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/details',[
          'headers' => [
              'Authorization' => 'Bearer '.Session::get('api_token'),
              'Accept'     => 'application/json',
          ]
        ]);

      } catch (ClientException  $e) {
        echo "<script>alert('Terjadi Kesalahan Saat Mengambil Pofile Anda')</script>";
        return redirect('/');
      }

      // If Focus
      if ($response_details->getStatusCode() == 200) {
        $data_detail = $response_details->getBody()->getContents();
        $detail = json_decode($data_detail,true);
        $data = $detail['success'];

        if (Session::get('menu_siswa')) {
          $menu_siswa = Session::get('menu_siswa');
          return view('SiswaModul.Umum.my-profile' , [ 'data' => $data ])->with('menu_siswa' , $menu_siswa);
        }else if(Session::get('menu_admin')) {
          $menu_admin = Session::get('menu_admin');
          return view('SiswaModul.Umum.my-profile' , [ 'data' => $data  ])->with('menu_admin' , $menu_admin);
        }else {
          $menu_sekolah = Session::get('menu_sekolah');
          return view('SiswaModul.Umum.my-profile' , [ 'data' => $data  ])->with('menu_sekolah' , $menu_sekolah);
        }

      }

  }

  public function updateProfile($id,Request $request)
  {

    $file = $request->file('photo');
    $filename = $file->getClientOriginalName();
    $file->move(public_path('/upload') ,  $filename);

    $client = new Client();

    try {

      $response = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/file/upload',[

        'headers' => [
              'Authorization' => 'Bearer ' . Session::get('api_token'),
          ],
          'multipart' => [
              [
                  'Content-type' => 'multipart/form-data',
                  'name' => 'photo',
                  'contents' => fopen(public_path('upload/' . $filename), 'r')
              ]
          ]

      ]);

    } catch (ClientException  $e) {
      echo "<script>alert('Email Atau Password Salah')</script>";
      return view('login');
    }

    if ($response->getStatusCode() == 200) { // 200 OK
        $response_data = $response->getBody()->getContents();

        $data = json_decode($response_data,true);
        File::delete(public_path('upload/' . $filename));
        $url_photo = $data['url'];

        try {

          $response_edit = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/details/' . $id,[
              'form_params' => [
                  'url_photo' => $url_photo
              ],
              'headers' => [
                  'Authorization' => 'Bearer '. Session::get('api_token'),
                  'Accept'     => 'application/json',
              ]
          ]);

        } catch (ClientException  $e) {
          echo "<script>alert('Terjadi Kesalahan')</script>";
        }

        if ($response_edit->getStatusCode() == 200) {
          Session::flush();
          return redirect('login')->with('alert','Kamu sudah logout');
        }

      }else {
        Session::flush();
        return redirect('login')->with('alert','Kamu sudah logout');
      }

  }

  public function register_store(Request $request)
  {

    $url_default = 'http://laravel.simkug.com/siswa-api/public/api/file/download/SbBdWLLpQ5.png';
    $kode_menu = 'SISWA';
    $client = new Client();

    try {

      $response = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/register',[
          'form_params' => [
              'name' => $request->input('name'),
              'email' => $request->input('email'),
              'password' => $request->input('password'),
              'url_photo' => $url_default,
              'kode_menu' => $kode_menu,
              'confirm_password' => $request->input('confirm_password')
          ]
      ]);

    } catch (ClientException  $e) {
      echo "<script>alert('Terjadi Kesalahan Saat Register')</script>";
      return view('SiswaModul.Umum.login');
    }


    if ($response->getStatusCode() == 200) {
      return view('SiswaModul.Umum.login');
    }

  }

}
