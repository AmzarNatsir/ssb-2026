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
                            <h4 class="card-title">Receiving</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="purchasingOrderForm" action={{ !isset($receiving) ? route('warehouse.receiving.store') : route('warehouse.receiving.update',$receiving->model->id) }} method="POST" >
                            <div class="iq-card-body">
                                @csrf
                                @isset($receiving)
                                    @method('PUT')
                                @endisset
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Purchasing Order Number</label>
                                                <input type="hidden" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->id : $receiving->model->purchasing_order->id }}" name="purchasing_order_id">
                                                <input type="text" class="form-control" value="{{ isset($purchasingOrder) ? $purchasingOrder->model->number : $receiving->model->purchasing_order->number }}" readonly >
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <input type="hidden" value="{{ isset($receiving) ?  $receiving->model->supplier->id : $purchasingOrder->model->supplier->id  }}" name="supplier_id">
                                                <input type="text" class="form-control" value="{{ isset($receiving) ?  $receiving->model->supplier->name : $purchasingOrder->model->supplier->name   }}" readonly >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label>No Faktur</label>
                                                <input type="text" class="form-control" required name="invoice_number" value="{{ isset($receiving) ? $receiving->model->invoice_number : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Keterangan </label>
                                                <textarea class="form-control" name="remarks" cols="30" rows="5">{{ isset($receiving) ? $receiving->model->remarks : '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="name">Tanggal Terima </label>
                                                <input type="date" name="received_at" class="form-control" value="{{ isset($receiving) ? date('Y-m-d', strtotime($receiving->model->received_at)) : date('Y-m-d', strtotime(now())) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="">Diterima Oleh :</label>
                                                <select id="approved-id" name="received_by" id="" class="form-control" required>
                                                    @foreach ($approved_by as $item)
                                                        <option {{ isset($receiving) && $receiving->model->received_by == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="">Disetujui Oleh :</label>
                                                <select id="approved-id" name="approved_by" id="" class="form-control" required>
                                                    @foreach ($approved_by as $item)
                                                        <option {{ isset($receiving) && $receiving->model->approved_by == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{$item->nm_lengkap}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="custom-control custom-switch custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1" name="issued_immediately" value="1">
                                                <label class="custom-control-label" for="customSwitch1">Issued Immediately (No / Yes) </label>
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
                                <div class="col-sm-4 col-lg-4"><h6>Part Name</h6>
                                </div>
                                <div class="col-sm-3 col-lg-3"><h6>Part Number</h6>
                                </div>
                                <div class="col-sm-1 col-lg-1"><h6>Kuantitas</h6>
                                </div>
                            </div>
                            @foreach ( isset($purchasingOrder) ? $purchasingOrder->model->details->where('status', \App\Models\Warehouse\PurchasingOrderDetail::STATUS_NOT_RECEIVED) : $receiving->model->details as $item)
                                <div class="row" style="margin-bottom:5px">
                                    <div class="col-sm-4 col-lg-4">
                                        <input type="hidden" name="purchasing_order_detail_id[]" value="{{ isset($item->purchasing_order_detail_id) ? $item->purchasing_order_detail_id : $item->id  }}">
                                        <input type="search"  class="form-control autocomplete" placeholder="ketik nama part/part number" name="part_name[]" required value="{{ $item->sparepart->part_name }}" readonly>
                                    </div>
                                    <div class="col-sm-3 col-lg-3">
                                        <input type="input" class="form-control" placeholder="part id" readonly name="part_number[]" required value="{{ $item->sparepart->part_number }}" >
                                        <input type="hidden" class="form-control" placeholder="part id" readonly name="part_id[]"  value="{{ $item->sparepart->id }}" >
                                    </div>
                                    @php
                                    if(isset($purchasingOrder) && $purchasingOrder->model->status == \App\Models\Warehouse\Receiving::CURRENT_STATUS ){
                                        $qty = abs($item->qty - $item->receiving_detail->sum('qty'));
                                    } else {
                                        $qty = $item->qty;
                                    }

                                    @endphp
                                    <div class="col-sm-1 col-lg-1">
                                        <input type="number" class="form-control" placeholder="qty" style="font-size: 12px" name="qty[]"  required value="{{ $qty }}" max="{{ $qty }}" min="0">
                                    </div>
                                </div>

                            @endforeach
                            <br>
                            <div class="row" style="margin-bottom: 2px">
                                <div class="col-sm-6 col-lg-6">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('warehouse.receiving.index') }}" class="btn iq-bg-danger">Batal</a>
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
@endsection
