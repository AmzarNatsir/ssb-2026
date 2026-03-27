<html>
<title>Purchasing Comparison - PT. Sumber Setia Budi </title>

<head>
    <style>
        body {
          font-size: 10px;
          font-family: Arial, Helvetica, sans-serif;
          margin: 10px;
          text-transform: uppercase;
        }

    </style>
</head>

<body>
    @include('Warehouse.partials._print_header')
    <br>
    <div style="text-align: center"><u>PERBANDINGAN HARGA</u></div>

    <table width="100%">
        <tr>
            <td width="5%">Keb/Unit</td>
            <td width="70%">
                {{ $purchasing_comparison->model->reference_id ? $purchasing_comparison->model->work_order->number : '' }}
            </td>
            <td width="10%">No Order</td>
            <td>{{ $purchasing_comparison->model->number }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>{{ $purchasing_comparison->model->dateCreation }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    @php
        $suppliers = $purchasing_comparison->model->supplierName;
    @endphp
    <table cellspacing=0 cellpadding=0 style="border: solid black 1px; text-align:center" width="100%" border="1">
        <tr style="background-color: gray;color:white;border: solid black 1px">
            <td colspan="4"></td>
            @foreach ($suppliers as $item)
                <td colspan="5">{{ $item->name }}</td>
            @endforeach
        </tr>
        <tr style="background-color: gray;color:white;border: solid black 1px">
            <td rowspan="2">No</td>
            <td rowspan="2">Part Number</td>
            <td rowspan="2">Description</td>
            <td rowspan="2">Qty</td>
            @foreach ($suppliers as $item)
                <td colspan="2">Harga</td>
                <td rowspan="2">Ket</td>
                <td rowspan="2">Weight</td>
                <td rowspan="2">ETA</td>
            @endforeach
        </tr>
        <tr style="background-color: gray;color:white;border: solid black 1px">
            @foreach ($suppliers as $item)
                <td>Geniune</td>
                <td>Non Geniune</td>
            @endforeach
        </tr>
        {{-- {{ dd($purchasing_comparison->model->details->groupBy('part_id')) }} --}}
        @foreach ($purchasing_comparison->model->details->groupBy('part_id') as $key => $detail)
            @php
                $part = \App\Models\Warehouse\SparePart::find($key);
            @endphp
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $part->part_number }}</td>
                <td>{{ $part->part_name }}</td>
                <td>{{ $detail->where('part_id', $key)->first()->qty }}</td>
                @foreach ($detail as $item)
                    <td>{{ $item->sparepart->is_geniune ? $item->price : '' }}</td>
                    <td>{{ !$item->sparepart->is_geniune ? $item->price : '' }}</td>
                    <td>{{ $item->remarks }}</td>
                    <td>{{ $item->sparepart->weight }}</td>
                    <td>{{ $item->eta }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
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
                <td>{{ $purchasing_comparison->model->created_user->karyawan->nm_lengkap }}, </td>
            </tr>
            <tr>
                <td>Jabatan</td>
            </tr>
        </table>
    </div>
</body>

</html>
