@extends('Tender.layouts.master')
@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Project</a></li>
                    <li class="breadcrumb-item"><a href="#">Customers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Customer</li>
                </ul>
            </nav>
        </div>
        <div class="iq-card">
          <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">          
              <h5 class="card-title">Daftar Customer</h5>  
            </div>
            {{-- <div class="d-flex justify-content-center">
              <button class="btn btn-primary">Excel</button>
            </div> --}}
          </div>          
            <div class="iq-card-body">
              {{-- <p>Daftar Customer dari PT SSB</p> --}}
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th>Customer Id</th>
                    <th>Customer</th>
                    <th>Alamat</th>
                    <th>Nama Kontak Person</th>
                    <th>Nomor Kontak (HP)</th>                    
                  </tr>
                </thead>
                <tbody>
                    @foreach($customer as $key => $value)
                  <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->customer_name }}</td>
                    <td>{{ $value->customer_address }}</td>
                    <td>{{ $value->contact_person_name }}</td>
                    <td>{{ $value->contact_person_number }}</td>                    
                  </tr>                  
                  @endforeach
                </tbody>
              </table>            
          </div>
        </div>      
    </div>
</div>
@endsection