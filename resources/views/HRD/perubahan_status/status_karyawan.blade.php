<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
            <h4 class="card-title">Monitoring PKWT Jatuh Tempo {{ $keterangan }}</h4>
        </div>
    </div>
</div>
<div class="row">
    @if(count($list)==0)
        <div class="col-lg-12">
            <div class="alert text-white bg-secondary" role="alert">
                <div class="iq-alert-text">No matching records found !</div>
            </div>
        </div>
    @else
    <div class="col-lg-12">
        {{-- <div class="iq-card-body"> --}}
            <table class="table" style="width:100%">
                <tbody>
                    @php($nom=1)
                    @foreach ($list as $list)
                    <tr>
                        <td style="width: 10%">
                            @if(!empty($list->photo))
                            <img src="{{ url(Storage::url('hrd/photo/'.$list->photo)) }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;">
                            @else
                            <a href="{{ asset('assets/images/user/1.jpg') }}" data-fancybox data-caption="avatar">
                            <img src="{{ asset('assets/images/user/1.jpg') }}"
                                class="rounded-circle" alt="avatar" style="width: 80px; height: auto;"></a>
                            @endif
                        </td>
                        <td style="width: 40%">
                            <h4 class="mb-0">{{ $list->nm_lengkap }}</h4>
                            <h6 class="mb-0">{{(empty($list->get_jabatan->nm_jabatan)) ? "" : $list->get_jabatan->nm_jabatan }} | {{ $list->get_departemen->nm_dept }}</h6>
                        </td>
                        <td style="width: 40%">
                            <h4 class="mb-0">Status Karyawan : {{ $list->get_status_karyawan($list->id_status_karyawan) }}</h4>
                            <h6 class="mb-0">
                                PKWT Efektif Mulai : <span class="text-success">{{ date_format(date_create($list->tgl_sts_efektif_mulai), 'd-m-Y') }}</span> s/d <span class="text-danger">{{ date_format(date_create($list->tgl_sts_efektif_akhir), 'd-m-Y') }}</span></h6>
                            </h6>
                        </td>
                        <td style="width: 10%; vertical-align: middle">
                            @if(empty($list->evaluasi_kerja))
                                <button type="button" name="tbl_rubah_status" id="{{ \App\Helpers\Hrdhelper::encrypt_decrypt('encrypt', $list->id) }}" class="btn btn-primary btn-block" onClick="prosesPerubahanStatus(this);" disabled>Proses</button>
                            @else
                            <span class="badge badge-success">Telah Diajukan</span>
                            @endif
                        </td>
                    </tr>
                    @php($nom++)
                    @endforeach
                </tbody>
            </table>
        {{-- </div> --}}
    </div>
    @endif
</div>
