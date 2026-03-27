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
        font-size: 12px;
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
                    @if(!empty($kop_surat['logo']))
                    <img src="{{ url(Storage::url('logo_perusahaan/'.$kop_surat['logo'])) }}" alt="Logo" width="100px" width="auto" class="logo"/>
                    @else
                    <img src="{{ asset('assets/images/no_image.jpg') }}" alt="Logo" width="80px" width="auto" class="logo"/>
                    @endif
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
    <td style="width: 69%;"><b>{{ $dt_status->get_current_approve->nm_lengkap }}</b></td>
</tr>
<tr>
    <td></td>
    <td>Jabatan</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $dt_status->get_current_approve->get_jabatan->nm_jabatan }}</b></td>
</tr>
<tr>
    <td></td>
    <td>Alamat</td>
    <td style="text-align: right;">:</td>
    <td><b>{{ $dt_status->get_current_approve->alamat }}</b></td>
</tr>
<tr><td colspan="4" style="height: 20px;"></td></tr>
<tr>
    <td colspan="4">Bertindak untuk dan atas nama PT. Sumber Setia Budi Pomalaa, selanjutnya dalam perjanjian ini disebut <b>PIHAK PERTAMA</b></td>
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
    <td colspan="2" style="text-align: center"><b>PASAL 1<br>Tugas dan Tanggung Jawab</b></td>
</tr>
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
    <td style="text-align: justify">Dalam pelaksanaan tugas, Pihak Kedua berada dibawah perintah dan bertanggung jawab kepada Pihak Pertama Cq. atasan masing-masing / Pimpinan Perusahaan.</td>
</tr>
<tr>
    <td style="vertical-align: top;">4. </td>
    <td style="text-align: justify">Pihak Kedua bersedia ditempatkan dimana saja dan mentaati aturan Perusahaan.</td>
</tr>
<tr>
    <td style="vertical-align: top;">5. </td>
    <td style="text-align: justify">Memastikan pencatatan pada buku besar terupdate dengan benar</td>
</tr>
<tr>
    <td style="vertical-align: top;">6. </td>
    <td style="text-align: justify">Memastikan keseimbangan untuk seluruh akun general ledger</td>
</tr>
<tr>
    <td style="vertical-align: top;">7. </td>
    <td style="text-align: justify">Membuat persiapan laporan keuangan</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 2<br>Jangka Waktu PKWT</b></td>
</tr>
<tr>
    <td style="width: 5%; vertical-align: top;">1.</td>
    <td style="text-align: justify; width: 95%;">Perjanjian Kerja Waktu Tertentu (PKWT) ini berlaku terhitung mulai sejak tanggal, <b>{{ date_format(date_create($dt_status->tgl_eff_baru), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_eff_baru), 'm')) }} {{ date_format(date_create($dt_status->tgl_eff_baru), 'Y') }} sampai dengan {{ date_format(date_create($dt_status->tgl_akh_baru), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($dt_status->tgl_akh_baru), 'm')) }} {{ date_format(date_create($dt_status->tgl_akh_baru), 'Y') }}</b>. Perpanjangan maupun pembaharuan PKWT ini dapat dilakukan sesuai dengan kesepakatan dan persetujuan Kedua Pihak. Pihak Kedua diwajibkan untuk melapor kepada Pihak Pertama, jika jangka waktu perjanjian kerja waktu tertentu ini akan berakhir yaitu minimal 30 (tiga puluh) hari sebelumnya.</td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Selama PKWT masih berlangsung, maka akan ada Evaluasi kinerja setiap bulan dan atau per 3 Bulan bila dibutuhkan.
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">3. </td>
    <td style="text-align: justify">Jika Pihak Kedua setelah masa Evaluasi Kinerja 1 Bulan atau maksimal 3 Bulan dan telah mencapai standar yang telah ditetapkan, maka Pihak Kedua tetap melanjutkan PKWT yang sudah berlangsung sampai jangka waktu PKWT berakhir.</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 3<br>Upah dan Fasilitas</b></td>
</tr>
<tr>
    <td style="vertical-align: top;">1. </td>
    <td style="text-align: justify">
        Sehubungan dengan pemberian tugas pekerjaan dari Pihak Pertama kepada Pihak Kedua maka Pihak Pertama memberikan upah pokok sebesar <b><i>Rp. {{ number_format($dt_status->get_profil->gaji_pokok, 0, ",", ".") }} ({{ \App\Helpers\Hrdhelper::terbilang($dt_status->get_profil->gaji_pokok) }} Rupiah) Perbulan.</i></b>
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Pembayaran gaji dilakukan setiap awal bulan melalui rekening Bank milik Pihak Kedua.</td>
</tr>
<tr>
    <td style="vertical-align: top;">3. </td>
    <td style="text-align: justify">Pihak Kedua berhak memperoleh Tunjangan Hari Raya (THR) yang besarnya diperhitungkan secara pro- rata/proposional dan berdasarkan ketentuan undang-undang.</td>
