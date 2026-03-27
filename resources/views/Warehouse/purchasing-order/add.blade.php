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
                        <form id="purchasingOrderForm" action={{ route('warehouse.purchasing-order.store')}} method="POST" >
                            <div class="iq-card-body">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Purchasing Comparison Number</label>
                                                <input type="hidden" value="{{ $purchasingComparison->model->id }}" name="purchasing_comparison_id">
                                                <input type="hidden" name="reference_id" value="{{ $purchasingComparison->model->reference_id ?? '' }}">
                                                <input type="text" class="form-control" value="{{ $purchasingComparison->model->number}}" readonly >
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="">Tanggal Kirim :</label>
                                                <input type="date" name="send_date" value="{{ date('Y-m-d', strtotime(now())) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-lg-3">
                                            <div class="form-group">
                                                <label for="">Disetujui Oleh :</label>
                                                <select id="approved-id" name="approved_by" id="" class="form-control">
                                                    @foreach ($approved_by as $item)
                                                        <option value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea class="form-control" name="remarks" cols="30" rows="5"></textarea>
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
                                <div class="col-sm-3">
                                    <h6>Supplier</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3">
                                    <h6>Part Name</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3">
                                    <h6>Part Number</h6>
                                </div>
                                <div class="col-sm-1 col-lg-1">
                                    <h6>Qty</h6>
                                </div>
                                <div class="col-sm-2 col-lg-2">
                                    <h6>Price</h6>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom:5px">
                                <div class="col-sm-3 col-lg-3"></div>
                                <div class="col-sm-3 col-lg-3">
                                    <h6>Discount</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3">
                                    <h6>Sub Total</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3">
                                    <h6>Keterangan</h6>
                                </div>
                            </div>
                            <hr>
                            @php
                                $subtotal = 0;
                                $total = 0;
                            @endphp
                            @foreach ($partsData as $part)
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-3">
                                        <select name="supplier_id[]" class="form-control" id="" required onchange="setPrice(this)">
                                            <option value="">Pilih supplier</option>
                                            @foreach ($part['suppliers'] as $supplier)
                                                <option data-price="{{ $supplier['price'] }}" value="{{ $supplier['id'] }}">{{ $supplier['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-3 col-lg-3">
                                        <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" required value="{{ $part['part_name'] }}" readonly>
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $part['part_number'] }}" >
                                        <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $part['part_id'] }}" >
                                    </div>
                                    <div class="col-sm-1 col-lg-1">
                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required value="{{ $part['qty'] }}" readonly>
                                    </div>
                                    <div class="col-sm-2 col-lg-2">
                                        <input type="number" class="form-control part-price" placeholder="estimasi harga" name="price[]"  required value="0" readonly>
                                    </div>

                                </div>

                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-3 col-lg-3"></div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="discount" name="discount[]" onchange="calculate_total()" value="" >
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="total" name="total[]" value="0" readonly>
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="">
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
                                    <input type="number" class="form-control" name="ppn" step="1" onchange="calculate_total()" value="11" >
                                </div>
                                <div class="col-sm-1 col-lg-1" style="padding-left:0;">
                                    <input type="number" id="ppn_value" class="form-control" readonly style="font-size:12px;padding:0%">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Beban Tansportasi</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="additional_expense" onchange="calculate_total()" value="0">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-10 col-lg-10" style="text-align: right">Grand Total</div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" class="form-control" name="grand_total" value="0" readonly>
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

    function setPrice(el){
        let price = $(el).find(':selected').data('price');
        $(el).closest('.row').find('input[name="price[]"]').val(price);
        calculate_total();
    }

    $(document).ready(function() {
        calculate_total();
    });


</script>
@endsection
