@extends('Workshop.layouts.master')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <h1>Work Request</h1>
                </div>
            </div>
            <form
                action="{{ isset($work_request) ? route('workshop.work-request.update', $work_request->id) : route('workshop.work-request.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($work_request))
                    @method('put')
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="iq-card">
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Unit</label>
                                            <select name="equipment_id" id="" class="form-control"
                                                onchange="setLocation(this)" required>
                                                <option value="">Please select unit</option>
                                                @foreach ($equipments as $equipment)
                                                    <option data-location="{{ $equipment->location_id }}"
                                                        data-project="{{ $equipment->project_id }}"
                                                        {{ isset($work_request) && $work_request->equipment_id == $equipment->id ? 'selected' : '' }}
                                                        value="{{ $equipment->id }}">{{ $equipment->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="hidden" name="project_id"
                                                value="{{ isset($work_request) ? $work_request->project_id : '' }}">
                                            <label for="">Location</label>
                                            <select name="location_id" id="" class="form-control" required>
                                                <option value="">Please location</option>
                                                @foreach ($locations as $location)
                                                    <option
                                                        {{ isset($work_request) && $work_request->location_id == $location->id ? 'selected' : '' }}
                                                        value="{{ $location->id }}">{{ $location->location_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Operator/Driver</label>
                                            <select name="driver_id" id="" class="form-control" required>
                                                <option value="">Please select driver</option>
                                                @foreach ($drivers as $driver)
                                                    <option
                                                        {{ isset($work_request) && $work_request->driver_id == $driver->id ? 'selected' : '' }}
                                                        value="{{ $driver->id }}">{{ $driver->nm_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Activity</label>
                                            <select name="activity" id="" class="form-control" required>
                                                <option
                                                    {{ isset($work_request) && $work_request->activity == \App\Models\Workshop\WorkRequest::ACTIVITY_SERVICE ? 'selected' : '' }}
                                                    value="SERVICE">Service</option>
                                                <option
                                                    {{ isset($work_request) && $work_request->activity == \App\Models\Workshop\WorkRequest::ACTIVITY_REPAIR ? 'selected' : '' }}
                                                    value="REPAIR">Repair</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Priority</label>
                                            <select name="priority" id="" class="form-control" required>
                                                <option
                                                    {{ isset($work_request) && $work_request->priority == \App\Models\Workshop\WorkRequest::PRIORITY_LOW ? 'selected' : '' }}
                                                    value="LOW">Low</option>
                                                <option
                                                    {{ isset($work_request) && $work_request->priority == \App\Models\Workshop\WorkRequest::PRIORITY_NORMAL ? 'selected' : '' }}
                                                    value="NORMAL">Normal</option>
                                                <option
                                                    {{ isset($work_request) && $work_request->priority == \App\Models\Workshop\WorkRequest::PRIORITY_HIGH ? 'selected' : '' }}
                                                    value="HIGH">High</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" id="" class="form-control">
                                                @foreach (\App\Models\Workshop\WorkRequest::STATUS as $status => $value)
                                                    <option
                                                        {{ isset($work_request) && $work_request->status == $status ? 'selected' : '' }}
                                                        value="{{ $status }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea name="description" cols="30" rows="3" class="form-control">{{ isset($work_request) ? $work_request->description : '' }}</textarea>
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
                                        <div class="nav flex-column nav-pills text-center" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <a class="nav-link active" id="v-pills-instruction-tab" data-toggle="pill"
                                                href="#v-pills-instruction" role="tab"
                                                aria-controls="v-pills-instruction" aria-selected="true">Instruction</a>
                                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                                aria-selected="false">Spare part</a>
                                            <a class="nav-link" id="v-pills-picture-tab" data-toggle="pill"
                                                href="#v-pills-picture" role="tab" aria-controls="v-pills-picture"
                                                aria-selected="false">Picture</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="tab-content mt-0" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-instruction"
                                                role="tabpanel" aria-labelledby="v-pills-instruction-tab">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <h6>Work Instruction</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <h6>Description</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                    </div>
                                                </div>
                                                @if (isset($work_request) && $work_request->additional_attributes)
                                                    @foreach ($work_request->additional_attributes as $item)
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="text" name="instruction_name[]"
                                                                        class="form-control"
                                                                        value="{{ $item->value }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="text" name="instruction_description[]"
                                                                        class="form-control"
                                                                        value="{{ $item->description }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="deleteItem(this)"
                                                                        class="btn btn-danger">X</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="row work-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-success"
                                                            onclick="addInstruction()">Add item</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                 <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <h6>Part name</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <h6>Part Code</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <h6>Quantity</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <h6>Description</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                    </div>
                                                </div>
                                                @if (isset($work_request) && $work_request->part_order)
                                                    @foreach ($work_request->part_order as $item)
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="search"
                                                                        class="form-control"
                                                                        placeholder="Type part name or part code"
                                                                        value="{{ $item->sparepart->part_name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <input name="part_id[]" type="hidden"
                                                                        value="{{ $item->part_id }}">
                                                                    <input readonly style="font-size:11px"
                                                                        name="part_number[]" type="text"
                                                                        class="form-control" placeholder="Part code"
                                                                        value="{{ $item->sparepart->part_number }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="number"
                                                                        name="part_qty[]" class="form-control"
                                                                        placeholder="Qty" value="{{ $item->qty }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <input style="font-size:11px" type="text"
                                                                        name="part_description[]" class="form-control"
                                                                        placeholder="Description"
                                                                        value="{{ $item->description }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="deleteItem(this)"
                                                                        class="btn btn-danger">X</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <div class="row part-button" style="text-align: right">
                                                    <div class="col-sm-12">
                                                        <button type="button" class="btn btn-success"
                                                            onclick="addPart()">Add part</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-picture" role="tabpanel"
                                                aria-labelledby="v-pills-picture-tab">
                                                @if (isset($work_request))
                                                    <div class="row" style="margin-bottom: 10px">
                                                        @foreach ($work_request->media as $item)
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
                                                        <button type="button" class="btn btn-success"
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
            </form>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        function deleteImage(el) {
            let imageId = $(el).data('id');
            let token = '{{ csrf_token() }}';
            $.post('{{ route('workshop.work-request.delete-image') }}', {
                id: imageId,
                _token: token
            }, function(response) {
                if (response.status == 'ok') {
                    alert('Image has been deleted');
                    $(el).closest('.image-container').remove();
                }
            })
        }

        function setLocation(el) {
            let selectedLocation = $(el).find(':selected').data('location');
            let selectedProject = $(el).find(':selected').data('project');
            let locationElement = $(el).closest('.row').find('select[name="location_id"]').val(selectedLocation);
            let projectElement = $(el).closest('.row').find('input[name="project_id"]').val(selectedProject);
        }

        function addInstruction() {
            let item = `<div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input style="font-size:11px" type="text" name="instruction_name[]" class="form-control"  required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input style="font-size:11px" type="text" name="instruction_description[]" class="form-control" >
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
                            <input readonly style="font-size:11px" name="part_number[]" type="text" class="form-control" placeholder="" >
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input style="font-size:11px" type="number" name="part_qty[]" class="form-control" placeholder="" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input style="font-size:11px" type="text" name="part_description[]" class="form-control" placeholder="">
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

        function deleteItem(el) {
            $(el).closest('.row').remove();
        }

        $(document).ready(function() {
            initAutoComplete();
        })
    </script>
@endsection
