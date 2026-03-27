@extends('Workshop.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <form id="purchasingOrderForm" action={{ !isset($issued) ? route('warehouse.issued.store') : route('warehouse.issued.update',$issued->model->id) }} method="POST" >
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Issued</h4>
                            </div>
                        </div>
                            <div class="iq-card-body">
                                @csrf
                                @isset($issued)
                                    @method('PUT')
                                @endisset
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="">Diterima Oleh :</label>
                                                <select id="approved-id" name="received_by" id="" class="form-control">
                                                    @foreach ($received_by as $item)
                                                        <option {{ isset($issued) && $issued->model->received_by == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="">Tanggal Terima</label>
                                                <input type="date" name="received_at" id="" class="form-control" value="{{ isset($issued) ? date('Y-m-d', strtotime($issued->model->received_at)) : date('Y-m-d', strtotime(now())) }}">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="">Keb/Unit</label>
                                                <input type="hidden" name="reference_id" value="{{ isset($work_order) ? $work_order->id : (isset($issued) ? $issued->model->reference_id : '' ) }}">
                                                <input type="text" class="form-control" value="{{ isset($work_order) ? $work_order->number : (isset($issued->model->work_order) ? $issued->model->work_order->number : '' ) }}" readonly  >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea class="form-control" name="remarks" cols="30" rows="5">{{ isset($issued) ? $issued->model->remarks : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="iq-card">
                        <div class="iq-card-body">
                            <div class="container-fluid sparepartSection">
                                    <div class="row" style="margin-bottom:5px">
                                        <div class="col-sm-3 col-lg-3">
                                            <h6>Part Name</h6>
                                        </div>
                                        <div class="col-sm-2 col-lg-2">
                                            <h6>Part Number</h6>
                                        </div>
                                        <div class="col-sm-1 col-lg-1">
                                            <h6>Quantity</h6>
                                        </div>
                                        <div class="col-sm-5 col-lg-5">
                                            <h6>Description</h6>
                                        </div>
                                        <div class="col-sm-1 col-lg-1">
                                        </div>
                                    </div>
                                @if (isset($issued))
                                    @foreach ($issued->model->details as $item)
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-sm-3 col-lg-3">
                                                <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" value="{{ $item->sparepart->part_name }}"  required>
                                            </div>
                                            <div class="col-sm-2 col-lg-2">
                                                <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}">
                                                <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $item->part_id }}" >
                                            </div>
                                            <div class="col-sm-1 col-lg-1">
                                                <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required min=1 value="{{ $item->qty }}">
                                            </div>
                                            <div class="col-sm-5 col-lg-5">
                                                <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="{{ $item->remarks }}"">
                                            </div>
                                            <div class="col-sm-1 col-lg-1">
                                                <a href="#" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                @if (isset($work_order))
                                    @foreach ($work_order->work_request->part_order->where('status', 0) as $item)
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-sm-3 col-lg-3">
                                                <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" value="{{ $item->sparepart->part_name }}"  required>
                                            </div>
                                            <div class="col-sm-2 col-lg-2">
                                                <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}">
                                                <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $item->part_id }}" >
                                            </div>
                                            <div class="col-sm-1 col-lg-1">
                                                <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required min=1 value="{{ $item->qty }}">
                                            </div>
                                            <div class="col-sm-5 col-lg-5">
                                                <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="{{ $item->remarks }}"">
                                            </div>
                                            <div class="col-sm-1 col-lg-1">
                                                <a href="#" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="iq-card-body">
                                <div class="container-fluid">
                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-sm-12 col-lg-12" style="text-align: right">
                                            <button type="button" class="btn btn-success" onclick="addItem()" > <i class="ri-add-circle-fill"></i> tambah part</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-6 col-lg-6">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('warehouse.issued.index') }}" class="btn iq-bg-danger">Batal</a>
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
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    function deleteItem(el) {
        $(el).closest('.row').remove();
    }

    function addItem(){
        let item = `
        <div class="row" style="margin-bottom:5px">
            <div class="col-sm-3 col-lg-3">
                <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]"  required>
            </div>
            <div class="col-sm-2 col-lg-2">
                <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required >
                <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]" >
            </div>
            <div class="col-sm-1 col-lg-1">
                <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required min=1>
            </div>
            <div class="col-sm-5 col-lg-5">
                <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]">
            </div>
            <div class="col-sm-1 col-lg-1">
                <a href="#" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</a>
            </div>
        </div>`;

        $('.sparepartSection').append(item);
        initAutoComplete();

    }

    function initAutoComplete(){
        $('input[type="search"]').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('warehouse.master-data.spare-part.autocomplete') }}",
                    dataType: "json",
                    data: request,
                    success: function(data){
                        response(data);
                    }

                });
            },
            minLength: 1,
            select: function(event, ui){
                $(this).closest('.row').children().eq(1).children().first().val(ui.item.part_number);
                $(this).closest('.row').children().eq(1).children().last().val(ui.item.id);
                $(this).closest('.row').children().eq(2).children().first().attr('max', ui.item.stock);
            }
        });
    }

    $(document).ready(function(){
        @if(!isset($issued) && !isset($work_order))
            addItem();
        @endif
    });
</script>
@endsection
