@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            @if (session('status'))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert text-white bg-success" role="alert">
                            <div class="iq-alert-text">{{ session('status') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card" style="font-size: 12px">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Operating Sheet </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-operating_sheet.create'))
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ri-add-line"></i>
                                            Add Operating Sheet
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a  class="dropdown-item"
                                                href="{{ route('workshop.inspection.add') }}">Form</a>
                                            <a data-toggle="modal" data-target="#workshopModal" class="dropdown-item"
                                                href="">Import</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('workshop.inspection.index') }}" method="GET">
                                        <div class="iq-email-search d-flex">
                                            @php
                                                $start = request()->get('start') ? date('Y-m-d', strtotime(request()->get('start'))) : '';
                                                $end = request()->get('end') ? date('Y-m-d', strtotime(request()->get('end'))) : '';
                                                $keyword = request()->get('keyword') ? request()->get('keyword') : '';
                                                $type = request()->get('type') ? request()->get('type') : '';
                                            @endphp
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 150px;font-size:11px"
                                                name="start" value="{{ $start }}">
                                            <small style="margin: 10px 5px;">to</small>
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 150px;;font-size:11px"
                                                name="end" value="{{ $end }}">
                                            <div class="mr-3 position-relative">
                                                <div style="margin-left: 5px" class="form-group mb-0">
                                                    <select name="type" class="form-control" style="max-width: 200px">
                                                        <option value=""> Filter By </option>
                                                        <option value="equipment"
                                                            {{ $type == 'equipment' ? 'selected' : '' }}>
                                                            Unit</option>
                                                        <option value="project" {{ $type == 'project' ? 'selected' : '' }}>
                                                            Project</option>
                                                    </select>
                                                    <a class="search-link" href="#"><i class="ri-filter-line"></i></a>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;min-width: 200px;margin-right:5px"
                                                name="keyword" placeholder="keyword" value="{{ $keyword }}">
                                            <button type="submit" class="btn iq-bg-success">Apply Filter</button>
                                        </div>
                                    </form>
                                    {{ $inspections->links('vendor.pagination.workshop') }}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table  table-sm table-striped">
                                    <thead style="text-align: center">
                                        <tr>
                                            <th scope="col" rowspan="2">#</th>
                                            <th scope="col" rowspan="2">Date</th>
                                            <th scope="col" rowspan="2">Unit</th>
                                            <th scope="col" rowspan="2">Project</th>
                                            <th scope="col" rowspan="2">Operator</th>
                                            <th scope="col" rowspan="2">Shift</th>
                                            <th scope="col" colspan="2">KM/HM</th>
                                            <th scope="col" rowspan="2">OH</th>
                                            <th scope="col" colspan="2">Standby</th>
                                            <th scope="col" colspan="2">Breakdown</th>
                                            <th scope="col" rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col">Hour</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Hour</th>
                                            <th scope="col">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        @forelse ($inspections as $inspection)
                                            <tr>
                                                <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>{{ workshop_date($inspection->date) }}</td>
                                                <td>{{ $inspection->equipment->name }}</td>
                                                <td>{{ $inspection->project->name }}</td>
                                                <td>{{ $inspection->driver->nm_lengkap }}</td>
                                                <td>{{ $inspection->shift == 1 ? 'I' : 'II' }}</td>
                                                <td>{{ $inspection->km_start }}/{{ $inspection->hm_start }}</td>
                                                <td>{{ $inspection->km_end }}/{{ $inspection->hm_end }}</td>
                                                <td>{{ $inspection->operating_hour }}</td>
                                                <td>{{ $inspection->standby_hour }}</td>
                                                <td>{{ $inspection->standby_description }}</td>
                                                <td>{{ $inspection->breakdown_hour }}</td>
                                                <td>{{ $inspection->breakdown_description }}</td>
                                                <td>
                                                    <div class="d-block">
                                                        <div class="btn-group  btn-group-sm" role="group">
                                                            @if ($inspection->editable() && current_user_has_permission_to('workshop-operating_sheet.edit'))
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('workshop.inspection.edit', $inspection->id) }}">Edit</a>
                                                                @if (current_user_has_permission_to('workshop-operating_sheet.delete'))
                                                                    <form method="POST" id="delete-{{ $inspection->id }}"
                                                                        action="{{ route('workshop.inspection.delete', $inspection->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button
                                                                            onclick="confirmDelete({{ $inspection->id }});"
                                                                            type="button" class="btn btn-danger">Delete</a>
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13">No Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                @if (current_user_has_permission_to('workshop-operating_sheet.print'))
                                    <a target="_blank" href="{{ route('workshop.inspection.download', request()->all()) }}"
                                        class="btn bg-info"><i class="ri-download-line"></i> Download Results</a>
                                @endif
                                <a target="_blank" href="{{ route('workshop.inspection.download_template') }}"
                                    class="btn bg-warning"><i class="ri-download-line"></i> Download Template</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="workshopModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Operating Sheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('workshop.inspection.import') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Template</label>
                            <input name="inspection_import" type="file" class="form-control-file" id="exampleFormControlFile1">
                         </div>
                         <div class="form-group">
                            <button class="btn btn-info" type="submit">Import</button>
                         </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
