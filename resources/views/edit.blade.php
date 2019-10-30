@extends('layout.master')

@section('title' , 'Edit Siswa')

@section('judul-content')
<h3>Edit Data Siswa</h3>
@endsection


@section('container')

<!-- Awal Form -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ url('/edit_store/' . $siswa['id']) }}" method="post">
                    <button type="submit" class="btn btn-primary float-right ml-2">Save</button>
                    <a href="{{ url('/') }}" class='btn btn-warning float-right' type='button'>Cancel</a>
                    <h4 class="card-title">Form Input Data Siswa</h4>
                    @csrf
                    @method('put')
                    <div class="form-group mt-5 row">
                        <label for="nama" class="col-2 col-form-label">Nama</label>
                        <div class="col-10">
                            <input class="form-control" name="nama" type="text" value="{{ $siswa['nama'] }}" id="nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jurusan" class="col-2 col-form-label">Jurusan</label>
                        <div class="col-10">
                          <select name="jurusan" class="custom-select col-12" id="jurusan">
                            <option selected="" disabled>{{ $siswa['jurusan'] }}</option>
                            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                            <option value="Teknik Audio Video">Teknik Audio Video</option>
                          </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Akhir Form -->

@endsection
