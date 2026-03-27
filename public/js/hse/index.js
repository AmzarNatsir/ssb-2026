$(function(){
  
  // date filter input
  var startDate = $("#startDate"),
      endDate = $("#endDate");

  var TableInspeksi = $("#table-inspection").DataTable({
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
        url: loadInspectionListUrl,
        dataSrc: "data",        
        "data": function (d) {
          return $.extend({}, d, {
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
            return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
          }
        },
        { data: "assignment_no" },
        { data: "officer.karyawan.nm_lengkap" },
        { data: "location.location_name" },
        { data: "equipment.name" },
        { data: "created_at", className: "text-center" },        
      ]
  });  
  
  $("#btn-filter-p2h").on('click', function(e){
    e.preventDefault();    
    TableInspeksi.ajax.reload();    
  });

  // hides the default search input
  $(document).on('ready', function(){
    $("#table-inspection_filter").addClass('d-none');      
    console.log($("#table-inspection_filter"));
    alert('filter');
  });

  $("#searchFilter").on("keyup", function(){
    TableInspeksi.search($(this).val()).draw();
  });

  $("#table-inspection_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-inspection_wrapper").find(".dataTables_length").addClass("d-flex w-50");

  // action tags
  $(document).on('click', '.selectRow', function(){
    $('.selectRow').not($(this)).prop('checked', false);      
    if($(this).prop('checked')){        
      selectedRow = $(this).val()        
      $("#action-tags").removeClass('d-none');
      // let projectStatus = $(this).data('status');

      // if(projectStatus == "5"){
      //   $("#action-tag-aktivasi-project").addClass("d-none");
      // } else {
      //   $("#action-tag-aktivasi-project").removeClass("d-none");
      // }

    } else {
      selectedRow = "";
      $("#action-tags").addClass('d-none');
    }
  });

  // tooltips
  $(document).on('ready', function(){

    const uiTooltips = [{
      'selector':'#action-tag-viewAsPdf',
      'title':'View As PDF'
    }];

    for(const item of uiTooltips){
      $(`${item.selector}`).tooltip({
        container:'body',
        title: item.title,          
        animation: true,
        html: true,
        trigger:'manual'
      }).on('mouseenter', function(){
        var _this = this;
        $(this).tooltip('show');                    
        $('.tooltip').on("mouseleave", function(){            
          $(_this).tooltip('hide')
        });
      }).on('mouseleave', function(){
        var _this = this;          
        if(!$(".tooltip:hover").length){
          $(_this).tooltip("hide")
        }
      })
    }
  });

  // view inspection as PDF
  $(document).on('click', '#action-tag-viewAsPdf', function(evt){
    evt.preventDefault();
   
    // open in current window
    // location.assign(viewAsPDFUrl.replace(':inspectionId', selectedRow));
    
    // open in new tab
    window.open(viewAsPDFUrl.replace(':inspectionId', selectedRow));

  })

})