@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Purchasing Request </h4>
              </div>
              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_request.create'))
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-add-line"></i>
                      Purchasing Request Baru
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a data-toggle="modal" data-target="#workshopModal" class="dropdown-item"
                         href="#">Workshop</a>
                      <a class="dropdown-item"
                         href="{{ route('warehouse.purchasing-request.add', ['type' => 2]) }}">Stok
                        Gudang</a>
                    </div>
                  </div>
                </div>
              @endif
            </div>
            <div class="iq-card-body">
              <form action="{{ route('warehouse.purchasing-request.index') }}" method="GET">
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
                    <label for="">Request Type</label>
                    <select class="form-control" name="request_type">
                      <option value="">ALL</option>
                      @foreach(\App\Models\Warehouse\PurchasingRequest::PURCHASING_TYPE as $key => $type)
                        <option value="{{ $key  }}" {{ $key == $request_type ? 'selected' : '' }}>{{ $type }}</option>
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
                    <th scope="col">Taggal Pembuatan</th>
                    <th scope="col">Tipe Permintaan</th>
                    <th scope="col">Keb/Unit</th>
                    <th scope="col">Total Qty</th>
                    <th scope="col">Total Estimasi Harga</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($purchasing_requests as $purchasing_request)
                    <tr>
                      <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                      </th>
                      <td>
                        <div class="d-block">
                          <div class="btn-group  btn-group-sm" role="group">
                            @if (current_user_has_permission_to('warehouse-spare_part.purchasing_request.print'))
                              <a target="_blank" class="btn btn-success"
                                 href="{{ route('warehouse.purchasing-request.print', $purchasing_request->id) }}">Print</a>
                            @endif
                            @if ($purchasing_request->editable() &&
                                current_user_has_permission_to('warehouse-spare_part.purchasing_request.edit'))
                              <a class="btn btn-warning"
                                 href="{{ route('warehouse.purchasing-request.edit', $purchasing_request->id) }}">Edit</a>
                              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_request.delete'))
                                <form method="POST"
                                      id="delete-{{ $purchasing_request->id }}"
                                      action="{{ route('warehouse.purchasing-request.destroy', $purchasing_request->id) }}">
                                  @csrf
                                  @method('delete')
                                  <button
                                    onclick="confirmDelete({{ $purchasing_request->id }});"
                                    type="button" class="btn btn-danger">Hapus</button>
                                </form>
                              @endif
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>{{ $purchasing_request->number }}</td>
                      <td>{{ $purchasing_request->dateCreation }}</td>
                      <td>{{ $purchasing_request->type }}</td>
                      <td>{{ $purchasing_request->reference_id ? $purchasing_request->work_order->number : '' }}
                      </td>
                      <td>{{ $purchasing_request->total_qty }}</td>
                      <td>{{ warehouse_number_format($purchasing_request->total_price) }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="13">Belum ada data</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              <a target="_blank" href="{{ route('warehouse.purchasing-request.download', request()->all()) }}"
                class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
              {{ $purchasing_requests->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- workshop modal --}}
  <div class="modal fade" id="workshopModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Work Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tr>
              <td>Number</td>
              <td>Unit</td>
              <td>Action</td>
            </tr>

            @forelse ($work_orders as $item)
              <tr>
                <td>{{ $item->number }}</td>
                <td>{{ $item->equipment->name }}</td>
                <td>
                  <div class="d-block">
                    <div class="btn-group  btn-group-sm" role="group">
                      <a class="btn btn-primary"
                         href="{{ route('warehouse.purchasing-request.add', ['type' => 1, 'id' => $item->id]) }}">Select</a>
                    </div>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3">No data</td>
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
