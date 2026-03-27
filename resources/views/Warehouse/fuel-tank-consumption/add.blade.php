@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Fuel Tank Consumption/Issued</h1>
                </div>
            </div>
            <form action="{{ route('warehouse.fuel-tank-consumption.store') }}" method="POST">
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

        function getDestinationData(el) {
            let destinationType = $(el).find(':selected').val();
            let destinationElement = $(el).closest('.row').find('select[name = "reference_id[]"]');
            let selectedFuelTank = $(el).closest('.row').find('select[name="fuel_tank_id[]"]').find(':selected').val();

            if (!destinationType) {
                destinationElement.find('option').remove();;
                return;
            }

            if (!selectedFuelTank) {
                alert('Please select fuel tank first');
                $(el).closest('.row').find('select[name="fuel_tank_id[]"]').focus();
                return
            }

            if (destinationType.includes('Truck') || destinationType.includes('Equipment')) {

                $(el).closest('.row').parent().find('input[name="hm[]"]').removeAttr('readonly').attr('required',
                    'required');
                $(el).closest('.row').parent().find('input[name="km[]"]').removeAttr('readonly').attr('required',
                    'required');
            } else {
                $(el).closest('.row').parent().find('input[name="hm[]"]').attr('readonly', 'readonly');
                $(el).closest('.row').parent().find('input[name="km[]"]').attr('readonly', 'readonly');
            }

            $.get('{{ route('warehouse.fuel-tank-consumption.destination-data') }}', {
                type: destinationType,
                selectedFuelTank: selectedFuelTank
            }, function(response) {
                if (response.length > 0) {
                    destinationElement.find('option').remove();
                    destinationElement.append($('<option/>').val('').text('Select Target'));
                    response.forEach(function(val, index) {
                        destinationElement.append($('<option />').val(val.id).text(val.name).attr('data-hm',
                            val.hm).attr('data-km', val.km));
                    })
                }
            })

        }

        function setHmKm(el) {
            $(el).closest('.row').parent().find('input[name="hm[]"]').val($(el).find(':selected').data('hm'));
            $(el).closest('.row').parent().find('input[name="km[]"]').val($(el).find(':selected').data('km'));
        }

        function addItem() {
            let item = `<div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Source</label>
                                                <select name="fuel_tank_id[]" id="" class="form-control" required
                                                    onchange="setMaximumAmount(this)">
                                                    <option value="">Select Fuel Tank</option>
                                                    @foreach ($fuelTanks as $fuelTank)
                                                        <option data-stock="{{ $fuelTank->stock }}" value="{{ $fuelTank->id }}">
                                                            {{ $fuelTank->number }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Target Type</label>
                                                <select name="reference_type[]" id="" class="form-control" required
                                                    onchange="getDestinationData(this)">
                                                    <option value="">Select Target Type</option>
                                                    <option value="{{ warehouse_to_double_backslash(\App\Models\Warehouse\FuelTank::class) }}">Fuel Tank
                                                    </option>
                                                    <option value="{{ warehouse_to_double_backslash(\App\Models\Warehouse\FuelTruck::class) }}">Fuel Truck
                                                    </option>
                                                    <option value="{{ warehouse_to_double_backslash(\App\Models\Workshop\Equipment::class) }}">Unit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">Target Number</label>
                                                <select name="reference_id[]" id="" class="form-control" required onclick="setHmKm(this)" required>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">HM</label>
                                                <input type="number" class="form-control" name="hm[]" readonly >
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="">KM</label>
                                                <input type="number" name="km[]" min="1" class="form-control" readonly>
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
                                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(this)"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
            $('.item-wrapper').append(item);
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
