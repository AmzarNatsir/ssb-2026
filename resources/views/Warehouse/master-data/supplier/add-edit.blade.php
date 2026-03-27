@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Tambah Supplier </h4>
              </div>
            </div>
            <div class="iq-card-body">
              <form id="addModalForm" action={{ !isset($supplier) ? route('warehouse.master-data.supplier.store') : route('warehouse.master-data.supplier.update',$supplier->id) }} method="POST" >
                @csrf
                @isset($supplier)
                  @method('PUT')
                @endisset
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12 sm-lg-12">
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input class="form-control" name="name" type="text" id="name" value="{{ isset($supplier) ? $supplier->name : ''  }}" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 sm-lg-6">
                      <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea required class="form-control" name="address" id="address" rows="3">{{ isset($supplier) ? $supplier->address : '' }}</textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="phone">Telepon</label>
                        <input class="form-control" name="phone" type="text" id="phone" value="{{ isset($supplier) ? $supplier->phone : '' }}" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input class="form-control" name="fax" type="text" id="fax" value="{{ isset($supplier) ? $supplier->fax : '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="contact_person">Kontak person</label>
                        <input class="form-control" name="contact_person" type="text" id="contact_person" value="{{ isset($supplier) ? $supplier->contact_person : '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" name="email" type="text" id="email" value="{{ isset($supplier) ? $supplier->email : '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input class="form-control" name="npwp" type="text" id="npwp" value="{{ isset($supplier) ? $supplier->npwp : '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="phone">Nama Bank</label>
                        <input class="form-control" name="bank_name" type="text" id="bank_name" value="{{ isset($supplier) ? $supplier->bank_name : '' }}" required>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                      <div class="form-group">
                        <label for="fax">Nomor Rekening</label>
                        <input class="form-control" name="bank_number" type="text" id="bank_number" value="{{ isset($supplier) ? $supplier->bank_number : '' }}">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <div class="checkbox mb-3">
                        <label><input type="checkbox" name="active" {{ isset($supplier) && $supplier->active ? "checked" : '' }} value="1" > Status Aktif</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6 col-lg-6">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <a href="{{ route('warehouse.master-data.supplier.index') }}" class="btn iq-bg-danger">Batal</a>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Add New Modal --}}
  <script>

  </script>
@endsection