</tr>
<tr>
    <td style="vertical-align: top;">4. </td>
    <td style="text-align: justify">Pihak Kedua bersedia dan berjanji mentaati aturan sistem penggajian yang ditetapkan oleh Pihak Pertama, tanpa menuntut sesuatu apapun termasuk perubahan-perubahan aturan sistem penggajian yang disesuaikan dengan kemampuan perusahaan PT.Sumber Setia Budi dan tidak bertentangan dengan aturan dari Depertemen Tenaga Kerja RI.</td>
</tr>
<tr>
    <td style="vertical-align: top;">5. </td>
    <td style="text-align: justify">Pihak Pertama mengikut sertakan Pihak Kedua kedalam Jaminan BPJamsostek dan BPJS Kesehatan setelah masa percobaan 3 bulan.</td>
</tr>
<tr>
    <td style="vertical-align: top;">6. </td>
    <td style="text-align: justify">Pihak Kedua berhak mendapatkan cuti tahunan setelah bekerja selama 12 bulan berturut-turut.</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 4<br>Tata Tertib dan Waktu Kerja</b></td>
</tr>
<tr>
    <td style="vertical-align: top;">1. </td>
    <td style="text-align: justify">
        Pihak Pertama menetapkan jam kerja bagi Pihak Kedua sebagaimana ditentukan oleh pihak Perusahaan PT. Sumber Setia Budi sebagai berikut :<br>
        • Senin - Jumat, Jam 08 : 00 sampai dengan 17 : 00<br>
        • Sabtu 08 : 00 sampai dengan 16 : 00<br>
        &nbsp;&nbsp;&nbsp;Istirahat jam 12.00-14.00 untuk hari Senin-Kamis dan Sabtu<br>
        &nbsp;&nbsp;&nbsp;Istirahat jam 11.00-14.00 untuk hari Jumat
    </td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Ketentuan Sakit, ijin dan tidak masuk bekerja dilaporkan ke Atasan langsung. Apabila sakit lebih dari 2 hari, wajib melampirkan surat keterangan sakit dari dokter</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 5<br>Etika dan Perilaku</b></td>
</tr>
<tr>
    <td style="vertical-align: top;">1. </td>
    <td style="text-align: justify">Melaksanakan tugas  serta  pekerjaan dengan  penuh  rasa tanggung  jawab  sesuai dengan kewajiban, serta memperhatikan dan mentaati Peraturan yang berlaku pada PT. Sumber Setia Budi.</td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Bertindak jujur, komitmen dan dapat dipercaya dalam melaksanakan pekerjaannya.</td>
</tr>
<tr>
    <td style="vertical-align: top;">3. </td>
    <td style="text-align: justify">Memelihara etika kerja termasuk ketepatan waktu kerja.</td>
</tr>
<tr>
    <td style="vertical-align: top;">4. </td>
    <td style="text-align: justify">Selama berada dilingkungan kerja Pihak Kedua wajib menggunakan pakaian kerja yang telah di tentukan oleh Pihak Pertama.</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 6<br>Kerahasiaan</b></td>
</tr>
<tr>
    <td style="vertical-align: top;"></td>
    <td style="text-align: justify">Pihak Kedua tidak diperkenankan untuk menyebarkan data perusahaan atau rumah tangga pengusaha baik berbentuk file, tulisan, lisan maupun surel.</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 7<br>Berakhirnya PKWT</b></td>
