<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\ClientException;
use Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      if (Session::get('menu_siswa')) {
        $menu_siswa = Session::get('menu_siswa');
        $form_siswa = Session::get('form_siswa');
        return view('SiswaModul.siswa.siswa')->with('menu_siswa' , $menu_siswa)->with('form_siswa' , $form_siswa);
      }else {
        $menu_admin = Session::get('menu_admin');
        $form_admin = Session::get('form_admin');
        return view('SiswaModul.siswa.siswa')->with('menu_admin' , $menu_admin)->with('form_admin' , $form_admin);
      }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $input = $request->all();

      $validator = Validator::make($input, [
          'nama' => 'required',
          'jurusan' => 'required'
      ]);

      if ($validator->fails()) {
          $error = $validator->errors();
          return redirect('/')->with('kesalahan' , $error);
      }

      $client = new Client();

      try {

        $response = $client->request('POST', 'http://laravel.simkug.com/siswa-api/public/api/siswa',[
            'form_params' => [
                'nama' => $request->nama,
                'jurusan' => $request->jurusan
            ],
            'headers' => [
                'Authorization' => 'Bearer '. Session::get('api_token'),
                'Accept'     => 'application/json',
            ]
        ]);

      } catch (ClientException  $e) {
        echo "<script>alert('Terjadi Kesalahan')</script>";
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = new Client();
        try {

          $response = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/siswa/'.$id,[
              'headers' => [
                  'Authorization' => 'Bearer '.Session::get('api_token'),
                  'Accept'     => 'application/json',
              ]
          ]);

          if ($response->getStatusCode() == 200) { // 200 OK
              $response_data = $response->getBody()->getContents();
              $data = json_decode($response_data,true);
          }

        }catch (ClientException $e) {
          echo "<script>alert('Terjadi Kesalahan')</script>";
        }

        return $data['value'][0];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $client = new Client();

      try {

        $response = $client->request('PUT', 'http://laravel.simkug.com/siswa-api/public/api/siswa/'.$id,[
            'form_params' => [
                'nama' => $request->nama,
                'jurusan' => $request->jurusan
            ],
            'headers' => [
                'Authorization' => 'Bearer '. Session::get('api_token'),
                'Accept'     => 'application/json',
            ]
        ]);

      } catch (ClientException  $e) {
        echo "<script>alert('Terjadi Kesalahan')</script>";
      }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $client = new Client();
      try {

        $response = $client->request('DELETE', 'http://laravel.simkug.com/siswa-api/public/api/siswa/'.$id,[
          'headers' => [
              'Authorization' => 'Bearer '. Session::get('api_token'),
              'Accept'     => 'application/json',
          ]
        ]);

      } catch (ClientException  $e) {
        echo "<script>alert('Terjadi Kesalahan')</script>";
      }

    }

    public function json(){

      $email = 'naufalahnaf37@gmail.com';
      $pass = 'naufalahnaf123';

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
      }


      if ($response->getStatusCode() == 200) { // 200 OK
          $response_data = $response->getBody()->getContents();

          $data = json_decode($response_data,true);
          $token = $data['success']['token'];
          Session::put('api_token',$data["success"]["token"]);
          try {

            $response = $client->request('GET', 'http://laravel.simkug.com/siswa-api/public/api/siswa',[
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Accept'     => 'application/json',
                ]
            ]);

            if ($response->getStatusCode() == 200) { // 200 OK
                $response_data = $response->getBody()->getContents();

                $data = json_decode($response_data,true);
                $siswa = $data['value'];
                return Datatables::of($siswa)
                ->addColumn('action', function($siswa){
                return '<a style="color:#fff;" onclick="editForm('. $siswa['id'] .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                       '<a style="color:#fff;" onclick="deleteData('. $siswa['id'] .')" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                })->make(true);

            }

          }catch (ClientException $e) {
            echo "<script>alert('Terjadi Kesalahan')</script>";
          }

      }

    }
}
