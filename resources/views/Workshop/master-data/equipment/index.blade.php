@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Equipment/Assets </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-master_data.equipment.create'))
                                <a style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    href="{{ route('workshop.master-data.equipment.add') }}"><i
                                        class="ri-add-line pr-0"></i></a>
                            @endif
                        </div>
                        <div class="iq-card-body">

                            <div class="iq-todo-page">
                                <form class="position-relative" method="GET"
                                    action="{{ route('workshop.master-data.equipment.index') }}">
                                    <div class="form-group mb-0">
                                        <input type="text" name="search" class="form-control todo-search"
                                            id="exampleInputEmail001" placeholder="Pencarian"
                                            value="{{ $search ? $search : '' }}">
                                        <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                                    </div>
                                </form>
                            </div>

                            <table class="table table-striped table-responsive table-sm" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Serial Number</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Production Year</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($equipments as $equipment)
                                        <tr>
                                            <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                            </th>
                                            <td>{{ $equipment->code }}</td>
                                            <td>{{ $equipment->name }}</td>
                                            <td>{{ $equipment->equipment_category->name }}</td>
                                            <td>{{ $equipment->brand->name }}</td>
                                            <td>{{ $equipment->serial_number }}</td>
                                            <td>{{ $equipment->model }}</td>
                                            <td>{{ $equipment->yop }}</td>
                                            <td><span
                                                    class="badge badge-{{ \App\Models\Workshop\Equipment::STATUS_COLOR[$equipment->status] }}">{{ \App\Models\Workshop\Equipment::STATUS[$equipment->status] }}</span>
                                            </td>
                                            <td>{{ $equipment->current_location->location_name }}</td>
                                            <td>{{ $equipment->pic_user->karyawan->nm_lengkap }}</td>
                                            <td><a style="font-size: 2em;"
                                                    href="{{ show_workshop_image($equipment->picture) }}"
                                                    target="_blank"><i class="ri-image-line"></i></a></td>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        @if (current_user_has_permission_to('workshop-master_data.equipment.edit'))
                                                            <a class="btn btn-warning"
                                                                href="{{ route('workshop.master-data.equipment.edit', $equipment->id) }}">Edit</a>
                                                            @if (current_user_has_permission_to('workshop-master_data.equipment.delete'))
                                                                <form method="POST" id="delete-{{ $equipment->id }}"
                                                                    action="{{ route('workshop.master-data.equipment.destroy', $equipment->id) }}">
                                                            @endif
                                                            @csrf
                                                            @method('delete')
                                                            <button onclick="confirmDelete({{ $equipment->id }});"
                                                                type="button" class="btn btn-danger">Hapus</a>
                                                                </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13">Belum ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $equipments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            $confirm = confirm('Anda Yakin?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }
    </script>
@endsection
