@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Fuel Truck Consumption</h4>
                            </div>
                            @if (current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_truck.create'))
                                <a style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    href="{{ route('warehouse.fuel-truck-consumption.add') }}"><i
                                        class="ri-add-line pr-0"></i></a>
                            @endif
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('warehouse.fuel-truck-consumption.index') }}" method="GET">
                                        <div class="iq-email-search d-flex">
                                            @php
                                                $start = request()->get('start') ? date('Y-m-d', strtotime(request()->get('start'))) : '';
                                                $end = request()->get('end') ? date('Y-m-d', strtotime(request()->get('end'))) : '';
                                                $equipmentid = request()->has('equipment_id') ? request()->get('equipment_id') : null;
                                            @endphp
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 200px;" name="start"
                                                value="{{ $start }}">
                                            <small style="margin: 10px 5px;">to</small>
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 200px;" name="end"
                                                value="{{ $end }}">
                                            <button type="submit" class="btn iq-bg-success">Apply Filter</button>
                                        </div>
                                    </form>
                                    {{ $fuelTruckConsumptions->links('vendor.pagination.workshop') }}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped  table-sm" style="width: 100%">
                                    <thead style="text-align: center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Number</th>
                                            <th scope="col">Date</th>
                                            <th scope="col" style="min-width:150px">Fuel Truck Number</th>
                                            <th scope="col" style="min-width:150px">Unit Name</th>
                                            <th scope="col">HM/KM</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Updated Stock</th>
                                            <th scope="col" style="min-width:150px">Created By</th>
                                            <th scope="col" style="min-width:150px">Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        @forelse ($fuelTruckConsumptions as $consumption)
                                            <tr>
                                                <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>
                                                    <div class="d-block">
                                                        <div class="btn-group  btn-group-sm" role="group">
                                                            <!-- @if (current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_truck.print'))
                                                                <a target="_blank" class="btn btn-success"
                                                                    href="{{ route('warehouse.fuel-truck-consumption.print', $consumption->id) }}">Print</a>
                                                            @endif -->
                                                            @if ($consumption->editable() &&
                                                                current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_truck.edit'))
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('warehouse.fuel-truck-consumption.edit', $consumption->id) }}">Edit</a>
                                                                @if (current_user_has_permission_to('warehouse-bbm_consumption/issued.fuel_truck.delete'))
                                                                    <form method="POST" id="delete-{{ $consumption->id }}"
                                                                        action="{{ route('warehouse.fuel-truck-consumption.destroy', $consumption->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button
                                                                            onclick="confirmDelete({{ $consumption->id }});"
                                                                            type="button" class="btn btn-danger">Hapus</a>
                                                                    </form>
                                                                @endif
                                                            @endif

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $consumption->number }}</td>
                                                <td>{{ warehouse_date_format($consumption->date) }}</td>
                                                <td>{{ $consumption->fuel_truck->number }}</td>
                                                <td>
                                                    {{ $consumption->equipment->name }}
                                                </td>
                                                <td>{{ $consumption->hm . '/' . $consumption->km }}</td>
                                                <td>{{ $consumption->amount }}</td>
                                                <td>{{ $consumption->current_stock }}</td>
                                                <td>{{ $consumption->created_user->karyawan->nm_lengkap }}</td>
                                                <td>{{ $consumption->updated_user->karyawan->nm_lengkap }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13">No Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <a target="_blank"
                                href="{{ route('warehouse.fuel-truck-consumption.download', request()->all()) }}"
                                class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
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
