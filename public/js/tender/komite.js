$(function() {
  console.log("komite ready");
  // var filterUrl = "{{ url('/project/filter/') }}";
  function validateAddKomite() {
    let filterDeptOpt = $("#filter_dept"),
      filterJabtOpt = $("#filter_jabt"),
      daftarKaryOpt = $("#daftar_kary");

    // if(filterDeptOpt.val() == ""){
    // 	formValidationArea(filterDeptOpt, "Belum memilih Departemen");
    // }

    if (filterJabtOpt.val() == "") {
      formValidationArea(filterJabtOpt, "Belum memilih Jabatan");
    }

    if (daftarKaryOpt.val() == "") {
      formValidationArea(daftarKaryOpt, "Belum memilih Anggota Komite");
    }
  }

  $("#filter_dept").on("change", function(e) {
    let filterJabt = $("#filter_jabt"),
      idDept = $(this).val() == "" ? 0 : $(this).val();
    filterJabt.empty();
    ajaxRequest(
      {
        url: filterUrl + "/" + "jabatan/" + idDept,
        requestType: "GET"
      },
      function cbFilter(response) {
        if (response.status === "ok") {
          let data = response.data;
          data.forEach(option => {
            filterJabt.append(
              '<option value="' +
                option.id +
                '">' +
                option.nm_jabatan +
                "</option>"
            );
          });
        }
      },
      function cbError(err) {
        filterJabt.empty();
      }
    );
  });

  $("#filter_jabt").on("change", function(e) {
    let filterKary = $("#daftar_kary"),
      idJabt = $(this).val();
    if (idJabt !== "") {
      filterKary.empty();
      ajaxRequest(
        {
          url: filterUrl + "/" + "karyawan/" + idJabt,
          requestType: "GET"
        },
        function cbFilter(response) {
          if (response.status === "ok") {
            let data = response.data;
            data.forEach(option => {
              filterKary.append(
                '<option value="' +
                  option.id +
                  '">' +
                  option.nm_lengkap +
                  "</option>"
              );
            });
          }
        },
        function cbError(err) {
          filterKary.empty();
        }
      );
    } else {
      filterKary.empty();
    }
  });

  var arr = [],
    ob = {};
  // Sortable

  function updateOrder() {
    $.ajax({
      type: "POST",
      url: updateOrderUrl,
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      data: JSON.stringify({
        test: "test"
      }),
      success: function(data) {
        console.log(data);
        // $("#msg").html(data.msg);
      }
    });
  }

  $("#addKomiteModal").on("shown.bs.modal", function(e) {});

  $("#add-komite-form #save-komite-btn").on("click", function(e) {
    e.preventDefault();
    beforeValidate();
    validateAddKomite();
    if (doesntHasValidationError()) {
      $("#add-komite-form").submit();
    }
  });

  // Komite table Reorder
  $(document).on("click", ".btn-toggle-reorder", function() {
    let tableContainer,
      mainButton = $(this);
  });

  // function turnOnSortable(){
  // 	var mainButton = $('.btn-reorder-toggle');
  // 	mainButton.removeAttr('disabled');
  // }

  // table scrollable
  // var tableScrollX = 0;
  // $('.table-scrollable').scroll(function(){
  // 	console.log(this.scrollLeft);
  // 	scrollLine((this.scrollLeft > 0));
  //    tableScrollX = this.scrollLeft;
  // });

  // function scrollLine(add = true) {
  //    let selector = {
  //        theader: $('div[data-header="location"]'), // theader: $('th[data-header="location"]'),
  //        tbody: $('.row-location')
  //    },
  //        className = 'border-scroll-line';

  //    for (let vName of ['theader', 'tbody']) {
  //        if (!add)
  //            selector[vName].removeClass(className)
  //        else if (!selector[vName].hasClass(className))
  //            selector[vName].addClass(className)
  //    }
  // }

  // scrollLine((tableScrollX > 0));

  $(document).on("ready", function() {
    // hide default search filter
    $("#table-komite_filter").addClass("d-none");
    // tableKomite.rowReorder.disable();
  });

  $("#searchFilter").on("keyup", function() {
    tableKomite.search($(this).val()).draw();
  });

  var tableKomite = $("#table-komite").DataTable({
    paging: true,
    ordering: false,
    info: true,
    scrollX: true,
    scrollY: 160,
    searching: true,
    autoWidth: false,
    lengthChange: false,
    serverSide: false,
    columnDefs: [
      {
        width: "2rem",
        targets: 0
      },
      {
        width: "1.4rem",
        targets: 1
      }
    ],
    language: {
      lengthMenu: "Tampilkan _MENU_",
      emptyTable: "Tidak ada data",
      processing: "Mohon tunggu meload data",
      info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      infoEmpty: "Menampilkan 0 s/d 0 dari 0 data",
      zeroRecords: "Tidak ada data ditemukan",
      paginate: {
        first: "Pertama",
        last: "Terakhir",
        next: "Berikut",
        previous: "Sebelumnya"
      }
    },
    createdRow: function(row, date, index) {
      $(row).addClass("table-row tr-shadow");
    },
    ajax: {
      url: loadKomiteUrl,
      dataSrc: "data"
    },
    columns: [
      {
        data: null,
        className: "text-center pl-4",
        orderable: false,
        render: function(data, type, row) {
          return `<input id="selectRow-${row.id}" value="${row.id}" type="checkbox" name="selectRow" class="selectRow form-check-input pl-4">`;
        }
      },
      { data: "approval_order", className: "text-center" },
      { data: "karyawan.nm_lengkap" },
      { data: "karyawan.get_departemen.nm_dept", defaultContent: "-" },
      { data: "karyawan.get_jabatan.nm_jabatan", defaultContent: "-" }
    ],
    rowReorder: {
      dataSrc: "approval_order",
      selector: "td:nth-child(2)"
    }
  });

  $("#table-komite_filter").addClass("d-none");

  showSnackbar();

  // reordering events
  tableKomite.on("row-reorder", function(e, diff, edit) {
    // console.log('row yg trigger reorder : ', edit.triggerRow.data()['id']);

    var elems = [];
    for (var i = 0; i < diff.length; i++) {
      var rowData = tableKomite.row(diff[i].node).data();
      let memberId = rowData["id"];
      let memberNewPosition = diff[i].newData;

      var $container = $("#reorder-member-form"),
        $inputMemberId = $("<input/>"),
        $inputNewPosition = $("<input/>");

      $inputMemberId.attr("type", "hidden");
      $inputMemberId.attr("name", "member_id[]");
      $inputMemberId.attr("id", "member_id");
      $inputMemberId.val(memberId);

      $inputNewPosition.attr("type", "hidden");
      $inputNewPosition.attr("name", "member_new_position[]");
      $inputNewPosition.attr("id", "member_new_position");
      $inputNewPosition.val(memberNewPosition);

      $container.append($inputMemberId);
      $container.append($inputNewPosition);

      elems.push(i);
    }

    if (elems.length > 1) {
      $("#reorder-member-form").submit();
    }
  });

  // select row
  $(document).on("click", ".selectRow", function() {
    $(".selectRow")
      .not($(this))
      .prop("checked", false);
    if ($(this).prop("checked")) {
      selectedRow = $(this).val();
      $("#action-tags").removeClass("d-none");
      // $("#actions-reorder-container").removeClass('d-hidden');
    } else {
      selectedRow = "";
      $("#action-tags").addClass("d-none");
      // $("#actions-reorder-container").addClass('d-hidden');
    }
  });

  // action tags click events
  // reference : https://stackoverflow.com/questions/59169918/error-missing-required-parameters-for-route-city-uri-daftar-city-id

  $("#action-tag-delete-komite").on("click", function(e) {
    e.preventDefault();
    ajaxRequest(
      {
        url: "/project/komite/hapusMember/" + selectedRow,
        requestType: "GET"
      },
      deleteKomiteSuccessCallback
    );
  });

  function deleteKomiteSuccessCallback(result) {
    if (result.status == "1") {
      tableKomite.ajax.reload();
      $("#action-tags").addClass("d-none");
    }
  }

  // action tags update
  $("#action-tag-update-komite").on("click", function(e) {
    e.preventDefault();
    $("#addKomiteModal .modal-title").text("Update Anggota Komite");
    $("#addKomiteModal").modal("show");
  });

  $("#addKomiteModal").on("hide.bs.modal", function() {
    let modalTitle = "Tambah Anggota Komite";
    $("#addKomiteModal .modal-title").text(modalTitle);
  });

  // activate reorder function
  $(document).on("click", "#reorder-komite", function() {
    // show some styles to indicate reorder is activated
    $(".table-komite tbody tr").addClass("onSortActive");

    // enable row-reordering
    // tableKomite.rowReorder.enable();

    $("#accept-reorder-komite").removeClass("d-none");
    $("#cancel-reorder-komite").removeClass("d-none");
  });

  // cancel reorder function
  $(document).on("click", "#cancel-reorder-komite", function() {
    $(".table-komite tbody tr").removeClass("onSortActive");
  });
});
