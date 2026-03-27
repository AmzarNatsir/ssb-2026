@extends('Tender.layouts.master')
@section('content')
<div class="row">
  <x-reusable.breadcrumb :list="$breadcrumb" />
</div>
<div class="iq-card">
  <div class="iq-card-body" style="padding:1.5rem 3rem;">
    <div class="row">
      <div class="col-sm-8">
        <h4 class="card-title text-primary">
          <span class="ri-chat-check-line pr-2"></span>Pemenuhan Unit
        </h4>
      </div>
      <div class="col-sm-4 text-right">
        @hasrole('project_manager')
          <button id="createFulfillmentBtn" type="button" class="btn btn-lg mb-3 btn-success rounded-pill font-weight-bold" data-toggle="modal" data-backdrop="static" data-target="#createProjectModal">
            <i class="las la-plus"></i>Create Unit Fulfillment
          </button>
        @endhasrole
      </div>
    </div>

    <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
      <form id="filter-daftar-p2h" name="filter-daftar-p2h" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Project.loadDataTable') }}">
       @csrf
        <div class="form-row">
          <div class="form-group pr-2">
            <label>Projects</label>
            <select id="project" name="project" class="form-control form-control-sm">
              @if(isset($activeProjects))
                @foreach ($activeProjects as $project)
                  <option value="{{ $project->id }}">{{ $project->number}}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="form-group pr-2">
            <label>Tanggal Pemenuhan (awal)</label>
            <input class="form-control form-control-sm pl-3" id="startDate" name="startDate" type="date" />
          </div>
          <div class="form-group pr-2">
            <label>Tanggal Pemenuhan (akhir)</label>
            <input class="form-control form-control-sm pl-3" id="endDate" name="endDate" type="date" />
          </div>
          <div class="form-group pr-2">
            <label>&nbsp;</label>
            <button id="btn-filter-fulfillment" type="button" class="btn btn-lg btn-block btn-primary px-6" style="height:45px;">
              <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
            </button>
          </div>
        </div>
      </form>
    </div>

    <div class="row">
      <div id="action-tags" class="col-md-3 text-center d-flex align-items-center justify-content-start d-none">
        <button id="action-tag-viewAsPdf" data-id="" class="tag tag-primary mr-2" style="border: solid 1px #3490dc;">
          <i class="fa fa-file-pdf-o pt-2 h5" aria-hidden="true"></i>
        </button>
      </div>
      <div class="flex-grow-1"></div>
      <div class="col-md-3">
        <div class="form-group">
          <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mt-2">
        <table id="table-fulfillment" class="table table-data nowrap w-100">
          <thead>
            <tr class="tr-shadow">
              <th></th>
              <th>No.Project</th>
              <th>Id Pemenuhan</th>
              <th>Tanggal Project</th>
              <th>Tanggal Registrasi Pemenuhan</th>
              <th>Input Id</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/datatables.min.js') }}"></script>
<script type="text/javascript">
  $(function(){

    var project = $("#project"),
        startDate = $("#startDate"),
        endDate = $("#endDate"),
        viewAsPDFUrl = "{{ route('fulfillment.viewAsPDF', ['fulfillmentId' => ':fulfillmentId' ]) }}",
        selectedRow;

        startDate.val(moment().startOf('month').format('YYYY-MM-DD'));
        endDate.val(moment().endOf('month').format('YYYY-MM-DD'));
        $("#startDate, #endDate").attr("max", moment().format('YYYY-MM-DD'));

    var createFulfillmentUrl = "{{ route('fulfillment.create') }}",
        loadFulfillmentListUrl = "{{ route('fulfillment.loadDataTable') }}";

    var tableFulfilment = $("#table-fulfillment").DataTable({
        "paging": true,
        "ordering": true,
        "info": true,
        "scrollX": true,
        "scrollY": "260px",
        "searching": true,
        "autoWidth": true,
        "pageLength": 5,
        "lengthChange": true,
        "columnDefs":[{
            "width": "2rem",
            "targets": 0
        }],
        "dom": '<"top"f>rt<"bottom"lp><"clear">',
        createdRow: function(row, date, index){
          $(row).addClass("table-row tr-shadow")
        },
        "language":{
          "lengthMenu": `
            <select class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">
              <option value='5'>5</option>
              <option value='10'>10</option>
              <option value='15'>15</option>
              <option value='-1'>All</option>
            </select>
          `,
          "emptyTable": "Tidak ada data",
          "processing": "Mohon tunggu meload data",
          "info": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
          "infoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
          "zeroRecords": "Tidak ada data ditemukan",
          "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Berikut",
            "previous": "Sebelumnya"
          }
        },
        "processing": true,
        "serverSide": false,
        ajax:{
          url: loadFulfillmentListUrl,
          dataSrc: "data",
          "data": function (d) {
            return $.extend({}, d, {
              "project": project.val(),
              "startDate": startDate.val(),
              "endDate": endDate.val()
            });
          },
        },
        "columns": [
          {
            data: null,
            className: "text-center pl-4",
            orderable: false,
            render: function(data, type, row){
              return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" data-status="${row.id}" class="selectRow form-check-input pl-4">`;
            }
          },
          { data: "project.number" },
          { data: "id" },
          { data: "created_at", className: "text-center" },
          { data: "created_at", className: "text-center" },
          { data: "user.karyawan.nm_lengkap" }
        ]
    });

    $("#table-fulfillment_filter").addClass('d-none');

    $("#btn-filter-fulfillment").on('click', function(e){
      e.preventDefault();
      tableFulfilment.ajax.reload();
    });

    $("#createFulfillmentBtn").on('click', function(e){
      e.preventDefault();
      window.open(createFulfillmentUrl);
    });

    // action tags
  $(document).on('click', '.selectRow', function(){
    $('.selectRow').not($(this)).prop('checked', false);
    if($(this).prop('checked')){
      selectedRow = $(this).val()
      $("#action-tags").removeClass('d-none');
    } else {
      selectedRow = "";
      $("#action-tags").addClass('d-none');
    }
  });

  // view inspection as PDF
  $(document).on('click', '#action-tag-viewAsPdf', function(evt){
    evt.preventDefault();

    // open in current window
    // location.assign(viewAsPDFUrl.replace(':inspectionId', selectedRow));

    // open in new tab
    window.open(viewAsPDFUrl.replace(':fulfillmentId', selectedRow));

  })

  // tooltip utk view pdf
  const uiTooltips = [{
    'selector':'#action-tag-viewAsPdf',
    'title':'View berkas pemenuhan unit'
    }];

    for(const item of uiTooltips){
        $(`${item.selector}`).tooltip({
          title: item.title
        })
    }

  });

</script>
