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
                <div class="card-header">Data Perusahaan</div>

                <div class="card-body">
                       <div class="container">
            <h2><button class="btn btn-primary btn-sm" style="color: white;" data-toggle="modal" data-target="#modalAddCompanies">Tambah Data Perusahaan</button></h2>
            
            @php
                $msg = Session::get('msg')
            @endphp
             @if($msg)
            <div class="alert alert-{{ $msg['code'] }}" role="alert">
                 {{ $msg['message'] }}
            </div>
             @endif 
            <table class="table table-bordered" id="companies">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>website</th>
                     <th>Logo</th>
                    <th>action</th>
                  </tr>
               </thead>
               <tbody>
                @foreach($companies as $key =>  $dt)
               
            <tr>
               <td>{{ $companies->firstItem() + $key }}</td>
               <td>{{ $dt->name }}</td>
               <td>{{ $dt->email }}</td>
               <td>{{ $dt->website }}</td>
               <td><img style="max-height: 120px; max-width: 120px;" class="img" src="{{ url('/diplay_image/'.str_replace('.','-',$dt->logo)) }}"/></td>
               <td style="text-align: center; color: white;"><a class="btn btn-sm btn-success btn-view" data-id="{{ $dt->id_companies }}">Lihat Data</a> <a class="btn btn-sm btn-info btn-up" data-id="{{ $dt->id_companies }}" style="margin-top: 5px;">Perbarui Data</a> <a class="btn btn-sm btn-danger btn-delete" data-id="{{ $dt->id_companies }}" data-name="{{ $dt->name }}" style="margin-top: 5px;">Hapus Data</a></td>
            </tr>
            @endforeach

               </tbody>
            </table>
             {{ $companies->links() }}
         </div>
 
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Modal tambah data perusahaan -->
<div class="modal" tabindex="-1" role="dialog" id="modalAddCompanies">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="fomAddCompanies" method="POST" action="{{ url('crudCompanies/insert') }}" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Perusahaan</label>
      <input type="text" id="name_companies" class="form-control" placeholder="Masukkan Nama Persuahaan" name="name" required="">
    </div>

     <div class="form-group">
      <label>Email Perusahaan</label>
      <input type="email" id="email_companies" class="form-control" placeholder="Masukkan Email Perusahaan" name="email" required="">
    </div>

     <div class="form-group">
      <label>Website Perusahaan</label>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="text" id="website_companies" class="form-control" placeholder="Masukkan website Perusahaan" name="website" required="">
    </div>
    <div class="form-group">
    <label>Logo Perusahaan</label>
    <input type="file" class="form-control-file"  name="logo" id="logo" required="">
  </div>
  <div class="form-group center">
                                
            <img id="logo-preview" style="max-height: 120px; max-width: 120px;" />
                        
    </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary add-companies">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update data perusahaan -->
<div class="modal" tabindex="-1" role="dialog" id="modalupCompanies">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Perbarui Data Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="fomUpCompanies" method="POST" action="{{ url('crudCompanies/update') }}" enctype="multipart/form-data">
    <div class="form-group">
      <label>Nama Perusahaan</label>
      <input type="hidden" name="id_companies" id="id_companies_up">
      <input type="text" class="form-control" placeholder="Masukkan Nama Persuahaan" name="name" id="up_name" required="">
    </div>

     <div class="form-group">
      <label>Email Perusahaan</label>
      <input type="email" class="form-control" placeholder="Masukkan EMail Perusahaan" name="email" id="up_email" required="">
    </div>

     <div class="form-group">
      <label>Website Perusahaan</label>
      <input type="text" class="form-control" placeholder="Masukkan website Perusahaan" name="website" id="up_web" required="">
    </div>
    <div class="form-group">
    <label>Logo Perusahaan</label>
    <input type="hidden" name="status_up_logo" id="status_up_logo" value="false">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="file" class="form-control-file"  name="logo" id="logo-up" required="">
  </div>
  <div class="form-group center">
                                
            <img id="logo-preview-up" style="max-height: 120; max-width: 120;" />
                        
    </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary up-companies">Simpan</button>
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
        <h4 class="modal-title">Detail Perusahaan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>


      <div class="modal-body">
          <table class="table">
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td id="view_name_company"></td>
                </tr>
                <tr>
                    <td>email Perusahaan</td>
                    <td>:</td>
                    <td id="view_email_company"></td>
                </tr>
                <tr>
                    <td>web Perusahaan</td>
                    <td>:</td>
                    <td id="view_web_company"></td>
                </tr>
                <tr>
                    <td>Logo Perusahaan</td>
                    <td>:</td>
                    <td><img  id="view_logo_company" style="max-width: 120px; max-height: 120px;" ></td>
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
        $('.add-companies').on('click', function()
        {
            $('#fomAddCompanies').submit();
        });


        // jquery for preview imagge add

          function previewLogo(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) 
                {
                    $('#logo-preview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
          }


           function previewLogoUp(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) 
                {
                    $('#logo-preview-up').attr('src', e.target.result);
                    $('#status_up_logo').val('true');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
          }

        $("#logo").change(function(){ 
            previewLogo(this);
        });

        $("#logo-up").change(function(){ 
            previewLogoUp(this);
        });

        // javascript/jquery for delete data

        $('.btn-delete').on('click', function()
        {
              let id   = $(this).data('id');
              let name = $(this).data('name');
              let baseUrl  = '{{ url('/') }}';
              let token    = '{{ csrf_token() }}';

              let con = confirm("Apakah anda yakin ingin menghapus data perusahaan "+ name +" ?");

              if(con)
              {
                  $.ajax({
                        url      : baseUrl +'/crudCompanies/delete',
                        type     : 'POST',
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
                  url       : baseUrl +'/crudCompanies/get',
                  type      : 'get',
                  dataType  : 'JSON',
                  data      : {id:id,_token:token}, 
                   success  : function(resp)
                  {
                                if(resp.success == 'true')
                                {
                                   $('#view_name_company').html(resp.data[0].name);
                                   $('#view_email_company').html(resp.data[0].email);
                                   $('#view_web_company').html(resp.data[0].website);
                                   let logo = resp.data[0].logo.replace('.','-');
                                   $('#view_logo_company').attr('src',baseUrl+'/diplay_image/'+logo);

                                   $('#viewModal').modal('show');
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


        // javascript/jquery view update data

        $('.btn-up').on('click', function(){
              let id = $(this).data('id');
              let baseUrl  = '{{ url('/') }}';
              let token    = '{{ csrf_token() }}';

              $.ajax({
                  url       : baseUrl +'/crudCompanies/get',
                  type      : 'get',
                  dataType  : 'JSON',
                  data      : {id:id,_token:token}, 
                   success  : function(resp)
                  {
                                if(resp.success == 'true')
                                {
                                   $('#up_name').val(resp.data[0].name);
                                   $('#up_email').val(resp.data[0].email);
                                   $('#up_web').val(resp.data[0].website);
                                   $('#id_companies_up').val(resp.data[0].id_companies);
                                   let logo = resp.data[0].logo.replace('.','-');
                                   $('#logo-preview-up').attr('src',baseUrl+'/diplay_image/'+logo);

                                   $('#modalupCompanies').modal('show');
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


        // javascript/jquery submit update data

        $('.up-companies').on('click', function()
        {
            $('#fomUpCompanies').submit();
        });

    });
</script>