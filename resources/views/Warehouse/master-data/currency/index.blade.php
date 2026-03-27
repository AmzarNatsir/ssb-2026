@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Mata Uang </h4>
                        </div>

                        <button onclick="resetModal();" style="margin-top: auto" type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addModal"><i class="ri-add-line pr-0"></i></button>

                    </div>
                    <div class="iq-card-body">
                        <p>Daftar master data mata uang</p>
                        <table class="table table-striped">
                            <thead>
                               <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Aksi</th>
                                  <th scope="col">Mata uang</th>
                                  <th scope="col">Kode mata uang</th>
                                  <th scope="col">Simbol</th>
                               </tr>
                            </thead>
                            <tbody>
                                @forelse ($currencies as $currency)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>
                                            <div class="d-block">
                                                <div class="btn-group  btn-group-sm" role="group" >
                                                    <button onclick="editBrand(this);" type="button" class="btn btn-warning" data-toggle="modal" data-target="#addModal" data-id="{{ $currency->id }}" data-name="{{ $currency->name }}" data-code="{{ $currency->code }}" data-symbol="{{ $currency->symbol }}" >Edit</button>
                                                    <form method="POST" id="delete-{{ $currency->id }}" action="{{ route('warehouse.master-data.currency.destroy',$currency->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button onclick="confirmDelete({{ $currency->id }});" type="button" class="btn btn-danger">Hapus</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $currency->name }}</td>
                                        <td>{{ $currency->code }}</td>
                                        <td>{{ $currency->symbol }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada data</td>
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
             <h5 class="modal-title" id="exampleModalLabel">Tambah Mata Uang Baru</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body">
            <form id="addModalForm" action={{ route('warehouse.master-data.currency.store') }} method="POST" >
                @csrf
                <div class="form-group">
                    <label for="email">Mata Uang</label>
                    <input class="form-control" name="name" type="text" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Kode Mata Uang</label>
                    <input class="form-control" name="code" type="text" id="code" required>
                </div>
                <div class="form-group">
                    <label for="email">Simbol</label>
                    <input class="form-control" name="symbol" type="text" id="symbol" required>
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
    function editBrand(el){
        $('#addModalForm').attr('action', '/master-data/currency/'+$(el).data('id'));
        $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
        $('input[name="name"]').val($(el).data('name'));
        $('input[name="code"]').val($(el).data('code'));
        $('input[name="symbol"]').val($(el).data('symbol'));
    }

    function resetModal(method = 'add'){

        if (method == 'add') {
            $('#addModalForm').attr('action', '/master-data/currency/');
            $('#addModalForm').find('input[name="_method"]').remove();
        }

        $('input[name="name"]').val('');
        $('input[name="code"]').val('');
        $('input[name="symbol"]').val('');
    }

    function confirmDelete(id){
        $confirm = confirm('Anda Yakin?')
        if ($confirm) {
            $('#delete-'+id).submit();
        }
    }
</script>
@endsection

