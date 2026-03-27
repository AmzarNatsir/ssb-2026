$(document).on('ready', function(){
    $("#table-template_filter").addClass('d-none');
    var tableTemplate = $("#table-template").DataTable({
        "paging": true,
        "ordering": true,
        "scrollX": true,
        "scrollY": "260px",
        "searching": true,
        "autoWidth": true,
        "pageLength": 5,// default page length
        "lengthChange": true,      
        "columnDefs":[{
            "width": "2rem",
            "targets": 0
        }],
        "dom": '<"top"f>rt<"bottom"lp><"clear">',
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
            url: "",
            dataSrc: "data",
            "data": function(d){},
        },
        "columns": [{
            data: null,
            className: "text-center pl-4",
            orderable: false,
            render: function(data, type, row){
                return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
            }
        },
        { data: "nodok" },
        { data: "nodok" },
        { data: "nodok" },
        { data: "nodok" },
        ]
    });

    // custom page length  
  $("#table-templaste_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-template_wrapper").find(".dataTables_length").addClass("d-flex w-50");

});