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
        <div class="col-lg-12">
            <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">Daftar Group Pengguna</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="table-responsive">
                        <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-12">
                                <div class="user-list-files d-flex float-right">
                                    <a href="javascript:void();" class="btn btn-primary mb-2 tbl_add" data-toggle="modal"
                                        data-target="#ModalForm"><i class='fa fa-plus'></i> Group Baru</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <button type="button" class="btn btn-success mb-2 btn_edit"
                                                id="{{ $value->id }}" data-toggle="modal" data-target="#ModalRole"><i
                                                    class="ri-user-fill pr-0"></i>Role Akses</button>
                                            <a href="{{ url('hrd/setup/manajemengroup/hapus/' . $value->id) }}"
                                                class="btn btn-danger mb-2" onClick="return konfirmHapus()"><i
                                                    class="ri-delete-bin-line pr-0"></i>Hapus Group</a>
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
    </div>

    <!--Modal -->
    <div id="ModalForm" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content" id="v_form"></div>
        </div>
    </div>

    <div id="ModalRole" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" id="v_form_role"></div>
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
                $("#v_form").load("{{ url('hrd/setup/manajemengroup/add') }}")
            });

            $(".btn_edit").on("click", function() {
                var id_data = this.id;
                $("#v_form_role").load("{{ url('hrd/setup/manajemengroup/edit') }}/" + id_data);
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
