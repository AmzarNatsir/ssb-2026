@php
$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
 <html lang="en">
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>SSB | Smart System Base | HRD | Perubahan Status | Surat PKWT</title>
<style>
    @page {
        margin: 0px;
    }
    body {
        margin : 110px 100px;
        font-size: 12px;
        font-family: 'Poppins', sans-serif;
    }
    a {
        color: #fff;
        text-decoration: none;
    }
    table {
        font-size: 11px;
        font-family: 'Poppins', sans-serif;
    }
    tfoot tr td {
        font-weight: bold;
        font-size: x-small;
    }
    .page-break {
        page-break-after: always;
    }
    .information {
        background-color: #ffffff;
        color: #020202;
    }
    .information .logo {
        margin: 5px;
    }
    .information table {
        padding: 10px;
    }
    header { position: fixed; top: -10px; left: 0px; right: 0px; background-color: #03a9f4; height: 30px; }
    .isi {
        font-size: 13px;
    }
    /*
    footer { position: fixed; bottom: -60px; left: 0px; right: 0px; background-color: #03a9f4; height: 25px; }
    */
    .page-break:last-child { page-break-after: never; }
    </style>
    </head>
    <header>
    <div class="information">
        <table width="100%">
            <tr>
                <td align="left" style="width: 50%;">
                <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo"/>
                </td>
                <td align="right" style="width: 50%;">
                    <h2>PT. SUMBER SETIA BUDI</h2>
                    {{-- <pre> --}}
                        {{ $kop_surat['alamat_situs'] }}<br>
                        {{ $kop_surat['lokasi'] }}
                    {{-- </pre> --}}
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
        </table>
    </div>
    </header>
  <main>
<table style="width: 100%;" class="isi">
<tr>
    <td colspan="3" style="text-align: center; font-size:large"><b><u>PERJANJIAN KERJA WAKTU TERTENTU (PKWT)</u></b></td>
</tr>
<tr>
    <td colspan="3" style="text-align: center; font-size:13px"><b>NO. {{ (empty($dt_status->no_surat)) ? "" : $dt_status->no_surat }}</b></td>
</tr>
<tr><td colspan="3" style="height: 30px;"></td></tr>
<tr>
    <td colspan="3" style="text-align: justify;">Yang bertanda tangan dibawah ini :</td>
</tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 5%; text-align: right;">I.</td>
    <td style="width: 25%;">Nama</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>MISBAH</b></td>
</tr>
<tr>
    <td></td>
    <td>Jabatan</td>
    <td style="text-align: right;">:</td>
    <td><b>HRD</b></td>
</tr>
<tr>
    <td></td>
    <td>Alamat</td>
    <td style="text-align: right;">:</td>
    <td><b>Jl. Protokol, No.45 Dawi-Dawi Pomala, Tlp. (0405) 310188</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Bertindak untuk dan atas nama PT. Sumber Setia Budi Pomala, selanjutnya dalam perjanjian ini disebut <b>PIHAK PERTAMA</b></td>
</tr>
<tr>
    <td style="width: 5%; text-align: right;">II.</td>
    <td style="width: 25%;">Nama</td>
    <td style="width: 1%;; text-align: right;">:</td>
    <td style="width: 69%;"><b>{{ $dt_status->get_profil->nm_lengkap }}</b></td>
</tr>
<tr>
    <td></td>
    <td>Tempat/Tgl. Lahir</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $dt_status->get_profil->tmp_lahir }} / {{ date_format(date_create($dt_status->get_profil->tgl_lahir), 'd-m-Y') }}</b></td>
</tr>
<tr>
    <td></td>
    <td>Agama</td>
    <td style="text-align: right;">:</td>
    <td><b>
        @foreach($list_agama as $key => $agama)
        @if($key==$dt_status->get_profil->agama)
            {{ $agama }}
            @php break; @endphp
        @endif
        @endforeach
        </b></td>
</tr>
<tr>
    <td></td>
    <td>Alamat</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $dt_status->get_profil->alamat }}</b></td>
</tr>
<tr>
    <td colspan="4">Selanjutnya dalam perjanjian ini disebut <b>PIHAK KEDUA</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Kami <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> berdasarkan persetujuan bersama telah mengadakan perjanjian ikatan kerja dengan ketentuan sebagai berikut :</td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 5%; vertical-align: top;">1.</td>
    <td style="text-align: justify; width: 95%;">Pihak Pertama memberikan pekerjaan kepada Pihak Kedua sebagai <b>{{ (empty($dt_status->get_profil->get_jabatan->nm_jabatan)) ? "" : $dt_status->get_profil->get_jabatan->nm_jabatan }}</b> dengan status tenaga <b>{{ $dt_status->get_status_karyawan($dt_status->get_profil->id_status_karyawan) }}</b>.</td>
