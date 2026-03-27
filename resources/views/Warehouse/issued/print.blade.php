<html>
<title>Issued - PT. Sumber Setia Budi </title>

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

            </td>
            <td style="vertical-align: top" ;>
                <table width="70%" style="float:right">
                    <tr>
                        <td style="border-top: solid black 1px; border-bottom: solid black 1px">Pengeluaran Barang</td>
                    </tr>
                    <tr>
                        <td style="background-color: lightgray;color:black">
                            <table>
                                <tr>
                                    <td>No. Form #</td>
                                    <td>:</td>
                                    <td>{{ $issued->model->number }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ date('j M Y', strtotime($issued->model->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td>No. Referensi</td>
                                    <td>:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Diterima Oleh</td>
                                    <td>:</td>
                                    <td>{{ $issued->model->received_by_user->nm_lengkap }}</td>
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
    <br>
    <br>
    <br>
    <br>
    <table cellspacing=0 cellpadding=0 width="100%">
        <tr style="background-color: gray;color:white;border: solid black 1px">
            <td>Kd Barang</td>
            <td>Nama Barang</td>
            <td>Kts.</td>
            <td>Keterangan</td>
        </tr>
        {{-- {{ dd($issued->model->details->groupBy('part_id')) }} --}}
        @foreach ($issued->model->details as $key => $detail)
            <tr>
                <td>{{ $detail->sparepart->part_number }}</td>
                <td>{{ $detail->sparepart->part_name }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->remarks }}</td>

            </tr>
        @endforeach
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td width="60%" style="vertical-align: top">
                <table width="70%">
                    <tr>
                        <td style="border-bottom: solid black 1px">Keterangan : </td>
                    </tr>
                    <tr>
                        <td style="border-bottom: dotted black 1px">{{ $issued->model->remarks }}</td>
                    </tr>
                </table>
            </td>
            {{-- <td>
                    <table width="100%" style="border-collapse: collapse">
                        <tr>
                            <td >Sub Total </td>
                            <td style="text-align: right">{{ warehouse_number_format($issued->model->subtotal) }}</td>
                        </tr>
                        <tr>
                            <td >PPN (%) </td>
                            <td style="text-align: right">{{ warehouse_number_format($issued->model->ppn) }}</td>
                        </tr>
                        <tr>
                            <td style="background-color: gray;color:white" >Total </td>
                            <td style="text-align: right;background-color: gray;color:white">{{ warehouse_number_format($issued->model->grand_total) }}</td>
                        </tr>
                    </table>
                </td> --}}
        </tr>
    </table>
</body>

</html>
