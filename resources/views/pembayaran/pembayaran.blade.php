@extends('layout.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title' , 'Pembayaran | Siswa')

@section('container')

<div class="row mt-3" id="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pembayaran
                <button type="button" id="btn-tambah-siswa" class="btn btn-info ml-2" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah</button>
                </h4>
                <h6 class="card-subtitle">Tabel Data Pembayaran</h6>
                <hr>
            </div>
        </div>
    </div>
</div>

@endsection
