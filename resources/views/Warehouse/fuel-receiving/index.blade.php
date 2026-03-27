@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Fuel Receiving</h4>
                            </div>
                            @if (current_user_has_permission_to('warehouse-bbm.receiving.create'))
                                <a href="{{ route('warehouse.fuel-receiving.add') }}" class="btn btn-success"><i
                                        class="ri-add-line"></i></a>
                            @endif
                        </div>
                        <div class="iq-card-body">

                            <div class="iq-todo-page">
                                <form class="position-relative" method="GET"
                                    action="{{ route('warehouse.fuel-receiving.index') }}">
                                    <div class="form-group mb-0">
                                        <input type="text" name="search" class="form-control todo-search"
                                            id="exampleInputEmail001" placeholder="Pencarian"
                                            value="{{ $search ? $search : '' }}">
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Aksi</th>
                                            <th scope="col">Nomor</th>
                                            <th scope="col">Fuel Tank</th>
                                            <th scope="col">Tanggal Terima</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">No Plat Kendaraan</th>
                                            <th scope="col">Nomor DO</th>
                                            <th scope="col">Jumlah DO</th>
                                            <th scope="col">Jumlah Real</th>
                                            <th scope="col">Selisih</th>
                                            <th scope="col">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($fuelReceivings as $fuelReceiving)
                                            <tr>
                                                <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>
                                                    <div class="d-block">
                                                        <div class="btn-group  btn-group-sm" role="group">
                                                            {{-- <a target="_blank" class="btn btn-success"
                                                                href="{{ route('warehouse.fuel-receiving.print', $fuelReceiving->id) }}">Print</a> --}}
                                                            @if ($fuelReceiving->editable() &&
                                                                current_user_has_permission_to('warehouse-bbm.receiving.edit'))
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('warehouse.fuel-receiving.edit', $fuelReceiving->id) }}">Edit</a>
                                                                @if (current_user_has_permission_to('warehouse-bbm.receiving.delete'))
                                                                    <form method="POST"
                                                                        id="delete-{{ $fuelReceiving->id }}"
                                                                        action="{{ route('warehouse.fuel-receiving.destroy', $fuelReceiving->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button
                                                                            onclick="confirmDelete({{ $fuelReceiving->id }});"
                                                                            type="button" class="btn btn-danger">Hapus</a>
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $fuelReceiving->number }}</td>
                                                <td>{{ $fuelReceiving->fuel_tank->number ?? '' }}</td>
                                                <td>{{ warehouse_date_format($fuelReceiving->received_at) }}</td>
                                                <td>{{ $fuelReceiving->supplier->name ?? '' }}</td>
                                                <td>{{ $fuelReceiving->vehicle_number }}</td>
                                                <td>{{ $fuelReceiving->invoice_number }}</td>
                                                <td>{{ $fuelReceiving->invoice_amount }}</td>
                                                <td>{{ $fuelReceiving->real_amount }}</td>
                                                <td>{{ $fuelReceiving->difference }}</td>
                                                <td>{{ $fuelReceiving->remarks }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11">Belum ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $fuelReceivings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Purchasig Request Modal --}}

    {{-- <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="btn-group  btn-group-sm" role="group" >
                                    <input type="hidden" name="purchasing_comparison_id" value="{{ $item->id }}">
                                    <a target="_blank" class="btn btn-success" href="{{ route('warehouse.purchasing-order.print', $item->id) }}" >View</a>
                                    <a class="btn btn-primary" href="{{ route('warehouse.fuel-receiving.add', $item->id) }}" >Pilih</a>
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
 </div> --}}

    <script>
        function confirmDelete(id) {
            $confirm = confirm('Anda Yakin?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }

        function confirmRelease(id) {
            $confirm = confirm('Selesaikan proses return?')
            if ($confirm) {
                $('#release-' + id).submit();
            }
        }
    </script>
@endsection
