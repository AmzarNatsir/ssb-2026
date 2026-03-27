@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Receiving</h4>
              </div>
              @if (current_user_has_permission_to('warehouse-spare_part.receiving.create'))
                <button style="margin-top: auto" type="button" class="btn btn-success mb-3"
                        data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i>Create</button>
              @endif
            </div>
            <div class="iq-card-body">
              <form action="{{ route('warehouse.receiving.index') }}" method="GET">
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
                    <th scope="col">PO Number</th>
                    <th scope="col">Taggal Pembuatan</th>
                    <th scope="col">Taggal Penerimaan</th>
                    <th scope="col">Diterima Oleh</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">No. Faktur</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($receivings as $receiving)
                    <tr>
                      <th scope="row">
                        {{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                      </th>
                      <td>
                        <div class="d-block">
                          <div class="btn-group  btn-group-sm" role="group">
                            @if (current_user_has_permission_to('warehouse-spare_part.receiving.print'))
                              <a target="_blank" class="btn btn-success"
                                 href="{{ route('warehouse.receiving.print', $receiving->id) }}">Print</a>
                            @endif
                            @if ($receiving->editable() && current_user_has_permission_to('warehouse-spare_part.receiving.edit'))
                              <a class="btn btn-warning"
                                 href="{{ route('warehouse.receiving.edit', $receiving->id) }}">Edit</a>
                              @if (current_user_has_permission_to('warehouse-spare_part.receiving.delete'))
                                <form method="POST" id="delete-{{ $receiving->id }}"
                                      action="{{ route('warehouse.receiving.destroy', $receiving->id) }}">
                                  @csrf
                                  @method('delete')
                                  <button
                                    onclick="confirmDelete({{ $receiving->id }});"
                                    type="button" class="btn btn-danger">Hapus</button>
                                </form>
                              @endif
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>{{ $receiving->number }}</td>
                      <td>{{ $receiving->purchasing_order->number ?? '' }}</td>
                      <td>{{ $receiving->dateCreation }}</td>
                      <td>{{ $receiving->getFormattedDate('received_at') }}</td>
                      <td>{{ $receiving->received_user->nm_lengkap ?? '' }}</td>
                      <td>{{ $receiving->supplier->name ?? '' }}</td>
                      <td>{{ $receiving->invoice_number }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9">Belum ada data</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              {{ $receivings->links() }}
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
          <h5 class="modal-title" id="exampleModalLabel">Pilih Purchasing Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table">
            <tr>
              <td>Number</td>
              <td>Status</td>
              <td>Action</td>
            </tr>

            @forelse ($purchasing_orders as $item)
              <tr>
                <td>{{ $item->number }}</td>
                <td>
                  @if ($item->status == \App\Models\Warehouse\PurchasingOrder::CURRENT_STATUS)
                    <span class="badge badge-success">
                                            Not Received Yet
                                        </span>
                  @else
                    <span class="badge badge-warning">
                                            Some already received
                                        </span>
                  @endif
                </td>
                <td>
                  <div class="d-block">
                    <div class="btn-group  btn-group-sm" role="group">
                      <input type="hidden" name="purchasing_comparison_id"
                             value="{{ $item->id }}">
                      <a target="_blank" class="btn btn-success"
                         href="{{ route('warehouse.purchasing-order.print', $item->id) }}">View</a>
                      <a class="btn btn-primary"
                         href="{{ route('warehouse.receiving.add', $item->id) }}">Pilih</a>
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
