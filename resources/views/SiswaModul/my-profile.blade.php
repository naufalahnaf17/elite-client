@extends('SiswaModul.master')

<?php

$client = new \GuzzleHttp\Client;
$id = $data['id'];
$nama = $data['name'];
$email = $data['email'];
$jabatan = $data['kode_menu'];

    if ($data['url_photo'] === '') {
      echo "<script> console.log('tidak ada gambar') </script>";
    }else {

      try {

        $response_detail = $client->request('GET', $data['url_photo'],[
          'headers' => [
            'Authorization' => 'Bearer '.Session::get('api_token'),
            'Accept'     => 'application/json',
          ]
        ]);

      } catch (ClientException  $e) {
        echo "<script>alert('Email Atau Password Salah')</script>";
        return view('login');
      }

      if ($response_detail->getStatusCode() == 200) { // 200 OK
        $data = $response_detail->getBody()->getContents();
        $photo = 'data:image/png;base64,' . base64_encode($data);
        Session::put('ada' , 'ada');
      }

    }

?>

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title' , 'Akun Saya')

@section('container')

<div class="row mt-3" id="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <form  action="{{ url('update-profile/' . $id) }}" method="post" enctype="multipart/form-data">
                @csrf
              <h4 class="card-title">Data Akun
              <button type="submit" name="submit" id="btn-tambah-siswa" class="btn btn-info ml-2" style="float:right;"> Simpan Profile</button>
              </h4>
              <hr>
                <ul>

                  <?php if (Session::get('ada')): ?>
                    <img src="{{ $photo }}" alt="Profile Image" style="width:150px;">
                  <?php else: ?>
                    <img src="{{ url('/asset_elite/images/users/1.jpg') }}" alt="Profile Image" style="width:150px;">
                  <?php endif; ?>

                    <input type="file" name="photo"></input>

                  <li class="mt-2"> Nama : {{ $nama }} </li>
                  <li class="mt-2"> Email : {{ $email }} </li>
                  <li class="mt-2"> Jabatan : {{ $jabatan }} </li>

                </ul>
              </div>
            </form>
        </div>
    </div>
</div>

@endsection
