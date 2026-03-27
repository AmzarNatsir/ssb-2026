@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Purchasing Order </h4>
              </div>
              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_order.create'))
                <button style="margin-top: auto" type="button" class="btn btn-success mb-3"
                        data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i>Create</button>
              @endif
            </div>
            <div class="iq-card-body">
              <form action="{{ route('warehouse.purchasing-order.index') }}" method="GET">
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
                    <th scope="col">Comparison Number</th>
                    <th scope="col">Taggal Pembuatan</th>
                    <th scope="col">Keb/Unit</th>
                    <th scope="col">Supplier</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Total Diskon</th>
                    <th scope="col">PPN (%)</th>
                    <th scope="col">Beban Tansportasi</th>
                    <th scope="col">Grand Total</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($purchasing_orders as $purchasing_order)
                    <tr>
                      <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                      </th>
                      <td>
                        <div class="d-block">
                          <div class="btn-group  btn-group-sm" role="group">
                            @if (current_user_has_permission_to('warehouse-spare_part.purchasing_order.print'))
                              <a target="_blank" class="btn btn-success"
                                 href="{{ route('warehouse.purchasing-order.print', $purchasing_order->id) }}">Print</a>
                            @endif
                            @if ($purchasing_order->editable() &&
                                current_user_has_permission_to('warehouse-spare_part.purchasing_order.edit'))
                              <a class="btn btn-warning"
                                 href="{{ route('warehouse.purchasing-order.edit', $purchasing_order->id) }}">Edit</a>
                              @if (current_user_has_permission_to('warehouse-spare_part.purchasing_order.delete'))
                                <form method="POST"
                                      id="delete-{{ $purchasing_order->id }}"
                                      action="{{ route('warehouse.purchasing-order.destroy', $purchasing_order->id) }}">
                                  @csrf
                                  @method('delete')
                                  <button
                                    onclick="confirmDelete({{ $purchasing_order->id }});"
                                    type="button" class="btn btn-danger">Hapus</button>
                                </form>
                              @endif
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>{{ $purchasing_order->number }}</td>
                      <td>{{ $purchasing_order->purchasing_comparison->number }}</td>
                      <td>{{ $purchasing_order->dateCreation }}</td>
                      <td>{{ $purchasing_order->reference_id ? $purchasing_order->work_order->number : '' }}
                      </td>
                      <td>{{ $purchasing_order->supplier->name ?? '' }}</td>
                      <td>{{ warehouse_number_format($purchasing_order->subtotal) }}</td>
                      <td>{{ warehouse_number_format($purchasing_order->total_discount) }}</td>
                      <td>{{ $purchasing_order->ppn }}</td>
                      <td>{{ warehouse_number_format($purchasing_order->additional_expense) }}
                      </td>
                      <td>{{ warehouse_number_format($purchasing_order->grand_total) }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="12">Belum ada data</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              {{ $purchasing_orders->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Purchasig Request Modal --}}

  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih purchasing comparison</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table ">
            <tr>
              <td>Number</td>
              <td>Suppliers</td>
              <td>Action</td>
            </tr>

            @forelse ($purchasing_comparisons as $item)
              <form action="{{ route('warehouse.purchasing-order.add') }}" method="GET">
                <tr>
                  <td>{{ $item->number }}</td>
                  <td>
                    <select name="supplier_id[]" id="" required style="width:100%"
                            multiple="multiple">
                      <option value="">Pilih supplier</option>
                      @foreach (explode(',', $item->supplier_ids) as $supplier)
                        @if(isset($suppliers[$supplier]))
                        <option value="{{ $supplier }}">{{ $suppliers[$supplier] }}</option>
                        @else
                          @continue
                        @endif
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <div class="d-block">
                      <div class="btn-group  btn-group-sm" role="group">
                        <input type="hidden" name="purchasing_comparison_id"
                               value="{{ $item->id }}">
                        <a target="_blank" class="btn btn-success"
                           href="{{ route('warehouse.purchasing-comparison.print', $item->id) }}">View</a>
                        <button class="btn btn-primary" type="submit">Pilih</button>
                      </div>
                    </div>
                  </td>
                </tr>
              </form>
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
    $(document).ready(function() {
      $('select[name="supplier_id[]"]').select2();
    });

    function confirmDelete(id) {
      $confirm = confirm('Anda Yakin?')
      if ($confirm) {
        $('#delete-' + id).submit();
      }
    }
  </script>
@endsection
