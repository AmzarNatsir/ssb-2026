@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Tools </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-master_data.tools.create'))
                                <button onclick="resetModal();" style="margin-top: auto" type="button"
                                    class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i
                                        class="ri-add-line pr-0"></i></button>
                            @endif

                        </div>
                        <div class="iq-card-body">
                            <p>Tools list</p>
                            <table class="table table-sm table-striped" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tools as $tool)
                                        <tr>
                                            <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                            </th>
                                            <td>{{ $tool->code }}</td>
                                            <td>{{ $tool->name }}</td>
                                            <td>{{ $tool->qty }}</td>
                                            <td>{{ $tool->location }}</td>
                                            <td>{{ $tool->category->name }}</td>
                                            <td>
                                                @if ($tool->picture)
                                                    <a style="font-size: 2em;" href="{{ show_workshop_image($tool->picture) }}" target="_blank"><i
                                                            class="ri-image-line"></i></a>
                                            </td>
                                    @endif
                                    <td>
                                        <div class="d-block">
                                            <div class="btn-group  btn-group-sm" role="group">
                                                @if (current_user_has_permission_to('workshop-master_data.tools.print'))
                                                    <a target="_blank" title="Tool History" class="btn btn-info"
                                                        href="{{ route('workhsop.master-data.tools.history', $tool->id) }}"><i
                                                            class="ri-book-open-line"></i></a>
                                                @endif
                                                @if (current_user_has_permission_to('workshop-master_data.tools.edit'))
                                                    <button onclick="editBrand(this);" type="button"
                                                        class="btn btn-warning" data-toggle="modal" data-target="#addModal"
                                                        data-id="{{ $tool->id }}" data-code="{{ $tool->code }}"
                                                        data-name="{{ $tool->name }}" data-qty="{{ $tool->qty }}"
                                                        data-location="{{ $tool->location }}"
                                                        data-category="{{ $tool->tool_category_id }}"
                                                        data-picture="{{ $tool->picture }}">Edit</button>
                                                @endif
                                                @if (current_user_has_permission_to('workshop-master_data.tools.delete'))
                                                    <form method="POST" id="delete-{{ $tool->id }}"
                                                        action="{{ route('workshop.master-data.tools.destroy', $tool->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="confirmDelete({{ $tool->id }});"
                                                            type="button" class="btn btn-danger">Delete</a>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No Data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $tools->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Create new tool</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addModalForm" action={{ route('workshop.master-data.tools.store') }} method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="email">Code</label>
                            <input class="form-control" name="code" type="text" id="code" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Name</label>
                            <input class="form-control" name="name" type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Qty</label>
                            <input class="form-control" name="qty" type="number" id="qty" min=1 required>
                        </div>
                        <div class="form-group">
                            <label for="email">Location</label>
                            <input class="form-control" name="location" type="text" id="location">
                        </div>
                        <div class="form-group">
                            <label for="email">Category</label>
                            <select name="tool_category_id" id="tool_category_id" class="form-control">
                                <option value="">Please Choose</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="picture">
                                <label class="custom-file-label" for="customFile">Picture</label>
                                <small>Choose another image to replace previous one</small>
                            </div>
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
        var toolsCategories = {!! $tool_categories !!};
        $('#tool_category_id').html(generateOption());


        function editBrand(el) {
            $('#addModalForm').attr('action', '/master-data/tools/' + $(el).data('id'));
            $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
            $('input[name="code"]').val($(el).data('code'));
            $('input[name="name"]').val($(el).data('name'));
            $('input[name="qty"]').val($(el).data('qty'));
            $('input[name="location"]').val($(el).data('location'));

            $('#tool_category_id').html(generateOption($(el).data('category')));
        }

        function generateOption(selectedId = null) {
            var option = '<option value="">Please Choose</option>';

            for (let i = 0; i < toolsCategories.length; i++) {
                if (selectedId == toolsCategories[i].id) {
                    option += '<option selected value="' + toolsCategories[i].id + '">' + toolsCategories[i].name +
                        '</option>';
                } else {
                    option += '<option value="' + toolsCategories[i].id + '">' + toolsCategories[i].name + '</option>';
                }
            }

            return option;
        }

        function resetModal(method = 'add') {

            if (method == 'add') {
                $('#addModalForm').attr('action', '/master-data/tools/');
                $('#addModalForm').find('input[name="_method"]').remove();
            }

            $('input[name="name"]').val('');
        }

        function confirmDelete(id) {
            $confirm = confirm('Anda Yakin?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }
    </script>
@endsection
