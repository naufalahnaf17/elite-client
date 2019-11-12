@extends('SiswaModul.Umum.master')

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

  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>

  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

  <script type="text/javascript">
  Highcharts.chart('container', {

  chart: {
      type: 'column'
  },

  title: {
      text: 'Dashboard Grafik Data'
  },

  xAxis: {
      categories: ['Jumlah Data']
  },

  yAxis: {
      allowDecimals: true,
      min: 0,
      title: {
          text: 'Data Yang Ada'
      }
  },

  plotOptions: {
      column: {
          stacking: 'normal'
      }
  },

  series: [{
      name: 'Siswa',
      data: [ {{ $jumlahSiswa }}],
      stack: 'male'
    },{
        name: 'Tagihan',
        data: [0],
        stack: 'tagihan'
    },{
        name: 'Pembayaran',
        data: [0],
        stack: 'pembayaran'
    }]
});
  </script>

@endsection
