$(document).ready(function(){
	console.log('jampel')

	$('body').on('shown.bs.modal', '.modal', function() {
	  $(this).find('select').each(function() {
	    var dropdownParent = $(document.body);
	    if ($(this).parents('.modal.in:first').length !== 0)
	      dropdownParent = $(this).parents('.modal.in:first');
	    console.log(dropdownParent);
	    $(this).select2({
	      dropdownParent: dropdownParent,
	      theme: "bootstrap custom-container",
	      width: "100%"
	    });
	  });
    $("#bond_amount").number(true, 0);
	});

	showSnackbar();

	$(document).on('ready', function(){
		$("#table-bond_filter").addClass('d-none');
	});
	// tableBond.ajax.reload();

	var tableBond = $("#table-bond").DataTable({
		"paging": true,
      "ordering": true,
      "info": true,
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
        url: loadBondUrl,
        dataSrc: "data",        
        "data": function (d) {
          // return $.extend({}, d, {
          //   "opsiKategori": opsiKategori.val(),
          //   "opsiTipe": opsiTipe.val(),
          //   "opsiStatus": opsiStatus.val()
          // });
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
        { data: "name" },        
        { data: "created_at", className: "text-center" },
        { data: "value", render: $.fn.dataTable.render.number(','), className: "text-right" },        
        { data: "category.keterangan" },
        { data: "status.keterangan" },
        { data: "type.keterangan" },
        { data: "location" }        
      ]    
	});

	// custom page length  
  $("#table-bond_wrapper").find(".bottom").addClass("d-flex align-items-center justify-content-between pt-3");
  $("#table-bond_wrapper").find(".dataTables_length").addClass("d-flex w-50");

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

  const uiTooltips = [{
  	'selector':'#action-tag-form-jampel',
  	'title':'Formulir Jaminan Pelaksanaan & Penyusunan Dokumen Lelang'
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

  $("#action-tag-form-jampel").on('click', function(){
  	ajaxRequest({
  		url:"/bond/" + selectedRow + "/create",
  		requestType: "GET"
  	}, loadBondForm);
  });

  function loadBondForm(form){
  	$("#edit-jampel-dynamic-content").html("");      
    $("#create-jampel-dynamic-content").html(form);
  }


  // Bond Form
  $(document).on('click', '#btn-bond-submit', function(evt){
  	evt.preventDefault();
  	$("#create-jampel-form").submit();
  });

  $("#create-jampel-form").submit(function(evt){
  	evt.preventDefault();
  	$("#btn-bond-submit")
  		.attr("disabled", "true")
  		.text("Processing...");
  	this.submit();
  })

  // Auction Document Form
  $(document).on('click', '#btn-auction1-submit', function(evt){
  	evt.preventDefault();
  	$("#create-auction-phase1-form").submit();
  });

  $("#create-auction-phase1-form").submit(function(evt){
  	evt.preventDefault();
  	$("#btn-auction1-submit")
  		.attr("disabled", "true")
  		.text("Processing...");
  	this.submit()
  });


  // Auction Document Form 2
  $(document).on('click', '#btn-auction2-submit', function(evt){
  	evt.preventDefault();
  	$("#create-auction-phase2-form").submit();
  });

  $("#create-auction-phase2-form").submit(function(evt){
  	evt.preventDefault();
  	$("#btn-auction2-submit")
  		.attr("disabled", "true")
  		.text("Processing...");
  	this.submit()
  });

  // Closing Project
  $(document).on('click', '#btn-close-project', function(evt){
  	evt.preventDefault();
  	$("#close-project-form").submit();
  });

  $("#close-project-form").submit(function(evt){
  	evt.preventDefault();
  	$("#btn-close-project")
  		.attr("disabled", "true")
  		.text("Processing...");
  	this.submit();
  });

});