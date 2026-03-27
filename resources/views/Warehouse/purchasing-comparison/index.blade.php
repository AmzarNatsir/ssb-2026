@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Purchasing Comparison </h4>
              </div>
              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_comparison.create'))
                <button style="margin-top: auto" type="button" class="btn btn-success mb-3"
                        data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i>Create</button>
              @endif
            </div>
            <div class="iq-card-body">
              <form action="{{ route('warehouse.purchasing-comparison.index') }}" method="GET">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="">Search keyword</label>
                    <input type="text" class="form-control" placeholder="" name="keyword" value="{{ $keyword ?? ''  }}">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="">Date Start</label>
                    <input type="date" class="form-control" name="date_start" value="{{ $date_start ? date('Y-m-d', strtotime($date_start)) : '' }}">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="">Date End</label>
                    <input type="date" class="form-control" name="date_end" value="{{ $date_end ? date('Y-m-d', strtotime($date_end)) : '' }}">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="">Supplier</label>
                    <select class="form-control" name="supplier_id">
                      <option value="">ALL</option>
                      @foreach($suppliers as $key => $supplier)
                        <option value="{{ $key  }}" {{ $key == $supplier_id ? 'selected' : '' }}>{{ $supplier }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-2" style="margin-top: 2.1em">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-success">Search</button>
                  </div>
                </div>
              </form>
              <div class="table-responsive">
                <table class="table table-striped  table-sm" style="font-size: 12px">
                  <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Nomor</th>
                    <th scope="col">Purchasing Request Number</th>
                    <th scope="col">Taggal Pembuatan</th>
                    <th scope="col">Keb/Unit</th>
                    <th scope="col">Supplier</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($purchasing_comparisons as $purchasing_comparison)
                    <tr>
                      <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                      </th>
                      <td>
                        <div class="d-block">
                          <div class="btn-group  btn-group-sm" role="group">
                            @if (current_user_has_permission_to('warehouse-spare_part.purchasing_comparison.print'))
                              <a target="_blank" class="btn btn-success"
                                 href="{{ route('warehouse.purchasing-comparison.print', $purchasing_comparison->id) }}">Print</a>
                            @endif
                            @if ($purchasing_comparison->editable() &&
                                current_user_has_permission_to('warehouse-spare_part.purchasing_comparison.edit'))
                              <a class="btn btn-warning"
                                 href="{{ route('warehouse.purchasing-comparison.edit', $purchasing_comparison->id) }}">Edit</a>
                              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_comparison.delete'))
                                <form method="POST"
                                      id="delete-{{ $purchasing_comparison->id }}"
                                      action="{{ route('warehouse.purchasing-comparison.destroy', $purchasing_comparison->id) }}">
                                  @csrf
                                  @method('delete')
                                  <button
                                    onclick="confirmDelete({{ $purchasing_comparison->id }});"
                                    type="button" class="btn btn-danger">Hapus</button>
                                </form>
                              @endif
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>{{ $purchasing_comparison->number }}</td>
                      <td>{{ $purchasing_comparison->purchasing_request->number }}</td>
                      <td>{{ $purchasing_comparison->dateCreation }}</td>
                      <td>{{ $purchasing_comparison->reference_id ? $purchasing_comparison->work_order->number : '' }}
                      </td>
                      <td>
                        @foreach ($purchasing_comparison->supplierName as $item)
                          <span class="badge badge-success">
                                                            {{ $item->name }}
                                                        </span>
                        @endforeach
                      </td>
                    </tr>
                  @empty
                  @endforelse
                  </tbody>
                </table>
              </div>
              {{ $purchasing_comparisons->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Purchasig Request Modal --}}

  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih purchasing request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tr>
              <td>Number</td>
              <td>Description</td>
              <td>Action</td>
            </tr>

            @forelse ($purchasing_requests as $item)
              <tr>
                <td>{{ $item->number }}</td>
                <td>{{ $item->remarks }}</td>
                <td>
                  <div class="d-block">
                    <div class="btn-group  btn-group-sm" role="group">
                      <a target="_blank" class="btn btn-success"
                         href="{{ route('warehouse.purchasing-request.print', $item->id) }}">View</a>
                      <a class="btn btn-primary"
                         href="{{ route('warehouse.purchasing-comparison.add', $item->id) }}">Pilih</a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="2">Belum ada data</td>
              </tr>
            @endforelse

          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
