@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Fuel Tank Consumption/Issued</h1>
                </div>
            </div>
            <form action="{{ route('warehouse.fuel-tank-consumption.update', $fuelTankConsumption->id) }}" method="POST">
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
                                                value="{{ $fuelTankConsumption->fuel_tank->number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Target Type</label>
                                            @switch($fuelTankConsumption->reference_type)
                                                @case(\App\Models\Warehouse\FuelTank::class)
                                                    @php
                                                        $targetType = 'Fuel Tank';
                                                    @endphp
                                                @break
                                                @case(\App\Models\Warehouse\FuelTruck::class)
                                                    @php
                                                        $targetType = 'Fuel Truck';
                                                    @endphp
                                                @break
                                                @case(\App\Models\Workshop\Equipment::class)
                                                    @php
                                                        $targetType = 'Unit';
                                                    @endphp
                                                @break
                                            @endswitch
                                            <input type="text" class="form-control" value="{{ $targetType }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Target Number</label>
                                            <input type="text" class="form-control"
                                                value="{{ $fuelTankConsumption->fuelTankConsumption->number ?? $fuelTankConsumption->fuelTankConsumption->name }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">HM</label>
                                            <input type="number" class="form-control" name="hm" min="1"
                                                value="{{ $fuelTankConsumption->hm }}"
                                                {{ $fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTank::class ? 'readonly' : 'required' }}>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">KM</label>
                                            <input type="number" name="km" min="1" class="form-control"
                                                value="{{ $fuelTankConsumption->km }}"
                                                {{ $fuelTankConsumption->reference_type == \App\Models\Warehouse\FuelTank::class ? 'readonly' : 'required' }}>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="date"
                                                value="{{ date('Y-m-d', strtotime($fuelTankConsumption->date)) }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input type="number" name="amount" min="1" class="form-control"
                                                value="{{ $fuelTankConsumption->amount }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Remarks</label>
                                            <textarea name="description" id="" cols="30" rows="1"
                                                class="form-control">{{ $fuelTankConsumption->description }}</textarea>
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
