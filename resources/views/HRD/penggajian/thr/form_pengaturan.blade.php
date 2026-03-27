<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Form Pengaturan THR Karyawan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
</div>
<form  method="post" id="formPengaturanThrKaryawan">
{{ csrf_field() }}
<input type="hidden" name="id_karyawan" id="id_karyawan" value="{{ $profil->id }}">
<input type="hidden" name="id_departemen" id="id_departemen" value="{{ (empty($profil->id_departemen)) ? 0 : $profil->id_departemen }}">
<input type="hidden" name="periode_bulan" id="periode_bulan" value="{{ $bulan }}">
<input type="hidden" name="periode_tahun" id="periode_tahun" value="{{ $tahun }}">
<input type="hidden" name="id_head" id="id_head" value="{{ $id_head }}">
<div class="modal-body" style="height: 350px">
    <div class="iq-card-body p-0">
        <div class="iq-card">
            <div class="user-post-data p-3">
                <div class="d-flex flex-wrap">
                    <div class="media-sellers">
                        <div class="media-sellers-img">
                        @if(!empty($profil->photo))
                            <a href="{{ url(Storage::url('hrd/photo/'.$profil->photo)) }}" data-fancybox data-caption='{{ $profil->nm_lengkap }}'><img class="mr-3 rounded" src="{{ url(Storage::url('hrd/photo/'.$profil->photo)) }}" alt="profile"></a>
                        @else
                            <a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $profil->nm_lengkap }}'><img class="mr-3 rounded" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
                        @endif
                        </div>
                        <div class="media-sellers-media-info">
                            <h5 class="mb-0"><a class="text-dark" href="#">{{ $profil->nik }} - {{ $profil->nm_lengkap }}</a></h5>
                            <p class="mb-1">{{ $profil->get_jabatan->nm_jabatan }}</p>
                            <div class="sellers-dt">
                                @php if($profil->id_status_karyawan==1)
                                {
                                    $badge_thema = 'badge iq-bg-info';
                                } elseif($profil->id_status_karyawan==2) {
                                    $badge_thema = 'badge iq-bg-primary';
                                } elseif($profil->id_status_karyawan==3) {
                                    $badge_thema = 'badge iq-bg-success';
                                } elseif($profil->id_status_karyawan==7) {
                                    $badge_thema = 'badge iq-bg-warning';
                                } else {
                                    $badge_thema = 'badge iq-bg-danger';
                                }
                                @endphp
                                <span class="font-size-12">Status: <a href="#"> <span class="{{ $badge_thema }}">{{ $profil->get_status_karyawan($profil->id_status_karyawan) }}</span></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="iq-card">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <ul class="list-group">
                        <li class="list-group-item active">Pengaturan Gaji Pokok dan Tunjangan Tetap</li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="form-group row">
                                <label class="col-sm-6">Gaji Pokok</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" name="inpGapok" id="inpGapok" style="text-align: right" value="{{ $gaji_pokok }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-6">Tunjangan Tetap</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control angka" name="inpTunjTetap" id="inpTunjTetap" style="text-align: right" value="{{ $tunjangan_tetap }}">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup Form</button>
    <button type="submit" class="btn btn-primary" name="btn-submit" id="btn-submit">Simpan Data</button>
</div>
</form>
<script>
    $(document).ready(function()
    {
        // window.setTimeout(function () { $("#success-alert").alert('close'); }, 2000);
        // $('.datatable').DataTable({
        //     fixedColumns: {
        //         start: 3,
        //         // end: 1,
        //     },
        //     scrollCollapse: true,
        //     scrollX: true,
        //     autoWidth: true, // <-- add this
        //     scrollY: 300,
        //     searchDelay: 500,
        //     processing: true,
        // });
        $('#formPengaturanThrKaryawan').submit(function (e) {
            var id_dept = $("#id_departemen").val();
            var bulan = $("#periode_bulan").val();
            var tahun = $("#periode_tahun").val();
            e.preventDefault(); // Prevent default form submission
            Swal.fire({
                title: "Yakin akan menyimpan pengaturan THR karyawan ?",
                text: "Simpan data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData(document.getElementById('formPengaturanThrKaryawan'));
                    $.ajax({
                        url: "{{ url('hrd/thr_karyawan/simpanPengaturan') }}", // Update this with your route
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: formData, //$(this).serialize(),
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status==true) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ url('hrd/thr_karyawan/detailPengaturan') }}/"+id_dept+"/"+bulan+"/"+tahun;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: "It's danger!",
                                    text: response.message
                                });
                                return false;
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText); // Debugging errors
                            Swal.fire({
                                icon: 'error',
                                title: "It's danger!",
                                text: "Something went wrong! "+xhr.responseText
                            });
                        }
                    });
                } else {
                    Swal.close();
                }
            });
        });
    });
</script>
