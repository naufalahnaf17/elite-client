@extends('SiswaModul.master')

<style media="screen">
  img#cuk{
    width: 60px;
  }
</style>

<?php

  $client = new \GuzzleHttp\Client();
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
      $jumlahSiswa = count($siswa);
  }

?>

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title' , 'Dashboard | Siswa')

@section('container')

  <h3 class="mt-3">Dashboard</h3>

  <!-- Awal Card -->
  <div class="row">
    <div id="kartu" class="col-sm-4">
      <div id="card-satu" class="card bg-warning">
        <div class="card-body justify-content-center">
          <center><h4 class="card-text">Siswa</h4>
          <img id="cuk" src="{{url('/images/student.png')}}"><br><br>
          <p class="card-text">{{ $jumlahSiswa }}</p>
          <a href="{{url('/data-siswa')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
    <div id="kartu" class="col-sm-4">
      <div id="card-satu" class="card bg-success">
        <div class="card-body justify-content-center">
          <center><h4 class="card-text">Tagihan</h4>
          <img id="cuk" src="{{url('/images/notebook.png')}}"><br><br>
          <p class="card-text">Belum Ada</p>
          <a href="{{url('/data-tagihan')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
    <div id="kartu" class="col-sm-4">
      <div id="card-satu" class="card bg-danger">
        <div class="card-body justify-content-center">
          <center><h4 class="card-text">Pembayaran</h4>
          <img id="cuk" src="{{url('/images/money.png')}}"><br><br>
          <p class="card-text">Belum Ada</p>
          <a href="{{url('/data-pembayaran')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Card -->

  <h3>Grafik Dashboard Admin </h3>
  <div id="siswaChart" style="height: 200px;"></div>

  <script type="text/javascript">
    Morris.Bar({
    element: 'siswaChart',
    data: [
    { y: 'siswa', a: {{ $jumlahSiswa }} },
    { y: 'tagihan', a: 0 },
    { y: 'pembayaran', a: 0 }
    ],
    xkey: 'y',
    ykeys: ['a'],
    labels: ['Size']
    });
  </script>

@endsection
