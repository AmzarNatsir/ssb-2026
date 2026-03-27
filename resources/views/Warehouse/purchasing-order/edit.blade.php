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
                            <h4 class="card-title">Purchasing Order</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="purchasingOrderForm" action={{ !isset($purchasingOrder) ? route('warehouse.purchasing-order.store') : route('warehouse.purchasing-order.update',$purchasingOrder->model->id) }} method="POST" >
                            <div class="iq-card-body">
                                @csrf
                                @isset($purchasingOrder)
                                    @method('PUT')
                                @endisset
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Purchasing Comparison Number</label>
                                                <input type="hidden" value="{{ isset($purchasingComparison) ? $purchasingComparison->model->id : $purchasingOrder->model->purchasing_comparison->id }}" name="purchasing_comparison_id">
                                                <input type="hidden" name="reference_id" value="{{ isset($purchasingComparison->model->reference_id) ? $purchasingComparison->model->reference_id : (isset($purchasingOrder) ? $purchasingOrder->model->reference_id : '') }}">
                                                <input type="text" class="form-control" value="{{ isset($purchasingComparison) ? $purchasingComparison->model->number : $purchasingOrder->model->purchasing_comparison->number }}" readonly >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <input type="hidden" value="{{ isset($supplier) ? $supplier->id : $purchasingOrder->model->supplier->id }}" name="supplier_id">
                                                <input type="text" class="form-control" value="{{ isset($supplier) ? $supplier->name : $purchasingOrder->model->supplier->name }}" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea class="form-control" name="remarks" cols="30" rows="5">{{ isset($purchasingOrder) ? $purchasingOrder->model->remarks : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="">Tanggal Kirim :</label>
                                                <input type="date" name="send_date" value="{{ isset($purchasingOrder) ? date('Y-m-d', strtotime($purchasingOrder->model->send_date)) : date('Y-m-d', strtotime(now())) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="">Disetujui Oleh :</label>
                                                <select id="approved-id" name="approved_by" id="" class="form-control">
                                                    @foreach ($approved_by as $item)
                                                        <option {{ isset($purchasingOrder) && $purchasingOrder->model->approved_by == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                                    @endforeach
                                                </select>
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
                            @php
                                $subtotal = 0;
                                $total = 0;
                            @endphp
                            @foreach ( $purchasingOrder->model->details as $item)
                            @php
                                if (isset($item->discount)) {
                                    $total = ($item->price * $item->qty) - $item->discount ;
                                } else {
                                    $total = $item->price * $item->qty;
                                }

                                $subtotal += $total;

                            @endphp
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-3">
                                        <h6>Part Name</h6>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <h6>Part Number</h6>
                                    </div>
                                    <div class="col-sm-1 col-lg-1">
                                        <h6>Qty</h6>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <h6>Price</h6>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <h6>Discount</h6>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <h6>Subtotal</h6>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-12 col-lg-12">
                                        <h6>Remarks</h6>
                                    </div>
                                </div>
                                <hr>

                                <div class="row" style="margin-bottom:5px">
                                    @if (!isset($purchasingOrder))
                                        <div class="col-sm-3">
                                            <select name="supplier_id[]" class="form-control" id="">
                                                @foreach ($suppliers as $supplieritem)
                                                    <option value="{{ $supplierItem->id }}">{{ $supplierItem->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" required value="{{ $item->sparepart->part_name }}" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}" >
                                        <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $item->sparepart->id }}" >
                                    </div>
                                    <div class="col-sm-1 col-lg-1">
                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required value="{{ $item->qty }}" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="number" class="form-control part-price" placeholder="estimasi harga" name="price[]"  required value="{{ $item->price }}" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="input" class="form-control" placeholder="discount" name="discount[]" onchange="calculate_total()" value="{{ isset($item->discount) ? $item->discount : '' }}" >
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="input" class="form-control" placeholder="total" name="total[]" value="{{ $total }}" readonly>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-12 col-lg-12">
                                        <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="{{ $item->remarks }}">
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Total Diskon</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="total_discount" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->total_discount : 0 }}"  readonly >
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Subtotal</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" value="{{ $subtotal }}" name="subtotal" id="subtotal" readonly>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">PPN (%)</div>
                                <div class="col-sm-1 col-lg-1">
                                    <input type="number" class="form-control" name="ppn" step="1" onchange="calculate_total()" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->ppn : 10 }}" >
                                </div>
                                <div class="col-sm-1 col-lg-1" style="padding-left:0;">
                                    <input type="number" id="ppn_value" class="form-control" readonly style="font-size:12px;padding:0%">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Beban Tansportasi</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="additional_expense" onchange="calculate_total()" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->additional_expense  : 0 }}">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Grand Total</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="grand_total" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->grand_total: 0 }}" readonly>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-6 col-lg-6">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('warehouse.purchasing-order.index') }}" class="btn iq-bg-danger">Batal</a>
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

    function calculate_total() {
        var subtotal = 0;
        var total_discount = 0;
        var grand_total = 0;
        $('input[name="part_name[]"]').map(function (index) {
            var qty = $('input[name="qty[]"]').eq(index).val() ? parseFloat($('input[name="qty[]"]').eq(index).val()) : 0;
            var price = $('input[name="price[]"]').eq(index).val() ? parseFloat($('input[name="price[]"]').eq(index).val()) : 0 ;
            var discount = $('input[name="discount[]"]').eq(index).val() ? parseFloat($('input[name="discount[]"]').eq(index).val()) : 0 ;
            var total = (price * qty) - discount ;
            subtotal += total;
            total_discount += discount;
            $('input[name="total[]"]').eq(index).val(total);
        });

        var additional_expense =  $('input[name="additional_expense"]').val() ? parseFloat($('input[name="additional_expense"]').val()) : 0;
        var ppn =  $('input[name="ppn"]').val() ? parseInt((subtotal) * (parseFloat($('input[name="ppn"]').val())/100)) : 0;
        $("#ppn_value").val(ppn);
        grand_total = subtotal + additional_expense + ppn  ;

        $('input[name="total_discount"]').val(total_discount);
        $('input[name="grand_total"]').val(grand_total);
        $('input[name="subtotal"]').val(subtotal);
    }

    $(document).ready(function() {
        calculate_total();
    });


</script>
@endsection
