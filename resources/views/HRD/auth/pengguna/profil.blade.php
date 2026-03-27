@extends('HRD.layouts.master')
@section('content')
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil Pengguna</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        @if(\Session::has('konfirm'))
            <div class="alert text-white bg-success" role="alert" id="success-alert">
                <div class="iq-alert-icon">
                    <i class="ri-alert-line"></i>
                </div>
                <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="iq-card">
            <div class="iq-card-body p-0">
                <div class="iq-edit-list">
                    <ul class="iq-edit-profile d-flex nav nav-pills">
                        <li class="col-md-6 p-0">
                            <a class="nav-link active" data-toggle="pill" href="#personal-information">
                            Personal Information
                            </a>
                        </li>
                        <li class="col-md-6 p-0">
                            <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                            Change Password
                            </a>
                        </li>
                        {{-- <li class="col-md-4 p-0">
                            <a class="nav-link" data-toggle="pill" href="#absensi">
                            Absensi
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                <div class="iq-card">
                    {{-- <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Data Diri</h4>
                        </div>
                    </div> --}}
                    <div class="iq-card-body">
                        <div class="row">
                            <div class="col-lg-8 profile-left">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-body p-0">
                                        <div class="user-post-data p-3">
                                            <div class="d-flex flex-wrap">
                                                <div class="media-support-user-img mr-3">
                                                    @if(empty(auth()->user()->karyawan->photo))
                                                    <img src="{{ asset('assets/images/no-image.png') }}" alt="profile-img" class="rounded-circle img-fluid" />
                                                    @else
                                                    <img src="{{ url(Storage::url('hrd/photo/' . auth()->user()->karyawan->photo)) }}" alt="profile-img" class="rounded-circle img-fluid" />
                                                    @endif
                                                </div>
                                                <div class="media-support-info mt-2">
                                                    <h5 class="mb-0"><a href="#" class="">{{ auth()->user()->karyawan->nm_lengkap }}</a></h5>
                                                    <p class="mb-0 text-primary">{{ auth()->user()->karyawan->nik }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="comment-area p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <table class="table" style="width: 100%;">
                                                    <tr>
                                                        <td colspan="3" style="background-color: rgb(9, 128, 247); color:white"><b>Data Diri</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 28%;">Alamat</td>
                                                        <td style="width: 2%;">:</td>
                                                        <td style="width: 70%;">{{ auth()->user()->karyawan->alamat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Telepon</td>
                                                        <td>:</td>
                                                        <td>{{ auth()->user()->karyawan->notelp }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" style="background-color: rgb(9, 128, 247); color:white"><b>Posisi</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->id_jabatan)) ? auth()->user()->karyawan->get_jabatan->nm_jabatan : "" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sub Departemen</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->id_subdepartemen)) ? auth()->user()->karyawan->get_subdepartemen->nm_subdept : "" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Departemen</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->id_departemen)) ? auth()->user()->karyawan->get_departemen->nm_dept : "" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Divisi</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->id_divisi)) ? auth()->user()->karyawan->get_divisi->nm_divisi : "" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bergabung Tanggal</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->tgl_masuk)) ? date_format(date_create(auth()->user()->karyawan->tgl_masuk), 'd-m-Y') : "Tanpa Keterangan" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lama Bekerja</td>
                                                        <td>:</td>
                                                        <td>{{ (!empty(auth()->user()->karyawan->tgl_masuk)) ? App\Helpers\Hrdhelper::get_lama_kerja_karyawan(auth()->user()->karyawan->tgl_masuk) : "Tanpa Keterangan" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Karyawan</td>
                                                        <td>:</td>
                                                        <td>@php
                                                            $ket_status="";
                                                            $list_status = Config::get('constants.status_karyawan');
                                                            foreach($list_status as $key => $value)
                                                            {
                                                                if($key==auth()->user()->karyawan->id_status_karyawan)
                                                                {
                                                                    $ket_status = $value;
                                                                    break;
                                                                }
                                                            }
                                                            @endphp
                                                            {{ $ket_status }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 profile-right">
                                <div class="iq-card iq-card-block iq-card-stretch">
                                    <div class="iq-card-header d-flex justify-content-between">
                                       <div class="iq-header-title">
                                          <h4 class="card-title">Atasan Langsung</h4>
                                       </div>
                                    </div>
                                    <div class="iq-card-body">
                                        @php
                                        $id_jabatan_al = (empty(auth()->user()->karyawan->get_jabatan->id_gakom)) ? "" : auth()->user()->karyawan->get_jabatan->id_gakom;
                                        $nama_atl = (empty(auth()->user()->karyawan->get_nama_atasan_langsung($id_jabatan_al)->id)) ? "" : auth()->user()->karyawan->get_nama_atasan_langsung($id_jabatan_al)->nm_lengkap;
                                        $photo_atl = (empty(auth()->user()->karyawan->get_nama_atasan_langsung($id_jabatan_al)->id)) ? : auth()->user()->karyawan->get_nama_atasan_langsung( $id_jabatan_al)->photo
                                        @endphp
                                        @if(!empty($id_jabatan_al))
                                            @if(!empty(auth()->user()->karyawan->get_nama_atasan_langsung($id_jabatan_al)->id))
                                                <ul class="media-story m-0 p-0">
                                                    <li class="d-flex mb-4 align-items-center active">
                                                        @if(empty($photo_atl))
                                                            <img src="{{ asset('assets/images/no-image.png') }}" alt="profile-img" class="rounded-circle img-fluid" style="width: 50px; height: auto;" />
                                                        @else
                                                            <img src="{{ url(Storage::url('hrd/photo/' . auth()->user()->karyawan->get_nama_atasan_langsung(auth()->user()->karyawan->get_jabatan->id_gakom)->photo)) }}" alt="profile-img" class="rounded-circle img-fluid" style="width: 50px; height: auto;" />
                                                        @endif
                                                    <div class="stories-data ml-3">
                                                        <h5>{{ $nama_atl }}</h5>
                                                        <p class="mb-0">{{ (!empty($id_jabatan_al)) ? auth()->user()->karyawan->get_jabatan->get_id_gakom($id_jabatan_al)->nm_jabatan : "" }}</p>
                                                    </div>
                                                    </li>
                                                </ul>
                                            @else
                                                <div class="text-center">Kosong/Belum Diatur</div>
                                            @endif
                                        @else
                                            <div class="text-center">Kosong/Belum Diatur</div>
                                        @endif
                                    </div>
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">Atasan Tidak Langsung</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        @php
                                        $id_jabatan_atl = (empty(auth()->user()->karyawan->get_jabatan->id_gakom)) ? "" : auth()->user()->karyawan->get_jabatan->get_id_gakom(auth()->user()->karyawan->get_jabatan->id_gakom)->id_gakom;
                                        $nama_atl = (empty(auth()->user()->karyawan->get_nama_atasan_tidak_langsung($id_jabatan_atl)->id)) ? "" : auth()->user()->karyawan->get_nama_atasan_tidak_langsung($id_jabatan_atl)->nm_lengkap;
                                        $photo_atl = (empty(auth()->user()->karyawan->get_nama_atasan_tidak_langsung($id_jabatan_atl)->id)) ? : auth()->user()->karyawan->get_nama_atasan_tidak_langsung( $id_jabatan_atl)->photo
                                        @endphp
                                        @if(!empty($id_jabatan_atl))
                                            @if(!empty(auth()->user()->karyawan->get_nama_atasan_tidak_langsung($id_jabatan_atl)->id))
                                            <ul class="media-story m-0 p-0">
                                                <li class="d-flex mb-4 align-items-center active">
                                                    @if(!empty($id_jabatan_atl))
                                                        @if(empty($photo_atl))
                                                            <img src="{{ asset('assets/images/no-image.png') }}" alt="profile-img" class="rounded-circle img-fluid" style="width: 50px; height: auto;" />
                                                        @else
                                                            <img src="{{ url(Storage::url('hrd/photo/' . $photo_atl)) }}" alt="profile-img" class="rounded-circle img-fluid" style="width: 50px; height: auto;" />
                                                        @endif
                                                    @endif
                                                    <div class="stories-data ml-3">
                                                        <h5>{{ $nama_atl }}</h5>
                                                        <p class="mb-0">{{ (!empty($id_jabatan_atl)) ? auth()->user()->karyawan->get_jabatan->get_id_gakom($id_jabatan_atl)->nm_jabatan : "" }}</p>
                                                    </div>
                                                </li>
                                            </ul>

                                            @else
                                            <div class="text-center">Kosong/Belum Diatur</div>
                                            @endif
                                        @else
                                        <div class="text-center">Kosong/Belum Diatur</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Change Password</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form action="{{ url('hrd/profil_user_update') }}" method="POST" onsubmit="return konfirm()">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group row align-items-center">
                                <label class="col-md-2" for="npass">New Password</label>
                                <div class="col-md-4">
                                    <input type="Password" class="form-control" id="npassnew" name="npassnew" required>
                                </div>
                                <label class="col-md-2" for="vpass">Verify Password</label>
                                <div class="col-md-4">
                                    <input type="Password" class="form-control" id="vpassnew" name="vpassnew" required>
                                </div>
                            </div>
                            <div class="alert_box"></div>
                            <hr>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="absensi" role="tabpanel">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Absensi</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div id='calendarUser'></div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function()
    {
        window.setTimeout(function () {
            $("#success-alert").alert('close');
            $("#danger-alert").alert('close');
        }, 2000);

        // var Calendar = FullCalendar.Calendar;
        // var calndarE1 = document.getElementById('calendarUser');
        // var calendar = new Calendar(calndarE1, {
        //     plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
        //     header    : {
        //         left  : 'prev,next today',
        //         center: 'title',
        //         right : 'dayGridMonth'
        //         },
        //         editable  : false,
        //         droppable : true, // this allows things to be dropped onto the calendar !!!
        //         displayEventTime : false

        // });
        // calendar.render();
    });

    function konfirm()
    {
        var psn = confirm("Yakin akan menyimpan data ?");
        var newpswd = $("#npassnew").val();
        var newpswdverify = $("#vpassnew").val();
        if(psn==true)
        {
            if(newpswdverify!=newpswd)
            {
                $(".alert_box").html(`<div class="alert text-white bg-danger" role="alert" id="danger-alert">
                                <div class="iq-alert-icon">
                                    <i class="ri-alert-line"></i>
                                </div>
                                <div class="iq-alert-text">Verify Password is Not Valid !!</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                `);
                return false;
            } else {
                return true
            }
        } else {
            return false;
        }
    }
</script>
@endsection
