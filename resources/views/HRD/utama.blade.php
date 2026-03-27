@extends('HRD.layouts.master')

@section('content')
<style>
    .container {
  background-color: #fdfdfd;
  height: 100%;
  width: 100%;
  border-radius: 6px;
  box-shadow: 0 4px 28px rgba(123,151,158,.25);
  border: 1px solid #d6dee1;
  padding: 1rem;
  overflow: scroll;
}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course d-flex align-items-center justify-content-between">
                    <div class="left-block">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/images/page-img/29.png') }}" class="img-fluid">
                        <div class=" ml-3">
                            <h4 class="">Welcome <b>{{ auth()->user()->karyawan->nm_lengkap }}</b><br> to Smart System Base - Human Resource Departemen</h4>
                            <p class="mb-0">PT SUMBER SETIA BUDI - POMALA - KOLAKA</p>
                        </div>
                    </div>
                    </div>
                    <div class="right-block position-relativ">
                        <img src="{{ asset('assets/images/page-img/34.png') }}" class="img-fluid image-absulute image-absulute-1">
                        <img src="{{ asset('assets/images/page-img/35.png') }}" class="img-fluid image-absulute image-absulute-2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-notification-2-line"></i> Memo Internal</h4>
                </div>
            </div>
            <div class="iq-card-body">
                @if(!empty($list_memo))
                @foreach($list_memo as $memo)
                <div class="media mb-4">
                    <a href="{{ url(Storage::url('memo_internal/'.$memo->file_memo)) }}" data-fancybox data-caption='Prview'><img src="{{ url(Storage::url('memo_internal/'.$memo->file_memo)) }}" style="width: 100px;" class="align-self-start mr-3" alt="#"></a>
                    <div class="media-body">
                        <h5 class="mt-0">{{ $memo->judul }}</h5>
                        <div class="twit-date" style="color: blue;"><b>{{ date_format(date_create($memo->tgl_post), 'd') }} {{ \App\Helpers\Hrdhelper::get_nama_bulan(date_format(date_create($memo->tgl_post), 'm')) }} {{ date_format(date_create($memo->tgl_post), 'Y') }}</b></div>
                        <p>{{ $memo->deskripsi }}</p>
                        <div class="row align-items-center justify-content-between mt-3">
                            <div class="col-sm-6">
                                <p class="mb-0">Diterbitkan oleh </p>
                                <h6>Departemen : {{ (empty($memo->get_departemen->nm_dept)) ? "" : $memo->get_departemen->nm_dept }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-calendar-2-line"></i> Agenda Pelatihan Tahun {{ date("Y") }}</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-md-between">
                        <div>
                            <div class="btn-group ml-2 bg-white" role="group" aria-label="Basic example">
                                {{-- <button type="button" class="btn btn-outline-success active px-5" onclick="goToday(this)" value="1">Hari Ini</button>
                                <button type="button" class="btn btn-outline-dark active px-5" onclick="goThisMonth(this)" value="2">Bulan Ini</button>
                                <button type="button" class="btn btn-outline-warning active px-5" onclick="goThisYear(this)" value="3">Tahun Ini</button> --}}

                                @php
                                $bln_now=date('m');
                                @endphp
                                @for($i=$bln_now; $i<=12; $i++)
                                    @if($i==$bln_now)
                                    <button type="button" class="btn btn-outline-success active px-2" onclick="goThisMonth(this)" value="{{ $i }}">{{ \App\Helpers\Hrdhelper::get_nama_bulan($i) }}</button>
                                    @else
                                    <button type="button" class="btn btn-outline-primary px-2" onclick="goThisMonth(this)" value="{{ $i }}">{{ \App\Helpers\Hrdhelper::get_nama_bulan($i) }}</button>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive showPage">
                    <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                    <table class="table table-striped table-bordered" style="width: 100%">
                        <thead class="thead-light">
                            <th style="width: 5%">No</th>
                            <th>Pelatihan</th>
                            <th style="width: 30%">Tanggal</th>
                            <th style="width: 15%">Durasi</th>
                        </thead>
                        <tbody>
                            @php $nom=1 @endphp
                            @foreach($hari_ini_pelatihan as $key => $item)
                            @php
                            $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                            $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
                            @endphp
                            <tr>
                                <td>{{ $nom }}</td>
                                <td>{{ $nama_pelatihan }}</td>
                                <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
                                <td>{{ $item->durasi }}</td>
                            </tr>
                            @php $nom++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <div class="tab-content">
                       <div class="tab-pane fade show active" id="mail-inbox" role="tabpanel">
                            @foreach ($hari_ini_pelatihan as $key => $item)
                            @php
                            $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
                            $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
                            @endphp
                            <ul class="iq-email-sender-list">
                                <li class="iq-unread">
                                <div class="d-flex align-self-center">
                                    <div class="iq-email-sender-info">
                                        <div class="iq-checkbox-mail">
                                            <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="mailk" checked disabled>
                                            <label class="custom-control-label" for="mailk"></label>
                                            </div>
                                        </div>
                                        <a href="javascript: void(0);" class="iq-email-title">{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</a>
                                    </div>
                                    <div class="iq-email-content">
                                        <a href="javascript: void(0);" class="iq-email-subject">{{ $nama_pelatihan }}</a>
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
                                                          <li class="mr-3"><a href="javascript: void(0);"><h4 class="m-0"><i class="ri-arrow-left-line"></i></h4></a></li>
                                                       </ul>
                                                       <div class="iq-email-search d-flex">
                                                          <ul><li class="mr-3"><a class="font-size-14" href="#">Detail</a></li></ul>
                                                       </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-0">
                                                <div class="iq-inbox-subject p-3">
                                                    <h5 class="mt-0">{{ $nama_pelatihan }}</h5>
                                                    <div class="iq-inbox-subject-info">
                                                       <div class="iq-subject-info">
                                                          <div class="iq-subject-status align-self-center">
                                                                <h6 class="mb-0">Kategori : {{ $item->kategori }}</h6>
                                                                <h6 class="mb-0">Durasi : {{  $item->durasi }}</h6>
                                                                <h6 class="mb-0">Biaya/Investasi : Rp. {{ number_format($item->investasi_per_orang, 0, ",", ".") }}</h6>
                                                          </div>
                                                          <span class="float-right align-self-center">@if($item->tanggal_awal==$item->hari_sampai)
                                                            {{ App\Helpers\Hrdhelper::get_hari($item->tanggal_awal) }}
                                                            @else
                                                            {{ App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_sampai) }}
                                                            @endif, {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, $item->hari_awal, $item->hari_sampai) }}</span>
                                                       </div>
                                                       <div class="iq-inbox-body mt-5">
                                                          <p>Kompetensi Pelatihan :</p>
                                                          <p>{{ $item->kompetensi }}</p>
                                                       </div>
                                                       <hr>
                                                       <h6 class="mb-2">PESERTA:</h6>
                                                        <div class="attegement container" style="width:100%; height:200px">
                                                          <ul class="suggestions-lists m-0 p-0">
                                                            @php $nom=1 @endphp
                                                            @foreach ($item->get_peserta as $peserta)
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
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-calendar-2-line"></i> Kalender</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="row row-eq-height">
                    <div class="col-md-12">
                        <div id='calendar_1'></div>
                        <ul class="m-2 p-2 job-classification">
                            @if(count($list_hari_libur)<=0)
                            <li class=""><i class="ri-check-line bg-danger"></i>Tidak Ada Hari Libur</li>
                            @else
                                @foreach($list_hari_libur as $libur)
                                <li class=""><i class="ri-check-line bg-danger"></i>{{ date_format(date_create($libur->tanggal), 'd') }} - {{ $libur->keterangan}}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#spinner-div').hide();
        $(function () {
            var calendarEl = document.getElementById('calendar_1');
            var Calendar = FullCalendar.Calendar;

            var calendar = new Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                initialDate: new Date(),
                headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
                },
                editable: false,
                droppable: true,
                displayEventTime: false,
                // events: [
                //     {
                //         title: 'Hadir',
                //         start: '2025-06-10',
                //         backgroundColor: '#28a745',
                //         display: 'background',
                //     },
                //     {
                //         title: 'Izin',
                //         start: '2025-07-02',
                //         backgroundColor: '#ffc107',
                //         display: 'background'
                //     },
                //     {
                //         title: 'Alpha',
                //         start: '2025-07-03',
                //         backgroundColor: '#dc3545',
                //         display: 'background'
                //     },
                //     {
                //         title: 'Libur',
                //         start: '2025-07-06',
                //         backgroundColor: '#6c757d',
                //         display: 'background'
                //     }
                // ]
            });
        calendar.render();
        });
    });
    var goToday = function(el)
    {
        var filter = $(el).val()
        $(".showPage").load("{{ url('hrd/home/getPelatihan') }}/"+filter, function(){
            jQuery('ul.iq-email-sender-list li').click(function() {
                jQuery(this).next().addClass('show');
            });
            jQuery('.email-app-details li h4').click(function() {
                jQuery('.email-app-details').removeClass('show');
            });
        });
    }
    var goThisMonth = function(el)
    {
        $('#spinner-div').show();
        var filter = $(el).val()
        $(".showPage").load("{{ url('hrd/home/getPelatihan') }}/"+filter, function(){
            jQuery('ul.iq-email-sender-list li').click(function() {
                jQuery(this).next().addClass('show');
            });
            jQuery('.email-app-details li h4').click(function() {
                jQuery('.email-app-details').removeClass('show');
            });
        }, function(){
            $('#spinner-div').hide();
        });
    }
    var goThisYear = function(el)
    {
        var filter = $(el).val()
        $(".showPage").load("{{ url('hrd/home/getPelatihan') }}/"+filter, function(){
            jQuery('ul.iq-email-sender-list li').click(function() {
                jQuery(this).next().addClass('show');
            });
            jQuery('.email-app-details li h4').click(function() {
                jQuery('.email-app-details').removeClass('show');
            });
        });
    }
</script>
@endsection
