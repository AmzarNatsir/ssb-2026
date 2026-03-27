@extends('Workshop.layouts.master')

@section('content')
  <div id="content-page" class="content-page">
    <div class="cantainer-fluid">
      <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Issued</h4>
              </div>
              {{-- <a href="{{ route('warehouse.issued.add') }}" class="btn btn-success" ><i class="ri-add-line"></i></a> --}}
              @if (current_user_has_permission_to('warehouse-spare_part.issued.create'))
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                  <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="ri-add-line"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                      <a data-toggle="modal" data-target="#workshopModal" class="dropdown-item"
                         href="#">Workshop</a>
                      <a class="dropdown-item" href="{{ route('warehouse.issued.add') }}">General</a>
                      {{-- <a class="dropdown-item" href="{{ route('warehouse.purchasing-request.add',['type' => 3]) }}">Direct</a> --}}
                    </div>
                  </div>
                </div>
              @endif
            </div>
            <div class="iq-card-body">
              <form action="{{ route('warehouse.issued.index') }}" method="GET">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="">Search keyword</label>
                    <input type="text" class="form-control" placeholder="" name="keyword" value="{{ $keyword ?? ''  }}">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="">Date Start</label>
                    <input type="date" class="form-control" name="date_start" value="{{ $date_start ? date('Y-m-d', strtotime($date_start)) : '' }}">
                  </div>
                  <div class="form-group col-md-2">
                    <label for="">Date End</label>
                    <input type="date" class="form-control" name="date_end" value="{{ $date_end ? date('Y-m-d', strtotime($date_end)) : '' }}">
                  </div>
                  <div class="form-group col-md-2" style="margin-top: 2.1em">
                    <label for="">&nbsp;</label>
                    <button type="submit" class="btn btn-success">Search</button>
                  </div>
                </div>
              </form>
              <div class="table-responsive">
                <table class="table table-striped table-sm" style="font-size: 12px">
                  <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Aksi</th>
                    <th scope="col">Nomor</th>
                    <th scope="col">Keb/Unit</th>
                    <th scope="col">Taggal Pembuatan</th>
                    <th scope="col">Tanggal Terima</th>
                    <th scope="col">Diterima Oleh</th>
                    <th scope="col">Dibuat Oleh</th>
                    <th scope="col">Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>
                  @forelse ($issueds as $issued)
                    <tr>
                      <th scope="row">{{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                      </th>
                      <td>
                        <div class="d-block">
                          <div class="btn-group  btn-group-sm" role="group">
                            @if (current_user_has_permission_to('warehouse-spare_part.issued.print'))
                              <a target="_blank" class="btn btn-success"
                                 href="{{ route('warehouse.issued.print', $issued->id) }}">Print</a>
                            @endif
                            @if ($issued->editable() && current_user_has_permission_to('warehouse-spare_part.issued.edit'))
                              <a class="btn btn-warning"
                                 href="{{ route('warehouse.issued.edit', $issued->id) }}">Edit</a>
                              @if (current_user_has_permission_to('warehouse-spare_part.issued.delete'))
                                <form method="POST" id="delete-{{ $issued->id }}"
                                      action="{{ route('warehouse.issued.destroy', $issued->id) }}">
                                  @csrf
                                  @method('delete')
                                  <button
                                    onclick="confirmDelete({{ $issued->id }});"
                                    type="button" class="btn btn-danger">Hapus</button>
                                </form>
                              @endif
                            @endif
                          </div>
                        </div>
                      </td>
                      <td>{{ $issued->number }}</td>
                      @if ($issued->reference_id)
                        <td>{{ $issued?->work_order?->number }} /
                          {{ $issued?->work_order?->equipment?->code }} -
                          {{ $issued?->work_order?->equipment?->name }}</td>
                      @else
                        <td></td>
                      @endif
                      <td>{{ $issued->dateCreation }}</td>
                      <td>{{ $issued->getFormattedDate('received_at') }}</td>
                      <td>{{ $issued->received_by_user->nm_lengkap ?? '' }}</td>
                      <td>{{ $issued->created_user->karyawan->nm_lengkap ?? '' }}</td>
                      <td>{{ $issued->remarks }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="9">Belum ada data</td>
                    </tr>
                  @endforelse
                  </tbody>
                </table>
              </div>
              <a target="_blank" href="{{ route('warehouse.issued.download', request()->all()) }}"
                 class="btn iq-bg-info"><i class="ri-download-line"></i> Download Results</a>
              {{ $issueds->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- workshop modal --}}
  <div class="modal fade" id="workshopModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select Work Order</h5>
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
                         href="{{ route('warehouse.issued.add', ['id' => $item->id]) }}">Select</a>
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

    function confirmRelease(id) {
      $confirm = confirm('Selesaikan proses return?')
      if ($confirm) {
        $('#release-' + id).submit();
      }
    }
  </script>
@endsection
