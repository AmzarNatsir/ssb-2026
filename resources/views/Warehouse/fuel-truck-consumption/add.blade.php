@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Fuel Truck Consumption/Issued</h1>
                </div>
            </div>
            <form action="{{ route('warehouse.fuel-truck-consumption.store') }}" method="POST">
                @csrf
                <div class="row item-wrapper">

                </div>
                <div class="row action-button">
                    <div class="col-sm-12" style="text-align: right">
                        <button class="btn btn-info" type="button" onclick="addItem()">Add item</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Add New Modal --}}
    <script>
        // set max for amount input based on selected fuel tank
        function setMaximumAmount(el) {
            $(el).closest('.row').parent().find('input[name="amount[]"]').attr('max', $(el).find(':selected').data('stock'))
            $(el).closest('.row').find('select[name="reference_type[]"]').val('').change();
        }

        function addItem() {
            let item = `<div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Source</label>
                                            <select name="fuel_truck_id[]" id="" class="form-control" required
                                                onchange="setMaximumAmount(this)">
                                                <option value="">Select Fuel Truck</option>
                                                @foreach ($fuelTrucks as $fuelTruck)
                                                    <option data-stock="{{ $fuelTruck->stock }}" value="{{ $fuelTruck->id }}">
                                                        {{ $fuelTruck->number }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Target Equipment</label>
                                            <select name="equipment_id[]" id="" class="form-control" required onchange="setHmKm(this)">
                                                <option value="">Select Equipment Type</option>
                                                @foreach ($equipments as $equipment)
                                                    <option value="{{ $equipment->id }}" data-km="{{ $equipment->km }}" data-hm="{{ $equipment->hm }}">
                                                        {{ $equipment->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">HM</label>
                                                <input type="number" class="form-control" name="hm[]" required >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">KM</label>
                                                <input type="number" name="km[]" min="1" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="date[]" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Amount</label>
                                            <input type="number" name="amount[]" min="1" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Remarks</label>
                                            <textarea name="description[]" id="" cols="30" rows="1"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(this)"><i
                                                class="ri-delete-bin-line"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            $('.item-wrapper').append(item);
        }

        function setHmKm(el) {
            $(el).closest('.row').parent().find('input[name="hm[]"]').val($(el).find(':selected').data('hm'));
            $(el).closest('.row').parent().find('input[name="km[]"]').val($(el).find(':selected').data('km'));
        }

        function deleteItem(el) {
            $(el).closest('.iq-card').parent().remove();
        }

        function setKm(el) {
            let km = parseFloat($(el).find(':selected').data('km'));
            $(el).parent().parent().parent().parent().find('input[name="km_start[]"]').val(km)
            $(el).parent().parent().parent().parent().find('input[name="km_end[]"]').attr('min', km)
        }

        $(document).ready(function() {
            @if (!isset($fuelTankConsumption))
                addItem();
            @endif
        });
    </script>
@endsection
