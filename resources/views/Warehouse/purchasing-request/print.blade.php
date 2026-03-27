<html>

<head>
    <style>
        body {
          font-size: 10px;
          font-family: Arial, Helvetica, sans-serif;
          margin: 10px;
          text-transform: uppercase;
        }

    </style>
    <title>Purchasing Request - PT. Sumber Setia Budi </title>
</head>

<body>
    @include('Warehouse.partials._print_header')
    <br>
    <div style="text-align: center"><u>PERMINTAAN PENAWARAN</u></div>

    <table width="100%">
        <tr>
            <td width="5%">Keb/Unit</td>
            <td width="70%">
                {{ $purchasing_request->model->reference_id ? $purchasing_request->model->work_order->number : '' }}
            </td>
            <td width="10%">No Order</td>
            <td>{{ $purchasing_request->model->number }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>{{ $purchasing_request->model->dateCreation }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <table cellspacing=0 cellpadding=0 style="text-align:center" width="100%">
        <tr style="background-color: gray;color:white;border: solid black 1px">
            <td>No</td>
            <td>Part Number</td>
            <td>Description</td>
            <td colspan="2">Qty</td>
            <td>Harga Satuan</td>
            <td>Merk</td>
            <td>Weight</td>
            <td>ETA</td>
            <td>KET</td>
        </tr>
        @foreach ($purchasing_request->model->details as $key => $detail)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $detail->sparepart->part_number }}</td>
                <td>{{ $detail->sparepart->part_name }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->sparepart->uop->name }}</td>
                <td>{{ warehouse_number_format($detail->price) }}</td>
                <td>{{ $detail->sparepart->brand->name }}</td>
                <td>{{ $detail->sparepart->weight }}</td>
                <td>{{ $detail->eta }}</td>
                <td>{{ $detail->remarks }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <br>
    <div style="float: right">
        <table>
            <tr>
                <td>Pomala, {{ date('d M Y', strtotime(now())) }}</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>{{ $purchasing_request->model->created_user->karyawan->nm_lengkap }}, </td>
            </tr>
            <tr>
                <td>Jabatan</td>
            </tr>
        </table>
    </div>
</body>

</html>
