@extends('HRD.layouts.master')

@section('content')
<!--
<div class="row">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                        <div class="rounded-circle iq-card-icon iq-bg-primary mr-3"> <i class="ri-mail-open-line"></i></div>
                        <div class="text-left">
                            <h4>425</h4>
                            <p class="mb-0">Mails</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center mb-3 mb-lg-0">
                        <div class="rounded-circle iq-card-icon iq-bg-info mr-3"> <i class="ri-message-3-line"></i></div>
                        <div class="text-left">
                            <h4>110</h4>
                            <p class="mb-0">Message</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="rounded-circle iq-card-icon iq-bg-danger mr-3"> <i class="ri-group-line"></i></div>
                        <div class="text-left">
                            <h4>8000</h4>
                            <p class="mb-0">Users</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="rounded-circle iq-card-icon iq-bg-warning mr-3"> <i class="ri-task-line"></i></div>
                        <div class="text-left">
                            <h4>690</h4>
                            <p class="mb-0">Task</p>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<div class="row">
    <div class="col-sm-4">
        <div class="iq-card">
            <div class="iq-card-body">
                <div id="high-pie-chart-1"></div>
                <table class="table table-striped table-condensed" style="width: 100%;">
                <tr>
                    <td style="width: 60%;">Departemen</td>
                    <td style="width: 40%;">Jumlah Karyawan</td>
                </tr>
                @foreach($data_chart_1 as $key => $dt_1)
                <tr>
                    <td>{{ $dt_1['nm_dept'] }}</td>
                    <td>{{ $dt_1['jml_karyawan'] }} orang</td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="iq-card">
            <div class="iq-card-body">
                <div id="high-pie-chart-2"></div>
                <table class="table table-striped table-condensed" style="width: 100%;">
                <tr>
                    <td style="width: 60%;">Range Usia</td>
                    <td style="width: 40%;">Jumlah Karyawan</td>
                </tr>
                <tr>
                    <td><= 25</td>
                    <td>{{ $usia_1 }} orang</td>
                </tr>
                <tr>
                    <td>26 - 30</td>
                    <td>{{ $usia_2 }} orang</td>
                </tr>
                <tr>
                    <td>31 - 40</td>
                    <td>{{ $usia_3 }} orang</td>
                </tr>
                <tr>
                    <td>> 40</td>
                    <td>{{ $usia_4 }} orang</td>
                </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="iq-card">
            <div class="iq-card-body">
                <div id="high-pie-chart-3"></div>
                <table class="table table-striped table-condensed" style="width: 100%;">
                <tr>
                    <td style="width: 60%;">Status Karyawan</td>
                    <td style="width: 40%;">Jumlah Karyawan</td>
                </tr>
                @foreach($data_chart_2 as $key => $dt_2)
                <tr>
                    <td>{{ $dt_2['status'] }}</td>
                    <td>{{ $dt_2['jml_karyawan'] }} orang</td>
                </tr>
                @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
<!-- highcharts JavaScript -->
<script src="{{ asset('assets/js/highcharts.js') }} "></script>
<!-- highcharts-3d JavaScript -->
<script src="{{ asset('assets/js/highcharts-3d.js') }}"></script>
<!-- highcharts-more JavaScript -->
<script src="{{ asset('assets/js/highcharts-more.js') }}"></script>
<script>
if(jQuery('#high-pie-chart-1').length){
      Highcharts.chart('high-pie-chart-1', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      colorAxis: {},
      title: {
          text: 'Jumlah Karyawan Berdasarkan Departemen, Periode Tahun {{ date("Y") }}'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              }
          }
      },
      series: [{
          name: 'Departemen',
          colorByPoint: true,
          data: [
            @foreach($data_chart_1 as $key => $value)
                { name: "{{ $value['nm_dept'] }}", y: {{ $value['jml_karyawan'] }} },
            @endforeach
            ]
      }]
    });
}
if(jQuery('#high-pie-chart-2').length)
{
      Highcharts.chart('high-pie-chart-2', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      colorAxis: {},
      title: {
          text: 'Jumlah Karyawan Berdasarkan Usia, <br>Periode Tahun{{ date("Y") }}'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              }
          }
      },
      series: [{
          name: 'Usia',
          colorByPoint: true,
          data: [
                { name: "<= 25 thn", y: {{ $usia_1 }} },
                { name: "26 - 30 thn", y: {{ $usia_2 }} },
                { name: "31 - 40 thn", y: {{ $usia_3 }} },
                { name: "> 40 thn", y: {{ $usia_4 }} }
            ]
      }]
    });
}
if(jQuery('#high-pie-chart-3').length)
{
      Highcharts.chart('high-pie-chart-3', {
      chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie'
      },
      colorAxis: {},
      title: {
          text: 'Jumlah Karyawan Berdasarkan Status, <br>Periode Tahun{{ date("Y") }}'
      },
      tooltip: {
          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      plotOptions: {
          pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
              }
          }
      },
      series: [{
          name: 'Status',
          colorByPoint: true,
          data: [
            @foreach($data_chart_2 as $key => $value)
                { name: "{{ $value['status'] }}", y: {{ $value['jml_karyawan'] }} },
            @endforeach
            ]
      }]
    });
}
</script>
@endsection