</tr>
<tr>
    <td style="vertical-align: top;">1. </td>
    <td style="text-align: justify">Pihak Pertama sewaktu-waktu dapat memutuskan hubungan kerja secara sepihak terhadap Pihak Kedua karena melakukan pelanggaran atas ketentuan yang berlaku pada perusahaan PT. Sumber Setia Budi dan ketentuan undang-undang No.13 thn 2003 sebagai berikut :</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">a. </td>
    <td style="text-align: justify">Pihak Kedua tidak mematuhi peraturan Keselamatan Kerja Pertambangan bagi pekerja lapangan dan Tata Tertib Kepegawaian yang berlaku pada PT.Sumber Setia Budi.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">b. </td>
    <td style="text-align: justify">Terulangnya keterlambatan datang bekerja tanpa alasan yang dapat dipertanggung jawabkan setelah mendapat 3 (tiga) kali peringatan dari Pihak Pertama.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">c. </td>
    <td style="text-align: justify">Mangkir 5 (lima) hari dalam sebulan tanpa alasan yang dapat dipertanggung jawabkan setelah mendapat peringatan dari pihak pertama</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">d. </td>
    <td style="text-align: justify">Evaluasi Kinerja tidak sesuai dengan komitmen dan tidak memenuhi standar yang telah ditetapkan.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">e. </td>
    <td style="text-align: justify">Melakukan pencurian, penggelapan, atau penipuan.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">f. </td>
    <td style="text-align: justify">Melakukan penganiayaan terhadap pengusaha, keluarga pengusaha atau sesama rekan kerja.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">g. </td>
    <td style="text-align: justify">Menimbulkan kerugian materil yang besar akibat kelalaian terhadap inventaris/asset perusahaan akan ditanggung sepenuhnya karyawan temasuk diperhitungkan saat pembayaran sisa gaji atau pesangon dll.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">h. </td>
    <td style="text-align: justify">Melakukan perbuatan Asusila / minum-minuman keras / mabuk / judi / memakai narkotika.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">i. </td>
    <td style="text-align: justify">Memberikan keterangan palsu atau mencemarkan nama baik perusahaan.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">j. </td>
    <td style="text-align: justify">Menghina atau mengancam pengusaha, sesama pekerja dan Perusahaan PT. Sumber Setia Budi.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">k. </td>
    <td style="text-align: justify">Membawa senjata tajam ditempat kerja tanpa surat izin dari kepolisian</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">l. </td>
    <td style="text-align: justify">Tidak Menunjukkan Kesungguhan Kerja dan atau loyalitas kerja.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">m. </td>
    <td style="text-align: justify">Terjadi hubungan Disharmonis (tidak harmonis) antara pihak pertama dan pihak kedua.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">n. </td>
    <td style="text-align: justify">Terbukti melakukan perselingkuhan dalam hubungan perkawinan.</td>
</tr>
<tr>
    <td style="vertical-align: top; text-align: right">o. </td>
    <td style="text-align: justify">Tidak dapat melakukan pekerjaan selama 6 (enam) bulan akibat ditahan pihak yang berwajib karena diduga melakukan tindak pidana.</td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Pihak Kedua mengakhiri hubungan kerja sebelum berakhirnya jangka waktu yang ditetapkan dalam PKWT, atau berakhirnya hubungan kerja bukan karena Pihak Kedua meninggal dunia atau berakhirnya jangka waktu perjanjian kerja, Pihak Kedua wajib mengajukan permohonan pengunduran diri secara tertulis selambat-lambatnya 30 (tiga puluh) hari sebelum tanggal mulai pengunduran diri dan diwajibkan membayar ganti rugi kepada Pihak Pertama sebesar upah pekerja sampai batas waktu berakhirnya jangka waktu perjanjian kerja.</td>
</tr>
<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="text-align: center"><b>PASAL 8<br>Ketentuan Lain</b></td>
</tr>
<tr>
    <td style="vertical-align: top;">1. </td>
    <td style="text-align: justify">Kerugian materil yang disebabkan oleh kelalaian Pihak Kedua akan menjadi tanggung jawab sepenuhnya dari pihak kedua untuk mengganti kerugian tersebut.</td>
</tr>
<tr>
    <td style="vertical-align: top;">2. </td>
    <td style="text-align: justify">Bila Pihak Kedua tidak lagi bekerja pada PT.Sumber Setia Budi maka segala peralatan kerja dan kelengkapan milik PT.Sumber Setia Budi (Pakaian dinas, Alat Pelindung Diri (APD) dan Kartu Lencana) diserahkan  kembali pada PT. Sumber Setia Budi tanpa ada syarat apapun. Jika segala peralatan kerja dan kelengkapan tidak diserahkan, maka Pihak Pertama berhak memotong sisa hak sesuai dengan nilai perlengkapan tersebut.</td>
</tr>
<tr>
    <td style="vertical-align: top;">3. </td>
    <td style="text-align: justify">Pihak Pertama menyatakan kepada Pihak Kedua tidak memberi janji lain, selain ketentuan yang termaksud dalam perjanjian ini.</td>
</tr>
<tr>
    <td style="vertical-align: top;">4. </td>
    <td style="text-align: justify">Hal-hal yang belum diatur dalam surat perjanjian ini akan ditentukan dilain waktu yang ditandatangani kedua belah pihak.</td>
</tr>
<tr>
    <td style="vertical-align: top;">5. </td>
    <td style="text-align: justify">Dengan berakhirnya Perjanjian kerja ini, maka berakhirlah Ikatan Kerja antara Pihak Pertama terhadap Pihak Kedua. Pihak Pertama memberikan kompensasi kepada Pihak Kedua.</td>
</tr>

<tr><td colspan="2" style="height: 20px;"></td></tr>
<tr>
    <td colspan="2" style="height: 20px; text-align: justify">Demikian Surat Perjanjian Ikatan Kerja ini kami buat dan ditandatangani diatas materai dengan tidak ada unsur paksaan atau tekanan dari masing-masing pihak atau orang lain.
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