</tr>
<tr>
    <td style="vertical-align: top;">2.</td>
    <td style="text-align: justify">Pihak Kedua bersedia menjalankan pekerjaan sebagaimana yang dimaksud dalam butir 1 (satu) diatas dengan sebaik-baiknya, serta memperhatikan dan mentaati Peraturan / Tata Tertib Kepegawaian yang berlaku pada PT. Sumber Setia Budi.</td>
</tr>
<tr>
    <td style="vertical-align: top;">3. </td>
    <td style="text-align: justify">
        Pihak Pertama menentukan jam kerja bagi Pihak Kedua sebagaimana ditentukan oleh pihak Perusahaan PT. Sumber Setua Budi sebagai berikut :<br>
        1. Jam 07.00 wita sampai dengan 12.00 wita.<br>
        2. Jam 14.00 wita sampai dengan 17.00 wita.<br>
        Jam kerja tersebut diatas jam kerja untuk perhitungan 1 (satu) shift.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">4. </td>
    <td style="text-align: justify">
        Sehubungan dengan pemberian tugas pekerjaan dari Pihak Pertama kepada Pihak Kedua maka Pihak Pertama memberikan upah pokok sebesar <b>Rp. {{ number_format($dt_status->get_profil->gaji_pokok, 0, ",", ".") }} ({{ \App\Helpers\Hrdhelper::terbilang($dt_status->get_profil->gaji_pokok) }} Rupiah) Perbulan.</b>
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">5. </td>
    <td style="text-align: justify">
        Dalam pelaksanaan tugas, Pihak Kedua berada dibawah perintah dan bertanggung jawab kepada Pihak Pertama Cq. atasan masing-masing / Pimpinan Perusahaan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">6. </td>
    <td style="text-align: justify">
        Pihak Kedua bersedia dan berjanji mentaati aturan sistem penggajian yang ditetapkan oleh Pihak Pertama tanpa menuntut sesuatu apapun termasuk perubahan-perubahan aturan sistem penggajian yang disesuaikan dengan kemampuan perusahaan PT. Sumber Setia Budi dan tidak bertentangan dengan aturan dari Departemen Tenaga Kerja RI.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">7. </td>
    <td style="text-align: justify">
        Pihak Kedua bersedia ditempatkan dimana saja dan mentaati aturan Perusahaan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">8. </td>
    <td style="text-align: justify">
        Pihak Pertama mengikut sertakan Pihak Kedua kedalam Jaminan BPJS Ketenagakerjaan dan BPJS Kesehatan setelah masa percobaan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">9. </td>
    <td style="text-align: justify">
        Pihak Pertama sewaktu-waktu dapat memutuskan hubungan kerja secara sepihak terhadap Pihak Kedua karena melakukan pelanggaran atas ketentuan yang berlaku pada perusahaan.<br>
        PT. Sumber Setia Budi dan ketentuan undang-undang No. 13 tahun 2003 berikut :
    </td>
</tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="vertical-align: top; width: 5%;"></td>
    <td style="vertical-align: top; width: 5%;">a. </td>
    <td style="text-align: justify; width: 95%;">
        Pihak Kedua tidak mematuhi peraturan Keselamatan Kerja Pertambangan bagi pekerja lapangan dan Tata Tertib Kepegawaian yang berlaku pada PT. Sumber Setia Budi.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">b. </td>
    <td style="text-align: justify;">
        Terulangnya keterlambatan datang bekerja tanpa alasan yang dapat dipertanggung jawabkan setelah mendapat 3 (tiga) peringatan dari Pihak Pertama.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">c. </td>
    <td style="text-align: justify;">
        Mangkir 5 (lima) hari dalam sebulan tanpa alasan yang dapat dipertanggung jawabkan setelah mendapatkan peringatan dari Pihak Pertama.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">d. </td>
    <td style="text-align: justify;">
        Melakukan pencurian, pengelapan, atau penipuan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">e. </td>
    <td style="text-align: justify;">
        Melakukan penganiayaan terhadap pengusaha, keluarga pengusaha atau sesama rekan kerja.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">f. </td>
    <td style="text-align: justify;">
        Menimbulkan kerugian materil yang besar akibat kelalaian terhadap inventaris/asset perusahaan akan ditanggung sepenuhnya karyawan termasuk diperhitungkan saat pembayaran sisa gaji atau pesangon dll.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">g. </td>
    <td style="text-align: justify;">
        Melakukan perbuatan asusila / minum-minuman keras / mabuk / judi / memakai narkotika.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">h. </td>
    <td style="text-align: justify;">
        Memberikan keterangan palsu atau mencemarkan nama baik perusahaan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">i. </td>
    <td style="text-align: justify;">
        Menghina atau mengancam pengusaha, sesama pekerja dan Perusahaan PT. Sumber Setia Budi.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">j. </td>
    <td style="text-align: justify;">
        Membocorkan rahasia perusahaan atau rumah tangga pengusaha.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">k. </td>
    <td style="text-align: justify;">
        Membawa senjata tajam ditempat kerja tanpa surat izin dari kepolisian.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">l. </td>
    <td style="text-align: justify;">
        Tidak menunjukkan kesungguhan kerja dan atau loyalitas kerja.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">m. </td>
    <td style="text-align: justify;">
        Terjadi hubungan disharmonisasi (tidak harmonis) antara pihak pertama dan pihak kedua.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="vertical-align: top;">n. </td>
    <td style="text-align: justify;">
        Terbukti melakukan perselingkuhan dalam hubungan perkawinan.
    </td>
</tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 5%; vertical-align: top;">10.</td>
    <td style="text-align: justify; width: 95%;">Kerugian materil yang disebabkan oleh kelalaian Pihak Kedua akan menjadi tanggung jawab sepenuhnya dari pihak kedua untuk mengganti kerugian tersebut.</td>
</tr>
<tr>
    <td style="vertical-align: top;">11. </td>
    <td style="text-align: justify">
        Bila Pihak Kedua tidak lagi bekerja pada PT. Sumber Setia Budi maka segalam peralatan kerja dan kelengkapan milik PT. Sumber Setia Budi (pakaian dinas, alat pelindung diri (APD) dan Kartu Lencana) diserahkan kembali pada PT. Sumber Setia Budi tanpa ada syarat apapun.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">12. </td>
    <td style="text-align: justify">
        Pihak Pertama menyatakan kepada Pihak Kedua tidak memberikan janji lain, selain ketentuan yang termaksud dalam perjanjian ini.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">13. </td>
    <td style="text-align: justify">
        Perjanjian Kerja Waktu Tertentu (PKWT) ini berlaku terhitung mulai sejak tanggal, <b>{{ date_format(date_create($dt_status->tgl_eff_baru), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_eff_baru), 'm')) }} {{ date_format(date_create($dt_status->tgl_eff_baru), 'Y') }} sampai dengan {{ date_format(date_create($dt_status->tgl_akh_baru), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_akh_baru), 'm')) }} {{ date_format(date_create($dt_status->tgl_akh_baru), 'Y') }}</b> dengan ketentuan bahwa perjanjian kerja ini dapat diakhiri sebelum habis, jika hal tersebut dikehendaki oleh salah satu pihak.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">14. </td>
    <td style="text-align: justify">
        Hal-hal yang belum diatur dalam surat perjanjian ini akan ditentukan dilain waktu yang ditandatangani kedua belah pihak.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">15. </td>
    <td style="text-align: justify">
        Dengan berakhirnya Perjanjian Kerja ini, maka berakhirlah Ikatan Kerja antara Pihak Pertama terhadap Pihak Kedua dan Pihak Pertama tidak mempunyai kewajiban apapun juga, termasuk pemberian uang pesangon dll terhadap Pihak Kedua.
    </td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="height: 20px; text-align: justify">
    Demikian Surat Perjajian Ikatan Kerja ini kami buat dan ditandatangani diatas materai dengan tidak ada unsur paksaan atau tekanan dari masing-masing pihak atau orang lain.
    </td>
</tr>
<tr><td colspan="2" style="height: 30px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
    <tr>
        <td style="width: 50%;"></td>
        <td style="width: 19%%;">Dibuat di</td>
        <td style="width: 1%;">:</td>
        <td style="width: 30%;">Pomalaa</td>
    </tr>
    <tr>
        <td></td>
        <td>Pada Tanggal</td>
        <td>:</td>
        <td>{{ date_format(date_create($dt_status->tgl_surat), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_surat), 'm')) }} {{ date_format(date_create($dt_status->tgl_surat), 'Y') }}</td>
    </tr>
    <tr><td colspan="4" style="height: 30px;"></td></tr>
</table>
<table style="width: 100%;" class="isi">
<tr>
    <td style="width: 50%;">Pihak Pertama</td>
    <td style="width: 50%;">Pihak Kedua</td>
</tr>
<tr><td colspan="2" style="height: 50px;"></td></tr>
<tr>
    <td><b><u>{{ $dt_status->get_current_approve->nm_lengkap }}</u></b><br><b>{{ $dt_status->get_current_approve->get_jabatan->nm_jabatan }}</b></td>
    <td><b><u>{{ $dt_status->get_profil->nm_lengkap }}</u></b></td>
</tr>
</table>
  </main>
</body>
 </html>
