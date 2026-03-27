@extends('Workshop.layouts.master')
@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Work Requests </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-work_request.create'))
                                <a style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    href="{{ route('workshop.work-request.add') }}"><i class="ri-add-line pr-0"></i>Create</a>
                            @endif
                        </div>
                        <div class="iq-card-body" style="font-size: 12px">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('workshop.work-request.index') }}" method="GET">
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
                                    {{ $work_requests->links('vendor.pagination.workshop') }}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead style="text-align: center">
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Action</th>
                                          <th scope="col">Number</th>
                                          <th scope="col">Created at</th>
                                          <th scope="col">Unit</th>
                                          <th scope="col" style="min-width: 300px">Location</th>
                                          <th scope="col">Activity</th>
                                          <th scope="col">Priority</th>
                                          <th scope="col">Status</th>
                                          <th scope="col" style="min-width: 200px">description</th>
                                          <th scope="col">Approved By</th>
                                          <th scope="col">Approved At</th>
                                          <th scope="col">Scheduled At</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center">
                                        @forelse ($work_requests as $work_request)
                                            <tr>
                                                <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>
                                                <div class="d-block" style="text-align: left">
                                                  <div class="btn-group  btn-group-sm" role="group">
                                                    @if (!$work_request->approved_by)
                                                      @if (current_user_has_permission_to('workshop-work_request.approve'))
                                                        <a href="{{ route('workshop.work-request.schedule', $work_request->id) }}"
                                                           class="btn btn-sm iq-bg-success">Approve/Schedule</a>
                                                      @endif
                                                      @if (current_user_has_permission_to('workshop-work_request.edit'))
                                                        <a class="btn btn-sm btn-warning"
                                                           href="{{ route('workshop.work-request.edit', $work_request->id) }}">Edit</a>
                                                      @endif
                                                      @if (current_user_has_permission_to('workshop-work_request.delete'))
                                                        <form method="POST"
                                                              id="delete-{{ $work_request->id }}"
                                                              action="{{ route('workshop.work-request.delete', $work_request->id) }}">
                                                          @csrf
                                                          @method('delete')
                                                          <button
                                                            onclick="confirmDelete({{ $work_request->id }});"
                                                            type="button"
                                                            class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                      @endif
                                                    @endif
                                                    @if (current_user_has_permission_to('workshop-work_request.print'))
                                                      <a target="_blank"
                                                         href="{{ route('workshop.work-request.print', $work_request->id) }}"
                                                         class="btn btn-sm iq-bg-info">Print</a>
                                                    @endif
                                                  </div>
                                                </div>
                                              </td>
                                                <td>{{ $work_request->number }}</td>
                                                <td>{{ workshop_date($work_request->created_at) }}</td>
                                                <td>{{ $work_request->equipment->name }}</td>
                                                <td style="text-align: left">{{ $work_request->location->location_name }}
                                                </td>
                                                <td>{{ $work_request->activity }}</td>
                                                <td>{{ $work_request->priority }}</td>
                                                <td>{{ \App\Models\Workshop\WorkRequest::STATUS[$work_request->status] }}
                                                </td>
                                                <td>{{ $work_request->description }}</td>
                                                <td>{{ $work_request->approved ? $work_request->approved->karyawan->nm_lengkap : '' }}
                                                </td>
                                                <td>{{ $work_request->approved_at ? workshop_date($work_request->approved_at) : '' }}
                                                </td>
                                                <td>{{ $work_request->schedule ? workshop_date($work_request->schedule->date) : '' }}
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
                            @if (current_user_has_permission_to('workshop-work_request.print'))
                                <a target="_blank" href="{{ route('workshop.work-request.download', request()->all()) }}"
                                    class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
                            @endif
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
