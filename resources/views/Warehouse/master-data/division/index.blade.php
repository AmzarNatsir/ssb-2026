@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Divisi </h4>
                        </div>

                        <button onclick="resetModal();" style="margin-top: auto" type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i></button>

                    </div>
                    <div class="iq-card-body">
                        <p>Daftar master data divisi</p>
                        <table class="table table-striped">
                            <thead>
                               <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Aksi</th>
                                  <th scope="col">Divisi</th>
                               </tr>
                            </thead>
                            <tbody>
                                @forelse ($divisions as $division)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>
                                            <div class="d-block">
                                                <div class="btn-group  btn-group-sm " role="group" >
                                                    <button onclick="editDivision(this);" type="button" class="btn btn-warning" data-toggle="modal" data-target="#addModal" data-id="{{ $division->id }}" data-name="{{ $division->name }}" data-description="{{ $division->description }}" >Edit</button>
                                                    <form method="POST" id="delete-{{ $division->id }}" action="{{ route('warehouse.master-data.division.destroy',$division->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="confirmDelete({{ $division->id }});" type="button" class="btn btn-danger">Hapus</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $division->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Belum ada data</td>
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
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="exampleModalLabel">Tambah Divisi Baru</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body">
            <form id="addModalForm" action={{ route('warehouse.master-data.division.store') }} method="POST" >
                @csrf
                <div class="form-group">
                    <label for="email">Divisi</label>
                    <input class="form-control" name="name" type="text" id="name" required>
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

    function editDivision(el){
        $('#addModalForm').attr('action', '/master-data/division/'+$(el).data('id'));
        $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
        $('input[name="name"]').val($(el).data('name'));
    }

    function resetModal(method = 'add'){

        if (method == 'add') {
            $('#addModalForm').attr('action', '/master-data/division/');
            $('#addModalForm').find('input[name="_method"]').remove();
        }

        $('input[name="name"]').val('');
    }

    function confirmDelete(id){
        $confirm = confirm('Anda Yakin?')
        if ($confirm) {
            $('#delete-'+id).submit();
        }
    }
</script>
@endsection

