<style>
table {
  width: 100%;
}
thead,  tr {
  display: table;
  width: 100%;
  table-layout: fixed;
}
 tbody {
  display: block;
  overflow-y: auto;
  table-layout: fixed;
  max-height: 500px;
}
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Edit Role AKses</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<form action="{{ url('hrd/setup/manajemengroup/update/' . $roles->id) }}" method="POST" onsubmit="return konfirm()">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-sm-4">Nama Group</label>
            <div class="col-sm-8">
                <input type="text" name="inp_nama_group" id="inp_nama_group" class="form-control" maxlength="100"
                    value="{{ $roles->name }}" required>
            </div>
        </div>
    </div>
    <div class="iq-card-body">
        <div class="table-responsive">
            <table class="table tablefixed table-striped" style="width: 100%">
            <thead>
                <tr>
                    <th style="width: 50%">Menu</th>
                    <th>View</th>
                    <th>Create</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Print</th>
                    <th>Approve</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7"><b>1- MENU HRD</b></td>
                </tr>
                @foreach(Config::get('constants.menu.hrd') as $key => $value)
                    <tr>
                        <td style="width: 50%">
                            @php
                            $menu = str_replace("_", " ", $key) @endphp
                            <b>{{ strtoupper($menu) }}</b>
                        </td>
                        @if(!isset($value['submenu']) )
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_view" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_view", $roles->id) }}>
                                </div>
                            </td>
                            <td colspan="5"></td>
                        @elseif(isset($value['submenu']) && !isset($value['url']))
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_view" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_view", $roles->id) }}>
                                </div>
                            </td>
                            <td colspan="5"></td>
                        @else
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_view" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_view", $roles->id) }}>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_create" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_create", $roles->id) }}>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_edit" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_edit", $roles->id) }}>
                            </div>
                        </td>
                        <td><div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_delete" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_delete", $roles->id) }}>
                        </div></td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_print" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_print", $roles->id) }}>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control" id="{{ $key }}" name="menu_hrd[]" value="{{ $key."_approve" }}" {{ App\Helpers\Hrdhelper::check_permission_user($key."_approve", $roles->id) }}>
                            </div>
                        </td>
                        @endif

                    </tr>
                    @if (isset($value['submenu']))
                        @php $hmenu = $key @endphp
                        @foreach ($value['submenu'] as $item => $sub)
                            <tr>
                                <td style="width: 50%">@php
                                    $menu = str_replace("_", " ", $item) @endphp
                                    - {!! (isset($sub['submenu'])) ? '<b>'.strtoupper($menu).'</b>' : strtoupper($menu) !!}
                                </td>
                                @if(!isset($sub['url']))
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_view" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_view", $roles->id) }}>
                                        </div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @else
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_view" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_view", $roles->id) }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_create" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_create", $roles->id) }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_edit" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_edit", $roles->id) }}>
                                    </div>
                                </td>
                                <td><div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_delete" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_delete", $roles->id) }}>
                                </div></td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_print" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_print", $roles->id) }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control" id="{{ $item }}" name="menu_hrd[]" value="{{ $hmenu."_".$item."_approve" }}" {{ App\Helpers\Hrdhelper::check_permission_user($hmenu."_".$item."_approve", $roles->id) }}>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                <tr>
                    <td colspan="7"><b>2- MENU HSE</b></td>
                </tr>
                <tr>
                    <td colspan="7"><b>3- MENU WORKSHOP</b></td>
                </tr>
                    {!! generate_menu_workshop($roles) !!}
                <tr>
                    <td colspan="7"><b>4- MENU PROJECT</b></td>
                </tr>
                <tr>
                    <td colspan="7"><b>5- MENU WAREHOUSE</b></td>
                </tr>
                    {!! generate_menu_warehouse($roles) !!}
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
