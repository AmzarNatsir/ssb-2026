@extends('Workshop.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <form id="purchasingOrderForm" action={{ !isset($fuelReceiving) ? route('warehouse.fuel-receiving.store') : route('warehouse.fuel-receiving.update',$fuelReceiving->model->id) }} method="POST" >
            @csrf
            @isset($fuelReceiving)
                @method('PUT')
            @endisset
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Fuel Receiving</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="container-fluid">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Fuel Tank</label>
                                        <select name="fuel_tank_id" class="form-control" required>
                                            <option value="">Pilih Fuel Tank</option>
                                            @foreach ($fuel_tanks as $fuel_tank)
                                                <option {{ isset($fuelReceiving) && $fuelReceiving->model->fuel_tank_id == $fuel_tank->id ? 'selected' : ''  }} value="{{ $fuel_tank->id }}">{{ $fuel_tank->number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Received At</label>
                                        <input class="form-control" type="date" name="received_at" value="{{ isset($fuel_receiving) ? date('Y-m-d', strtotime($fuel_receiving->model->received_at)) : date('Y-m-d', strtotime(now()))}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Supplier</label>
                                        <select name="supplier_id" class="form-control" required>
                                            <option value="">Pilih Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option {{ isset($fuelReceiving) && $fuelReceiving->model->supplier_id == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nomor DO</label>
                                        <input type="text" class="form-control" name="invoice_number" required value="{{ isset($fuelReceiving) ? $fuelReceiving->model->invoice_number : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Nama Driver</label>
                                        <input type="text" class="form-control" name="driver_name" required value="{{ isset($fuelReceiving) ? $fuelReceiving->model->driver_name : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Transporter (No Plat)</label>
                                        <input type="text" class="form-control" name="vehicle_number" required value="{{ isset($fuelReceiving) ? $fuelReceiving->model->vehicle_number : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Keteragan</label>
                                        <textarea name="remarks" id="" cols="30" rows="4" class="form-control">{{ isset($fuelReceiving) ? $fuelReceiving->model->remarks : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="container-fluid">
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Jumlah DO</label>
                                        <input type="number" class="form-control" name="invoice_amount" onchange="calculateDifference()" required value="{{ isset($fuelReceiving) ? $fuelReceiving->model->invoice_amount : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Jumlah Real</label>
                                        <input type="number" class="form-control" name="real_amount" onchange="calculateDifference()" required value="{{ isset($fuelReceiving) ? $fuelReceiving->model->real_amount : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="">Selisih</label>
                                        <input type="number" class="form-control" name="difference" readonly value="{{ isset($fuelReceiving) ? $fuelReceiving->model->difference : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('warehouse.issued.index') }}" class="btn iq-bg-danger">Batal</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Add New Modal --}}
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    function calculateDifference() {
        var invoice_amount = $('input[name="invoice_amount"]').val() ? $('input[name="invoice_amount"]').val() : 0 ;
        var real_amount = $('input[name="real_amount"]').val() ? $('input[name="real_amount"]').val() : 0 ;

        var difference = parseInt(real_amount) - parseInt(invoice_amount);

        $('input[name="difference"]').val(difference);
    }
</script>
@endsection
