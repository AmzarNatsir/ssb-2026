<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Persetujuan Pengajuan Pelatihan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/persetujuan/storeApproval') }}" method="post" id="myForm">
{{ csrf_field() }}
<input type="hidden" name="id_pengajuan" value="{{ $data_approval->id }}">
<input type="hidden" name="key_approval" value="{{ $data_approval->approval_key }}">
<input type="hidden" name="level_approval" value="{{ $data_approval->approval_level }}">
<input type="hidden" name="date_approval" value="{{ $data_approval->approval_date }}">
<input type="hidden" name="group_approval" value="{{ $data_approval->approval_group }}">
<input type="hidden" name="status_approval" value="{{ $profil->status_pengajuan }}">
<div class="modal-body">

    <div class="row">
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">Pengajuan Pelatihan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <ul class="list-group">
                       <li class="list-group-item disabled" aria-disabled="true">Periode Tahun : {{ $profil->tahun }}</li>
                       <li class="list-group-item">Deskripsi : {{ $profil->deskripsi }}</li>
                    </ul>
                </div>
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                       <h4 class="card-title">List Pelatihan</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        @foreach ($profil->get_detail as $list)
                        @php
                            $nama_pelatihan = ($list->getPelatihan->kategori=='Internal') ? $list->getPelatihan->get_nama_pelatihan->nama_pelatihan : $list->getPelatihan->nama_pelatihan;
                            $nama_vendor = ($list->getPelatihan->kategori=='Internal') ? $list->getPelatihan->get_pelaksana->nama_lembaga : $list->getPelatihan->nama_vendor;

                        @endphp
                        <div class="iq-email-listbox">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="mail-inbox" role="tabpanel">
                                    <ul class="iq-email-sender-list">
                                        <li class="iq-unread">
                                            <div class="d-flex align-self-center">
                                               <div class="iq-email-sender-info">
                                                <table class="table mb-0 table-striped" style="width: 100%">
                                                    <tr>
                                                        <td><a href="javascript: void(0);" class="iq-email-title">{{ $nama_pelatihan }}</a></td>
                                                    </tr>
                                                </table>
                                               </div>
                                            </div>
                                        </li>
                                        <div class="email-app-details">
                                            <div class="iq-card">
                                               <div class="iq-card-body p-0">
                                                  <div class="">
                                                     <div class="iq-email-to-list p-3">
                                                        <div class="d-flex justify-content-between">
                                                           <ul>
                                                              <li class="mr-3">
                                                                 <a href="javascript: void(0);">
                                                                    <h4 class="m-0"><i class="ri-arrow-left-line"></i></h4>
                                                                 </a>
                                                              </li>
                                                           </ul>
                                                           <div class="iq-email-search d-flex">
                                                              <ul>
                                                                 <li class="mr-3">
                                                                    Detail Pelatihan
                                                                 </li>
                                                              </ul>
                                                           </div>
                                                        </div>
                                                     </div>
                                                     <hr class="mt-0">
                                                     <div class="iq-inbox-subject p-3">
                                                        <h5 class="mt-0">{{ $nama_pelatihan }}</h5>
                                                        <div class="iq-inbox-subject-info">
                                                           <div class="iq-subject-info">
                                                              <div class="iq-subject-status align-self-center">
                                                                    @if($list->getPelatihan->kategori=="Internal")
                                                                    <h4 class="mb-0 badge badge-success">Kategori : {{ $list->getPelatihan->kategori }}</h4>
                                                                    @else
                                                                    <h4 class="mb-0 badge badge-dark">Kategori : {{ $list->getPelatihan->kategori }}</h4>
                                                                    @endif
                                                                    <h6 class="mb-0"><i class="fa fa-clock-o"></i> Durasi : {{  $list->getPelatihan->durasi }}</h6>
                                                                    <h6 class="mb-0"><i class="fa fa-money"></i> Biaya/Investasi : Rp. {{ number_format($list->getPelatihan->investasi_per_orang, 0, ",", ".") }}</h6>
                                                                    @if(!empty($list->getPelatihan->departemen_by))
                                                                    <h6 class="mb-0">Diajukan Oleh : {{ $list->getPelatihan->get_departemen->nm_dept }}</h6>
                                                                    @endif
                                                                    <h6 class="mb-0"><i class="fa fa-calendar"></i> @if($list->getPelatihan->tanggal_awal==$list->getPelatihan->hari_sampai)
                                                                        {{ App\Helpers\Hrdhelper::get_hari($list->getPelatihan->tanggal_awal) }}
                                                                        @else
                                                                        {{ App\Helpers\Hrdhelper::get_hari_ini($list->getPelatihan->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($list->getPelatihan->tanggal_sampai) }}
                                                                        @endif, {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($list->getPelatihan->tanggal_awal, $list->getPelatihan->tanggal_sampai, $list->getPelatihan->hari_awal, $list->getPelatihan->hari_sampai) }}</h6>
                                                              </div>
                                                           </div>
                                                           <div class="iq-inbox-body mt-5">
                                                              <p>Kompetensi Pelatihan :</p>
                                                              <p>{{ $list->getPelatihan->kompetensi }}</p>
                                                           </div>
                                                           <hr>
                                                           <div class="attegement">
                                                              <h6 class="mb-2">PESERTA:</h6>

                                                              <ul class="suggestions-lists m-0 p-0">
                                                                @php $nom=1 @endphp
                                                                {{-- {{ dd($list->getPelatihan->get_peserta) }} --}}
                                                                @foreach ($list->getPelatihan->get_peserta as $peserta)
                                                                <li class="d-flex mb-4 align-items-center">
                                                                    <div class="user-img img-fluid">
                                                                        @if(!empty($peserta->get_karyawan->photo))
            <a href="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" alt="profile"></a>
            @else
            <a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
            @endif
                                                                    </div>
                                                                    <div class="media-support-info ml-3">
                                                                        <h6>{{ $peserta->get_karyawan->nm_lengkap }}</h6>
                                                                        <p>{{ (blank($peserta->get_karyawan->id_departemen)) ? "" : $peserta->get_karyawan->get_departemen->nm_dept }} - {{ (blank($peserta->get_karyawan->id_jabatan)) ? "" : $peserta->get_karyawan->get_jabatan->nm_jabatan }}</p>
                                                                    </div>
                                                                 </li>
                                                                 @php $nom++ @endphp
                                                                @endforeach
                                                              </ul>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach
                     </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-6">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-body">
                    {{-- <ul class="list-group" style="margin-bottom: 15px">
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
                    </div> --}}
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
    });
    document.querySelector('#myForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        Swal.fire({
            title: 'Are you sure?',
            text: "Submit this application!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, submit the form
                this.submit();
            }
        });
    });
</script>
