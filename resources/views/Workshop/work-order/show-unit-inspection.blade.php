@extends('Workshop.layouts.master')
@section('content')
  <form method="post" action="{{ route('workshop.work-order.store-inspection', $workOrder->id) }}">
    @csrf
    <div id="content-page" class="content-page">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="iq-card">
              <div class="iq-card-header d-flex justify-content-beteween">
                <div class="iq-header-title">
                  <h4 class="card-title">Unit Inspection</h4>
                </div>
              </div>
              <div class="iq-card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>Unit Number</label>
                        <input type="text" class="form-control" value="{{$workOrder->equipment->code}}/{{$workOrder->equipment->name}}" readonly>
                      </div>
                    </div>
                    <div class="col-sm-2 col-lg-2">
                      <div class="form-group">
                        <label>HM</label>
                        <input name="hm" type="text" class="form-control" value="{{$unitInspection->hm ?? $workOrder->equipment->hm}}" required>
                      </div>
                    </div>
                    <div class="col-sm-2 col-lg-2">
                      <div class="form-group">
                        <label>KM</label>
                        <input name="km" type="text" class="form-control" value="{{$unitInspection->km ?? $workOrder->equipment->km}}" required>
                      </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>Mechanic</label>
                        <select name="mechanic_id" id="" class="form-control" required>
                          <option value="">-- Choose Mechanic --</option>
                          @forelse($mechanics as $mechanic)
                            <option value="{{ $mechanic["id"]  }}" {{ $unitInspection->mechanic_id == $mechanic["id"] ? "selected":""  }}>{{ $mechanic["name"]  }}</option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>Type</label>
                        <input class="form-control" value="{{$workOrder->equipment->equipment_category->name}}" readonly>
                      </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>Location</label>
                        <select name="location_id" id="" class="form-control" required>
                          <option value="">-- Please Select Location --</option>
                          @forelse($locations as $location)
                            <option value="{{ $location->id  }}" {{ $unitInspection->location_id == $location->id ? 'selected' : ''  }}>{{ $location->location_name  }}</option>
                          @empty
                          @endforelse
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>Inspection Date</label>
                        <input type="date" class="form-control" required name="inspection_date" value="{{ $unitInspection->inspection_date ? date("Y-m-d", strtotime($unitInspection->inspection_date)) : ''  }}">
                      </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group">
                        <label>WO. Number</label>
                        <input type="text" class="form-control" value="{{$workOrder->number}}" readonly>
                      </div>
                    </div>
                    <div class="col-sm-4 col-lg-4">
                      <div class="form-group"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="iq-card">
              <div class="iq-card-body">
                <div class="container-fluid">
                  <div class="row" style="text-align: right">
                    <div class="col-sm-12 col-lg-12">
                      <a onclick="return confirm('Are you sure?')" href="{{ route("workshop.work-order.reset-inspection", $workOrder->id) }}" class="btn btn-warning"><i class="ri-repeat-line"></i> Reset Template</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-lg-12">
                      <table class="table">
                        @forelse (collect($unitInspection->checklists_array) as $groupKey => $group)
                          <tr style="font-weight: bold">
                            <td colspan="2">
                              {{chr(($groupKey+1)+64)}}. {{ $group["checklist_group_name"] }}
                              <input type="hidden" name="checklist_group_name[]" value="{{ $group["checklist_group_name"]}}">
                            </td>
                            <td>GOOD</td>
                            <td>BAD</td>
                            <td>REMARKS</td>
                          </tr>
                          @forelse($group["checklist_items"] as $itemKey => $item)
                            <tr>
                              <td style="padding: 0.20rem">{{$itemKey+1}}.</td>
                              <td style="padding: 0.20rem">
                                {{$item["checklist_item_name"]}}
                                <input type="hidden" name="checklist_items[{{$groupKey}}][{{$itemKey}}]" value="{{$item["checklist_item_name"]}}">
                              </td>
                              <td style="padding: 0.20rem"><input value="1" {{ $item["check_result"] == "1" ? "checked":'' }} type="radio" name="checklist_item_results[{{$groupKey}}][{{$itemKey}}]" required></td>
                              <td style="padding: 0.20rem"><input value="0" {{ $item["check_result"] == "0" ? "checked":'' }} type="radio" name="checklist_item_results[{{$groupKey}}][{{$itemKey}}]" required></td>
                              <td style="padding: 0.20rem"><input value="{{ $item["remarks"]  }}" type="text" class="form-control" name="checklist_item_remarks[{{$groupKey}}][{{$itemKey}}]"></td>
                            </tr>
                          @empty
                          @endforelse
                        @empty
                        @endforelse
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-lg-12">
            <div class="iq-card">
              <div class="iq-card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="radio d-inline-block mr-2">
                      <input type="radio" name="check_result" id="radio1"  required value="1" {{ $unitInspection->check_result == "1" ? "checked" : ""  }}>
                      <label for="radio1">UNIT BISA DIOPERASIKAN DALAM KONDISI BAIK</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="radio d-inline-block mr-2">
                      <input type="radio" name="check_result" id="radio2"  required value="2" {{ $unitInspection->check_result == "2" ? "checked" : ""  }}>
                      <label for="radio2">UNIT BISA DIOPERASIKAN DENGAN KONDISI BACKLOG YANG BISA DI EXTEND</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="radio d-inline-block mr-2">
                      <input type="radio" name="check_result" id="radio3"  required value="3" {{ $unitInspection->check_result == "3" ? "checked" : ""  }}>
                      <label for="radio3">UNIT TIDAK BISA DIOPERASIKAN DENGAN KERUSAKAN BERAT</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10 col-lg-10">
            <div class="iq-card">
              <div class="iq-card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-12 col-lg-12">
                      <label>REMARKS</label>
                      <textarea name="remarks" cols="2" rows="2" class="form-control">{{$unitInspection->remarks}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @if($unitInspection->status == 0)
            <div class="col-sm-2 col-lg-2">
              <button class="btn btn-sm btn-success" type="submit">Submit</button>
              <button class="btn btn-sm btn-danger" type="button">Cancel</button>
            </div>
          @endif
        </div>
      </div>
    </div>
  </form>
@endsection
