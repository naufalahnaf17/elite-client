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
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <center>
            <h4>Siswa</h4>
            <hr>
            <h6>{{ $jumlahSiswa }} </h6>
          </center>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <center>
            <h4>Tagihan</h4>
            <hr>
            <h6>0 </h6>
          </center>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-body">
          <center>
            <h4>Pembayaran</h4>
            <hr>
            <h6>0 </h6>
          </center>
        </div>
      </div>
    </div>
    </div>

  <!-- Akhir card -->

  <h3 class="mt-3">Grafik Dashboard Admin </h3>
  <div id="siswaChart" style="height: 200px;padding:10px;background-color:#fff"></div>

  <script type="text/javascript">
    Morris.Bar({
    element: 'siswaChart',
    data: [
    { y: 'Siswa', a: {{$jumlahSiswa }} },
    { y: 'Tagihan', a: 0 },
    { y: 'Pembayaran', a: 0 }
    ],
    xkey: 'y',
    ykeys: ['a'],
    labels: ['Jumlah']
    });
  </script>

@endsection
