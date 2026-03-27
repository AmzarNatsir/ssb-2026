@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Scrap Database </h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <table class="table">
                                <thead style="text-align: center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Source</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Weight</th>
                                    </tr>
                                </thead>
                                <tbody style="text-align: center">
                                    @forelse ($scraps as $scrap)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ workshop_date($scrap->created_at) }}</td>
                                            <td>{{ $scrap->name }}</td>
                                            <td>{{ $scrap->number }}</td>
                                            <td>
                                                @if ($scrap->scrapable instanceof \App\Models\Workshop\WorkOrder)
                                                    <a target="_blank"
                                                        href="{{ route('workshop.work-order.print', $scrap->scrapable->id) }}">{{ $scrap->scrapable->number }}</a>
                                                @endif
                                            </td>
                                            <td>{{ $scrap->qty }}</td>
                                            <td>{{ $scrap->weight }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No Data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- <a target="_blank" href="{{ route('workshop.tool-usage.download', request()->all()) }}" class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a> --}}
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
