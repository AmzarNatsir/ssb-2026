@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-4 col-lg-4">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Stock Card</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="row">
                            <table>
                                <tr>

                                    <td colspan="2">
                                        <small>Part Name</small>
                                        <h2>{{ $sparePart->part_name }}</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <small>Part Number</small>
                                        <h2>{{ $sparePart->part_number }}</h2>
                                    </td>
                                    <td>
                                        <small>Stock</small>
                                        <h2>{{ $sparePart->stock }}</h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <small>Location</small>
                                        <h2>{{ $sparePart->location }}</h2>
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <form action="{{ route('warehouse.master-data.spare-part.stock-card', $sparePart->id) }}" method="GET">
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
                                        <a target="_blank" href="{{ route('warehouse.master-data.spare-part.stock-card-print', $sparePart->id).(isset(request()->start) && isset(request()->end) ? '?start='.request()->start.'&end='.request()->end :'') }}" class="btn btn-info">Print</a>
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
                                @forelse ($stockChanges as $stockChange)
                                    <tr>
                                        <td>{{ $stockChange->created_at }}</td>
                                        <td>
                                            {!! $stockChange->description !!}
                                        </td>
                                        <td>{{ $stockChange->method == \App\Models\Warehouse\StockChanges::INCREASE ? $stockChange->updated_stock - $stockChange->stock : 0 }} </td>
                                        <td>{{ $stockChange->method == \App\Models\Warehouse\StockChanges::DEDUCT ? $stockChange->stock - $stockChange->updated_stock : 0 }}</td>
                                        <td>{{{ $stockChange->updated_stock }}}</td>
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

