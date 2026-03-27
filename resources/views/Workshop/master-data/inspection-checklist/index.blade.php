@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <form action="{{ route('workshop.master-data.inspection-checklist.store') }}" method="POST">
            @csrf
            <div class="container-fluid">
                <h3>WORKSHOP INSPECTION CHECKLIST</h3>
                @forelse ($checklistGroups as $checklistGroup)
                    <div class="row checklistTitle">
                        <div class="col-sm-12 col-lg-12">
                            <div class="iq-card">
                                <div class="iq-card-body">
                                    <div class="row" style="text-align: right">
                                        <div class="col-sm-10 col-lg-10">
                                            <div class="form-group" style="margin-bottom: 0.5rem">
                                                <input type="text" required name="inspection_checklist_group[]"
                                                    class="form-control" placeholder="Checklist Title"
                                                    value="{{ $checklistGroup->name }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-lg-2">
                                            <button type="button" class="btn" onclick="moveTitleUp(this)" style="padding: 0"><i
                                                    style="font-size: 20px;color:darkcyan;"
                                                    class="ri-arrow-up-circle-fill"></i></button>
                                            <button type="button" class="btn" onclick="moveTitleDown(this)" style="padding: 0"><i
                                                    style="font-size: 20px;color:darkcyan;"
                                                    class="ri-arrow-down-circle-fill"></i></button>
                                            <button type="button" class="btn" onclick="deleteTitle(this)" style="padding: 0"><i
                                                    style="font-size: 20px;color: red;"
                                                    class="ri-delete-bin-fill"></i></button>
                                        </div>
                                    </div>
                                    <hr style="margin-bottom: 0.5rem; margin-top: 0">
                                    @forelse($checklistGroup->inspectionChecklistItems()->sortByOrder()->get() as $checklistItem)
                                        <div class="row" style="text-align: right">
                                            <div class="col-sm-9 col-lg-9 offset-md-1 offset-lg-1">
                                                <div class="form-group">
                                                    <input type="text" required class="form-control" placeholder="Checklist Item"
                                                        name="inspection_checklist_item[]"
                                                        value="{{ $checklistItem->name }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-2 col-lg-2">
                                                <button type="button" class="btn" onclick="moveRowUp(this)" style="padding: 0"><i
                                                        class="ri-arrow-up-circle-fill"
                                                        style="font-size: 20px;color:darkcyan;"></i></button>
                                                <button type="button" class="btn" onclick="moveRowDown(this)" style="padding: 0"><i
                                                        style="font-size: 20px;color:darkcyan;"
                                                        class="ri-arrow-down-circle-fill"></i></button>
                                                <button type="button" class="btn" onclick="deleteItem(this)" style="padding: 0"><i
                                                        style="font-size: 20px;color:red"
                                                        class="ri-delete-bin-fill"></i></button>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                    <div class="row newItem">
                                        <div class="col-sm-12 col-lg-12" style="text-align: right">
                                            <button type="button" class="btn btn-info" onclick="addItem(this)"><i
                                                    class="ri-add-circle-fill"></i> Add Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
                <div class="row" id="newTitle">
                    <div class="col-sm-12 col-lg-12" style="text-align: left">
                        <button type="button" class="btn btn-info" onclick="addTitle()"><i class="ri-add-circle-fill"></i>
                            Add Title</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let templateItem = `
    <div class="row" style="text-align: right">
      <div class="col-sm-9 col-lg-9 offset-md-1 offset-lg-1">
        <div class="form-group">
          <input type="text" required class="form-control" placeholder="Checklist Item" name="inspection_checklist_item[]">
        </div>
      </div>
      <div class="col-sm-2 col-lg-2">
        <button type="button" class="btn" onclick="moveRowUp(this)" style="padding: 0"><i style="font-size: 20px;color:darkcyan" class="ri-arrow-up-circle-fill"></i></button>
        <button type="button" class="btn" onclick="moveRowDown(this)" style="padding: 0"><i style="font-size: 20px;color:darkcyan" class="ri-arrow-down-circle-fill"></i></button>
        <button type="button" class="btn" onclick="deleteItem(this)" style="padding: 0"><i style="font-size: 20px;color:red" class="ri-delete-bin-fill"></i></button>
      </div>
    </div>`;

        let templateTitle = `
    <div class="row checklistTitle">
      <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
          <div class="iq-card-body">
            <div class="row" style="text-align: right">
              <div class="col-sm-10 col-lg-10">
                <div class="form-group" style="margin-bottom: 0.5rem">
                  <input type="text" required name="inspection_checklist_group[]" class="form-control" placeholder="Checklist Title">
                </div>
              </div>
              <div class="col-sm-2 col-lg-2">
                <button type="button" class="btn" onclick="moveTitleUp(this)" style="padding: 0"><i style="font-size: 20px;color:darkcyan" class="ri-arrow-up-circle-fill"></i></button>
                <button type="button" class="btn" onclick="moveTitleDown(this)" style="padding: 0"><i style="font-size: 20px;color:darkcyan" class="ri-arrow-down-circle-fill"></i></button>
                <button type="button" class="btn" onclick="deleteTitle(this)" style="padding: 0"><i style="font-size: 20px;color: red" class="ri-delete-bin-fill"></i></button>
              </div>
            </div>
            <hr style="margin-bottom: 0.5rem; margin-top: 0">
            ${templateItem}
            <div class="row newItem">
              <div class="col-sm-12 col-lg-12" style="text-align: right">
              <button type="button" class="btn btn-info" onclick="addItem(this)"><i class="ri-add-circle-fill"></i> Add Item</button>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>`;

        function addTitle() {
            $('#newTitle').before(templateTitle);
        }

        function addItem(selector) {
            $(selector).closest('.row').before(templateItem)
        }

        function deleteItem(selector) {
            $(selector).closest('.row').remove();
        }

        function deleteTitle(selector) {
            $(selector).closest('.checklistTitle').remove();
        }

        function moveRowUp(button) {
            var row = $(button).closest('.row');
            var previousRow = row.prev();

            if (previousRow.length && !previousRow.is('hr')) {
                row.slideUp('fast', function() {
                    row.insertBefore(previousRow);
                    row.slideDown('fast');
                });
            }
        }

        function moveRowDown(button) {
            var row = $(button).closest('.row');
            var nextRow = row.next();

            if (nextRow.length && !nextRow.hasClass('newItem')) {
                row.slideUp('fast', function() {
                    row.insertAfter(nextRow);
                    row.slideDown('fast');
                });
            }
        }

        function moveTitleUp(button) {
            var row = $(button).closest('.checklistTitle');
            var previousRow = row.prev();

            if (previousRow.length && !previousRow.is('h3')) {
                row.slideUp('fast', function() {
                    row.insertBefore(previousRow);
                    row.slideDown('fast');
                });
            }
        }

        function moveTitleDown(button) {
            var row = $(button).closest('.checklistTitle');
            var nextRow = row.next();

            if (nextRow.length && !nextRow.is('#newTitle')) {
                row.slideUp('fast', function() {
                    row.insertAfter(nextRow);
                    row.slideDown('fast');
                });
            }
        }

        function validateChecklistData(data) {
            var groups = [];
            var items = [];

            for (var i = 0; i < data.length; i++) {
                var checklist = data[i];

                if (groups.includes(checklist.value)) {
                    return false;
                } else {
                    groups.push(checklist.value);
                }

              items[i] = []
              for (var j = 0; j < checklist.items.length; j++) {
                  var item = checklist.items[j];

                  if (items[i].includes(item)) {
                      return false;
                  } else {
                      items[i].push(item);
                  }
                }
            }

            return true;
        }

        $(document).ready(function() {
            if ($('.checklistTitle').length < 1) {
                addTitle();
            }
        })

        $('form').submit(function(e) {
            e.preventDefault();
            $('#loading').show();

            let formData = $(this).serializeArray();
            var transformedData = [];
            var currentItem = {};

            for (var i = 0; i < formData.length; i++) {
                var field = formData[i];

                if (field.name === "inspection_checklist_group[]") {
                    currentItem = {
                        value: field.value
                    };
                    transformedData.push(currentItem);
                } else if (field.name === "inspection_checklist_item[]") {
                    if (!currentItem.items) {
                        currentItem.items = [];
                    }
                    currentItem.items.push(field.value);
                }
            }

            if (validateChecklistData(transformedData)) {
                $.post(
                    "{{ route('workshop.master-data.inspection-checklist.store') }}", {
                        data: transformedData,
                        _token: formData[0].value
                    },
                    function(response) {
                        if (response.status === 'ok') {
                            alert('Inspection checklist template has been saved!');
                            location.reload();
                        } else {
                            alert(response.messages);
                        }
                    }
                )
            } else {
                alert('Please make sure no duplicate Checklist Title Or Checklist Item');
                $('#loading').hide();
            }
        })
    </script>
@endsection
