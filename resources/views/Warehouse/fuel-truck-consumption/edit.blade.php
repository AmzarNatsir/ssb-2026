@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Fuel Truck Consumption/Issued</h1>
                </div>
            </div>
            <form action="{{ route('warehouse.fuel-truck-consumption.update', $fuelTruckConsumption->id) }}"
                method="POST">
                @method('put')
                @csrf
                <div class="row item-wrapper">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Source</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fuelTruckConsumption->fuel_truck->number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Target Equipment</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fuelTruckConsumption->equipment->name }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">HM</label>
                                            <input type="number" class="form-control" name="hm" min="1"
                                                value="{{ $fuelTruckConsumption->hm }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">KM</label>
                                            <input type="number" name="km" min="1" class="form-control"
                                                value="{{ $fuelTruckConsumption->km }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="date"
                                                value="{{ date('Y-m-d', strtotime($fuelTruckConsumption->date)) }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input type="number" name="amount" min="1" class="form-control"
                                                value="{{ $fuelTruckConsumption->amount }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Remarks</label>
                                            <textarea name="description" id="" cols="30" rows="1"
                                                class="form-control">{{ $fuelTruckConsumption->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row action-button">
                    <div class="col-sm-12" style="text-align: right">
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
    </script>
@endsection
