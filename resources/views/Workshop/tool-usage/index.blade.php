@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Tool Usage </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-tool_management.tool_usage.create'))
                                <button style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i>Create</button>
                            @endif
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('workshop.tool-usage.index') }}" method="GET">
                                        <div class="iq-email-search d-flex">
                                            @php
                                                $start = request()->get('start') ? date('Y-m-d', strtotime(request()->get('start'))) : '';
                                                $end = request()->get('end') ? date('Y-m-d', strtotime(request()->get('end'))) : '';
                                                $work_order_id = request()->has('work_order_id') ? request()->get('work_order_id') : null;
                                            @endphp
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 200px;" name="start"
                                                value="{{ $start }}">
                                            <small style="margin: 10px 5px;">to</small>
                                            <input type="date" class="form-control"
                                                style="height: 40px;border: 1px solid #eef0f4;width: 200px;" name="end"
                                                value="{{ $end }}">
                                            <div class="mr-3 position-relative">
                                                <div style="margin-left: 5px" class="form-group mb-0">
                                                    <select name="equipment_id" class="form-control">
                                                        <option value=""> Work Order </option>
                                                        @foreach ($work_orders as $work_order)
                                                            <option
                                                                {{ isset($work_order_id) && $work_order_id == $work_order->id ? 'selected' : '' }}
                                                                value="{{ $work_order->id }}">{{ $work_order->number }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <a class="search-link" href="#"><i class="ri-filter-line"></i></a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn iq-bg-success">Apply Filter</button>
                                        </div>
                                    </form>
                                    {{ $tool_usages->links('vendor.pagination.workshop') }}
                                </div>
                            </div>

                            <table class="table table-sm table-striped" style="font-size: 12px">
                                <thead style="text-align: center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Work Order</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Unit</th>
                                        <th scope="col">Mising/Broken</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                    @forelse ($tool_usages as $tool_usage)
                                        <tr>
                                            <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                            </th>
                                            <td>{{ $tool_usage->number }}</td>
                                            <td>{{ date('d-m-Y', strtotime($tool_usage->created_at)) }}</td>
                                            <td>{{ $tool_usage->toolable->number }}</td>
                                            <td></td>
                                            <td>{{ $tool_usage->toolable->equipment->name }}</td>
                                            <td>
                                                @if ($tool_usage->missings)
                                                    @foreach ($tool_usage->missings as $item)
                                                        <a style="font-size: 20px" target="_blank"
                                                            href="{{ route('workshop.tool-usage.print-missing', $item->id) }}"><i
                                                                class="ri-file-word-line"></i></a>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        @if ($tool_usage->editable() && current_user_has_permission_to('workshop-tool_management.tool_usage.edit'))
                                                            <a href="{{ route('workshop.tool-usage.missing', $tool_usage->id) }}"
                                                                class="btn btn-info">Missing/Broken</a>
                                                            <a class="btn btn-warning"
                                                                href="{{ route('workshop.tool-usage.edit', $tool_usage->id) }}">Edit</a>

                                                            @if (($tool_usage->missings->count() == 0) && current_user_has_permission_to('workshop-tool_management.tool_usage.delete'))
                                                                <form method="POST" id="delete-{{ $tool_usage->id }}"
                                                                    action="{{ route('workshop.tool-usage.delete', $tool_usage->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button onclick="confirmDelete({{ $tool_usage->id }});"
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
                            <!-- @if (current_user_has_permission_to('workshop-tool_management.tool_usage.print'))
                                <a target="_blank" href="{{ route('workshop.tool-usage.download', request()->all()) }}"
                                    class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
                            @endif -->
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

                        @forelse ($work_orders as $item)
                            <tr>
                                <td>{{ $item->number }}</td>
                                <td>{{ $item->equipment->name }}</td>
                                <td>
                                    <div class="d-block">
                                        <div class="btn-group  btn-group-sm" role="group">
                                            <a class="btn btn-primary"
                                                href="{{ route('workshop.tool-usage.add', $item->id) }}">Select</a>
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
