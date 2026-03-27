@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-4 col-lg-4">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Fuel Tank History</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table width="100%">
                            <tr>

                                <td colspan="2">
                                    <small>Number</small>
                                    <h2>{{ $fuelTank->number }}</h2>
                                </td>
                            </tr>
                            <tr>

                                <td width="50%">
                                    <small>Stock</small>
                                    <h2>{{ $fuelTank->stock }}</h2>
                                </td>
                                <td width="50%">
                                    <small>Capacity</small>
                                    <h2>{{ $fuelTank->capacity }}</h2>
                                </td>
                            </tr>
                        </table>
                        <form action="{{ route('warehouse.master-data.fuel-tank.history', $fuelTank->id) }}" method="GET">
                            <div class="row">
                                <small>Filter</small>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="start" style="font-size: smaller" value="{{ isset(request()->start) ? request()->start : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="end" style="font-size: smaller" value="{{ isset(request()->end) ? request()->end : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="btn-group" style="float: right">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <a target="_blank" href="{{ route('warehouse.master-data.fuel-tank.history-print', $fuelTank->id).(isset(request()->start) && isset(request()->end) ? '?start='.request()->start.'&end='.request()->end :'') }}" class="btn btn-info">Print</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-lg-8">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">History</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <table class="table" style="font-size: 12px">
                            <thead>
                               <tr>
                                  <th scope="col">Tanggal</th>
                                  <th scope="col">Uraian</th>
                                  <th scope="col">In</th>
                                  <th scope="col">Out</th>
                                  <th scope="col">Stock</th>

                               </tr>
                            </thead>
                            <tbody>
                                @forelse ($fuelChanges as $fuelChange)
                                    <tr>
                                        <td>{{ $fuelChange->created_at }}</td>
                                        <td>
                                            {!! $fuelChange->description !!}
                                        </td>
                                        <td>{{ $fuelChange->method == \App\Models\Warehouse\StockChanges::INCREASE ? $fuelChange->updated_stock - $fuelChange->stock : 0 }} </td>
                                        <td>{{ $fuelChange->method == \App\Models\Warehouse\StockChanges::DEDUCT ? $fuelChange->stock - $fuelChange->updated_stock : 0 }}</td>
                                        <td>{{{ $fuelChange->updated_stock }}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada data</td>
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
@endsection

