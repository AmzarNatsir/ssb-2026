<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.3.5/tailwind.min.css">


    <style>
        @page {
            margin-top: 0px;
            margin-left: 15px;
            margin-right: 15px;
        }

        .page-break {
            page-break-after: always;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        /*.w-1 {
            width: 1%;
        }

        .w-5 {
            width: 5%;
        }

        .w-10 {
            width: 10%;
        }*/

    </style>
</head>
<body>

    <h3 style="text-align:center;font-weight:900;">SAFETY LAYER AUDIT</h3>

    <table class="table" border="0">
        <tbody>
            <tr>
                <td>No Reg</td>
                <td class="w-1">:</td>
                <td>{{ $sla->form_number }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>SOP/WI/JSA</td>
                <td class="w-1">:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Lokasi Audit</td>
                <td class="w-1">:</td>
                <td>{{ $sla->location }}</td>
                <td></td>
                <td></td>
                <td>Tanggal Audit :</td>
                <td>{{ $sla->audit_date }}</td>
            </tr>
            <tr>
                <td>Mulai Jam</td>
                <td class="w-1">:</td>
                <td>{{ $sla->audit_start_time }}</td>
                <td>Berakhir Jam :</td>
                <td>{{ $sla->audit_end_time }}</td>
                <td>Jumlah Orang yang diamati :</td>
                <td></td>
            </tr>
            <tr>
                <td style="vertical-align:top;">Team Audit</td>
                <td class="w-1" style="vertical-align:top;">:</td>
                <td colspan="2" style="vertical-align:top;padding-right:3rem;">
                    @foreach($sla->audit_teams as $key => $value)
                    {{ $value['label'] }}
                    @endforeach
                </td>
                <td></td>
                <td></td>
                <td></td>
                {{-- <td></td>
                <td></td> --}}
            </tr>
            <tr>
                <td>Distribusi</td>
                <td class="w-1">:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="table" border="0" style="margin-top:1.5rem;font-size:12px;">
        <thead>
            <tr>
                @foreach ($categories as $key => $value)
                <th colspan="2" class="text-align:left;">{{ $value['name'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr style="height:12px;">

                @foreach ($categories as $key => $value)
                <td colspan="2" class="w-4 max-w-4 bg-blue-200" style="height:12px;padding:10px;text-align:left;">
                    {{ $categories[$key]['label'] }}
                </td>
                @endforeach
            </tr>
            <tr>
                @foreach($categories as $key => $val)
                <td colspan="2" class="w-4 max-w-4 items-start justify-start bg-blue-300" style="vertical-align:top;">

                    {{-- @php $valuasi = null; @endphp --}}
                    @php
                    $arr = [];
                    $no = 1;

                    foreach($categories[(int)$key]->items as $k => $v){
                    /*if(collect($sla->audit_findings[$key]['items'])->contains("value", $v['value'])){*/
                    if(1 === 1){

                    array_push($arr, $v);
                    print_r($v['value']);

                    /*print_r($sla->audit_findings[0]['items']);*/
                    /* ->contains("value", $v['value']) */

                    }
                    else {
                    array_push($arr, $v);
                    }
                    }

                    echo count($arr);
                    @endphp

                    @foreach ($categories[(int)$key]->items as $key => $value)
                    <div class="items-start justify-start bg-teal-200" style="vertical-align:middle;">
                        @php
                        $valuasi = $value['value']; // 1, 2, dst
                        $auditFindings = $sla->audit_findings;

                        //$checkResult = false;
                        //echo "valuasi=".$valuasi." - ";
                        if (isset($auditFindings[$key]['items']) && is_array($auditFindings[$key]['items']))
                        {



                        $rs = collect($auditFindings[(int)$key]['items']);
                        //dd($rs);

                        $checkResult = $rs->contains("value", $valuasi) && $rs->contains("label", $value['label']);
                        //dd($checkResult);

                        //echo "[".gettype($checkResult)."]";
                        } else {

                        //dd(isset($auditFindings[(int)$key]['items']) && is_array($auditFindings[(int)$key]['items']));

                        $checkResult = false;
                        }

                        @endphp
                        <input type="checkbox" class="pr-1" checked />
                        {{-- checked="{{ @if($checkResult) echo true @else echo false @endif }}" --}}



                        {{ $value['label'] }}
                        {{-- ( {{ $value['value'] }} ) --}}
                    </div>
                    @endforeach
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <table class="table w-full border border-black" style="border:solid 1px;font-size:12px;margin-top:2rem;">
        <thead>
            <tr>
                <td colspan="3" style="padding:.3rem;" class="font-bold">KONSEKUENSI (KON)</td>
                <td colspan="4" style="padding:.3rem;" class="font-bold">1=Minor 3=Major 9=Fatal</td>
            </tr>
            <tr style="border-collapse:collapse;background-color:#abe03a;font-weight:900;color:white;">
                <td style="width:2%;padding:.3rem;" class="py-2 w-4 font-bold text-[10px] text-white text-center bg-green-400">CAT</td>
                <td style="width:2%;padding:.3rem;" class="py-2 w-4 font-bold text-[10px] text-white text-center bg-green-400">KON</td>
                <td style="padding:.3rem;" class="py-2 font-bold text-white text-center bg-green-400">Pelanggaran Safety</td>
                <td style="padding:.3rem;" class="py-2 font-bold text-white text-center bg-green-400">Potensi Kerusakan/Kerugian</td>
                <td style="padding:.3rem;" class="py-2 font-bold text-white text-center bg-green-400">Tindakan yang sudah diberikan</td>
                <td style="padding:.3rem;" class="py-2 w-4 font-bold text-white text-center bg-green-400">ACT</td>
                <td style="padding:.3rem;" class="py-2 w-4 font-bold text-white text-center bg-green-400">CON</td>

            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($sla->audit_findings as $key => $value)
            <tr>
                <td style="width:2%;padding:.3rem;"></td>
                <td style="width:2%;padding:.3rem;">{{ $value['konsekuensi'] }}</td>
                <td style="padding:.3rem;">{{ $value['pelanggaran_safety'] }}</td>
                <td style="padding:.3rem;">{{ $value['potensi_kerusakan'] }}</td>
                <td style="padding:.3rem;">{{ $value['tindakan_yang_diberikan'] }}</td>
                <td style="width:2%;padding:.3rem;"></td>
                <td style="width:2%;padding:.3rem;"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- perilaku safety layak dipuji --}}

    <table border="0" class="table w-full border border-black" style="border:solid 1px;font-size:12px;margin-top:2rem;">
        <thead>
            <tr style="border-collapse:collapse;background-color:#abe03a;font-weight:900;color:white;">
                <td colspan="2" style="text-transform:capitalize;text-align:center;padding:.4rem;">perilaku safety yang layak dipuji</td>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($sla->safety_behaviors as $key => $value)
            <tr>
                <td style="width:2%;padding:.4rem;">{{ $no++ }}</td>
                <td style="padding:.4rem;">{{ $value['description'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>



    {{-- tindak lanjut --}}
    <table border="0" class="table w-full border border-black" style="border:solid 1px;font-size:12px;margin-top:2rem;">
        <thead>
            <tr style="border-collapse:collapse;background-color:#abe03a;font-weight:900;color:white;">
                <td style="width:2%;padding:.4rem;">No</td>
                <td style="padding:.4rem;">Uraian tindakan</td>
                <td style="padding:.4rem;">Oleh</td>
                <td style="padding:.4rem;">Selesai</td>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach($sla->audit_actionables as $key => $value)
            <tr>
                <td style="width:2%;padding:.4rem;">{{ $no++ }}</td>
                <td style="padding:.4rem;">{{ $value['uraian'] }}</td>
                <td style="padding:.4rem;">{{ $value['oleh']['label'] }}</td>
                <td style="padding:.4rem;">{{ $value['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>


    {{-- <div class="flex flex-row">
        <div class="flex w-5">1</div>
        <div class="flex w-5">2</div>
        <div class="flex w-5">3</div>

    </div> --}}

</body>
