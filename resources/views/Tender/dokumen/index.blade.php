@extends('Tender.layouts.master')
@include('Tender.dokumen.partials.dokumen_modal')
@section('content')
<div class="row">
  <div class="col-lg-12">
      <div class="navbar-breadcrumb">
          <nav aria-label="breadcrumb">
              <ul class="breadcrumb">              
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
              <li class="breadcrumb-item">Project Management</li>
              <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
              </ul>
          </nav>
      </div>
  </div>
</div>
<div class="iq-card">  
  <div class="iq-card-body" style="padding:1.5rem 3rem;">    
      <div class="row">
        <div class="col-sm-8">
          <h4 class="card-title text-primary">
            <span class="ri-chat-check-line pr-2"></span>Fixed Dokumen
          </h4>
        </div>
        <div class="col-sm-4 text-right">
          
          @hasrole('project_manager')
          
          <button 
            id="btnAddDocument" 
            type="button" 
            data-toggle="modal" 
            data-backdrop="static" 
            data-target="#addDocumentModal"
            class="btn btn-lg mb-3 btn-success rounded-pill font-weight-bold">
            <i class="las la-plus"></i>Tambah Fixed Dokumen
          </button>

          @endhasrole

        </div>
      </div>
      {{-- Toast --}}
      <div id="snackbar" class="alert text-white d-none {{ (\Session::has('danger') ? 'bg-danger' : 'bg-success') }}" role="alert" style="position:absolute;top:5%;right:25;z-index:2000;">
        <div id="snackbar_message" class="iq-alert-text">
          @if (\Session::has('danger'))
          {{ trim(\Session::get('danger')) }}
          @elseif(\Session::has('success'))
          {{ trim(\Session::get('success')) }}
          @endif          
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="ri-close-line"></i>
        </button>
     </div>
     
      <div class="row mt-4 mb-4 d-flex justify-content-center border-bottom">
        <form id="filter-project-form" name="filter-project-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('document.loadDataTable') }}">
         @csrf

         <div class="form-row">
          <div class="form-group pr-2">
            <label>Kategori</label>
            <select id="opsiKategoriDokumen" name="opsiKategoriDokumen" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">              
              @foreach($fileTypesCategory as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach              
            </select>            
          </div>
          <div class="form-group pr-2">
            <label>Jenis Dokumen</label>
            <select id="opsiJenisDokumen" name="opsiJenisDokumen" class="form-control" style="border-right: 10px transparent solid;border-bottom: 15px;">              
              @foreach($fileTypes as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach              
            </select>            
          </div>
          <div class="form-group pr-2">
            <label>&nbsp;</label>
            <button id="btn-filter-fixed-document" type="button" class="btn btn-lg btn-block btn-primary px-6 position-relative" style="height:45px;">
              <i class="ri-filter-line pr-1"></i><strong>Filter</strong>
              <span class="badge bg-light ml-2 position-absolute top-0 start-100 rounded-circle text-dark translate-middle d-none">4</span>
            </button>
          </div>
         </div>         
        </form>
      </div>

      {{-- Table --}}
      <div class="row">
        <div class="flex-grow-1"></div>                  
        <div class="col-md-3">
          <div class="form-group">
            <input id="searchFilter" name="searchFilter" class="form-control form-control-sm pl-3" type="text" placeholder="Filter" />
          </div>
        </div>
       </div>

      <div class="row mt-2">
        <div class="col-12">
          <table id="table-fixed-document" class="table table-data nowrap w-100">
            <thead>
              <tr class="tr-shadow">
                {{-- <th></th> --}}
                <th>Jenis Dokumen</th>
                <th>Nama Dokumen</th>                
                <th>Tgl Pembuatan</th>
                <th>Preview</th>                
              </tr>
            </thead>
            <tbody>              
            </tbody>
          </table>
        </div>
      </div>
      {{-- End Table --}}
  </div>
</div>
@endsection
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  
  showSnackbar();

  var btnAddDocument = $("#btnAddDocument"),
      btnSubmitAddDocument = $("#btnSubmitAddDocument"),
      addDocumentUrl = "{{ route('document.create') }}",
      loadFixedDocumentUrl = "{{ route('document.loadDataTable') }}",
      previewDocumentUrl = "{{ url('storage/project/') }}";      

    btnAddDocument.on('click', function(){
      ajaxRequest({
        url: addDocumentUrl,
        requestType: "GET"
      }, generateModalContent);
    });

    function generateModalContent(result){            
      $("#modal-container").html(result);
    }

    $(document).on('shown.bs.modal', '#addDocumentModal', function(){
      console.log('modal show')      
      // $("#btnSubmitAddDocument").attr('disabled','true');
    })

    // $(document).on('change', '#is_template_check', function(){
    //   if($(this).is(":checked")) {
    //     $("#btnSubmitAddDocument").removeAttr('disabled');
    //     $("#add-document-form div.form-group,#button_wrapper").removeClass('d-none');
    //   } else {
    //     $("#btnSubmitAddDocument").attr('disabled','true');
    //     $("#add-document-form div.form-group,#button_wrapper").addClass('d-none');
    //   }
    // })

    $(document).on('click', '#btnSubmitAddDocument', function(){
      // beforeValidate();
      // validateStepThree();
      // if (doesntHasValidationError()) {
        $("#add-document-form").submit();
      // }
    });

    $("#add-document-form").submit(function (e) {
      e.preventDefault();  
      // $("#btn-save-project")
      //   .attr("disabled", "true")
      //   .text("Processing...");      
        this.submit();
    });

    $.fn.dataTable.render.moment = function ( from, to, locale ) {
        // Argument shifting
        if ( arguments.length === 1 ) {
            locale = 'en';
            to = from;
            from = 'YYYY-MM-DD';
        }
        else if ( arguments.length === 2 ) {
            locale = 'en';
        }
    
        // return function ( d, type, row ) {
        //     if (! d) {
        //         return type === 'sort' || type === 'type' ? 0 : d;
        //     }
    
        //     var m = window.moment( d, from, locale, true );
    
        //     // Order and type get a number value from Moment, everything else
        //     // sees the rendered value
        //     return m.format( type === 'sort' || type === 'type' ? 'x' : to );
        // };
    };

    var tableFixedDocument = $("#table-fixed-document").DataTable({
      "paging": true,
      "ordering": true,
      "info": true,
      "scrollX": true,
      "scrollY": "260px",
      "searching": true,
      "autoWidth": true,
      "pageLength": 5,// default page length
      "lengthChange": true,      
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
        url: loadFixedDocumentUrl,
        dataSrc: "data",        
        "data": function (d) {
          return $.extend({}, d, {
            "opsiKategoriDokumen": $("#opsiKategoriDokumen").val(),
            "opsiJenisDokumen": $("#opsiJenisDokumen").val()
          });
        },               
      },
      "columns": [        
        { data: "filetype.name" },
        { data: "desc" },
        { data: "created_at", className: "text-center",  render: $.fn.dataTable.render.moment('YYYY-MM-DD HH:mm:ss', 'DD/MM/YYYY') },
        {
          data:null,
          render: function(data, type, row){
            return `<a target="_blank" href="${previewDocumentUrl}/${row.name}">Preview</span>`;            
          }
        },
      ]
    });

    $("#table-fixed-document_filter").addClass('d-none');
    $("#table-fixed-document_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
    $("#table-fixed-document_wrapper").find(".dataTables_length").addClass("d-flex w-50");

    $("#searchFilter").on("keyup", function(){
      tableFixedDocument.search($(this).val()).draw();
    });

    // filter
    $("#btn-filter-fixed-document").on('click', function(e){
      e.preventDefault();
      tableFixedDocument.ajax.reload();    
    });
})
</script>