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
                                <h4 class="card-title">Tambah Spare Part </h4>
                            </div>
                        </div>
                        <?php $purchasing_type = isset($purchasingType) ? $purchasingType : $purchasingRequest->model->purchasing_type; ?>

                        <form id="purchasingRequestForm"
                            action={{ !isset($purchasingRequest) ? route('warehouse.purchasing-request.store') : route('warehouse.purchasing-request.update', $purchasingRequest->model->id) }}
                            method="POST">
                            <div class="iq-card-body">
                                @csrf
                                @isset($purchasingRequest)
                                    @method('PUT')
                                @endisset
                                <input type="hidden" name="purchasing_type" value="{{ $purchasing_type }} ">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12 sm-lg-12">
                                            <div class="form-group">
                                                <label for="name">Keb/Unit </label>
                                                @if (isset($work_order))
                                                    <input type="hidden" name="reference_id"
                                                        value="{{ optional($work_order)->id }}" name="reference_id">
                                                @endif
                                                @php
                                                    $unit = '';
                                                    if (isset($work_order)) {
                                                        $unit = $work_order->number;
                                                    } else {
                                                        if (isset($purchasingRequest) && $purchasingRequest->model->reference_id) {
                                                            $unit = $purchasingRequest->model->work_order->number;
                                                        }
                                                    }
                                                @endphp
                                                <input disabled class="form-control" name="part_name" type="text"
                                                    id="part_name" value="{{ $unit }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 sm-lg-12">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea name="remarks" class="form-control" cols="30" rows="2">{{ isset($purchasingRequest) ? $purchasingRequest->model->remarks : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                </div>
                            </div>

                            <div class="iq-card-body">
                                <div class="container-fluid sparepartSection">
                                    <div class="row" style="margin-bottom:5px">
                                        <div class="col-sm-3 col-lg-3" style="padding-right: 3px"><h6>Nama Part</h6>
                                        </div>
                                        <div class="col-sm-2 col-lg-2" style="padding-right: 3px"><h6>Part ID</h6>
                                        </div>
                                        <div class="col-sm-1 col-lg-1" style="padding-right: 3px"><h6>Kuantitas</h6>
                                        </div>
                                        <div class="col-sm-2 col-lg-2" style="padding-right: 3px"><h6>Estimasi Harga</h6>
                                        </div>
                                        <div class="col-sm-2 col-lg-1" style="padding-right: 3px"><h6>ETA</h6>
                                        </div>
                                        <div class="col-sm-2 col-lg-2" style="padding-right: 3px"><h6>Keterangan</h6>
                                        </div>
                                        <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                                        </div>
                                    </div>
                                    @if (isset($purchasingRequest))
                                        @foreach ($purchasingRequest->model->details as $item)
                                            <div class="row" style="margin-bottom:5px">
                                                <div class="col-sm-3 col-lg-3" style="padding-right: 3px">
                                                    <input type="search" class="form-control autocomplete"
                                                        placeholder="ketik nama part/part number" name="part_name[]"
                                                        onchange="calculateTotal()" required
                                                        value="{{ $item->sparepart->part_name }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="part id"
                                                        readonly name="part_number[]" required
                                                        value="{{ $item->sparepart->part_number }}">
                                                    <input type="hidden" class="form-control" placeholder="part id"
                                                        readonly name="part_id[]" value="{{ $item->sparepart->id }}">
                                                </div>
                                                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                                                    <input type="number" class="form-control" placeholder="qty"
                                                        style="font-size: 12px" name="qty[]" onchange="calculateTotal()"
                                                        required value="{{ $item->qty }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="number" class="form-control part-price"
                                                        placeholder="estimasi harga" name="price[]"
                                                        onchange="calculateTotal()" required value="{{ $item->price }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-1" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="eta"
                                                        name="eta[]" value="{{ $item->eta }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="keterangan"
                                                        name="part_remarks[]" value="{{ $item->remarks }}">
                                                </div>
                                                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                                                    <a href="#" class="btn btn-danger rounded delete-button "
                                                        alt='hapus' onclick='deleteItem(this)'>
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if (isset($work_order))
                                        @foreach ($work_order->work_request->part_order->where('status', 0) as $item)
                                            <div class="row" style="margin-bottom:5px">
                                                <div class="col-sm-3 col-lg-3" style="padding-right: 3px">
                                                    <input type="search" class="form-control autocomplete"
                                                        placeholder="ketik nama part/part number" name="part_name[]"
                                                        onchange="calculateTotal()" required
                                                        value="{{ $item->sparepart->part_name }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="part id"
                                                        readonly name="part_number[]" required
                                                        value="{{ $item->sparepart->part_number }}">
                                                    <input type="hidden" class="form-control" placeholder="part id"
                                                        readonly name="part_id[]" value="{{ $item->sparepart->id }}">
                                                </div>
                                                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                                                    <input type="number" class="form-control" placeholder="qty"
                                                        style="font-size: 12px" name="qty[]"
                                                        onchange="calculateTotal()" required value="{{ $item->qty }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="number" class="form-control part-price"
                                                        placeholder="estimasi harga" name="price[]"
                                                        onchange="calculateTotal()" required
                                                        value="{{ $item->sparepart->price }}">
                                                </div>
                                                <div class="col-sm-2 col-lg-1" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="eta"
                                                        name="eta[]" value="">
                                                </div>
                                                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                                                    <input type="input" class="form-control" placeholder="keterangan"
                                                        name="part_remarks[]" value="{{ $item->remarks }}">
                                                </div>
                                                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                                                    <a href="#" class="btn btn-danger rounded delete-button "
                                                        alt='hapus' onclick='deleteItem(this)'>
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>


                            <div class="row" style="margin-bottom:5px">
                                <div class="col-sm-3 col-lg-3">

                                </div>
                                <div class="col-sm-2 col-lg-2" style="text-align: right">
                                    <span>Total : </span>
                                </div>
                                <div class="col-sm-1 col-lg-1">
                                    <input type="number" readonly class="form-control" style="font-size: 12px"
                                        id="total-qty" name="total_qty" value="0">
                                </div>
                                <div class="col-sm-2 col-lg-2">
                                    <input type="number" readonly class="form-control part-price" id="total-price"
                                        name="total_price" value="0">
                                </div>
                                <div class="col-sm-2 col-lg-1">

                                </div>
                                <div class="col-sm-2 col-lg-2">

                                </div>
                                <div class="col-sm-1 col-lg-1">

                                </div>
                            </div>

                            <div class="iq-card-body">
                                <div class="row" style="margin-top: 10px">
                                    <div class="col-sm-6 col-lg-6">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('warehouse.purchasing-request.index') }}"
                                            class="btn iq-bg-danger">Batal</a>
                                    </div>
                                    <div class="col-sm-6 col-lg-6" style="text-align: right">
                                        @if (!isset($work_order))
                                            <button type="button" class="btn btn-success addNewPart"> <i
                                                    class="ri-add-circle-fill"></i> tambah part</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add New Modal --}}
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script>
        function calculateTotal() {
            var i = 0;
            var totalQty = 0;
            var totalPrice = 0;
            var grandTotal = 0;

            $('input[name="qty[]"]').map(function() {

                var qty = $(this).val() ? parseFloat($(this).val()) : 0;
                var price = $('input[name="price[]"]').eq(i).val() ? parseFloat($('input[name="price[]"]').eq(i)
                    .val()) : 0;

                grandTotal += qty * price;
                totalQty += qty;
                totalPrice += price;

                i++;
            });

            $('#total-qty').val(totalQty);
            $('#total-price').val(grandTotal);
        }

        function deleteItem(el) {
            $(el).closest('.row').remove();
            calculateTotal();
        }


        $(document).ready(function() {
            $('.addNewPart').on('click', function() {
                addItem();
            });

            function addItem() {
                let item = `
            <div class="row" style="margin-bottom:5px">
                <div class="col-sm-3 col-lg-3" style="padding-right: 3px">
                    <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" onchange="calculateTotal()" required>
                </div>
                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                    <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required >
                    <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]" >
                </div>
                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                    <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]" onchange="calculateTotal()" required>
                </div>
                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                    <input type="number" class="form-control part-price" placeholder="estimasi harga" name="price[]" onchange="calculateTotal()" required>
                </div>
                <div class="col-sm-2 col-lg-1" style="padding-right: 3px">
                    <input type="input" class="form-control" placeholder="eta" name="eta[]">
                </div>
                <div class="col-sm-2 col-lg-2" style="padding-right: 3px">
                    <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]">
                </div>
                <div class="col-sm-1 col-lg-1" style="padding-right: 3px">
                    <a href="#" class="btn btn-danger rounded delete-button "
                                                        alt='hapus' onclick='deleteItem(this)'>
                                                        <i class="ri-delete-bin-line"></i>
                                                    </a>
                </div>
            </div>`;

                $('.sparepartSection').append(item);
                initAutoComplete();

            }

            function initAutoComplete() {
                $('input[type="search"]').autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('warehouse.master-data.spare-part.autocomplete') }}",
                            dataType: "json",
                            data: request,
                            success: function(data) {
                                response(data);
                            }

                        });
                    },
                    minLength: 1,
                    select: function(event, ui) {
                        $(this).closest('.row').children().eq(3).children().first().val(ui.item.price);
                        $(this).closest('.row').children().eq(1).children().first().val(ui.item
                            .part_number);
                        $(this).closest('.row').children().eq(1).children().last().val(ui.item.id);
                    }
                });
            }

            @if (!isset($purchasingRequest) && !isset($work_order))
                addItem();
            @endif
            initAutoComplete();
            calculateTotal();

        });
    </script>
@endsection
