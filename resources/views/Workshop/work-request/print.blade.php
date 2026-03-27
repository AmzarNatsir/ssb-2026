<html>
<title>Work Request - PT. Sumber Setia Budi </title>

<head>
    <style>
        body {
          font-size: 10px;
          font-family: Arial, Helvetica, sans-serif;
          margin: 10px;
          text-transform: uppercase;
        }

        table {
            border-collapse: collapse
        }

        .b-bottom {
            border-bottom: solid black 1px;
        }

        .b-right {
            border-right: solid black 1px;
        }

        .b-left {
            border-left: solid black 1px;
        }

        .b-top {
            border-top: solid black 1px;
        }

        .t-center {
            text-align: center
        }

        .t-right {
            text-align: right
        }

        td {
            word-wrap: break-word
        }

        .t-bold {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>
    <table style="width: 100%;border: solid black 1px">
        <tr>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
            <td style="width: 12%"></td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;border-bottom:solid black 1px; font-size:17px"><strong>WORK
                    REQUEST</strong></td>
        </tr>
        <tr>
            <td class="b-bottom">NO. WR</td>
            <td colspan="2" class="b-bottom b-right">: {{ $workRequest->number }}</td>
            <td class="b-bottom">NO. UNIT</td>
            <td colspan="2" class="b-bottom b-right">: {{ $workRequest->equipment?->name }}</td>
            <td colspan="2">ADMIN :</td>
            <td class="b-left">PRIORITY :</td>

        </tr>
        <tr>
            <td class="b-bottom">PROJECT</td>
            <td colspan="2" class="b-bottom b-right">: {{ $workRequest->equipment?->project?->name }}</td>
            <td class="b-bottom">HM/KM</td>
            <td colspan="2" class="b-bottom b-right">:
                {{ $workRequest->equipment->hm . '/' . $workRequest->equipment?->km }}</td>
            <td colspan="2" rowspan="2" class="b-bottom b-left t-center">
                {{ $workRequest->created_by_user?->karyawan?->nm_lengkap }}
            </td>
            <td rowspan="2" class="b-bottom b-left t-center">{{ $workRequest->priority }}</td>
        </tr>
        <tr>
            <td class="b-bottom">TANGGAL</td>
            <td class="b-bottom b-right" colspan="2">: {{ date('d.m.Y', strtotime($workRequest->created_at)) }}</td>
            <td class="b-bottom">OPERATOR / DRIVER </td>
            <td class="b-bottom" colspan="2">: {{ $workRequest->driver?->nm_lengkap }}</td>

        </tr>
    </table>
    <br>
    <table style="width: 100%;border: solid black 1px">
        <tr>
            <td colspan="9" class="b-bottom t-bold">PERMINTAAN PERBAIKAN</td>
        </tr>
        <tr>
            <td class="b-bottom b-right t-center t-bold">NO</td>
            <td colspan="5" class="b-bottom b-right t-center t-bold">PERMINTAAN PERBAIKAN</td>
            <td colspan="3" class="b-bottom t-center t-bold">KETERANGAN</td>
        </tr>
        @foreach ($workRequest->additional_attributes as $item)
            <tr>
                <td class="b-bottom b-right t-center">{{ $loop->index + 1 }}</td>
                <td colspan="5" class="b-bottom b-right ">{{ $item->value }}</td>
                <td colspan="3" class="b-bottom ">{{ $item->description }}</td>
            </tr>
        @endforeach
    </table>
    <br>
    @if ($workRequest->part_order->count())
        <table style="width: 100%;border: solid black 1px">
            <tr>
                <td colspan="9" class="b-bottom t-bold">RINCIAN KEBUTUHAN SPARE PART</td>
            </tr>
            <tr>
                <td class="b-bottom b-right t-center t-bold">NO</td>
                <td colspan="3" class="b-bottom b-right t-center t-bold">SPARE PART</td>
                <td class="b-bottom b-right t-center t-bold">QTY</td>
                <td class="b-bottom b-right t-center t-bold">SATUAN</td>
                <td colspan="3" class="b-bottom t-center t-bold">KETERANGAN</td>
            </tr>
            @foreach ($workRequest->part_order as $item)
                <tr>
                    <td class="b-bottom b-right t-center">{{ $loop->index + 1 }}</td>
                    <td colspan="3" class="b-bottom b-right ">{{ $item->sparepart?->part_name }}</td>
                    <td class="b-bottom t-center b-right ">{{ $item->qty }}</td>
                    <td class="b-bottom t-center b-right ">{{ $item->sparepart?->uop?->name }}</td>
                    <td colspan="3" class="b-bottom ">{{ $item->description }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    <br>
    @if ($workRequest->media->count())
        <table style="width: 100%;border: solid black 1px">
            <tr>
                <td colspan="2" class="b-bottom t-bold">FOTO DOKUMENTASI</td>
            </tr>
            <tr>
                <td class="b-bottom b-right t-center t-bold">NO</td>
                <td class="b-bottom b-right t-center t-bold">FOTO</td>
            </tr>
            @foreach ($workRequest->media as $item)
                <tr>
                    <td class="b-bottom b-right t-center">{{ $loop->index + 1 }}</td>
                    <td class="b-bottom b-right "><img src="{{ asset($item->file) }}" alt=""
                            style="max-width: 500px;margin-left:20px"></td>
                </tr>
            @endforeach
        </table>
    @endif
</body>

</html>
