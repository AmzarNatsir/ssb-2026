<style>
    .collapsible-link {
        width: 100%;
        position: relative;
        text-align: left;
        }

    .collapsible-link::before {
        content: "\f107";
        position: absolute;
        top: 50%;
        right: 0.8rem;
        transform: translateY(-50%);
        display: block;
        font-family: "FontAwesome";
        font-size: 1.1rem;
    }

    .collapsible-link[aria-expanded="true"]::before {
        content: "\f106";
    }

    .datatable2 th:nth-child(2),
    .datatable2 td:nth-child(2) {
        position: sticky;
        left: 0;
        background: white;
        z-index: 2;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Penggajian Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/persetujuan/storeApproval') }}" method="post" onsubmit="return konfirm()">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $data_approval->id }}">
<input type="hidden" name="key_approval" value="{{ $data_approval->approval_key }}">
<input type="hidden" name="level_approval" value="{{ $data_approval->approval_level }}">
<input type="hidden" name="date_approval" value="{{ $data_approval->approval_date }}">
<input type="hidden" name="group_approval" value="{{ $data_approval->approval_group }}">
<input type="hidden" name="status_approval" value="{{ $profil->status_pengajuan }}">
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $profil->bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $profil->tahun }}">
<input type="hidden" name="departemen" id="departemen" value="">
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="iq-card">
                <div class="iq-card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="todo-date d-flex mr-3">
                        <i class="ri-calendar-2-line text-success mr-2"></i>
                        <span>Daftar Gaji Karyawan - Periode Penggajian {{ \App\Helpers\Hrdhelper::get_nama_bulan($profil->bulan) }} {{$profil->tahun }}</span>
                        </div>
                    </div>
                    <div id="accordionExample" class="accordion shadow">
                        <div class="card mb-1">
                            <div id="headingOne" class="card-header shadow-sm border-0" style="background-color: #dcdcdc">
                                <h2 class="mb-0">
                                    <button type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne"
                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">Non Departemen</button>
                                </h2>
                            </div>
                            <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample" class="collapse">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="user-list-table-1" class="table-hover table-striped table-bordered datatable2" cellpadding="4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 14px">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 3%; ">No</th>
                                                    <th style="text-align: center;">Karyawan</th>
                                                    <th style="text-align: center;">Posisi</th>
                                                    <th style="text-align: center; width: 10%">Gaji&nbsp;Pokok</th>
                                                    <th style="text-align: center;">Total&nbsp;Tunjangan</th>
                                                    <th style="text-align: center;">Gaji&nbsp;Bruto</th>
                                                    <th style="text-align: center;">Total&nbsp;Potongan</th>
                                                    <th style="text-align: center;">Tunjangan&nbsp;BPJS</th>
                                                    <th style="text-align: center; width: 8%">THP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $nom_non_dept = 1; @endphp
                                                @foreach ($data_non_dept as $r1)
                                                @php
                                                $gapok = $r1['list_data']['gaji_pokok'] ?? 0;
                                                $pot_bpjs_ks = $r1['list_data']['bpjsks_karyawan'] ?? 0;
                                                $pot_jht = $r1['list_data']['bpjstk_jht_karyawan'] ?? 0;
                                                $pot_jp = $r1['list_data']['bpjstk_jp_karyawan'] ?? 0;
                                                $pot_jkm = $r1['list_data']['bpjstk_jkm_karyawan'] ?? 0;
                                                $pot_sedekah = $r1['list_data']['pot_sedekah'] ?? 0;
                                                $pot_pkk = $r1['list_data']['pot_pkk'] ?? 0;
                                                $pot_air = $r1['list_data']['pot_air'] ?? 0;
                                                $pot_rumah = $r1['list_data']['pot_rumah'] ?? 0;
                                                $pot_toko_alif = $r1['list_data']['pot_toko_alif'] ?? 0;
                                                $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                                                //tunjangan
                                                $tunj_perusahaan = $r1['list_data']['tunj_perusahaan'] ?? 0;
                                                $total_tunj_perusahaan_bpjs = $r1['list_data']['pot_tunj_perusahaan'] ?? 0;
                                                $gaji_bruto = $gapok + $tunj_perusahaan;
                                                //thp
                                                $thp = $gaji_bruto - $total_tunj_perusahaan_bpjs  - $tot_potongan;

                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $nom_non_dept++ }}</td>
                                                    <td>{{ $r1['nik'] }} - {{ $r1['nm_lengkap'] }}</td>
                                                    <td><b>{{ $r1['get_jabatan']['nm_jabatan'] }}</b></td>
                                                    <td style="text-align: right">{{ number_format($r1['list_data']['gaji_pokok'], 0) }}</td>
                                                    <td style="text-align: right">{{ number_format($tunj_perusahaan, 0) }}</td>
                                                    <td style="text-align: right">{{ number_format($gaji_bruto, 0) }}</td>
                                                    <td style="text-align: right">{{ number_format($tot_potongan, 0) }}</td>
                                                    <td style="text-align: right">{{ number_format($total_tunj_perusahaan_bpjs, 0) }}</td>
                                                    <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($data_dept as $r)
                        <div class="card mb-1">
                            <div id="heading{{ $r['id'] }}" class="card-header shadow-sm border-0" style="background-color: #dcdcdc">
                                <h2 class="mb-0">
                                <button type="button" data-toggle="collapse" data-target="#collapse{{ $r['id'] }}" aria-expanded="true"
                                    aria-controls="collapse{{ $r['id'] }}"
                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">{{ $r['nm_dept'] }}</button>
                                </h2>
                            </div>
                            <div id="collapse{{ $r['id'] }}" aria-labelledby="heading{{ $r['id'] }}" data-parent="#accordionExample" class="collapse">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <table id="user-list-table-{{ $r['id'] }}" class="table-hover table-striped table-bordered datatable2" cellpadding="4" role="grid" aria-describedby="user-list-page-info" style="width: 100%; font-size: 14px">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 3%; ">No</th>
                                                <th style="text-align: center;">Karyawan</th>
                                                <th style="text-align: center;">Posisi</th>
                                                <th style="text-align: center; width: 10%">Gaji&nbsp;Pokok</th>
                                                <th style="text-align: center;">Total&nbsp;Tunjangan</th>
                                                <th style="text-align: center;">Gaji&nbsp;Bruto</th>
                                                <th style="text-align: center;">Total&nbsp;Potongan</th>
                                                <th style="text-align: center;">Tunjangan&nbsp;BPJS</th>
                                                <th style="text-align: center; width: 8%">THP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $nom_dept = 1; @endphp
                                            @foreach ($r['list_data'] as $r2)
                                            @php
                                            $gapok = $r2['gaji_pokok'] ?? 0;
                                            $pot_bpjs_ks = $r2['bpjsks_karyawan'] ?? 0;
                                            $pot_jht = $r2['bpjstk_jht_karyawan'] ?? 0;
                                            $pot_jp = $r2['bpjstk_jp_karyawan'] ?? 0;
                                            $pot_jkm = $r2['bpjstk_jkm_karyawan'] ?? 0;
                                            $pot_sedekah = $r2['pot_sedekah'] ?? 0;
                                            $pot_pkk = $r2['pot_pkk'] ?? 0;
                                            $pot_air = $r2['pot_air'] ?? 0;
                                            $pot_rumah = $r2['pot_rumah'] ?? 0;
                                            $pot_toko_alif = $r2['pot_toko_alif'] ?? 0;
                                            $tot_potongan = $pot_bpjs_ks + $pot_jht + $pot_jp + $pot_jkm + $pot_sedekah + $pot_pkk + $pot_air + $pot_rumah + $pot_toko_alif;
                                            //tunjangan
                                            $tunj_perusahaan = $r2['tunj_perusahaan'] ?? 0;
                                            $total_tunj_perusahaan_bpjs = $r2['pot_tunj_perusahaan'] ?? 0;
                                            $gaji_bruto = $gapok + $tunj_perusahaan;
                                            //thp
                                            $thp = $gaji_bruto - $total_tunj_perusahaan_bpjs  - $tot_potongan;

                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $nom_dept++ }}</td>
                                                <td>{{ $r2['nik'] }} - {{ $r2['nm_lengkap'] }}</td>
                                                <td><b>{{ $r2['jabatan'] }}</b></td>
                                                <td style="text-align: right">{{ number_format($r2['gaji_pokok'], 0) }}</td>
                                                <td style="text-align: right">{{ number_format($tunj_perusahaan, 0) }}</td>
                                                <td style="text-align: right">{{ number_format($gaji_bruto, 0) }}</td>
                                                <td style="text-align: right">{{ number_format($tot_potongan, 0) }}</td>
                                                <td style="text-align: right">{{ number_format($total_tunj_perusahaan_bpjs, 0) }}</td>
                                                <td style="text-align: right"><b>{{ number_format($thp, 0) }}</b></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{-- <div class="d-flex justify-content-between align-items-center mt-5">
                        <div class="todo-date d-flex mr-3">
                            <i class="ri-table-line text-success mr-2"></i>
                            <span>Resume Penggajian</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-hover table-striped table-bordered" cellpadding="4" style="width: 100%">
                                <tr>
                                    <td>Non Departemen</td>
                                    <td style="width: 20%; text-align: right">Rp. {{ number_format($resumeNonDepartemen, 0) }}</td>
                                </tr>
                                @php $total_thp=0; @endphp
                                @foreach ($resumeDepartemen as $r3)
                                <tr>
                                    <td>{{ $r3['nm_dept'] }}</td>
                                    <td style="width: 20%; text-align: right">Rp. {{ number_format($r3['total'], 0) }}</td>
                                </tr>
                                @php $total_thp+=$r3['total'] + $resumeNonDepartemen; @endphp
                                @endforeach
                                <tr>
                                    <td><b>Total</b></td>
                                    <td style="text-align: right"><b>Rp. {{ number_format($total_thp, 0) }}</b></td>
                                </tr>
                            </table>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Hirarki Persetujuan</li>
                    </ul>
                    <div class="row align-items-center">
                        <table class="table" style="width: 100%; font-size: 10px">
                            <thead>
                            <tr>
                                <th rowspan="2" style="width: 5%">Level</th>
                                <th rowspan="2">Pejabat</th>
                                <th colspan="3" class="text-center">Persetujuan</th>
                            </tr>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($hirarki_persetujuan as $list)
                                <tr>
                                    <td class="text-center">
                                        @if($list->approval_active==1)
                                        <h4><span class="badge badge-pill badge-success">{{ $list->approval_level }}</span></h4>
                                        @else
                                        <h4><span class="badge badge-pill badge-danger">{{ $list->approval_level }}</span></h4>
                                        @endif
                                    </td>
                                    <td>{{ $list->get_profil_employee->nm_lengkap }}<br>
                                        {{ $list->get_profil_employee->get_jabatan->nm_jabatan }}</td>
                                    <td>
                                        {{ (empty($list->approval_date)) ? "" : date('d-m-Y', strtotime($list->approval_date))  }}
                                    </td>
                                    <td>{{ $list->approval_remark }}</td>
                                    <td>
                                        @if($list->approval_status==1)
                                        <h4><span class="badge badge-pill badge-success">Approved</span></h4>
                                        @elseif($list->approval_status==2)
                                        <h4><span class="badge badge-pill badge-danger">Rejected</span></h4>
                                        @else

                                        @endif
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    <ul class="list-group" style="margin-bottom: 15px">
                        <li class="list-group-item active">Form Persetujuan</li>
                    </ul>
                    <div class=" row align-items-center">
                        <label class="col-sm-4">Status Persetujuan</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="pil_persetujuan" name="pil_persetujuan" style="width: 100%;" required>
                                <option value="1">Setuju</option>
                                <option value="2">Tolak</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class=" row align-items-center">
                        <div class="form-group col-sm-12">
                            <label>Deskripsi Persetujuan</label>
                            <textarea class="form-control" name="inp_keterangan" id="inp_keterangan" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        // $('.datatable2').DataTable({
        //     fixedColumns: {
        //         start: 3,
        //         // end: 1,
        //     },
        //     scrollCollapse: true,
        //     scrollX: true,
        //     autoWidth: true,
        //     scrollY: 300,
        //     searchDelay: 500,
        //     // deferRender: true
        //     // processing: true,
        // });
    });
    function konfirm()
    {
        var psn = confirm("Yakin data akan disimpan ?");
        if(psn==true)
        {
            return true;
        } else {
            return false;
        }
    }
</script>
