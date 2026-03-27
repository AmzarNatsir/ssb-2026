<html>
<title>Purchasing Order - PT. Sumber Setia Budi </title>

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

    <table width="100%">
        <tr>
            <td width="50%" style="vertical-align: top">
                <table width="70%">
                    <tr>
                        <td style="border-top: solid black 1px; border-bottom: solid black 1px">Kepada</td>
                    </tr>
                    <tr>
                        <td style="background-color: lightgray;">
                            {{ $purchasing_order->model->supplier->name }} ,
                            {{ $purchasing_order->model->supplier->address }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top">
                <table width="70%" style="float: right">
                    <tr>
                        <td style="border-top: solid black 1px; border-bottom: solid black 1px">Pesanan Pembelian</td>
                    </tr>
                    <tr>
                        <td style="background-color: lightgray;color">
                            <table>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>{{ $purchasing_order->model->number }}</td>
                                </tr>
                                <tr>
                                    <td>Tangal</td>
                                    <td>:</td>
                                    <td>{{ date('j M Y', strtotime($purchasing_order->model->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Kirim</td>
                                    <td>:</td>
                                    <td>{{ date('j M Y', strtotime($purchasing_order->model->send_date)) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table cellspacing=0 cellpadding=0 width="100%">
        <tr style="background-color: gray;color:white;border: solid black 1px">
            <td>Kd Barang</td>
            <td>Nama Barang</td>
            <td>Qty</td>
            <td align="right">@Harga</td>
            <td align="right">Diskon</td>
            <td align="right">Total</td>
            <td>&nbsp;&nbsp;Ket</td>
        </tr>
        {{-- {{ dd($purchasing_order->model->details->groupBy('part_id')) }} --}}
        @foreach ($purchasing_order->model->details as $key => $detail)
            <tr>
                <td>{{ $detail->sparepart->part_number }}</td>
                <td>{{ $detail->sparepart->part_name }}</td>
                <td>{{ $detail->qty }}</td>
                <td style="text-align: right">{{ warehouse_number_format($detail->price) }}</td>
                <td style="text-align: right">{{ warehouse_number_format($detail->discount) }}</td>
                <td style="text-align: right">{{ warehouse_number_format($detail->subtotal) }}</td>
                <td style="margin-left: 10px">&nbsp;&nbsp;{{ $detail->remarks }}</td>
            </tr>
        @endforeach
    </table>
    <hr>
    <br>
    <table width="100%">
        <tr>
            <td width="60%" style="vertical-align: top">
                <table width="70%">
                    <tr>
                        <td style="border-bottom: solid black 1px">Keterangan : </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: solid black 1px">{{ $purchasing_order->model->remarks }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%" style="border-collapse: collapse">
                    <tr>
                        <td>Sub Total </td>
                        <td style="text-align: right">
                            {{ warehouse_number_format($purchasing_order->model->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td>Diskon </td>
                        <td style="text-align: right">
                            {{ warehouse_number_format($purchasing_order->model->total_discount) }}</td>
                    </tr>
                    <tr>
                        <td>PPN (%) </td>
                        <td style="text-align: right">{{ warehouse_number_format($purchasing_order->model->ppn) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Beban Tansportasi </td>
                        <td style="text-align: right">
                            {{ warehouse_number_format($purchasing_order->model->additional_expense) }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: gray;color:white">Total </td>
                        <td style="text-align: right;background-color: gray;color:white">
                            {{ warehouse_number_format($purchasing_order->model->grand_total) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
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
                <td>{{ $purchasing_order->model->created_user->karyawan->nm_lengkap }}, </td>
            </tr>
            <tr>
                <td>Jabatan</td>
            </tr>
        </table>
    </div>
</body>

</html>
