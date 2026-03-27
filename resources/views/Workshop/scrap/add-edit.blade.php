@extends('Workshop.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">

<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1>Tool Usage</h1>
            </div>
        </div>
        <form  action="{{ isset($tool_usage)? route('workshop.tool-usage.update', $tool_usage->id) : route('workshop.tool-usage.store', $work_order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($tool_usage))
                @method('put')
            @endif
            <div class="row ">
                <div class="col-sm-4">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Work Order Details</h4>
                            </div>
                         </div>
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Date Start</label>
                                        <input type="text" class="form-control" value="{{ date('d-m-Y H:i', strtotime($work_order->date_start)) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Date Finish</label>
                                        <input type="text" class="form-control" value="{{ date('d-m-Y H:i', strtotime($work_order->date_finish)) }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Number</label>
                                        <input type="text" readonly class="form-control" value="{{ $work_order->number }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Unit</label>
                                        <input type="text" readonly class="form-control" value="{{ $work_order->equipment->name }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Tool Details</h4>
                            </div>
                        </div>
                        <div class="iq-card-body item-wrapper" >
                            @if (isset($tool_usage))
                            @foreach ($tool_usage->details as $item)
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="hidden" name="part_id[]" value="{{ $item->tools_id}}">
                                            <input type="search" placeholder="Type tool code or name" class="form-control" required value="{{ $item->tools->name }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" placeholder="Qty" class="form-control" name="qty[]" required value="{{ $item->qty }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <textarea name="description[]" id="" cols="30" rows="1" class="form-control">{{ $item->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                            <div class="row item-action-button">
                                <div class="col-sm-12">
                                    <div class="form-group" style="text-align: right">
                                        <button type="button" class="btn btn-info" onclick="addItem()">Add Item</button>
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
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    function addItem() {
        let item = `<div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="hidden" name="part_id[]">
                                <input type="search" placeholder="Type tool code or name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" placeholder="Qty" class="form-control" name="qty[]" required>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <textarea name="description[]" id="" cols="30" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <button class="btn btn-danger" type="button" onclick="deleteItem(this)">X</button>
                            </div>
                        </div>
                    </div>`;
        $('.item-action-button').before(item);
        initAutoComplete();
    }

    function deleteItem(el) {
        $(el).closest('.row').remove();
    }

    function initAutoComplete(){
        $('input[type="search"]').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('workshop.utility.tool-autocomplete') }}",
                    dataType: "json",
                    data: request,
                    success: function(data){
                        response(data);
                    }

                });
            },
            minLength: 1,
            select: function(event, ui){
                $(this).closest('.row').find('input[name="part_id[]"]').val(ui.item.id);
                $(this).closest('.row').find('input[name="qty[]"]').attr('max',ui.item.qty);
            }
        });
    }

    $(document).ready(function(){
        $(document).ready(function(){
            initAutoComplete();
        })
    });
</script>
@endsection

