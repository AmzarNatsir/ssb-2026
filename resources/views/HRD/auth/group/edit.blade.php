<div class="iq-card-header d-flex justify-content-between">
    <div class="iq-header-title">
        <h4 class="card-title"><i class="fa fa-edit"></i> Edit Permission Group</h4>
    </div>
</div>
<div class="iq-card-body" style="width:100%; height:auto">
    <form action="{{ url('hrd/setup/manajemengroup/update/' . $roles->id) }}" method="POST"
        onsubmit="return konfirm()">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-group row">
            <label class="col-sm-4">Nama Group</label>
            <div class="col-sm-8">
                <input type="text" name="inp_nama_group" id="inp_nama_group" class="form-control" maxlength="100"
                    value="{{ $roles->name }}" required>
            </div>
        </div>
        <hr>
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title ">Daftar Menu</h4>
                </div>
            </div>
            <div class="iq-card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="iq-header-title">
                            <h4 class="card-title ">Modul HRD</h4>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <td rowspan="2" style="width: 50%">Menu</td>
                                <td colspan="6">Permission</td>
                            </tr>
                            <tr>
                                <td>View</td>
                                <td>Create</td>
                                <td>Edit</td>
                                <td>Delete</td>
                                <td>Print</td>
                                <td>Approve</td>
                            </tr>
                            @foreach (Config::get('constants.menu.hrd') as $key => $value)
                                <tr>
                                    <td>
                                        @php
                                        $menu = str_replace('_', ' ', $key); @endphp
                                        <b>{{ strtoupper($menu) }}</b>
                                    </td>
                                    @if (!isset($value['submenu']))
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_view' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_view', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td colspan="5"></td>
                                    @elseif(isset($value['submenu']) && !isset($value['url']))
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_view' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_view', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td colspan="5"></td>
                                    @else
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_view' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_view', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_create' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_create', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_edit' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_edit', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_delete' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_delete', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_print' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_print', $roles->id) }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control" id="{{ $key }}"
                                                    name="menu_hrd[]" value="{{ $key . '_approve' }}"
                                                    {{ App\Helpers\Hrdhelper::check_permission_user($key . '_approve', $roles->id) }}>
                                            </div>
                                        </td>
                                    @endif

                                </tr>
                                @if (isset($value['submenu']))
                                    @php $hmenu = $key @endphp
                                    @foreach ($value['submenu'] as $item => $sub)
                                        <tr>
                                            <td>@php
                                            $menu = str_replace('_', ' ', $item); @endphp
                                                - {!! isset($sub['submenu']) ? '<b>' . strtoupper($menu) . '</b>' : strtoupper($menu) !!}
                                            </td>
                                            @if (!isset($sub['url']))
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_view' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . '_view', $roles->id) }}>
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
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_view' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . '_view', $roles->id) }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_create' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . 'create', $roles->id) }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_edit' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . 'edit', $roles->id) }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_delete' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . '_delete', $roles->id) }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_print' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . '_print', $roles->id) }}>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control"
                                                            id="{{ $item }}" name="menu_hrd[]"
                                                            value="{{ $hmenu . '_' . $item . '_approve' }}"
                                                            {{ App\Helpers\Hrdhelper::check_permission_user($hmenu . '_' . $item . '_approve', $roles->id) }}>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        @if (isset($sub['submenu']))
                                            @php $hmenu_sub = $hmenu."_".$item @endphp
                                            @foreach ($sub['submenu'] as $item_2 => $sub_2)
                                                <tr>
                                                    <td>
                                                        @php $menu_sub = str_replace("_", " ", $item_2) @endphp
                                                        -- {{ strtoupper($menu_sub) }}
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_view' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_view', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_create' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_create', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_edit' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_edit', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_delete' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_delete', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_print' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_print', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control"
                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_approve' }}"
                                                                {{ App\Helpers\Hrdhelper::check_permission_user($hmenu_sub . '_' . $item_2 . '_approve', $roles->id) }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <div class="iq-header-title">
                            <h4 class="card-title ">Modul WAREHOUSE</h4>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <td rowspan="2" style="width: 50%">Menu</td>
                                <td colspan="6">Permission</td>
                            </tr>
                            <tr>
                                <td>View</td>
                                <td>Create</td>
                                <td>Edit</td>
                                <td>Delete</td>
                                <td>Print</td>
                                <td>Approve</td>
                            </tr>

                            {!! generate_menu_warehouse($roles) !!}

                        </table>
                    </div>
                    <div class="col-lg-12">
                        <div class="iq-header-title">
                            <h4 class="card-title ">Modul WORKSHOP</h4>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <td rowspan="2" style="width: 50%">Menu</td>
                                <td colspan="6">Permission</td>
                            </tr>
                            <tr>
                                <td>View</td>
                                <td>Create</td>
                                <td>Edit</td>
                                <td>Delete</td>
                                <td>Print</td>
                                <td>Approve</td>
                            </tr>

                            {!! generate_menu_workshop($roles) !!}

                        </table>
                    </div>
                    <div class="col-lg-12">
                        <div class="iq-header-title">
                            <h4 class="card-title ">Modul TENDER</h4>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="iq-header-title">
                            <h4 class="card-title ">Modul HSE</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" id="tbl_update" class="btn btn-primary">Submit</button>
    </form>
</div>
