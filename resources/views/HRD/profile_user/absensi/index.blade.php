@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
    position: absolute;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 2;
    }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dataku - Absensi</li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-3">
                        <select class="form-control" name="pil_bulan" id="pil_bulan" style="width: 100%">
                            <option value="0">Pilihan Bulan</option>
                            @foreach($list_bulan as $key => $value)
                            @if($key==date("m"))
                            <option value="{{ $key }}" selected>{{ $value }}</option>
                            @else
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        @php
                        $thn_start = 2010;
                        $thn_end = date('Y');
                        @endphp
                        <select class="form-control" name="inp_tahun" id="inp_tahun">
                           @for ($i=$thn_start; $i<=$thn_end; $i++)
                            @if($i==date("Y"))
                            <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                           @endfor
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <button type="button" class="btn btn-primary"  id="btnFilter"><i class="fa fa-search"></i> Filter</button>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                        <div class="iq-card table-responsive" id="data_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-body" style="width:100%; height:auto">
                {{-- <div id="calendarPresensi" style="padding: 1rem;"></div> --}}
                <div id="calendar_2"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
            var calendarEl = document.getElementById('calendar_2');
            var Calendar = FullCalendar.Calendar;
            var calendar = new Calendar(calendarEl, {
                // themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                initialDate: new Date(),
                headerToolbar: {
                    left: 'today',
                    center: 'title',
                    right: ''
                },
                editable: false,
                droppable: true,
                displayEventTime: false,
                events: function (info, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{ url("hrd/dataku/loadAbsensi") }}',
                        data: {
                            start: info.startStr,
                            end: info.endStr,
                             bulan: $('#pil_bulan').val(),
                            tahun: $('#inp_tahun').val()
                        },
                        success: function (response) {
                            successCallback(response);
                        },
                        error: function () {
                            failureCallback();
                        }
                    });
                }
            });
        calendar.render();
        // Klik tombol filter
        $('#btnFilter').on('click', function () {
            var bulan = $('#pil_bulan').val();
            var tahun = $('#inp_tahun').val();

            // Pindahkan kalender ke bulan & tahun yang dipilih
            var gotoDate = tahun + '-' + bulan + '-01';
            calendar.gotoDate(gotoDate);

            calendar.refetchEvents(); // reload data dengan filter baru
        });

    });

</script>
@endsection
