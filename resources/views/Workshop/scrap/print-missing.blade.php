<html>
    <title>Berita acara kerusakan tools - PT. Sumber Setia Budi </title>
    <head>
        <style>
            body{
                padding: 0 50px;
                
            }
        </style>
    </head>
    <body>
        <div style="text-align: center"><h2 >BERITA ACARA KERUSAKAN TOOLS</h2></div>
        <br>
        <table style="width: 40%;border-collapse: collapse;">
            <tr>
                <td>Nama</td>
                <td>: {{ $toolMissing->karyawan->nm_lengkap }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $toolMissing->karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ $toolMissing->karyawan->get_jabatan->nm_jabatan }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top">Perihal</td>
                <td>: Kerusakan Tools </td>
            </tr>
        </table>
        <br>
        <p style="text-indent: 50px;margin: 0 0 ">Pada hari ini, {{ \Carbon\Carbon::create($toolMissing->date)->format('d M Y') }} terjadi kerusakan tools yand di sebabkan oleh {{ $toolMissing->reason }}.</p>
        <p style="margin: 0 0">Daftar tools yang rusak sebagai berikut :</p>
        
        <br>
        <table  style="width: 50%; margin:0 auto; border-collapse: collapse;border:solid black 1px" border="1">
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Qty</td>
            </tr>
            @foreach ($toolMissing->details as $item)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $item->tools->name }}</td>
                    <td>{{ $item->qty}}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <p style="text-indent: 50px">Demikian berita acara ini dibuat, mohon kiranya dilakukan pergantian tools tersebut demi kelancaran dalam bekerja. Atas perhatian dan kerjasamanya diucapkan termikasih.</p>
        <br>
        <br>
        <table style="width: 100%; margin:0 auto;text-align:center">
            <tr>
                <td>Dibuat Oleh,</td>
                <td>Diketahui Oleh,</td>
            </tr>
            <tr>
                <td>{{ $toolMissing->karyawan->get_jabatan->nm_jabatan }}</td>
                <td>ka_mekanik</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>{{ $toolMissing->karyawan->nm_lengkap }}</td>
                <td>name</td>
            </tr>
        </table>
    </body>
</html>