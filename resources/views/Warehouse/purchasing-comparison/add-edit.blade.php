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
                            <h4 class="card-title">Purchasing Comparison </h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="purchasingComparisonForm" action={{ !isset($purchasingComparison) ? route('warehouse.purchasing-request.store') : route('warehouse.purchasing-request.update',$purchasingComparison->model->id) }} method="POST" >
                            <div class="iq-card-body">
                                @csrf
                                @isset($purchasingComparison)
                                    @method('PUT')
                                @endisset
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-12 sm-lg-12" style="overflow:auto;height: 300px">
                                            <div class="form-group">
                                                <label for="name">Supplier List</label>
                                            </div>

                                            <table class="table">
                                                <thead>
                                                    <td></td>
                                                    <td>Supplier Name</td>
                                                    <td>Alamat</td>
                                                    <td>Email</td>
                                                    <td>Kontak</td>
                                                </thead>
                                                @php
                                                    $selectedSuppliers = isset($purchasingComparison) ? explode(',',$purchasingComparison->model->supplier_ids)  : null;
                                                @endphp
                                                @forelse ($suppliers as $supplier)
                                                    <tr>
                                                        <td><input value="{{ $supplier->id }}" type="checkbox" name="supplier_ids[]" {{ isset($selectedSuppliers) && in_array($supplier->id, $selectedSuppliers) ? 'checked':''  }} ><input type="hidden" class="supplier-name" value="{{ $supplier->name }}"></td>
                                                        <td>{{ $supplier->name }}</td>
                                                        <td>{{ $supplier->address }}</td>
                                                        <td>{{ $supplier->email }}</td>
                                                        <td>{{ $supplier->contact_person }}</td>
                                                    </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5">Tidak ada data</td>
                                                </tr>
                                                @endforelse

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="iq-card-body">
                        <div class="row">
                            <div class="col-sm-2 col-lg-2">Disetujui Oleh :</div>
                            <div class="col-sm-4 col-lg-4">
                                <select id="approved-id" name="approved_id" id="" class="form-control">
                                    @foreach ($approved_by as $item)
                                        <option {{ isset($purchasingComparison) && $purchasingComparison->model->approved_by== $item->id ? 'selected':'' }} value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4 col-lg-6">
                                <button class="btn btn-success" onclick="generateComparison()">Generate comparison</button>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ !isset($purchasingComparison) ? route('warehouse.purchasing-comparison.store') : route('warehouse.purchasing-comparison.update',$purchasingComparison->model->id) }}" method="POST">
                @csrf
                @isset($purchasingComparison)
                    @method('PUT')
                @endisset
                <input type="hidden" name="purchasing_request_id" value="{{ $purchasing_request->model->id }}">
                <input type="hidden" name="reference_id" value="{{ $purchasing_request->model->reference_id ? $purchasing_request->model->reference_id : (isset($purchasingComparison) ? $purchasingComparison->model->reference_id : '') }}">

                <div class="iq-card">
                    <div class="iq-card-body">
                        <input type="hidden" name="approved_by" id="approved-by" value="{{ isset($purchasingComparison) ? $purchasingComparison->model->approved_by :'' }}">
                        <ul class="nav nav-pills mb-3 nav-fill tab-header" id="pills-tab-1" role="tablist">
                            @if (isset($purchasingComparison))
                                @foreach ($purchasingComparison->model->supplierName as $item)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->index == 0 ? 'active':'' }}" id="pills-{{$loop->index}}-tab-fill" data-toggle="pill" href="#pills-{{$loop->index}}-fill" role="tab" aria-controls="pills-{{$loop->index}}" aria-selected="true">{{$item->name}}</a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="tab-content" id="pills-tabContent-1">
                            @if (isset($purchasingComparison))
                                    {{-- @foreach ($purchasingComparison->model->supplierName as $item) --}}
                                    @foreach ($purchasingComparison->model->details->groupBy('supplier_id') as $key =>  $detail)
                                    <div class="tab-pane fade {{ $loop->index == 0 ? 'active show': '' }}" id="pills-{{ $loop->index }}-fill" role="tabpanel" aria-labelledby="pills-{{ $loop->index }}-tab-fill">
                                            @foreach ($detail as $comparison_detail)
                                                <div class="row" style="margin-bottom:5px">
                                                    <div class="col-sm-3 col-lg-3"><h6>Part Namem</h6>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2"><h6>Part Number</h6>
                                                    </div>
                                                    <div class="col-sm-1 col-lg-1"><h6>Kuantitas</h6>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2"><h6>Harga</h6>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-1"><h6>ETA</h6>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2"><h6>Keterangan</h6>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-bottom:5px">
                                                    <div class="col-sm-3 col-lg-3">
                                                        <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" onchange="calculateTotal()" required value="{{ $comparison_detail->sparepart->part_number }}" readonly>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2">
                                                        <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $comparison_detail->sparepart->part_number }}" readonly>
                                                        <input type="hidden" class="form-control"  readonly name="supplier_id[]" required value="{{ $comparison_detail->supplier_id }}" >
                                                        <input type="hidden" class="form-control" readonly name="part_id[]"  value="{{ $comparison_detail->sparepart->id }}" >
                                                    </div>
                                                    <div class="col-sm-1 col-lg-1">
                                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]" onchange="calculateTotal()" required value="{{ $comparison_detail->qty }}" readonly>
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2">
                                                        <input type="number" class="form-control part-price" placeholder="estimasi harga" name="price[]" onchange="calculateTotal()" required value="{{ $comparison_detail->price }}">
                                                    </div>
                                                    <div class="col-sm-2 col-lg-1">
                                                        <input type="input" class="form-control" placeholder="eta" name="eta[]" value="{{ $comparison_detail->eta }}">
                                                    </div>
                                                    <div class="col-sm-2 col-lg-2">
                                                        <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="{{ $comparison_detail->remarks }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        {{-- @endforeach --}}
                                    </div>
                                @endforeach
                            @else
                            <p>Silahkan pilih supplier</p>
                            @endif
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6 col-lg-6">
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Simpan</button>
                                    <a href="{{ route('warehouse.purchasing-request.index') }}" class="btn iq-bg-danger">Batal</a>
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
    function generatePurchasingRequest(supplier_id) {
        var purchasingRequest = `
        @foreach($purchasing_request->model->details as $item)

        <div class="row" style="margin-bottom:5px">
            <div class="col-sm-3 col-lg-3"><h6>Part Namem</h6>
            </div>
            <div class="col-sm-2 col-lg-2"><h6>Part Number</h6>
            </div>
            <div class="col-sm-1 col-lg-1"><h6>Kuantitas</h6>
            </div>
            <div class="col-sm-2 col-lg-2"><h6>Harga</h6>
            </div>
            <div class="col-sm-2 col-lg-1"><h6>ETA</h6>
            </div>
            <div class="col-sm-2 col-lg-2"><h6>Keterangan</h6>
            </div>
        </div>

        <div class="row" style="margin-bottom:5px">
            <div class="col-sm-3 col-lg-3">
                <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" onchange="calculateTotal()" required value="{{ $item->sparepart->part_name }}" readonly>
            </div>
            <div class="col-sm-2 col-lg-2">
                <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}" readonly>
                <input type="hidden" class="form-control"  readonly name="supplier_id[]" required value="${supplier_id}" >
                <input type="hidden" class="form-control" readonly name="part_id[]"  value="{{ $item->sparepart->id }}" >
            </div>
            <div class="col-sm-1 col-lg-1">
                <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]" onchange="calculateTotal()" required value="{{ $item->qty }}" readonly>
            </div>
            <div class="col-sm-2 col-lg-2">
                <input type="number" class="form-control part-price" placeholder="estimasi harga" name="price[]" onchange="calculateTotal()" required value="{{ $item->price }}">
            </div>
            <div class="col-sm-2 col-lg-1">
                <input type="input" class="form-control" placeholder="eta" name="eta[]" value="{{ $item->eta }}">
            </div>
            <div class="col-sm-2 col-lg-2">
                <input type="input" class="form-control" placeholder="keterangan" name="part_remarks[]" value="{{ $item->remarks }}">
            </div>
        </div>
        @endforeach()
        `;

        return purchasingRequest;
    }

    function generateComparison() {
        var tabHeader = '';
        var tabFill = '';
        var suppliers = $('input[name="supplier_ids[]"]:checked').each(function(index){
            supplierId = $(this).val();
            isActive = index == 0 ? 'active' : '';
            supplierName = $(this).next('input').val();
            tabHeader += `<li class="nav-item">
                    <a class="nav-link ${isActive}" id="pills-${index}-tab-fill" data-toggle="pill" href="#pills-${index}-fill" role="tab" aria-controls="pills-${index}" aria-selected="true">${supplierName}</a>
                </li>`;

            tabFill += `<div class="tab-pane fade ${index == 0 ? 'active show': '' }" id="pills-${index}-fill" role="tabpanel" aria-labelledby="pills-${index}-tab-fill">
                ${generatePurchasingRequest(supplierId)}
            </div>`;
        });

        $('.tab-header').html(tabHeader);
        $('.tab-content').html(tabFill);
        $('#approved-by').val($('#approved-id').val());
    }

    $(document).ready(function(){
        $('#submitBtn').click(function(){
            if ($('input[name="qty[]"]').length > 0){
                return true
            }
            else{
                alert('Please generate comparison for minimum 1 supplier')
                return false
            }
        })
    })

</script>
@endsection
