<html>
<title>Service work order </title>

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

        .tick {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: solid black 1px;
            margin: 0 auto;
            text-align: center;
        }

        .tick-filled {
            background-color: black
        }

        .t-bold {
            font-weight: bold;
        }

    </style>
</head>

<body>
    @php
        $workshopManager = \App\Repository\Workshop\SettingRepository::get('workshop_manager') ? \App\User::find(\App\Repository\Workshop\SettingRepository::get('workshop_manager'))->karyawan->nm_lengkap : '';
        $mechanicManager = \App\Repository\Workshop\SettingRepository::get('mechanic_manager') ? \App\Models\HRD\KaryawanModel::find(\App\Repository\Workshop\SettingRepository::get('mechanic_manager'))->nm_lengkap : '';
    @endphp
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
            <td colspan="9" style="text-align: center;border-bottom:solid black 1px; font-size:17px"><strong>SERVICE
                    WORK ORDER</strong></td>
        </tr>
        <tr>
            <td class="b-bottom">NO. WO</td>
            <td colspan="2" class="b-bottom b-right">: {{ $work_order->number }}</td>
            <td class="b-bottom">NO. UNIT</td>
            <td colspan="2" class="b-bottom b-right">: {{ $work_order->equipment->name }}</td>
            <td colspan="3">SUPERVISOR :</td>

        </tr>
        <tr>
            <td class="b-bottom">PROJECT</td>
            <td colspan="2" class="b-bottom b-right">: {{ $work_order->project->name }}</td>
            <td class="b-bottom">HM/KM</td>
            <td colspan="2" class="b-bottom b-right">:
                {{ $work_order->equipment->hm . '/' . $work_order->equipment->km }}</td>
            <td colspan="3" class="b-bottom t-center">{{ $work_order->supervisor->nm_lengkap }}</td>
        </tr>
        <tr>
            <td class="b-bottom">TANGGAL</td>
            <td class="b-bottom b-right" colspan="2">:
                {{ workshop_date_format($work_order->date_start) }}</td>
            <td class="b-right" colspan="3">OPERATOR / DRIVER: </td>
            <td colspan="3">ADMIN :</td>
        </tr>
        <tr>
            <td class="b-bottom">PUKUL</td>
            <td colspan="2" class="b-bottom b-right">: {{ workshop_time($work_order->date_start) }}</td>
            <td colspan="3" class="b-bottom b-right t-center">{{ $work_order->driver->nm_lengkap }}</td>
            <td colspan="3" class="b-bottom b-right t-center">{{ $work_order->created_by_user->karyawan->nm_lengkap }}
            </td>
        </tr>
        <tr>
            <td class="b-bottom b-right t-center t-bold">NO</td>
            <td colspan="5" class="b-bottom b-right t-center t-bold">PERMINTAAN PERBAIKAN</td>
            <td colspan="3" class="b-bottom t-center t-bold">KETERANGAN</td>
        </tr>
        @foreach ($work_order->work_request->additional_attributes as $item)
            <tr>
                <td class="b-bottom b-right t-center" style="vertical-align:top">{{ $loop->index + 1 }}</td>
                <td colspan="5" class="b-bottom b-right " style="word-wrap: break-word;vertical-align:top">
                    {{ $item->value }}</td>
                <td colspan="3" class="b-bottom " style="word-wrap: break-word;vertical-align:top">
                    {{ $item->description }}</td>
            </tr>
        @endforeach
        {{-- {{ count($work_order->work_request->additional_attributes) }} --}}
        @if (count($work_order->work_request->additional_attributes) < 9)
            @for ($i = 0; $i < abs(count($work_order->work_request->additional_attributes) - 9); $i++)
                <tr>
                    <td class="b-bottom b-right t-center">&nbsp;</td>
                    <td colspan="5" class="b-bottom b-right ">&nbsp;</td>
                    <td colspan="3" class="b-bottom ">&nbsp;</td>
                </tr>
            @endfor
        @endif
        <tr>
            <td class="b-right t-center b-bottom" rowspan="2"><span style="font-size: 50px">S</span>TART</td>
            <td class="b-bottom">TANGGAL</td>
            <td class="b-bottom b-right">: {{ workshop_date($work_order->date_start) }}</td>
            <td class="b-right t-center b-bottom" rowspan="2"><span style="font-size: 50px">F</span>INISH</td>
            <td class="b-bottom">TANGGAL</td>
            <td class="b-bottom b-right">: {{ workshop_date($work_order->date_finish) }}</td>
            <td colspan="3">MAN POWER :</td>
        </tr>
        <tr>
            <td class="b-bottom">PUKUL</td>
            <td class="b-bottom b-right">: {{ workshop_time($work_order->date_start) }}</td>
            <td class="b-bottom">PUKUL</td>
            <td class="b-bottom b-right">: {{ workshop_time($work_order->date_finish) }}</td>
            <td rowspan="3" colspan="3" class="t-center b-right">
                @if ($work_order->man_powers)
                    @foreach ($work_order->man_powers as $item)
                        {!! $item['name'] . '<br>' !!}
                    @endforeach
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="3" class="b-right">KA. WORKSHOP</td>
            <td colspan="3" class="b-right">KA. MEKANIK</td>
        </tr>
        <tr>
            <td colspan="3" class="b-right t-right">{{ $workshopManager }}</td>
            <td colspan="3" class="b-right t-right">{{ $mechanicManager }}</td>
        </tr>
        <tr>
            <td colspan="9" class="b-top b-bottom"><strong>RENCANA PERBAIKAN</strong></td>
        </tr>
        @php
            $i = 1;
        @endphp
        @for ($r = 0; $r < 3; $r++)
            <tr>
                @for ($c = 0; $c < 3; $c++)
                    <td colspan=2 class="b-bottom">{{ \App\Models\Workshop\WorkOrder::REPAIRING_PLAN[$i] }}
                    </td>
                    <td colspan=1 class="b-bottom b-right">
                        <div class="tick">
                            {{ $work_order->repairing_plan && in_array($i, $work_order->repairing_plan) ? 'X' : '' }}
                        </div>
                    </td>
                    @php
                        $i++;
                    @endphp
                @endfor
            </tr>
        @endfor
        <tr>
            <td colspan="9" class="b-bottom">LAIN-LAIN :</td>
        </tr>
        <tr>
            <td class="b-bottom b-right t-center t-bold">NO</td>
            <td colspan="5" class="b-bottom b-right t-center t-bold">PERBAIKAN YANG DIKERJAKAN</td>
            <td colspan="3" class="b-bottom t-center t-bold">KETERANGAN</td>
        </tr>
        @foreach ($work_order->additional_attributes as $item)
            <tr>
                <td class="b-bottom b-right t-center" style="vertical-align:top">{{ $loop->index + 1 }}</td>
                <td colspan="5" class="b-bottom b-right " style="word-wrap: break-word;vertical-align:top">
                    {{ $item->value }}</td>
                <td colspan="3" class="b-bottom " style="word-wrap: break-word;vertical-align:top">
                    {{ $item->description }}</td>
            </tr>
        @endforeach

        @if (count($work_order->additional_attributes) < 9)
            @for ($i = 0; $i < abs(count($work_order->additional_attributes) - 9); $i++)
                <tr>
                    <td class="b-bottom b-right t-center">&nbsp;</td>
                    <td colspan="5" class="b-bottom b-right t-center">&nbsp;</td>
                    <td colspan="3" class="b-bottom t-center">&nbsp;</td>
                </tr>
            @endfor
        @endif
        <tr>
            <td colspan="3" class="t-bold b-bottom" style="vertical-align: top">ANALISA PERNYEBAB KERUSAKAN </td>
            <td colspan="6" class="b-bottom">: {{ $work_order->damage_source_analysis }} <br><br></td>
        </tr>
        <tr>
            <td colspan="9" class="t-bold b-bottom">KONDISI UNIT SETELAH PERBAIKAN</td>
        </tr>
        <tr>
            <td class="b-bottom b-right" colspan="3">DAPAT DI OPERASIKAN KEMBALI</td>
            @foreach (\App\Models\Workshop\WorkOrder::CAN_BE_REOPERATED as $key => $item)
                <td colspan="2" class="b-bottom">{{ $item }} </td>
                <td class="b-bottom b-right">
                    <div class="tick">{{ $work_order->can_be_reoperated == $key ? 'X' : '' }}</div>
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="b-bottom b-right" colspan="3">DIBUTUHKAN PENANGANAN LEBIH LANJUT</td>
            @foreach (\App\Models\Workshop\WorkOrder::NEED_FURTHER_TREATMENT as $key => $item)
                <td colspan="2" class="b-bottom">{{ $item }} </td>
                <td class="b-bottom b-right">
                    <div class="tick">{{ $work_order->need_further_treatment == $key ? 'X' : '' }}</div>
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="1" class="t-bold b-bottom" style="vertical-align: top">CATATAN :</td>
            <td colspan="8" class="bold b-bottom">{{ $work_order->remarks }} <br><br> </td>
        </tr>
        <tr>
            <td colspan="3" class="t-center">KA. WORKSHOP</td>
            <td colspan="3" class="t-center">KA. MEKANIK</td>
            <td colspan="3" class="t-center">MEKANIK</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3" class="t-center">({{ $workshopManager }})</td>
            <td colspan="3" class="t-center">({{ $mechanicManager }})</td>
            <td colspan="3" class="t-center">(mekanik)</td>
        </tr>
        <tr>
            <td colspan="9" class="b-top t-center">
                <i>SHOLAT ON TIME FOR SAFETY ANY TIME</i>
            </td>
        </tr>
    </table>
    @php
        $media = $work_order->media->merge($work_order->work_request->media);
    @endphp
    @if ($work_order->work_request->part_order->count() || $media->count())
        <div style="page-break-after: always">
        </div>

    @endif
    @if ($work_order->work_request->part_order->count())
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
            @foreach ($work_order->work_request->part_order as $item)
                <tr>
                    <td class="b-bottom b-right t-center">{{ $loop->index + 1 }}</td>
                    <td colspan="3" class="b-bottom b-right ">{{ $item->sparepart->part_name }}</td>
                    <td class="b-bottom t-center b-right ">{{ $item->qty }}</td>
                    <td class="b-bottom t-center b-right ">{{ $item->sparepart->uop->name }}</td>
                    <td colspan="3" class="b-bottom ">{{ $item->description }}</td>
                </tr>
            @endforeach
        </table>
    @endif
    <br>

    @if ($media->count())
        <table style="width: 100%;border: solid black 1px">
            <tr>
                <td colspan="2" class="b-bottom t-bold">FOTO DOKUMENTASI</td>
            </tr>
            <tr>
                <td class="b-bottom b-right t-center t-bold">NO</td>
                <td class="b-bottom b-right t-center t-bold">FOTO</td>
            </tr>
            @foreach ($media as $item)
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
