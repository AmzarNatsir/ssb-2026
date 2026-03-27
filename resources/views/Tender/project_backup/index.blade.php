@extends('Tender.layouts.master')
@section('content')
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Proyek</a></li>
                    <li class="breadcrumb-item"><a href="#">Manajemen Proyek</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Daftar Project</li>
                </ul>
            </nav>
        </div>
        <div class="iq-card">
          <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">          
              <h5 class="card-title">Daftar Project</h5>  
            </div>
            {{-- <div class="d-flex justify-content-center">
              <button class="btn btn-primary">Create New Project</button>
            </div> --}}
          </div>          
            <div class="iq-card-body">
              {{-- <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam accusamus ab, minima molestias aut eum.</p> --}}
              <form class="form-horizontal" method="POST" action="{{ route('daftar.proyek') }}">
                  {{ csrf_field() }}
                  
                    <div class="form-row">
                      <div class="col-sm-2">
                        <label class="label">Kategori Proyek</label>                      
                        <select name="kategori_proyek" class="form-control form-control-sm">
                            <option value="0">-</option>
                            @foreach ($opsi_kategori_proyek as $item)
                              @if($item->id == old('kategori_proyek'))
                                <option value="{{ $item->id }}" selected>{{ $item->keterangan }}</option>
                              @else
                                <option value="{{ $item->id }}">{{ $item->keterangan }}</option>                              
                              @endif
                            @endforeach
                        </select>                      
                      </div>                      
                      <div class="col-sm-2">
                        <label class="label">Status Proyek</label>                      
                        <select name="status_proyek" class="form-control form-control-sm">
                          <option value="0">-</option>
                          @foreach ($opsi_status_project as $item)
                            <option value="{{ $item->id }}">{{ $item->keterangan }}</option>                              
                          @endforeach
                        </select>                      
                      </div>
                      <div class="col-sm-1">
                          <label class="label">&nbsp;</label>
                        <button class="btn btn-sm btn-block btn-primary">Cari</button>
                      </div>                      
                    </div>
                    <br/>
                  
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th>No Reg</th>
                    <th>Keterangan</th>
                    <th>Sumber Proyek</th>
                    <th>Tanggal Mulai Proyek</th>
                    <th>Tanggal Akhir Proyek</th>
                    <th>Nilai Proyek</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($project as $key => $value)
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $value->registration_no }}</td>
                    <td>{{ $value->project_desc }}</td>
                    <td>{{ $value->customer->customer_name }}</td>
                    <td class="text-justify">{{ date_format(date_create($value->project_start_date), 'd/m/Y') }}</td>
                    <td class="text-justify">{{ date_format(date_create($value->project_end_date), 'd/m/Y') }}</td>                    
                    <td class="text-right">{{ number_format($value->project_value) }}</td>
                    <td>{{ $value->projectStatus->keterangan }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>            
          </div>
        </div>      
    </div>
</div>
@endsection
