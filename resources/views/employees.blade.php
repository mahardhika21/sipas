@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card">
                <article class="card-group-item">
        <header class="card-header"><h6 class="title">Menu </h6></header>
        <div class="filter-content">
            <div class="list-group list-group-flush">
               <a href="{{ url('home')}}" class="btn btn-info" style="color: white;">Beranda  </a>
              <a href="{{ url('companies')}}" class="btn btn-info" style="margin-top: 5px; color: white;">Data Persuahaan  </a>
              <a href="{{ url('employees')}}" class=" btn btn-info" style="margin-top: 5px; color: white;">Data Karyawan  </a>
            
            </div>  <!-- list-group .// -->
        </div>
    </article>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Data Karyawan</div>

                <div class="card-body">
                       <div class="container">
            <h2><button class="btn btn-primary btn-sm" style="color: white;" data-toggle="modal" data-target="#modalAddEmployess">Tambah Data Karyawan</button></h2>
             @php
                $msg = Session::get('msg')
            @endphp
             @if($msg)
            <div class="alert alert-{{ $msg['code'] }}" role="alert">
                 {{ $msg['message'] }}
            </div>
             @endif 
            <table class="table table-bordered" id="employees">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Perusahaan</th>
                    <th>action</th>
                  </tr>
               </thead>
               <tbody>
                @foreach($employees as $key => $dt)
            <tr>
               <td>{{ $employees->firstItem() + $key }}</td>
               <td>{{ $dt->name }}</td>
               <td>{{ $dt->email }}</td>
               <td>{{ $dt->company_name }}</td>
              
               <td style="text-align: center; color: white;"><a class="btn btn-sm btn-success btn-view" data-id="{{ $dt->id_employees }}">Lihat Data</a> <a class="btn btn-sm btn-info btn-up" data-id="{{ $dt->id_employees }}">Perbarui Data</a> <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $dt->id_employees }}" data-name="{{ $dt->name }}" style="margin-top: 5px;">Hapus Data</a></td>
            </tr>
            @endforeach

               </tbody>
            </table>
             {{ $employees->links() }}
         </div>
 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Modal tambah data karyawan -->
<div class="modal" tabindex="-1" role="dialog" id="modalAddEmployess">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="fomAddEmployees" method="POST" action="{{ url('crudEmployees/insert') }}">
    <div class="form-group">
      <label>Nama Karyawan</label>
      <input type="text" id="name_emp" class="form-control" placeholder="Masukkan Nama karyawan" name="name" required="">
    </div>

     <div class="form-group">
      <label>Email Karyawan</label>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="email" id="email_emp" class="form-control" placeholder="Masukkan Email karyawan" name="email" required="">
    </div>

     <div class="form-group">
      <label>Perusahaan </label>
      <select class="form-control " name="company">
          @foreach($companies as $data)
          <option value="{{ $data->id_companies }}" >{{ $data->name }}</option>
          @endforeach
      </select>
    </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add-employees">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update data perusahaan -->
<div class="modal" tabindex="-1" role="dialog" id="modalUpEmployees">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Perbarui Data Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="fomUpEmployees" method="POST" action="{{ url('crudEmployees/update') }}">
    <div class="form-group">
      <label>Nama Karyawan</label>
      <input type="hidden" name="id_employees" id="id_emp_up">
      <input type="text" id="name_emp_up" class="form-control" placeholder="Masukkan Nama karyawan" name="name" required="">
    </div>

     <div class="form-group">
      <label>Email Karyawn</label>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="email" id="email_emp_up" class="form-control" placeholder="Masukkan Email karyawan" name="email" required="">
    </div>

    <div class="form-group">
    <label>Perusahaan Karyawan</label>
    <select class="form-control " name="company">
       
          <option value="" id="comp_emp"></option>
          @foreach($companies as $data)
          <option value="{{ $data->id_companies }}" >{{ $data->name }}</option>
          @endforeach
      </select>
     </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary up-emp">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<!--  Modal view data-->
<div class="modal" id="viewModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title">Detail Karywan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>


      <div class="modal-body">
          <table class="table">
                <tr>
                    <td>Nama karyawan</td>
                    <td>:</td>
                    <td id="view_name_emp"></td>
                </tr>
                <tr>
                    <td>email karyawan</td>
                    <td>:</td>
                    <td id="view_email_emp"></td>
                </tr>
                <tr>
                    <td>nama Perusahaan</td>
                    <td>:</td>
                    <td id="view_name_company"></td>
                </tr>
          </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
 <script src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript">
     $(document).ready(function()
    {

        // btn submit add data companies
        $('.add-employees').on('click', function()
        {
            $('#fomAddEmployees').submit();
        });


         // javascript/jquery for delete data

        $('.btn-delete').on('click', function()
        {
              let id   = $(this).data('id');
              let name = $(this).data('name');
              let baseUrl  = '{{ url('/') }}';
              let token    = '{{ csrf_token() }}';

              let con = confirm("Apakah anda yakin ingin menghapus data karyawan "+ name +" ?");

              if(con)
              {
                  $.ajax({
                        url      : baseUrl +'/crudEmployees/delete',
                        type     : 'DELETE',
                        dataType : 'JSON',
                        data     : {id:id,_token:token},
                        success  : function(resp)
                        {
                                if(resp.success == 'true')
                                {
                                    alert(resp.message);
                                    window.location.reload();
                                }
                                else
                                {
                                    alert(resp.message);
                                }

                        }, error : function()
                        {
                                alert('proses gagal, priksa jaringan anda');
                        }
                  });
              }
        });


        // javascript/jquery view data

        $('.btn-view').on('click', function(){
              let id = $(this).data('id');
              let baseUrl  = '{{ url('/') }}';
              let token    = '{{ csrf_token() }}';

              $.ajax({
                  url       : baseUrl +'/crudEmployees/get',
                  type      : 'get',
                  dataType  : 'JSON',
                  data      : {id:id,_token:token}, 
                   success  : function(resp)
                  {
                                if(resp.success == 'true')
                                {
                                   $('#view_name_emp').html(resp.data[0].name);
                                   $('#view_email_emp').html(resp.data[0].email);
                                   $('#view_name_company').html(resp.data[0].company_name);
                                   
                                   $('#viewModal').modal('show');

                                   console.log(resp);
                                }
                                else
                                {
                                    alert(resp.message);
                                }

                        }, error : function()
                        {
                                alert('proses gagal, priksa jaringan anda');
                        }
              });
        });


         // javascript/jquery get  data for update

        $('.btn-up').on('click', function(){
              let id = $(this).data('id');
              let baseUrl  = '{{ url('/') }}';
              let token    = '{{ csrf_token() }}';

              $.ajax({
                  url       : baseUrl +'/crudEmployees/get',
                  type      : 'get',
                  dataType  : 'JSON',
                  data      : {id:id,_token:token}, 
                   success  : function(resp)
                  {
                                if(resp.success == 'true')
                                {
                                   $('#id_emp_up').val(resp.data[0].id_employees);
                                   $('#name_emp_up').val(resp.data[0].name);
                                   $('#email_emp_up').val(resp.data[0].email);
                                   $('#comp_emp').val(resp.data[0].company);
                                   $('#comp_emp').html(resp.data[0].company_name);
                                   $('#modalUpEmployees').modal('show');

                                   console.log(resp);
                                }
                                else
                                {
                                    alert(resp.message);
                                }

                        }, error : function()
                        {
                                alert('proses gagal, priksa jaringan anda');
                        }
              });
        });

     // javascript update 
     $('.up-emp').on('click', function()
     {
        $('#fomUpEmployees').submit();
     });

        

    });
</script>