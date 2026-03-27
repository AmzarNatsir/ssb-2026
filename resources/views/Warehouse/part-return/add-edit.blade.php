@extends('Workshop.layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}">
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Part Return</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="purchasingOrderForm" action={{ !isset($partReturn) ? route('warehouse.part-return.store') : route('warehouse.part-return.update',$partReturn->model->id) }} method="POST" >
                            <div class="iq-card-body">
                                @csrf
                                @isset($partReturn)
                                    @method('PUT')
                                @endisset
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Purchasing Order Number</label>
                                                <input type="hidden" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->id : $partReturn->model->purchasing_order->id }}" name="purchasing_order_id">
                                                <input type="text" class="form-control" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->number : $partReturn->model->purchasing_order->number }}" readonly >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <input type="hidden" value="{{ isset($partReturn) ?  $partReturn->model->supplier->id : $purchasingOrder->model->supplier->id  }}" name="supplier_id">
                                                <input type="text" class="form-control" value="{{ isset($partReturn) ?  $partReturn->model->supplier->name : $purchasingOrder->model->supplier->name   }}" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea class="form-control" name="remarks" cols="30" rows="5">{{ isset($partReturn) ? $partReturn->model->remarks : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="container-fluid">
                            <div class="row" style="margin-bottom:5px">
                                <div class="col-sm-3 col-lg-3"><h6>Part Name</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3"><h6>Part Number</h6>
                                </div>
                                <div class="col-sm-1 col-lg-1"><h6>Quantity</h6>
                                </div>
                                <div class="col-sm-2 col-lg-2"><h6>Price</h6>
                                </div>
                                <div class="col-sm-2 col-lg-2"><h6>Subtotal</h6>
                                </div>
                                <div class="col-sm-1 col-lg-1">
                                </div>
                            </div>
                            @php
                                $subtotal = 0;
                                $total = 0;
                            @endphp
                            @foreach ( isset($purchasingOrder) ? $purchasingOrder->model->details->where('status', \App\Models\Warehouse\PurchasingOrderDetail::STATUS_NOT_RECEIVED) : $partReturn->model->details as $item)
                            @php
                                if(isset($purchasingOrder) && $purchasingOrder->model->status == \App\Models\Warehouse\Receiving::CURRENT_STATUS ){
                                    $qty = abs($item->qty - $item->receiving_detail->sum('qty'));
                                } else {
                                    $qty = $item->qty;
                                }

                                $total = $item->price * $qty;

                                $subtotal += $total;

                            @endphp
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="hidden" name="purchasing_order_detail_id[]" value="{{ isset($item->purchasing_order_detail_id) ? $item->purchasing_order_detail_id : $item->id  }}">
                                        <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" required value="{{ $item->sparepart->part_name }}" readonly>
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}" >
                                        <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $item->sparepart->id }}" >
                                    </div>

                                    <div class="col-sm-1 col-lg-1">
                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required value="{{ $qty }}" max="{{ $qty }}" min="0" onchange="calculate_total()" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="price[]"  required value="{{ $item->price }}" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="number" class="form-control" style="font-size: 12px" name="total[]"  value="{{ $total }}" readonly>
                                    </div>
                                    <div class="col-sm-1 col-lg-1">
                                        <button type="button" class="btn btn-danger rounded delete-button " alt='hapus' onclick='deleteItem(this)' >X</button>
                                    </div>
                                </div>

                            @endforeach
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-9 col-lg-9" style="text-align: right">Subtotal</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" value="{{ $subtotal }}" name="subtotal" id="subtotal" readonly>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-9 col-lg-9" style="text-align: right">PPN (%)</div>
                                <div class="col-sm-1 col-lg-1">
                                    <input type="number" class="form-control" name="ppn" step="0.1" onchange="calculate_total()" value="11" >
                                </div>
                                <div class="col-sm-1 col-lg-1" style="padding-left:0;">
                                    <input type="number" id="ppn_value" class="form-control" readonly style="font-size:12px;padding:0%">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-9 col-lg-9" style="text-align: right">Grand Total</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="grand_total" value="{{ $subtotal }}" readonly>
                                </div>
                            </div>

                            <br>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-6 col-lg-6">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('warehouse.part-return.index') }}" class="btn iq-bg-danger">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

{{-- Add New Modal --}}
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    function deleteItem(el) {
        $(el).closest('.row').remove();
        calculate_total();
    }

    function calculate_total() {
        var subtotal = 0;
        var grand_total = 0;
        $('input[name="part_name[]"]').map(function (index) {
            var qty = $('input[name="qty[]"]').eq(index).val() ? parseFloat($('input[name="qty[]"]').eq(index).val()) : 0;
            var price = $('input[name="price[]"]').eq(index).val() ? parseFloat($('input[name="price[]"]').eq(index).val()) : 0 ;
            var total = price * qty;
            subtotal += total;
            $('input[name="total[]"]').eq(index).val(total);
        });

        var ppn =  $('input[name="ppn"]').val() ? subtotal  * (parseFloat($('input[name="ppn"]').val())/100) : 0;
        $("#ppn_value").val(ppn);
        grand_total = subtotal + ppn  ;

        $('input[name="grand_total"]').val(grand_total);
        $('input[name="subtotal"]').val(subtotal);
    }

    $(document).ready(function(){
        calculate_total();
    });
</script>
@endsection
