@extends('HRD.layouts.master')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/animated-calendar/src/calendar-gc.css') }}">
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
                <div id="calendarPresensi" style="padding: 1rem;"></div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/animated-calendar/dist/calendar-gc.min.js') }}"></script>
<script type="text/javascript">
    var events = [];
    var presensi = [];
    var toDay = new Date(); //new Date();
    $(function (e) {

        var calendar = $("#calendarPresensi").calendarGC({
            dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            dayBegin: 0,
            prevIcon: '&#x3c;',
            nextIcon: '&#x3e;',
            onPrevMonth: function (e) {
                console.log("prev");
                console.log(e);
                getSelected(e);
                // getPresensi(e);
            },
            onNextMonth: function (e) {
                console.log("next");
                console.log(e);
                getSelected(e);
                // getPresensi(e);
            },
            events: getData(toDay), // getThisMonth(e), // getThisMonth(e),
            onclickDate: function (e, data) {
                console.log(e, data);
            }
        });
    });
    function getThisMonth(e) {
        events.length = 0; // Clears the array
        var d = new Date(); //new Date();
        var totalDay = new Date(d.getFullYear(), d.getMonth(), 0).getDate();
        // var events = [];
        for (var i = 1; i <= totalDay; i++)
        {
            var newDate = new Date(d.getFullYear(), d.getMonth(), i);
            if (newDate.getDay() == 0) {   //if Sunday
                events.push({
                date: newDate,
                eventName: "",
                // className: "badge bg-danger",
                onclick(e, data) {
                    console.log(data);
                },
                dateColor: "red"
                });
            } else if(newDate.getDay() > 0 || newDate.getDay() < 6) {
                events.push({
                date: newDate,
                eventName: "",
                className: "badge bg-danger",
                onclick(e, data) {
                    console.log(data);
                },
                dateColor: "black"
                });
            }
        }
        return events;
    }
    function getData(d) {
        $.ajax({
            type: 'post',
            headers : {
                        'X-CSRF-TOKEN' : '<?php echo csrf_token() ?>'
                    },
            url: '{{ url("hrd/dataku/loadAbsensi") }}',
            dataType: 'json',
            data: {
                bulan: d.getMonth(),
                tahun: d.getFullYear()
            },
            success: function (response) {
                console.log(response);
                events.push(response.data);
            }

        });
        return events;
        // console.log(presensi);
    }
    getData(toDay);
    // getThisMonth(toDay);
    // getHoliday();
    function getSelected(e)
    {
        events.length = 0; // Clears the array
        var totalDay = new Date(e.getFullYear(), e.getMonth(), 0).getDate();
        for (var i = 1; i <= totalDay; i++)
        {
            var newDate = new Date(e.getFullYear(), e.getMonth(), i);
            if (newDate.getDay() == 0) {   //if Sunday
                events.push({
                date: newDate,
                eventName: data['jam'],
                // className: "badge bg-danger",
                onclick(e, data) {
                    console.log(data);
                },
                dateColor: "red"
                });
            }

        }
        return events;
    }
</script>
@endsection
