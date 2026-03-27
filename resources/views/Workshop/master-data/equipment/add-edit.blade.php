@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1>Master Data Equipment</h1>
            </div>
        </div>
        <form action="{{ isset($equipment)? route('workshop.master-data.equipment.update', $equipment->id) : route('workshop.master-data.equipment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($equipment))
                @method('put')
            @endif
            <div class="row">
                <div class="col-sm-4 col-lg-4">
                    <div class="iq-card">
                        <div class="iq-card-body">
                        <img class="img-fluid" src="{{ isset($equipment) ? asset($equipment->picture) : asset('assets/images/no-image.png') }}" alt="">
                        <div class="form-group" style="margin-top: 5px">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="picture">
                                    <label class="custom-file-label" for="customFile">Picture</label>
                                    <small>Choose another image to replace previous one</small>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8 col-lg-8">
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" class="form-control" name="code" required value="{{ isset($equipment) ? $equipment->code : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" class="form-control" name="name" required  value="{{ isset($equipment) ? $equipment->name : '' }}" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Serial Number</label>
                                        <input type="text" class="form-control" name="serial_number" value="{{ isset($equipment) ? $equipment->serial_number : '' }}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Production Year</label>
                                        <input type="number" class="form-control" name="yop" value="{{ isset($equipment) ? $equipment->yop : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Model</label>
                                        <input type="text" class="form-control" name="model" value="{{ isset($equipment) ? $equipment->model : '' }}" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Person in charge</label>
                                        <select id="" class="form-control" name="pic">
                                            <option value="">Please select PIC</option>
                                            @foreach ($pics as $pic)
                                                <option {{ isset($equipment) && $equipment->pic == $pic->id ? 'selected':''  }} value="{{ $pic->id }}">{{ $pic->karyawan->nm_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select id="" class="form-control" name="status">
                                            <option value="">Please select status</option>
                                            @foreach (\App\Models\Workshop\Equipment::STATUS as $key => $status )
                                                <option {{ isset($equipment) && $equipment->status == $key ? 'selected':''  }} value="{{ $key }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">HM</label>
                                        <input type="number" class="form-control" name="hm" value="{{ isset($equipment) ? $equipment->hm : '' }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">KM</label>
                                        <input type="number" class="form-control" name="km" value="{{ isset($equipment) ? $equipment->km : '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Current Project</label>
                                        <select id="" class="form-control" name="project_id">
                                            <option value="">Please select project</option>
                                            @foreach ($projects as $project)
                                                <option {{ isset($equipment) && $equipment->project_id == $project->id ? 'selected':''  }} value="{{ $project->id }}">{{ $project->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Category</label>
                                        <select id="" class="form-control" name="equipment_category_id">
                                            <option value="">Please select category</option>
                                            @foreach ($equipment_category as $category)
                                                <option {{ isset($equipment) && $equipment->equipment_category_id == $category->id ? 'selected':''  }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Brand</label>
                                        <select id="" class="form-control" name="brand_id">
                                            <option value="">Please select brand</option>
                                            @foreach ($brands as $brand)
                                                <option {{ isset($equipment) && $equipment->brand_id == $brand->id ? 'selected':''  }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Location</label>
                                        <select id="" class="form-control" name="location_id">
                                            <option value="">Please select location</option>
                                            @foreach ($locations as $item)
                                                <option {{ isset($equipment) && $equipment->location_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->location_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <textarea id="" cols="30" rows="2" class="form-control" name="location">{{ isset($equipment)? $equipment->location : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Description</label>
                                    <textarea id="" cols="30" rows="4" class="form-control" name="description">{{ isset($equipment)? $equipment->description : '' }}</textarea>
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
                                <h4 class="card-title">Additional Attribute </h4>
                            </div>
                        </div>
                        <div class="iq-card-body ">
                            @if (isset($equipment))
                                @foreach ($equipment->additional_attributes as $additional_attribute)
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <input type="text" name="attribute_name[]" class="form-control" placeholder="Attribute" value="{{ $additional_attribute->name }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="text" name="attribute_value[]" class="form-control" placeholder="Value" value="{{ $additional_attribute->value }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <input type="text" name="attribute_description[]s" class="form-control" placeholder="Description" value="{{ $additional_attribute->description }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="#" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <hr class="attributessection">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12" style="text-align: right">
                                    <button type="button" class="btn btn-info addNewPart" onclick="addItem()" > <i class="ri-add-circle-fill"></i> Add Item</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Submit</button>
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
<script>
function addItem(){
    let item = `<div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <input type="text" name="attribute_name[]" class="form-control" placeholder="Attribute">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <input type="text" name="attribute_value[]" class="form-control" placeholder="Value">
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <input type="text" name="attribute_description[]s" class="form-control" placeholder="Description">
                </div>
            </div>
            <div class="col-sm-1">
                <a href="#" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</a>
            </div>
        </div>
        `;

        $('.attributessection').before(item);
    }

    function deleteItem(el) {
        $(el).closest('.row').remove();
    }
</script>
@endsection

