@extends('SiswaModul.Umum.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title' , 'Data Laporan Pembayaran | Siswa')

@section('container')

<div class="row mt-3" id="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Laporan Pembayaran
                <button type="button" id="btn-tambah-siswa" class="btn btn-info ml-2" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah</button>
                </h4>
                <h6 class="card-subtitle">Tabel Data Laporan Pembayaran</h6>
                <hr>
            </div>
        </div>
    </div>
</div>

@endsection
