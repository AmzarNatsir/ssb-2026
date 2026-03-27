@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
          @include('Workshop.partials._flash_mesage')
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Work Orders </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-work_order.create'))
                                <button style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i></button>
                            @endif
                        </div>
                        <div class="iq-card-body" style="font-size: 12px">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('workshop.work-order.index') }}" method="GET">
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
                                                        <option value="location"
                                                            {{ $type == 'location' ? 'selected' : '' }}>
                                                            Location</option>
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
                                    {{ $work_orders->links('vendor.pagination.workshop') }}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead style="text-align: center">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col"></th>
                                            <th scope="col">Number</th>
                                            <th scope="col">Work Request Number</th>
                                            <th scope="col">Created at</th>
                                            <th scope="col">Unit</th>
                                            <th scope="col" style="min-width: 200px">Project</th>
                                            <th scope="col" style="min-width: 200px">Location</th>
                                            <th scope="col">Operator/Driver</th>
                                            <th scope="col">Activity</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date/Time Start</th>
                                            <th scope="col">Date/Time Finish</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        @forelse ($work_orders as $work_order)
                                            <tr>
                                                <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button"
                                                            class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-menu-line"></i> Actions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                          <a class="dropdown-item"
                                                            href="{{ route('workshop.work-order.show-inspection', $work_order->id) }}">Form Inspection</a>
                                                            @if($work_order->unitInspection->id)
                                                              <a class="dropdown-item" target="_blank"
                                                                 href="{{ route('workshop.work-order.print-inspection', $work_order->id) }}">Print Inspection</a>
                                                            @endif
                                                            @if (
                                                                $work_order->status == \App\Models\Workshop\WorkOrder::STATUS_OPEN &&
                                                                    current_user_has_permission_to('workshop-work_order.create'))
                                                                <a href="{{ route('workshop.work-order.complete', Crypt::encryptString($work_order->id)) }}"
                                                                    class="dropdown-item">Complete</a>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('workshop.work-order.edit', $work_order->id) }}">Update
                                                                    Progress</a>
                                                            @endif
                                                            @if (current_user_has_permission_to('workshop-work_order.print'))
                                                                <a target="_blank"
                                                                    href="{{ route('workshop.work-order.print', $work_order->id) }}"
                                                                    class="dropdown-item">Print</a>
                                                            @endif
                                                            @if (
                                                                $work_order->status == \App\Models\Workshop\WorkOrder::STATUS_OPEN &&
                                                                    current_user_has_permission_to('workshop-work_order.delete'))
                                                                <form method="POST" id="delete-{{ $work_order->id }}"
                                                                    action="{{ route('workshop.work-order.delete', $work_order->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button onclick="confirmDelete({{ $work_order->id }});"
                                                                        type="button" class="dropdown-item">Delete</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $work_order->number }}</td>
                                                <td>{{ $work_order->work_request->number }}</td>
                                                <td>{{ workshop_date_format($work_order->created_at) }}</td>
                                                <td>{{ $work_order->equipment->name }}</td>
                                                <td>{{ $work_order->project->name }}</td>
                                                <td>{{ $work_order->location->location_name }}</td>
                                                <td>{{ $work_order->driver?->nm_lengkap }}</td>
                                                <td>{{ $work_order->work_request->activity }}</td>
                                                <td>{{ $work_order->status == \App\Models\Workshop\WorkOrder::STATUS_OPEN ? 'OPEN' : 'CLOSED' }}
                                                </td>
                                                <td>{{ workshop_datetime($work_order->date_start) }}</td>
                                                <td>{{ workshop_datetime($work_order->date_finish) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13">No Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if (current_user_has_permission_to('workshop-work_order.print'))
                                <a target="_blank" href="{{ route('workshop.work-order.download', request()->all()) }}"
                                    class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Work Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <td>Number</td>
                            <td>Unit</td>
                            <td>Action</td>
                        </tr>

                        @forelse ($work_requests as $item)
                            <tr>
                                <td>{{ $item->number }}</td>
                                <td>{{ $item->equipment->name }}</td>
                                <td>
                                    <div class="d-block">
                                        <div class="btn-group  btn-group-sm" role="group">
                                            <a class="btn btn-primary"
                                                href="{{ route('workshop.work-order.add', $item->id) }}">Select</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No data</td>
                            </tr>
                        @endforelse

                    </table>
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
