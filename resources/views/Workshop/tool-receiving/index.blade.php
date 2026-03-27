@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Tool Receiving </h4>
                            </div>
                            @if (current_user_has_permission_to('workshop-tool_management.tool_receiving.create'))
                                <a class="btn btn-success mb-3" href="{{ route('workshop.tool-receiving.add') }}"><i
                                        class="ri-add-line pr-0"></i></a>
                            @endif
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-email-to-list p-3">
                                <div class="d-flex justify-content-between">
                                    <form action="{{ route('workshop.tool-receiving.index') }}" method="GET">
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
                                                style="height: 40px;border: 1px solid #eef0f4;width: 200px;margin-right:5px"
                                                name="end" value="{{ $end }}">
                                            {{-- <div class="mr-3 position-relative">
                                            <div style="margin-left: 5px" class="form-group mb-0">
                                                <select name="equipment_id" class="form-control">
                                                    <option value=""> Work Order </option>
                                                    @foreach ($work_orders as $work_order)
                                                        <option {{ isset($work_order_id) && $work_order_id == $work_order->id ? 'selected' : '' }}  value="{{ $work_order->id }}">{{ $work_order->number }}</option>
                                                    @endforeach
                                                </select>
                                                <a class="search-link" href="#"><i class="ri-filter-line"></i></a>
                                            </div>
                                        </div> --}}
                                            <button type="submit" class="btn iq-bg-success">Apply Filter</button>
                                        </div>
                                    </form>
                                    {{ $toolsReceivings->links('vendor.pagination.workshop') }}
                                </div>
                            </div>

                            <table class="table table-sm table-striped" style="font-size: 12px">
                                <thead style="text-align: center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Supplier</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                    @forelse ($toolsReceivings as $toolsReceiving)
                                        <tr>
                                            <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                            </th>
                                            <td>{{ $toolsReceiving->number }}</td>
                                            <td>{{ date('d-m-Y', strtotime($toolsReceiving->created_at)) }}</td>
                                            <td>{{ $toolsReceiving->supplier?->name }}</td>
                                            <td>{{ $toolsReceiving->description }}</td>
                                            <td>
                                                <div class="d-block">
                                                    <div class="btn-group  btn-group-sm" role="group">
                                                        @if ($toolsReceiving->editable() && current_user_has_permission_to('workshop-tool_management.tool_receiving.delete'))
                                                            <a class="btn btn-warning"
                                                                href="{{ route('workshop.tool-receiving.edit', $toolsReceiving->id) }}">Edit</a>
                                                            @if (current_user_has_permission_to('workshop-tool_management.tool_receiving.delete'))
                                                                <form method="POST" id="delete-{{ $toolsReceiving->id }}"
                                                                    action="{{ route('workshop.tool-receiving.delete', $toolsReceiving->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button
                                                                        onclick="confirmDelete({{ $toolsReceiving->id }});"
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
                                            <td colspan="6">No Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- @if (current_user_has_permission_to('workshop-tool_management.tool_receiving.print'))
                                <a target="_blank" href="{{ route('workshop.tool-receiving.download', request()->all()) }}"
                                    class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
                            @endif -->
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
