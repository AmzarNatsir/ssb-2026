<html>
<title>Receiving - PT. Sumber Setia Budi </title>

<head>
    <style>
        body {
            font-size: 12px
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
                            {{ $receiving->model->supplier->name }} , {{ $receiving->model->supplier->address }}
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top">
                <table width="70%" style="float: right">
                    <tr>
                        <td style="border-top: solid black 1px; border-bottom: solid black 1px">Penerimaan Barang</td>
                    </tr>
                    <tr>
                        <td style="background-color: lightgray;color:black">
                            <table>
                                <tr>
                                    <td>No. Form #</td>
                                    <td>:</td>
                                    <td>{{ $receiving->model->number }}</td>
                                </tr>
                                <tr>
                                    <td>No. Faktur #</td>
                                    <td>:</td>
                                    <td>{{ $receiving->model->invoice_number }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    <td>{{ date('j M Y', strtotime($receiving->model->received_at)) }}</td>
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
            <td>Satuan</td>
        </tr>
        {{-- {{ dd($receiving->model->details->groupBy('part_id')) }} --}}
        @foreach ($receiving->model->details as $key => $detail)
            <tr>
                <td>{{ $detail->sparepart->part_number }}</td>
                <td>{{ $detail->sparepart->part_name }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->sparepart->uop->name }}</td>
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
                        <td style="border-bottom: dotted black 1px">{{ $receiving->model->remarks }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%" style="border-collapse: collapse">
                    <tr>
                        <td style="text-align: center">Diterima Oleh, </td>
                        <td style="text-align: center">Disetujui Oleh,</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br></td>
                        <td><br></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">
                            {{ $receiving->model->received_user->nm_lengkap }}
                        </td>
                        <td style="text-align:center">
                            {{ $receiving->model->approved_user->nm_lengkap }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
