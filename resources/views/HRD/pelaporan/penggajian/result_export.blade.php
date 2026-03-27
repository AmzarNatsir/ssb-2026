<h2>DAFTAR GAJI KARYAWAN</h2>
<p>Periode : {{ $ket_periode }}</p>
<p>Departemen : {{ $departemen }}</p>
<table>
    <thead>
        <tr>
            <td>No</td>
            <td>Karyawan</td>
            <td>Posisi</td>
            <td>Status</td>
            <td>Gaji Pokok</td>
            <td>Tunjangan Perusahaan</td>
            <td>Tunjangan Tetap</td>
            <td>Hours Meter</td>
            <td>Lembur</td>
            <td>Total Tunjangan</td>
            <td>BPJS Kesehatan</td>
            <td>JHT</td>
            <td>JP</td>
            <td>Sedekah Bulanan</td>
            <td>PKK</td>
            <td>Air</td>
            <td>Rumah</td>
            <td>PKK</td>
            <td>Total Potongan</td>
            <td>THP</td>
        </tr>
    </thead>
    <tbody>
        @php $total=0; $total_gapok=0; $total_potongan=0; $total_tunjangan=0; $nom=1; @endphp
        @foreach ($list_data as $list)
        @php
        $tot_tunj = doubleval($list->tunj_perusahaan) + doubleval($list->tunj_tetap) + doubleval($list->hours_meter) + doubleval($list->lembur);
        $tot_pot = doubleval($list->bpjsks_karyawan) + doubleval($list->bpjstk_jht_karyawan) + doubleval($list->bpjstk_jp_karyawan) + doubleval($list->pot_sedekah) + doubleval($list->pot_pkk) + doubleval($list->pot_air) + doubleval($list->pot_rumah) + doubleval($list->pot_toko_alif);
        $thp = (doubleval($list->gaji_pokok) + doubleval($tot_tunj)) - doubleval($tot_pot);
        @endphp
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $list->get_profil->nik }} - {{ $list->get_profil->nm_lengkap}}</td>
            <td>{{ (!empty($list->get_profil->id_jabatan) ? $list->get_profil->get_jabatan->nm_jabatan : "") }}</td>
            <td>
                @php
                $list_status = Config::get('constants.status_karyawan');
                foreach($list_status as $key => $value)
                {
                    if($key==$list->get_profil->id_status_karyawan)
                    {
                        $ket_status = $value;
                        break;
                    }
                }
                @endphp
                {{ $ket_status }}
            </td>
            <td>{{ $list->gaji_pokok }}</td>
            <td>{{ $list->tunj_perusahaan }}</td>
            <td>{{ $list->tunj_tetap }}</td>
            <td>{{ $list->hours_meter }}</td>
            <td>{{ $list->lembur }}</td>
            <td>{{ $tot_tunj }}</td>
            <td>{{ $list->bpjsks_karyawan }}</td>
            <td>{{ $list->bpjstk_jht_karyawan }}</td>
            <td>{{ $list->bpjstk_jp_karyawan }}</td>
            <td>{{ $list->pot_sedekah }}</td>
            <td>{{ $list->pot_pkk }}</td>
            <td>{{ $list->pot_air }}</td>
            <td>{{ $list->pot_rumah }}</td>
            <td>{{ $list->pot_toko_alif }}</td>
            <td>{{ $tot_pot }}</td>
            <td>{{ $thp }}</td>
        </tr>
        @php $nom++;
        $total_gapok+=$list->gaji_pokok;
        $total+=$thp;
        $total_tunjangan+=$tot_tunj;
        $total_potongan+=$tot_pot;
        @endphp
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_gapok }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_tunjangan }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $total_potongan }}</td>
            <td>{{ $total }}</td>
        </tr>
    </tbody>
</table>
