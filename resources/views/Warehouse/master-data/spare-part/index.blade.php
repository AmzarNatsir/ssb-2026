@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Spare Part </h4>
                            </div>
                            @if (current_user_has_permission_to('warehouse-master_data.spare_part.create'))
                                <a style="margin-top: auto" type="button" class="btn btn-success mb-3"
                                    href="{{ route('warehouse.master-data.spare-part.add') }}"><i
                                        class="ri-add-line pr-0"></i></a>
                            @endif
                        </div>
                        <div class="iq-card-body">
                            <form action="{{ route('warehouse.master-data.spare-part.index') }}" method="GET">
                              <div class="form-row">
                                <div class="form-group col-md-4">
                                  <label for="">Search keyword</label>
                                  <input type="text" class="form-control" placeholder="" name="keyword" value="{{ $keyword ?? ''  }}">
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="">Kategori</label>
                                  <select class="form-control" name="category">
                                    <option value="">ALL</option>
                                    @foreach($categories as $category)
                                      <option value="{{$category->id}}" {{ $category->id == $selCategory ? 'selected' : ''  }} >{{$category->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="">Merk</label>
                                  <select class="form-control" name="brand">
                                    <option value="">ALL</option>
                                    @foreach($brands as $brand)
                                      <option value="{{$brand->id}}" {{ $brand->id == $selBrand ? 'selected' : ''  }}>{{$brand->name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                  <label for="">Kode Rak</label>
                                  <select class="form-control" name="rack">
                                    <option value="">ALL</option>
                                    @foreach($racks as $rack)
                                      <option value="{{$rack->rack}}" {{ $rack->rack == $selRack ? 'selected' : ''  }}>{{$rack->rack}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="form-group col-md-2" style="margin-top: 2.1em">
                                  <label for="">&nbsp;</label>
                                  <button type="submit" class="btn btn-success">Search</button>
                                </div>
                              </div>
                            </form>

                            <div class="table-responsive" style="font-size: 10pt">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Aksi</th>
                                            <th scope="col">Part Number</th>
                                            <th scope="col">Part Name</th>
                                            <th scope="col">Interchange</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Kode Rak</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Min. Stock</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Harga Beli</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col">Penggunaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($spareParts as $sparePart)
                                            <tr>
                                                <th scope="row">
                                                    {{ !$page || $page == 1 ? $loop->index + 1 : $limit++ }}
                                                </th>
                                                <td>
                                                    <div class="d-block">
                                                        <div class="btn-group  btn-group-sm" role="group">
                                                            @if (current_user_has_permission_to('warehouse-master_data.spare_part.print'))
                                                                <a target="_blank" title="Stock Card" class="btn btn-info"
                                                                    href="{{ route('warehouse.master-data.spare-part.stock-card', $sparePart->id) }}"><i
                                                                        class="ri-book-open-line"></i></a>
                                                            @endif
                                                            @if (current_user_has_permission_to('warehouse-master_data.spare_part.edit'))
                                                                <a class="btn btn-warning"
                                                                    href="{{ route('warehouse.master-data.spare-part.edit', $sparePart->id) }}">Edit</a>
                                                            @endif
                                                            @if (current_user_has_permission_to('warehouse-master_data.spare_part.delete'))
                                                                <form method="POST" id="delete-{{ $sparePart->id }}"
                                                                    action="{{ route('warehouse.master-data.spare-part.destroy', $sparePart->id) }}">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button onclick="confirmDelete({{ $sparePart->id }});"
                                                                        type="button" class="btn btn-danger">Hapus</a>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="white-space:nowrap">{{ Str::limit($sparePart->part_number, 20) ?? '' }}</td>
                                                <td style="white-space:nowrap">{{ Str::limit($sparePart->part_name, 20) ?? '' }}</td>
                                                <td style="white-space:nowrap">{{ $sparePart->interchange }}</td>
                                                <td style="white-space:nowrap">{{ $sparePart->location }}</td>
                                                <td style="white-space:nowrap">{{ $sparePart->rack }}</td>
                                                <td>{{ $sparePart->brand->name }}</td>
                                                <td>
                                                    @if ($sparePart->min_stock < $sparePart->stock)
                                                        <span class="badge badge-success">
                                                            {{ $sparePart->stock }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning"
                                                            title="Stok akan segera habis, stok minimal adalah {{ $sparePart->min_stock }}">
                                                            {{ $sparePart->stock }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $sparePart->min_stock ?? '' }}</td>
                                                <td>{{ $sparePart->category->name ?? '' }}</td>
                                                <td>{{ $sparePart->price }}</td>
                                                <td>{{ $sparePart->uop->name ?? '' }}</td>
                                                <td style="white-space:nowrap">{{ $sparePart->used_for ?? '' }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13">Belum ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            @if (current_user_has_permission_to('warehouse-master_data.spare_part.print'))
                                <a target="_blank"
                                    href="{{ route('warehouse.master-data.spare-part.print-all', request()->all()) }}"
                                    class="btn iq-bg-info"><i class="ri-download-line"></i> Print</a>
                            @endif
                            <div style="float: right">
                                {{ $spareParts->links() }}
                            </div>
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
