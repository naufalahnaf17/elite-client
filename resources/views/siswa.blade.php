@extends('layout.master')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<style media="screen">

  img.edit{
    width: 30px;
    position: relative;
  }

  img.btn-delete{
    width: 30px;
  }

  button{
    background-color: Transparent;
    background-repeat:no-repeat;
    border: none;
    cursor:pointer;
    overflow: hidden;
    outline:none;
  }

</style>

@section('title' , 'Dashboard | Siswa')

@section('container')


<?php if (session('berhasil')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-success welcome" role="alert">
    <b class="justify-content-center"> Data Berhasil Di Tambahkan </b>
  </div>
<?php endif; ?>

<?php if (session('gagal')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-warning welcome" role="alert">
    <b class="justify-content-center"> Data Gagal Di Tambahkan </b>
  </div>
<?php endif; ?>

<?php if (session('success')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-success welcome" role="alert">
    <b class="justify-content-center"> Data Berhasil Di Hapus </b>
  </div>
<?php endif; ?>

<?php if (session('fail')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-warning welcome" role="alert">
    <b class="justify-content-center"> Data Gagal Di Hapus </b>
  </div>
<?php endif; ?>

<?php if (session('noe')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-warning welcome" role="alert">
    <b class="justify-content-center"> Data Gagal Di Edit </b>
  </div>
<?php endif; ?>

<?php if (session('e')): ?>
  <div style="width:600px;position:relative;height:50px;" class="alert alert-success welcome" role="alert">
    <b class="justify-content-center"> Data Berhasil Di Edit </b>
  </div>
<?php endif; ?>

    <div class="row mt-3" id="container">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Siswa
                    <button type="button" id="btn-tambah-siswa" class="btn btn-info ml-2" style="float:right;"><i class="fa fa-plus-circle"></i> Tambah</button>
                    </h4>
                    <h6 class="card-subtitle">Tabel Data Siswa</h6>
                    <hr>
                    <div class="table-responsive ">
                        <table id="data-siswa" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id Siswa</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="tambah-siswa">
          <div class="col-sm-12">
              <div class="card">
                  <div class="card-body">
                    <button id="edit-data" type="submit" class="btn btn-primary float-right ml-2">Edit</button>
                    <button id="simpan-data" type="submit" class="btn btn-primary float-right ml-2">Save</button>
                      <form id="formsiswa" class="form" method="post">
                        <button id="cancel" class='btn btn-warning float-right' type='button'>Cancel</button>
                          <h4 class="card-title">Form Input Data Siswa</h4>
                          @csrf
                          @method('POST')
                          <div class="form-group mt-5 row">
                              <label for="nama" class="col-2 col-form-label">Nama</label>
                              <div class="col-10">
                                  <input class="form-control" name="nama" type="text" id="nama">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="jurusan" class="col-2 col-form-label">Jurusan</label>
                              <div class="col-10">
                                <select name="jurusan" class="custom-select col-12" id="jurusan">
                                  <option selected="" disabled>Choose ..</option>
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

    <script type="text/javascript">

    $('#tambah-siswa').hide();
    $('#simpan-data').show();

    $('#data-siswa').DataTable({
        processing: true,
        serverSide: true,
        ajax: 'data',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nama', name: 'nama' },
            { data: 'jurusan', name: 'jurusan' },
            { data: 'action', name: 'action' }
        ]
    });

    $('#btn-tambah-siswa').on('click' , function(){
      $('#container').hide();
      $('#tambah-siswa').show();
      $('#edit-data').hide();
      $('#formsiswa')[0].reset();
    });

    $('#cancel').on('click' , function(){
      save_method = 'add';
      $('#container').show();
      $('#tambah-siswa').hide();
    });

    $('#simpan-data').on('click' , function(){

      $.ajax({
        url : "{{ url('siswa') }}",
        type : "POST" ,
        data : $('#formsiswa').serialize(),
        success : function(){
          $('#container').show();
          $('#tambah-siswa').hide();
          $('#formsiswa')[0].reset();
          $('#data-siswa').DataTable().ajax.reload();
        },
        error : function(){
          console.log('Terjadi Kesalahan');
        }

      });

    });

    function deleteData(id){

      var token = $("meta[name='csrf-token']").attr("content");

      $.ajax({
          url: "siswa/"+id,
          type: 'DELETE',
          data: { "id": id,"_token": token,},
          success: function (){
            $('#data-siswa').DataTable().ajax.reload();
          },
          error : function(){
            console.log('Terjadi Kesalahan');
          }
      });

    }

    function editForm(id){

      $.ajax({
          url: "siswa/"+id+"/"+"edit",
          type: 'GET',
          dataType : 'JSON',
          success: function (data){
            $('#container').hide();
            $('#tambah-siswa').show();
            $('#simpan-data').hide();
            $('#edit-data').show();
            $('#formsiswa')[0].reset();

            $('#nama').val(data.nama);

            $('#edit-data').on('click' , function(){

              $.ajax({
                url : "siswa/"+data.id,
                type : "PUT" ,
                data : $('#formsiswa').serialize(),
                success : function(){
                  $('#container').show();
                  $('#tambah-siswa').hide();
                  $('#formsiswa')[0].reset();
                  $('#data-siswa').DataTable().ajax.reload();
                },
                error : function(){
                  console.log('Terjadi Kesalahan');
                }

              });

            });

          },
          error : function(){
            alert('gagal');
          }
      });

    }


    </script>



@endsection
