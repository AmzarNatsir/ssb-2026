<html>
    <title>Part Return - PT. Sumber Setia Budi </title>
    <head>
        <style>
            body{
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
                                {{ $part_return->model->supplier->name }} , {{ $part_return->model->supplier->address }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top">
                    <table width="70%" style="float: right">
                        <tr>
                            <td style="border-top: solid black 1px; border-bottom: solid black 1px">Retur Pembelian</td>
                        </tr>
                        <tr>
                            <td style="background-color: lightgray;color:black">
                                <table>
                                    <tr>
                                        <td>No. Form #</td>
                                        <td>:</td>
                                        <td>{{ $part_return->model->number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>{{ date('j M Y',strtotime($part_return->model->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. Referensi</td>
                                        <td>:</td>
                                        <td>{{ $part_return->model->purchasing_order->number }}</td>
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
                <td>Kts.</td>
                <td>@Harga</td>
                <td>Total Harga</td>
            </tr>
            {{-- {{ dd($part_return->model->details->groupBy('part_id')) }} --}}
            @foreach ($part_return->model->details as $key =>  $detail)
                <tr>
                    <td>{{ $detail->sparepart->part_number }}</td>
                    <td>{{ $detail->sparepart->part_name }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ warehouse_number_format($detail->price) }}</td>
                    <td>{{ warehouse_number_format($detail->price * $detail->qty) }}</td>
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
                            <td style="border-bottom: dotted black 1px">{{ $part_return->model->remarks }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%" style="border-collapse: collapse">
                        <tr>
                            <td >Sub Total </td>
                            <td style="text-align: right">{{ warehouse_number_format($part_return->model->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td >PPN (%) </td>
                            <td style="text-align: right">{{ warehouse_number_format($part_return->model->ppn) }}</td>
                        </tr>
                        <tr>
                            <td style="background-color: gray;color:white" >Total </td>
                            <td style="text-align: right;background-color: gray;color:white">{{ warehouse_number_format($part_return->model->grand_total) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
