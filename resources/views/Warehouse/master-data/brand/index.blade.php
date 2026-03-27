@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Brand </h4>
                            </div>
                            @if (current_user_has_permission_to('warehouse-master_data.brand.create'))
                                <button onclick="resetModal();" style="margin-top: auto" type="button"
                                    class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i
                                        class="ri-add-line pr-0"></i></button>
                            @endif

                        </div>
                        <div class="iq-card-body">
                            <p>Daftar master data brand</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aksi</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($brands as $brand)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        @if (current_user_has_permission_to('warehouse-master_data.brand.edit'))
                                                            <button onclick="editBrand(this);" type="button"
                                                                class="btn btn-warning" data-toggle="modal"
                                                                data-target="#addModal" data-id="{{ $brand->id }}"
                                                                data-name="{{ $brand->name }}"
                                                                data-description="{{ $brand->description }}">Edit</button>
                                                        @endif
                                                        @if (current_user_has_permission_to('warehouse-master_data.brand.delete'))
                                                            <form method="POST" id="delete-{{ $brand->id }}"
                                                                action="{{ route('warehouse.master-data.brand.destroy', $brand->id) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button onclick="confirmDelete({{ $brand->id }});"
                                                                    type="button" class="btn btn-danger">Hapus</a>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->description }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Brand Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addModalForm" action={{ route('warehouse.master-data.brand.store') }} method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Brand</label>
                            <input class="form-control" name="name" type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Deskripsi</label>
                            <input class="form-control" name="description" type="text" id="description">
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
        function editBrand(el) {
            $('#addModalForm').attr('action', '/master-data/brand/' + $(el).data('id'));
            $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
            $('input[name="name"]').val($(el).data('name'));
            $('input[name="description"]').val($(el).data('description'));
        }

        function resetModal(method = 'add') {

            if (method == 'add') {
                $('#addModalForm').attr('action', '/master-data/brand/');
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
