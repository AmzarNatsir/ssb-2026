@extends('Workshop.layouts.master')

@section('content')
<div id="content-page" class="content-page">
    <div class="cantainer-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Tambah Spare Part </h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="addModalForm" action={{ !isset($sparePart) ? route('warehouse.master-data.spare-part.store') : route('warehouse.master-data.spare-part.update',$sparePart->id) }} method="POST" >
                            @csrf
                            @isset($sparePart)
                                @method('PUT')
                            @endisset
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Kategori </label>
                                            <select required class="form-control" name="category_id" id="category_id">
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option {{ isset($sparePart) && ( $sparePart->category_id == $category->id ) ? 'selected' : ''  }}  value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Kode Part </label>
                                            <input required class="form-control" name="part_number" type="text" id="part_number" value="{{ isset($sparePart) ? $sparePart->part_number : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Interchange </label>
                                            <input class="form-control" name="interchange" type="text" id="interchange" value="{{ isset($sparePart) ? $sparePart->interchange : ''  }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nama Part </label>
                                            <input required class="form-control" name="part_name" type="text" id="part_name" value="{{ isset($sparePart) ? $sparePart->part_name : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Merek </label>
                                            <select required class="form-control" name="brand_id" id="brand_id">
                                                <option value="">Pilih Merek</option>
                                                @foreach ($brands as $brand)
                                                    <option {{ isset($sparePart) && ( $sparePart->brand_id == $brand->id ) ? 'selected' : ''  }}  value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Kode Rak </label>
                                            <input class="form-control" name="rack" type="text" id="rack" value="{{ isset($sparePart) ? $sparePart->rack : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Lokasi </label>
                                            <input class="form-control" name="location" type="text" id="location" value="{{ isset($sparePart) ? $sparePart->location : ''  }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Penggunaan </label>
                                            <input class="form-control" name="used_for" type="text" id="used_for" value="{{ isset($sparePart) ? $sparePart->used_for : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6 sm-lg-6">
                                        <div class="form-group">
                                            <label for="name">Geniune </label>
                                            <select required class="form-control" name="is_geniune" id="is_geniune">
                                                <option value="1" {{ isset($sparePart) && $sparePart->is_geniune ? 'selected' : '' }} >Geniune Part</option>
                                                <option value="0" {{ isset($sparePart) && !$sparePart->is_geniune ? 'selected' : '' }}>Non Geniune Part</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Satuan </label>
                                            <select required class="form-control" name="uop_id" id="uop_id">
                                                <option value="">Pilih Satuan</option>
                                                @foreach ($uops as $uop)
                                                    <option {{ isset($sparePart) && ( $sparePart->uop_id == $uop->id ) ? 'selected' : ''  }}  value="{{ $uop->id }}">{{ $uop->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Stok Minimum </label>
                                            <input required class="form-control" name="min_stock" type="number" id="min_stock" value="{{ isset($sparePart) ? $sparePart->min_stock : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Stok Maksimum </label>
                                            <input required class="form-control" name="max_stock" type="number" id="max_stock" value="{{ isset($sparePart) ? $sparePart->max_stock : ''  }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Harga Beli </label>
                                            <input required class="form-control" name="price" type="number" id="price" value="{{ isset($sparePart) ? $sparePart->price : ''  }}" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Berat </label>
                                            <input required class="form-control" name="weight" type="number" id="weight" value="{{ isset($sparePart) ? $sparePart->weight : ''  }}" step="0.01" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4 sm-lg-4">
                                        <div class="form-group">
                                            <label for="name">Stok </label>
                                            <input required class="form-control" name="stock" type="number" id="stock" value="{{ isset($sparePart) ? $sparePart->stock : ''  }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-lg-6">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('warehouse.master-data.spare-part.index') }}" class="btn iq-bg-danger">Batal</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Add New Modal --}}
 <script>

</script>
@endsection

