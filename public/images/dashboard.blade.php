@extends('SiswaModul.master')

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
          <p class="card-text"></p>
          <a href="{{url('/data-siswa')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
    <div id="kartu" class="col-sm-4">
      <div id="card-satu" class="card bg-success">
        <div class="card-body justify-content-center">
          <center><h4 class="card-text">Tagihan</h4>
          <img id="cuk" src="{{url('/images/notebook.png')}}"><br><br>
          <p class="card-text"></p>
          <a href="{{url('/data-tagihan')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
    <div id="kartu" class="col-sm-4">
      <div id="card-satu" class="card bg-danger">
        <div class="card-body justify-content-center">
          <center><h4 class="card-text">Pembayaran</h4>
          <img id="cuk" src="{{url('/images/money.png')}}"><br><br>
          <p class="card-text"></p>
          <a href="{{url('/data-pembayaran')}}" class="btn btn-primary">Lihat Detail</a></center>
        </div>
      </div>
    </div>
  </div>
  <!-- Akhir Card -->

@endsection
