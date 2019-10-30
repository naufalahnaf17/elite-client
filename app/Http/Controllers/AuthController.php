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
      return view('auth.login');
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
      return view('siswa');
    }

  }

  public function login(){
    return view('auth.login');
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
      return view('auth.login');
    }


    if ($response->getStatusCode() == 200) { // 200 OK
        $response_data = $response->getBody()->getContents();

        $data = json_decode($response_data,true);
        if($data["success"]["token"]){
            Session::put('api_token',$data["success"]["token"]);
            Session::put('login',TRUE);
            return redirect('/');
            // echo $data["success"]["data"]["api_token"];
        }else{
            return view('auth.login');
        }
    }else{
        return view('auth.login');
    }

  }

  public function logout(){
    Session::flush();
    return redirect('login')->with('alert','Kamu sudah logout');
  }

}
