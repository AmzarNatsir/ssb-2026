<html>
<title>Service work order </title>

<head>
    <style>
      @page { margin: 10px; }
        body {
          font-size: 10px;
          font-family: Arial, Helvetica, sans-serif;
          margin: 10px;
          text-transform: uppercase;
        }

        table {
          border-collapse: collapse;
          width: 100%;
        }

        table td{
          width: 4.17%;
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
            width: 12px;
            height: 12px;
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

        .t-center{
          text-align: center;
        }

    </style>
</head>
<body>
  <table>
    <tr class="b-top b-left b-right">
      <td colspan="4" rowspan="2" class="t-center">logo</td>
      <td colspan="16" class="t-center t-bold" style="font-size: 11pt">FORM INSPEKSI UNIT "KELUAR & MASUK WORKSHOP"</td>
      <td colspan="4" rowspan="2" class="t-center">logo</td>
    </tr>
    <tr class="b-left b-right">
      <td colspan="16" class="t-center t-bold" style="font-size: 13pt">PT. SUMBER SETIA BUDI</td>
    </tr>
    <tr class="t-bold b-top b-left b-right">
      <td colspan="4">NO. UNIT</td>
      <td colspan="5">:&nbsp;{{ $workOrder->equipment?->code  }}/{{ $workOrder->equipment?->name  }}</td>
      <td colspan="3" class="b-left">HM/KM</td>
      <td colspan="5">:&nbsp;{{ $unitInspection->hm  }}/{{ $unitInspection->km }}</td>
      <td colspan="3" class="b-left">MEKANIK</td>
      <td colspan="4">:&nbsp;{{ $unitInspection->mechanic?->nm_lengkap }}</td>
    </tr>
    <tr class="t-bold b-top b-left b-right">
      <td colspan="4">TYPE/JENIS</td>
      <td colspan="5">:&nbsp;{{ $workOrder->equipment?->equipment_category?->name }}</td>
      <td colspan="3" class="b-left">LOKASI</td>
      <td colspan="5">:&nbsp;{{ $unitInspection->location?->location_name }}</td>
      <td colspan="3" class="b-left">NIK</td>
      <td colspan="4">:&nbsp;{{ $unitInspection->mechanic?->nik }}</td>
    </tr>
    <tr class="t-bold b-top b-left b-right">
      <td colspan="4">TGL/BLN/THN</td>
      <td colspan="5">:&nbsp;{{ date('d/m/Y', strtotime($unitInspection->inspection_date)) }}</td>
      <td colspan="3" class="b-left">NO. WO</td>
      <td colspan="5">:&nbsp;{{ $workOrder->number }}</td>
      <td colspan="3" class="b-left"></td>
      <td colspan="4"></td>
    </tr>
    @forelse (collect($unitInspection->checklists_array) as $groupKey => $group)
      <tr class="b-top b-left b-right t-bold" style="background-color: yellow">
        <td colspan="9">
          <i>{{chr(($groupKey+1)+64)}}. {{ $group["checklist_group_name"] }}</i>
        </td>
        <td colspan="3" class="t-center b-left">BAIK</td>
        <td colspan="3" class="t-center b-left">TIDAK</td>
        <td colspan="9" class="t-center b-left">KETERANGAN</td>
      </tr>
      @forelse($group["checklist_items"] as $itemKey => $item)
        <tr class="b-top b-left b-right">
          <td class="t-center">{{$itemKey+1}}.</td>
          <td colspan="8" class="b-left">
            &nbsp;{{$item["checklist_item_name"]}}
          </td>
          <td colspan="3" class="b-left">
            <div class="tick">{{ $item["check_result"] == "1" ? "X":''  }}</div>
          </td>
          <td colspan="3" class="b-left">
            <div class="tick"> {{ $item["check_result"] == "0" ? "X":'' }}</div>
          </td>
          <td colspan="9" class="b-left">&nbsp;{{ $item["remarks"] }}</td>
        </tr>
      @empty
      @endforelse
    @empty
    @endforelse
    <tr>
      <td colspan="24" class="b-top b-left b-right t-bold t-center" style="background-color: yellow">TEMUAN</td>
    </tr>
    <tr class="b-top b-left b-right">
      <td colspan="24">
        <div class="tick" style="float: left"> {{ $unitInspection->check_result == "1" ? "X" : ""  }} </div>&nbsp; UNIT BISA DIOPERASIKAN DALAM KONDISI BAIK
      </td>
    </tr>
    <tr class="b-top b-left b-right">
      <td colspan="24">
        <div class="tick" style="float: left"> {{ $unitInspection->check_result == "2" ? "X" : ""  }} </div>&nbsp; UNIT BISA DIOPERASIKAN DENGAN KONDISI BACKLOG YANG BISA DI EXTEND
      </td>
    </tr>
    <tr class="b-top b-left b-right">
      <td colspan="24">
        <div class="tick" style="float: left"> {{ $unitInspection->check_result == "3" ? "X" : ""  }} </div>&nbsp; UNIT TIDAK BISA DIOPERASIKAN DENGAN KERUSAKAN BERAT
      </td>
    </tr>
    <tr class="b-top b-left b-right t-bold t-center" style="background-color: yellow"><td colspan="24">CATATAN</td></tr>
    <tr class="b-top b-left b-right">
      <td colspan="24"> &nbsp;{{ $unitInspection->remarks }}<br><br></td>
    </tr>
    <tr class="b-top b-left b-right t-center t-bold">
      <td colspan="6" class="b-left">INSPEKSI BY</td>
      <td colspan="6" class="b-left">QUALITY CONTROL</td>
      <td colspan="6" class="b-left">MENGETAHUI</td>
      <td colspan="6" class="b-left">MENYETUJUI</td>
    </tr>
    <tr class="b-top b-left b-right">
      <td colspan="6" class="b-left"><br><br><br><br><hr style="width: 80%"></td>
      <td colspan="6" class="b-left"><br><br><br><br><hr style="width: 80%"></td>
      <td colspan="6" class="b-left"><br><br><br><br><hr style="width: 80%"></td>
      <td colspan="6" class="b-left"><br><br><br><br><hr style="width: 80%"></td>
    </tr>
    <tr class="b-top b-left b-right t-center">
      <td colspan="6">MEKANIK</td>
      <td colspan="6" class="b-left">Tim PI</td>
      <td colspan="6" class="b-left">Kepala Bagian</td>
      <td colspan="6" class="b-left">Manajer Workshop</td>
    </tr>
    <tr class="b-top">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table>
</body>
</html>
