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
        return view('SiswaModul.dashboard')->with('menu_siswa' , $menu_siswa)->with('form_siswa' , $form_siswa);
      }else {
        $menu_admin = Session::get('menu_admin');
        $form_admin = Session::get('form_admin');
        return view('SiswaModul.dashboard')->with('menu_admin' , $menu_admin)->with('form_admin' , $form_admin);
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

  public function register(){
    return view('SiswaModul.register');
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
                Session::put('url',$detail['success']['url_photo']);
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
                Session::put('url' , $detail['success']['url_photo']);
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
          $form_siswa = Session::get('form_siswa');
          return view('SiswaModul.my-profile' , [ 'data' => $data ])->with('menu_siswa' , $menu_siswa)->with('form_siswa' , $form_siswa);
        }else {
          $menu_admin = Session::get('menu_admin');
          $form_admin = Session::get('form_admin');
          return view('SiswaModul.my-profile' , [ 'data' => $data  ])->with('menu_admin' , $menu_admin)->with('form_admin' , $form_admin);
        }

      }

  }

  public function updateProfile($id,Request $request)
  {

    $file = $request->file('photo');
    $filename = $file->getClientOriginalName();
    $file->move(public_path('/') ,  $filename);

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
                  'contents' => fopen(public_path($filename), 'r')
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
        File::delete($filename);
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
    $client = new Client();

    try {

      $response = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/register',[
          'form_params' => [
              'name' => $request->input('name'),
              'email' => $request->input('email'),
              'password' => $request->input('password'),
              'url_photo' => $url_default,
              'confirm_password' => $request->input('confirm_password')
          ]
      ]);

    } catch (ClientException  $e) {
      echo "<script>alert('Terjadi Kesalahan Saat Register')</script>";
      return view('SiswaModul.login');
    }


    if ($response->getStatusCode() == 200) {
      return view('SiswaModul.login');
    }

  }

}
