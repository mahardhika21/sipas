@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <article class="card-group-item">
        <header class="card-header"><h6 class="title">Menu </h6></header>
        <div class="filter-content">
            <div class="list-group list-group-flush">
               <a href="{{ url('home')}}" class="btn btn-info" style="color: white;">Beranda  </a>
              <a href="{{ url('companies')}}" class="btn btn-info" style="margin-top: 5px; color: white;">Data Persuahaan  </a>
              <a href="{{ url('employees')}}" class=" btn btn-info" style="margin-top: 5px; color: white;">Data Kariawan  </a>
            
            </div>  <!-- list-group .// -->
        </div>
    </article>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! welcome {{Auth::user()->name}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
