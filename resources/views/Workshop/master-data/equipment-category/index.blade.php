@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Equipment Category </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-master_data.equipment_category.create'))
                                <button onclick="resetModal();" style="margin-top: auto" type="button"
                                    class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i
                                        class="ri-add-line pr-0"></i></button>
                            @endif

                        </div>
                        <div class="iq-card-body">
                            <p>Equipment category list</p>
                            <table class="table table-sm table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($equipment_categories as $category)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->description }}</td>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        @if (current_user_has_permission_to('workshop-master_data.equipment_category.edit'))
                                                            <button onclick="editBrand(this);" type="button"
                                                                class="btn btn-warning" data-toggle="modal"
                                                                data-target="#addModal" data-id="{{ $category->id }}"
                                                                data-name="{{ $category->name }}"
                                                                data-description="{{ $category->description }}">Edit</button>
                                                        @endif
                                                        @if (current_user_has_permission_to('workshop-master_data.equipment_category.delete'))
                                                            <form method="POST" id="delete-{{ $category->id }}"
                                                                action="{{ route('workshop.master-data.equipment-category.destroy', $category->id) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button onclick="confirmDelete({{ $category->id }});"
                                                                    type="button" class="btn btn-danger">Delete</a>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No Data</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Create new equipment category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addModalForm" action={{ route('workshop.master-data.equipment-category.store') }}
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Name</label>
                            <input class="form-control" name="name" type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Description</label>
                            <textarea name="description" id="" cols="30" rows="3" class="form-control"></textarea>
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
            $('#addModalForm').attr('action', '/master-data/equipment-category/' + $(el).data('id'));
            $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
            $('input[name="name"]').val($(el).data('name'));
            $('textarea[name="description"]').val($(el).data('description'));
        }

        function resetModal(method = 'add') {

            if (method == 'add') {
                $('#addModalForm').attr('action', '/master-data/equipment-category/');
                $('#addModalForm').find('input[name="_method"]').remove();
            }

            $('input[name="name"]').val('');
            $('textarea[name="description"]').val('');
        }

        function confirmDelete(id) {
            $confirm = confirm('Are you sure?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }
    </script>
@endsection
