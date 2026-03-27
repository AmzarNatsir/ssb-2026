@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">UOM ( Unit Of Measurement )</h4>
                            </div>

                            <button onclick="resetModal();" style="margin-top: auto" type="button"
                                class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i
                                    class="ri-add-line pr-0"></i></button>

                        </div>
                        <div class="iq-card-body">
                            <p>Daftar master data uop</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aksi</th>
                                        <th scope="col">Uop</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($uops as $uop)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        <button onclick="editUop(this);" type="button"
                                                            class="btn btn-warning" data-toggle="modal"
                                                            data-target="#addModal" data-id="{{ $uop->id }}"
                                                            data-name="{{ $uop->name }}"
                                                            data-description="{{ $uop->description }}">Edit</button>
                                                        <form method="POST" id="delete-{{ $uop->id }}"
                                                            action="{{ route('warehouse.master-data.uop.destroy', $uop->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button onclick="confirmDelete({{ $uop->id }});"
                                                                type="button" class="btn btn-danger">Hapus</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $uop->name }}</td>
                                            <td>{{ $uop->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Add New Modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Uom Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addModalForm" action={{ route('warehouse.master-data.uop.store') }} method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">UOM</label>
                            <input class="form-control" name="name" type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Deskripsi</label>
                            <input class="form-control" name="description" type="text" id="description" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitAdd" type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // $('#submitAdd').on('click', function(){
            //     $('#addModalForm').submit();
            // });

        })

        function editUop(el) {
            $('#addModalForm').attr('action', '/master-data/uop/' + $(el).data('id'));
            $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
            $('input[name="name"]').val($(el).data('name'));
            $('input[name="description"]').val($(el).data('description'));
        }

        function resetModal(method = 'add') {

            if (method == 'add') {
                $('#addModalForm').attr('action', '/master-data/uop/');
                $('#addModalForm').find('input[name="_method"]').remove();
            }

            $('input[name="name"]').val('');
            $('input[name="description"]').val('');
        }

        function confirmDelete(id) {
            $confirm = confirm('Anda Yakin?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }
    </script>
@endsection
