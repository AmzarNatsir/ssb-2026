@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Supplier </h4>
              </div>
              @if (current_user_has_permission_to('warehouse-master_data.supplier.create'))
                <a style="margin-top: auto" type="button" class="btn btn-success mb-3"
                   href="{{ route('warehouse.master-data.supplier.add') }}"><i
                    class="ri-add-line pr-0"></i></a>
              @endif
            </div>
            <div class="iq-card-body">
              <p>Daftar master data supplier</p>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Aksi</th>
                  <th scope="col">Telepon</th>
                  <th scope="col">Email</th>
                  <th scope="col">Kontak Person</th>
                  <th scope="col">Informasi Bank</th>
                  <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($suppliers as $supplier)
                  <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>
                      <div class="d-block">
                        <div class="btn-group  btn-group-sm" role="group">
                          @if (current_user_has_permission_to('warehouse-master_data.supplier.edit'))
                            <a class="btn btn-warning"
                               href="{{ route('warehouse.master-data.supplier.edit', $supplier->id) }}">Edit</a>
                          @endif
                          @if (current_user_has_permission_to('warehouse-master_data.supplier.delete'))
                            <form method="POST" id="delete-{{ $supplier->id }}"
                                  action="{{ route('warehouse.master-data.supplier.destroy', $supplier->id) }}">
                              @csrf
                              @method('delete')
                              <button onclick="confirmDelete({{ $supplier->id }});"
                                      type="button" class="btn btn-danger">Hapus</button>
                            </form>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ ($supplier->bank_number || $supplier->bank_name) ?  $supplier->bank_name.' / '.$supplier->bank_number : '' }} </td>
                    <td>
                      @if ($supplier->active)
                        <span
                          class="badge badge-pill border border-primary text-primary">Aktif</span>
                      @else
                        <span
                          class="badge badge-pill border border-secondary text-secondary">Tidak aktif</span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8">Belum ada data</td>
                  </tr>
                @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(id) {
      $confirm = confirm('Anda Yakin?')
      if ($confirm) {
        $('#delete-' + id).submit();
      }
    }
  </script>
@endsection
