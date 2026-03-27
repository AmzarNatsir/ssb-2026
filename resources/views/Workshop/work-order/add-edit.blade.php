@extends('Workshop.layouts.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <style>
        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #1759a1;
        }

        a {
            color: #3c5e83;
            text-decoration: none;
            background-color: transparent;
        }
    </style>
    <div id="content-page" class="content-page">
        <form
            action="{{ isset($work_order) ? route('workshop.work-order.update', $work_order->id) : route('workshop.work-order.store', $work_request->id) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($work_order))
                @method('put')
            @endif
            <div class="cantainer-fluid">
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <h1>Work Order</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Started At</label>
                                            <input type="datetime-local" class="form-control" name="date_start"
                                                value="{{ isset($work_order) && $work_order->date_start ? date('Y-m-d\TH:i', strtotime($work_order->date_start)) : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Finished At</label>
                                            <input type="datetime-local" class="form-control" name="date_finish"
                                                value="{{ isset($work_order) && $work_order->date_finish ? date('Y-m-d\TH:i', strtotime($work_order->date_finish)) : null }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Work Request Number</label>
                                            <input type="text" class="form-control" value="{{ $work_request->number }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Driver</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request?->driver?->nm_lengkap }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Activity</label>
                                            <input type="text" class="form-control" value="{{ $work_request->activity }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Unit Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request->equipment->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Unit Code</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request->equipment->code }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="">Serial Number</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request->equipment->serial_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="">Unit HM</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request->equipment->hm }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="">Unit KM</label>
                                            <input type="text" class="form-control"
                                                value="{{ $work_request->equipment->km }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Project</label>
                                            <input type="hidden" name="location_id"
                                                value="{{ isset($work_order) ? $work_order->location_id : $work_request->location_id }}">
                                            <select name="project_id" id="" class="form-control">
                                                @foreach ($projects as $project)
                                                    <option
                                                        {{ isset($work_order) && $work_order->project_id == $project['id'] ? 'selected' : '' }}
                                                        value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Supervisor</label>
                                            <select name="supervisor_id" id="" class="form-control">
                                                @foreach ($supervisor as $item)
                                                    <option
                                                        {{ isset($work_order) && $work_order->supervisor_id == $item->id ? 'selected' : '' }}
                                                        value="{{ $item?->id }}">{{ $item?->nm_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Details</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical" style="border-right: solid #e9e9e9 1.5px">
                                            <a class="nav-link active" id="v-pills-repairing-plan-tab" data-toggle="pill"
                                                href="#v-pills-repairing-plan" role="tab"
                                                aria-controls="v-pills-repairing-plan" aria-selected="true">Repairing
                                                Plan</a>
                                            <a class="nav-link" id="v-pills-work-request-tab" data-toggle="pill"
                                                href="#v-pills-work-request" role="tab"
                                                aria-controls="v-pills-work-request" aria-selected="true">Work Request</a>
                                            <a class="nav-link" id="v-pills-work-sparepart-tab" data-toggle="pill"
                                                href="#v-pills-sparepart" role="tab"
                                                aria-controls="v-pills-sparepart" aria-selected="true">Spare Part</a>
                                            <a class="nav-link" id="v-pills-man-power-tab" data-toggle="pill"
                                                href="#v-pills-man-power" role="tab"
                                                aria-controls="v-pills-man-power" aria-selected="true">Man Power</a>
                                            <a class="nav-link" id="v-pills-tools-tab" data-toggle="pill"
                                                href="#v-pills-tools" role="tab" aria-controls="v-pills-tools"
                                                aria-selected="true">Tool Usage</a>
                                            <a class="nav-link" id="v-pills-repairing-activity-tab" data-toggle="pill"
                                                href="#v-pills-repairing-activity" role="tab"
                                                aria-controls="v-pills-repairing-activity" aria-selected="false">Repairing
                                                Activity</a>
                                            <a class="nav-link" id="v-pills-c-o-d-tab" data-toggle="pill"
                                                href="#v-pills-cod" role="tab" aria-controls="v-pills-cod"
                                                aria-selected="false">Cause Of damage analysis</a>
                                            <a class="nav-link" id="v-pills-puc-tab" data-toggle="pill"
                                                href="#v-pills-puc" role="tab" aria-controls="v-pills-puc"
                                                aria-selected="false">Post repair unit condition</a>
                                            <a class="nav-link" id="v-pills-remarks-tab" data-toggle="pill"
                                                href="#v-pills-remarks" role="tab" aria-controls="v-pills-remarks"
                                                aria-selected="false">Remarks</a>
                                            <a class="nav-link" id="v-pills-picture-tab" data-toggle="pill"
                                                href="#v-pills-picture" role="tab" aria-controls="v-pills-picture"
                                                aria-selected="false">Picture</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="tab-content mt-0" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-repairing-plan"
                                                role="tabpanel" aria-labelledby="v-pills-repairing-plan-tab">
                                                <h4>Rencana Perbaikan</h4>
                                                @php
                                                    $repairingPlan = \App\Models\Workshop\WorkOrder::REPAIRING_PLAN;
                                                    $repairingPlanSquare = sqrt(count($repairingPlan));
                                                    $i = 1;
                                                @endphp
                                                <div class="row">
                                                    @foreach ($repairingPlan as $key => $item)
                                                        <div class="col-sm-4">
                                                            <div class="checkbox d-inline-block mr-2">
                                                                <input
                                                                    {{ isset($work_order) && $work_order->repairing_plan && in_array($key, $work_order->repairing_plan) ? 'checked' : '' }}
                                                                    type="checkbox" class="checkbox-input"
                                                                    id="checkbox{{ $key }}"
                                                                    value="{{ $key }}" name="repairing_plan[]">
                                                                <label
                                                                    for="checkbox{{ $key }}">{{ $item }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-work-request" role="tabpanel"
                                                aria-labelledby="v-pills-work-request-tab">
                                                <h4>Permintaan Perbaikan</h4>
                                                <div class="row" style="margin-left: 1rem">
                                                    <table style="font-size:11px" class="table table-sm table-striped">
                                                        <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>Name</td>
                                                                <td>Description</td>
                                                            </tr>
                                                            @foreach ($work_request->additional_attributes as $item)
                                                                <tr>
                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                    <td>{{ $item->value }}</td>
                                                                    <td>{{ $item->description }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    @foreach ($work_request->media as $item)
                                                        <a target="_blank" href="{{ asset($item->file) }}">
                                                            <img src="{{ asset($item->file) }}" alt=""
                                                                class="img-thumbnail" height="50"
                                                                style="max-width:200px">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-sparepart" role="tabpanel"
                                                aria-labelledby="v-pills-sparepart-tab">
                                                <h4>SPAREPART</h4>
                                                @if (isset($work_request) && $work_request->part_order)
                                                    @foreach ($work_request->part_order as $item)
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="search"
                                                                        class="form-control"
                                                                        placeholder="Type part name or part code"
                                                                        value="{{ $item->sparepart->part_name }}"
                                                                        {{ $item->status == 1 ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <input name="part_id[]" type="hidden"
                                                                        value="{{ $item->part_id }}">
                                                                    <input name="part_status[]" type="hidden"
                                                                        value="{{ $item->status }}">
                                                                    <input readonly style="font-size:11px"
                                                                        name="part_number[]" type="text"
                                                                        class="form-control" placeholder="Part code"
                                                                        value="{{ $item->sparepart->part_number }}"
                                                                        {{ $item->status == 1 ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="number"
                                                                        name="part_qty[]" class="form-control"
                                                                        placeholder="Qty" value="{{ $item->qty }}"
                                                                        {{ $item->status == 1 ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="text"
                                                                        name="part_description[]" class="form-control"
                                                                        placeholder="Description"
                                                                        value="{{ $item->description }}"
                                                                        {{ $item->status == 1 ? 'readonly' : '' }}>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="form-group">
                                                                    @if (!$item->status)
                                                                        <button type="button" onclick="deleteItem(this)"
                                                                            class="btn btn-sm btn-danger">X</button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="row part-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addPart()">Add part</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-man-power" role="tabpanel"
                                                aria-labelledby="v-pills-man-power-tab">
                                                <h4>Man Power</h4>
                                                @if (isset($work_order) && $work_order->man_powers)
                                                    @foreach ($work_order->man_powers as $item)
                                                        <div class="row">
                                                            <div class="col-sm-11">
                                                                <div class="form-group">
                                                                    <select name="man_powers[]" class="form-control"
                                                                        id="" readonly>
                                                                        <option selected value="{{ $item['id'] }}">
                                                                            {{ $item['name'] }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="deleteItem(this)"
                                                                        class="btn btn-sm btn-danger">X</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="row man-power-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addMechanic()">Add man power</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-tools" role="tabpanel"
                                                aria-labelledby="v-pills-tools-tab">
                                                <h4>Penggunaan Tools</h4>
                                                @if (isset($work_order->tools))
                                                    <table class="table table-sm table-striped">
                                                        <thead>
                                                            <tr>
                                                                <td>#</td>
                                                                <td>Name</td>
                                                                <td>Qty</td>
                                                                <td>Missing</td>
                                                                <td>Description</td>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($work_order->tools->details as $item)
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $loop->index + 1 }}</td>
                                                                    <td>{{ $item->tools->name }}</td>
                                                                    <td>{{ $item->qty }}</td>
                                                                    <td>
                                                                        @if ($work_order->tools->missings)
                                                                            {{ $work_order->tools->missings->map(function ($i) use ($item) {
                                                                                    return $i->details->where('tools_id', $item->tools_id)->sum('qty');
                                                                                })->sum() }}
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->description }}</td>
                                                                </tr>
                                                            </tbody>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-cod" role="tabpanel"
                                                aria-labelledby="v-pills-cod-tab">
                                                <h4>Analisa Penyebab Kerusakan</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="damage_source_analysis" id="" cols="30" rows="5">{{ isset($work_order) ? $work_order->damage_source_analysis : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-repairing-activity" role="tabpanel"
                                                aria-labelledby="v-pills-repairing-activity-tab">
                                                <h4>Perbaikan Yang Dikerjakan</h4>
                                                @if (isset($work_order))
                                                    @foreach ($work_order->additional_attributes as $item)
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <div class="form-group">
                                                                    <input type="text" name="repairing_name[]"
                                                                        class="form-control" placeholder="Repairs done"
                                                                        value="{{ $item->value }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input type="text" name="repairing_remarks[]"
                                                                        class="form-control" placeholder="Remarks"
                                                                        value="{{ $item->description }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="deleteItem(this)"
                                                                        class="btn btn-sm btn-danger">X</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="row work-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addRepair()">Add repairing activitry</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-puc" role="tabpanel"
                                                aria-labelledby="v-pills-puc-tab">
                                                <div class="row">
                                                    <div class="form-group">
                                                        <h5>DAPAT DI OPERASIKAN KEMBALI</h5>
                                                        @foreach (\App\Models\Workshop\WorkOrder::CAN_BE_REOPERATED as $key => $val)
                                                            <div class="radio d-inline-block mr-2">
                                                                <input
                                                                    {{ isset($work_order) && $work_order->can_be_reoperated == $key ? 'checked' : '' }}
                                                                    type="radio" name="can_be_reoperated"
                                                                    id="canBeReoperated{{ $key }}"
                                                                    value="{{ $key }}">
                                                                <label
                                                                    for="canBeReoperated{{ $key }}">{{ $val }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group">
                                                        <h5>DIBUTUHKAN PENANGANAN LEBIH LANJUT</h5>
                                                        @foreach (\App\Models\Workshop\WorkOrder::NEED_FURTHER_TREATMENT as $key => $val)
                                                            <div class="radio d-inline-block mr-2">
                                                                <input
                                                                    {{ isset($work_order) && $work_order->need_further_treatment == $key ? 'checked' : '' }}
                                                                    type="radio" name="need_further_treatment"
                                                                    id="needFurtherTreatment{{ $key }}"
                                                                    value="{{ $key }}">
                                                                <label
                                                                    for="needFurtherTreatment{{ $key }}">{{ $val }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-remarks" role="tabpanel"
                                                aria-labelledby="v-pills-remarks-tab">
                                                <h4>Catatan</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <textarea name="remarks" id="" cols="30" rows="5" class="form-control">{{ isset($work_order) ? $work_order->remarks : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-picture" role="tabpanel"
                                                aria-labelledby="v-pills-picture-tab">
                                                @if (isset($work_order))
                                                    <div class="row" style="margin-bottom: 10px">
                                                        @foreach ($work_order->media as $item)
                                                            <div class="image-container">
                                                                <a target="_blank" href="{{ asset($item->file) }}">
                                                                    <img src="{{ asset($item->file) }}" alt=""
                                                                        class="img=thumbnail" height="50">
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    style="margin-right: 20px"
                                                                    data-id="{{ $item->id }}"
                                                                    onclick="deleteImage(this)">delete</button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                <div class="row picture-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="addPicture()">Add picture</button>
                                                    </div>
                                                </div>
                                            </div>
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
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        var mechanic = {!! $mechanic !!};

        function deleteImage(el) {
            let imageId = $(el).data('id');
            let token = '{{ csrf_token() }}';
            $.post('{{ route('workshop.work-order.delete-image') }}', {
                id: imageId,
                _token: token
            }, function(response) {
                if (response.status == 'ok') {
                    alert('Image has been deleted');
                    $(el).closest('.image-container').remove();
                }
            })
        }

        function addRepair() {
            let item = `<div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" name="repairing_name[]" class="form-control" placeholder="Repairs done" value="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="text" name="repairing_remarks[]" class="form-control" placeholder="Remarks" value="">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" onclick="deleteItem(this)" class="btn btn-danger">X</button>
                            </div>
                        </div>
                    </div>`;
            $('.work-button').before(item);
        }

        function generateOption(selectedId = null) {
            var option = '<option value="">Please Choose</option>';

            for (let i = 0; i < mechanic.length; i++) {
                if (selectedId == mechanic[i].id) {
                    option += '<option selected value="' + mechanic[i].id + '">' + mechanic[i].name + '</option>';
                } else {
                    option += '<option value="' + mechanic[i].id + '">' + mechanic[i].name + '</option>';
                }
            }
            return option;
        }

        function addMechanic() {

            let item = `<div class="row">
                        <div class="col-sm-11">
                            <div class="form-group">
                                <select name="man_powers[]" class="form-control" id="">
                                ${generateOption()}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button type="button" onclick="deleteItem(this)" class="btn btn-danger">X</button>
                            </div>
                        </div>
                    </div>`;
            $('.man-power-button').before(item);
        }

        function deleteItem(el) {
            $(el).closest('.row').remove();
        }

        function addPicture(param) {
            let item = `<div class="row">
                    <div class="col-sm-11">
                        <div class="form-group">
                            <input type="file" name="picture[]" id="" >
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <button type="button" onclick="deleteItem(this)" class="btn btn-danger">X</button>
                        </div>
                    </div>

                </div>`;
            $('.picture-button').before(item);
        }

        function addPart() {
            let item = `<div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input style="font-size:11px" type="search" class="form-control" placeholder="Type part name or part code" required>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input name="part_id[]" type="hidden">
                            <input readonly style="font-size:11px" name="part_number[]" type="text" class="form-control" placeholder="Part code" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input style="font-size:11px" type="number" name="part_qty[]" class="form-control" placeholder="Qty" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input style="font-size:11px" type="text" name="part_description[]" class="form-control" placeholder="Description">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <button type="button" onclick="deleteItem(this)" class="btn btn-danger">X</button>
                        </div>
                    </div>
                </div>`;
            $('.part-button').before(item);
            initAutoComplete();
        }

        function initAutoComplete() {
            $('input[type="search"]').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('workshop.utility.part-autocomplete') }}",
                        dataType: "json",
                        data: request,
                        success: function(data) {
                            response(data);
                        }

                    });
                },
                minLength: 1,
                select: function(event, ui) {
                    $(this).closest('.row').children().eq(1).children().find('input[name="part_number[]"]').val(
                        ui.item.part_number);
                    $(this).closest('.row').children().eq(1).children().find('input[name="part_id[]"]').val(ui
                        .item.id);
                }
            });
        }
        $(document).ready(function() {
            initAutoComplete();
        })
    </script>
@endsection
