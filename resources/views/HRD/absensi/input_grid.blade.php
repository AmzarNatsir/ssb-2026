<form id="frm_absensi_input">
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <input type="hidden" name="id_dept" value="{{ $id_dept }}">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="font-weight-bold mb-0">Periode Tanggal : {{ date('d-m-Y', strtotime($tanggal)) }}</h6>
        <button type="button" class="btn btn-success" onClick="actSimpan();"><i class="fa fa-save mr-2"></i>Simpan</button>
    </div>
    <small class="text-muted d-block mb-2"><i class="ri-information-line"></i> Out/In Ishoma opsional &mdash; kosongkan bila tidak ada istirahat. Bila diisi, gunakan jam istirahat (rentang 11:00&ndash;14:00) agar terbaca benar.</small>

    <table class="table table-bordered table-hover tbl-input">
        <thead style="background-color:#f8f9fa;">
            <tr>
                <th style="width:4%; text-align:center;">No</th>
                <th style="width:9%;">NIK</th>
                <th style="width:9%;">NIK Lama</th>
                <th style="width:22%;">Nama</th>
                <th style="width:12%;">Jabatan</th>
                <th style="width:11%; text-align:center;">Jam IN</th>
                <th style="width:11%; text-align:center;" title="Jam keluar istirahat (11:00-14:00)">Out Ishoma</th>
                <th style="width:11%; text-align:center;" title="Jam masuk setelah istirahat (11:00-14:00)">In Ishoma</th>
                <th style="width:11%; text-align:center;">Jam OUT</th>
            </tr>
        </thead>
        <tbody>
        @php $nom=1; @endphp
        @forelse($list_karyawan as $kry)
            <tr>
                <td style="text-align:center;">{{ $nom }}</td>
                <td>{{ $kry->nik }}</td>
                <td>
                    {{ $kry->nik_lama }}
                    <input type="hidden" name="nik_lama[]" value="{{ $kry->nik_lama }}">
                </td>
                <td>{{ $kry->nm_lengkap }}</td>
                <td>{{ optional($kry->get_jabatan)->nm_jabatan }}</td>
                <td style="text-align:center;">
                    <input type="text" name="jam_in[]" value="{{ $kry->jam_in }}" class="form-control jam-input text-center" placeholder="07:30" maxlength="5" inputmode="numeric" @if(empty($kry->nik_lama)) disabled @endif>
                </td>
                <td style="text-align:center;">
                    <input type="text" name="jam_ishoma_out[]" value="{{ $kry->jam_ishoma_out }}" class="form-control jam-input text-center" placeholder="12:00" maxlength="5" inputmode="numeric" @if(empty($kry->nik_lama)) disabled @endif>
                </td>
                <td style="text-align:center;">
                    <input type="text" name="jam_ishoma_in[]" value="{{ $kry->jam_ishoma_in }}" class="form-control jam-input text-center" placeholder="13:00" maxlength="5" inputmode="numeric" @if(empty($kry->nik_lama)) disabled @endif>
                </td>
                <td style="text-align:center;">
                    <input type="text" name="jam_out[]" value="{{ $kry->jam_out }}" class="form-control jam-input text-center" placeholder="17:15" maxlength="5" inputmode="numeric" @if(empty($kry->nik_lama)) disabled @endif>
                </td>
            </tr>
        @php $nom++; @endphp
        @empty
            <tr><td colspan="9" style="text-align:center;">Data karyawan tidak ditemukan untuk departemen ini.</td></tr>
        @endforelse
        </tbody>
    </table>

    @if($list_karyawan->count() > 0)
    <div class="text-right">
        <button type="button" class="btn btn-success" onClick="actSimpan();"><i class="fa fa-save mr-2"></i>Simpan</button>
    </div>
    @endif
</form>
@php
    $ada_tanpa_niklama = $list_karyawan->whereNull('nik_lama')->count() + $list_karyawan->where('nik_lama', '')->count();
@endphp
@if($ada_tanpa_niklama > 0)
<div class="alert bg-warning text-dark mt-2">
    <i class="ri-alert-line"></i> Ada {{ $ada_tanpa_niklama }} karyawan tanpa NIK Lama (input dinonaktifkan). Lengkapi NIK Lama di master karyawan agar bisa diabsenkan.
</div>
@endif
