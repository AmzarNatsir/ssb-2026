@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Operating Sheet</h1>
                </div>
            </div>
            <form
                action="{{ isset($inspection) ? route('workshop.inspection.update', $inspection->id) : route('workshop.inspection.store') }}"
                method="POST" enctype="multipart/form-data" style="font-size: 12px">
                @csrf
                @if (isset($inspection))
                    @method('put')
                @endif
                @if (isset($inspection))
                    <div class="row item-wrapper">
                        <div class="col-sm-12">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Unit</label>
                                                <select name="equipment_id" id="" class="form-control" readonly>
                                                    @foreach ($equipments as $equipment)
                                                        <option
                                                            {{ $equipment->id == $inspection->equipment_id ? 'selected' : '' }}
                                                            value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">KM Start</label>
                                                <input type="text" class="form-control" name="km_start"
                                                    value="{{ $inspection->km_start }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">KM End</label>
                                                <input type="text" class="form-control" name="km_end"
                                                    value="{{ $inspection->km_end }}"
                                                    min="{{ $inspection->km_start }} ">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">HM Start</label>
                                                <input type="text" class="form-control" name="hm_start"
                                                    value="{{ $inspection->hm_start }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">HM End</label>
                                                <input type="text" class="form-control" name="hm_end"
                                                    value="{{ $inspection->hm_end }}"
                                                    min="{{ $inspection->hm_start }} ">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Operator/Driver</label>
                                                <select name="driver_id" id="" class="form-control" required>
                                                    @foreach ($drivers as $driver)
                                                        <option
                                                            {{ $driver->id == $inspection->driver_id ? 'selected' : '' }}
                                                            value="{{ $driver->id }}">{{ $driver->nm_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">Shift</label>
                                                <select name="shift" id="" class="form-control">
                                                    <option {{ $inspection->driver_id == 1 ? 'selected' : '' }}
                                                        value="1">
                                                        I</option>
                                                    <option {{ $inspection->driver_id == 2 ? 'selected' : '' }}
                                                        value="2">
                                                        II</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">OH</label>
                                                <input type="number" class="form-control" name="operating_hour"
                                                    value="{{ $inspection->operating_hour }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">Standby Hour</label>
                                                <input type="text" class="form-control" name="standby_hour"
                                                    value="{{ $inspection->standby_hour }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="">Breakdown Hour</label>
                                                <input type="text" class="form-control" name="breakdown_hour"
                                                    value="{{ $inspection->breakdown_hour }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Date</label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ date('Y-m-d', strtotime($inspection->date)) }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Standby Reason</label>
                                                <input type="text" class="form-control" name="standby_description"
                                                    value="{{ $inspection->standby_description }}">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="">Breakdown Reason</label>
                                                <input type="text" class="form-control" name="breakdown_description"
                                                    value="{{ $inspection->breakdown_description }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row action-button">
                    <div class="col-sm-12" style="text-align: right">
                        @if (!isset($inspection))
                            <button class="btn btn-info" type="button" onclick="addItem()">Add item</button>
                        @endif
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Add New Modal --}}
    <script>
        let drivers = {!! $drivers !!};
        let locations = {!! $locations !!};
        let projects = {!! $projects !!};
        let equipments = {!! $equipments !!};

        function addItem() {
            let item = `<div class="row item-wrapper">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Unit</label>
                                        <select name="equipment_id[]" id="" class="form-control" onchange="setKm(this)" required>
                                            <option value="">Please select unit</option>
                                            ${generateOption(equipments, null)}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">KM Start</label>
                                        <input type="number" class="form-control" name="km_start[]" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">KM End</label>
                                        <input type="number" class="form-control" name="km_end[]" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">HM Start</label>
                                        <input type="number" class="form-control" name="hm_start[]" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">HM End</label>
                                        <input type="number" class="form-control" name="hm_end[]" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Operator/Driver</label>
                                        <select name="driver_id[]" id="" class="form-control" required>
                                            <option value="">Please select operator</option>
                                            ${generateOption(drivers, null)}
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">Shift</label>
                                        <select name="shift[]" id="" class="form-control">
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">Operating Hour</label>
                                        <input type="number" class="form-control" name="operating_hour[]" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">Standby Hour</label>
                                        <input type="number" class="form-control" name="standby_hour[]" value="0">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="">Breakdown Hour</label>
                                        <input type="number" class="form-control" name="breakdown_hour[]" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="date" name="date[]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Standby Reason</label>
                                        <input type="text" class="form-control" name="standby_description[]">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Breakdown Reason</label>
                                        <input type="text" class="form-control" name="breakdown_description[]">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button class="btn btn-danger" type="button" onclick="deleteItem(this)">Delete item</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

            $('.action-button').before(item);
        }

        function generateOption(data, selectedId) {
            var option = '';
            for (let i = 0; i < data.length; i++) {
                if (selectedId && selectedId == data[i].id) {
                    option += '<option data-hm="' + data[i].hm + '" data-km="' + data[i].km + '" selected value="' + data[i]
                        .id + '">' + data[i].name + (data[i].code ? ' - ' + data[i].code : '') + '</option>';
                } else {
                    option += '<option data-hm="' + data[i].hm + '" data-km="' + data[i].km + '" value="' + data[i].id +
                        '">' + data[i].name + (data[i].code ? ' - ' + data[i].code : '') + '</option>';
                }
            }

            return option;
        }

        function deleteItem(el) {
            $(el).closest('.item-wrapper').remove();
        }

        function setKm(el) {
            let km = parseFloat($(el).find(':selected').data('km'));
            let hm = parseFloat($(el).find(':selected').data('hm'));
            $(el).parent().parent().parent().parent().find('input[name="km_start[]"]').val(km)
            $(el).parent().parent().parent().parent().find('input[name="km_end[]"]').attr('min', km)
            $(el).parent().parent().parent().parent().find('input[name="hm_start[]"]').val(hm)
            $(el).parent().parent().parent().parent().find('input[name="hm_end[]"]').attr('min', hm)
        }

        $(document).ready(function() {
            @if (!isset($inspection))
                addItem();
            @endif
        });
    </script>
@endsection
