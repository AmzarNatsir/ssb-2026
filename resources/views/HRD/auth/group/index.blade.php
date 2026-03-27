@extends('HRD.layouts.master')
@section('content')
    <div class="navbar-breadcrumb">
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Setup</li>
                <li class="breadcrumb-item"><a href="{{ url('hrd/setup/manajemengroup') }}">Manajemen Group Pengguna
                        (F5)</a></li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            @if (\Session::has('konfirm'))
                <div class="alert text-white bg-success" role="alert" id="success-alert">
                    <div class="iq-alert-icon">
                        <i class="ri-alert-line"></i>
                    </div>
                    <div class="iq-alert-text">{{ \Session::get('konfirm') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="iq-card" id="form_view">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="fa fa-plus"></i> Input Data Baru</h4>
                    </div>
                </div>
                <div class="iq-card-body" style="width:100%; height:auto">
                    <form action="{{ url('hrd/setup/manajemengroup/simpan') }}" method="POST" onsubmit="return konfirm()">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-sm-4">Nama Group</label>
                            <div class="col-sm-8">
                                <input type="text" name="inp_nama_group" id="inp_nama_group" class="form-control"
                                    maxlength="150" required>
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
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_view' }}">
                                                            </div>
                                                        </td>
                                                        <td colspan="5"></td>
                                                    @elseif(isset($value['submenu']) && !isset($value['url']))
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_view' }}">
                                                            </div>
                                                        </td>
                                                        <td colspan="5"></td>
                                                    @else
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_view' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_create' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_edit' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_delete' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_print' }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control"
                                                                    id="{{ $key }}" name="menu_hrd[]"
                                                                    value="{{ $key . '_approve' }}">
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
                                                                            value="{{ $hmenu . '_' . $item . '_view' }}">
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
                                                                            value="{{ $hmenu . '_' . $item . '_view' }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control"
                                                                            id="{{ $item }}" name="menu_hrd[]"
                                                                            value="{{ $hmenu . '_' . $item . '_create' }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control"
                                                                            id="{{ $item }}" name="menu_hrd[]"
                                                                            value="{{ $hmenu . '_' . $item . '_edit' }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control"
                                                                            id="{{ $item }}" name="menu_hrd[]"
                                                                            value="{{ $hmenu . '_' . $item . '_delete' }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control"
                                                                            id="{{ $item }}" name="menu_hrd[]"
                                                                            value="{{ $hmenu . '_' . $item . '_print' }}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control"
                                                                            id="{{ $item }}" name="menu_hrd[]"
                                                                            value="{{ $hmenu . '_' . $item . '_approve' }}">
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
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_view' }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control"
                                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_create' }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control"
                                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_edit' }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control"
                                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_delete' }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control"
                                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_print' }}">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control"
                                                                                id="{{ $item_2 }}" name="menu_hrd[]"
                                                                                value="{{ $hmenu_sub . '_' . $item_2 . '_approve' }}">
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
                                    <div class="col-lg-12" style="margin-top: 2rem">
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

                                            {!! generate_menu_warehouse() !!}

                                        </table>
                                    </div>

                                    <div class="col-lg-12" style="margin-top: 2rem">
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

                                            {!! generate_menu_workshop() !!}

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
                        <button type="submit" id="tbl_simpan" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="fa fa-table"></i> Daftar Group Pengguna</h4>
                    </div>
                </div>
                <div class="iq-card-body" style="width:100%; height:auto">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <th style="width: 5%;">No.</th>
                            <th style="width: 65%;">Nama Group</th>
                            <th style="width: 30%;">Aksi</th>
                        </thead>
                        <tbody>

                            @php $nom=1; @endphp
                            @foreach ($roles as $key => $value)
                                <tr>
                                    <td>{{ $nom }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary mb-2 btn_edit"
                                            id="{{ $value->id }}"><i class="ri-edit-fill pr-0"></i></button>
                                        <a href="{{ url('hrd/setup/manajemengroup/hapus/' . $value->id) }}"
                                            class="btn btn-danger mb-2" onClick="return konfirmHapus()"><i
                                                class="ri-delete-bin-line pr-0"></i></a>
                                    </td>
                                </tr>
                        </tbody>
                        @php $nom++; @endphp
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Data Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view_form"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function checkAll(el) {
            let parentEl = $(el).parent('tr');
            parentEl.find('input[type="checkbox"]').each(function(key, item) {
                // console.log($(item).prop('checked'));
                if ($(item).prop('checked')) {
                    $(item).prop('checked', false);
                } else {
                    $(item).prop('checked', true);
                }
            })
        }

        $(document).ready(function() {
            window.setTimeout(function() {
                $("#success-alert").alert('close');
            }, 2000);
            $(".tbl_add").on("click", function() {
                $("#view_form").load("{{ url('hrd/setup/manajemenmenu/tambah') }}")
            });
            $(".btn_edit").on("click", function() {
                var id_data = this.id;
                $('#loading').show();
                $("#form_view").load("{{ url('hrd/setup/manajemengroup/edit') }}/" + id_data,
                    function() {
                        $('#loading').hide();
                    });
            });
        });

        function konfirm() {
            var psn = confirm("Yakin akan menyimpan data ?");
            if (psn == true) {
                return true;
            } else {
                return false;
            }
        }

        function konfirmHapus() {
            var psn = confirm("Yakin akan Menghapus data ?");
            if (psn == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
