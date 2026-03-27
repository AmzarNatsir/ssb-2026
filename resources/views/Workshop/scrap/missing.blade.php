@extends('Workshop.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">

<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <h1>Report Missing Tools</h1>
            </div>
        </div>
        <form  action="{{ route('workshop.tool-usage.store-missing', $tool_usage->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row ">
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Tool missing details</h4>
                            </div>
                         </div>
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Date</label>
                                        <input type="date" class="form-control" value="" name="date" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">User</label>
                                        <select name="user_id" id="" class="form-control">
                                            @foreach ($users as $item)
                                                <option value="{{ $item->id }}">{{ $item->nm_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Reason : </label>
                                    <div class="form-group">
                                        <textarea name="reason" cols="30" rows="2" class="form-control"></textarea>
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
                <div class="col-sm-6">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Tool List</h4>
                            </div>
                        </div>
                        <div class="iq-card-body item-wrapper" >
                            @if (isset($tool_usage))
                            @php
                                $toolMissing =null;
                                if ($tool_usage->missings) {
                                    $toolMissing = $tool_usage->missings->map(function($item){
                                        return $item->details->mapWithKeys(function($i){ return ['tools_id'=>$i->tools_id, 'qty' =>$i->qty]; })->toArray();
                                    })->groupBy('tools_id')->map(function($item){
                                        return $item->sum('qty');
                                    });
                                }
                            @endphp
                            @foreach ($tool_usage->details as $item)
                                @php
                                    $qty = isset($toolMissing) && isset($toolMissing[$item->tools_id]) ? abs($toolMissing[$item->tools_id] - $item->qty) : $item->qty;
                                @endphp
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="hidden" name="part_id[]" value="{{ $item->tools_id}}">
                                            <input type="search" placeholder="Type tool code or name" class="form-control" required value="{{ $item->tools->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <input type="number" placeholder="Qty" class="form-control" name="qty[]" required value="{{ $qty }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    function deleteItem(el) {
        $(el).closest('.row').remove();
    }
</script>
@endsection

