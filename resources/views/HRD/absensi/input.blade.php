@extends('HRD.layouts.master')
@section('content')
<style>
    .spinner-div {
        position: absolute;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 2;
    }
    .form-control, .form-control:focus { border-radius: 4px; font-size: 13px; }
    label { font-size: 13px; color: #333; }
    .btn { font-size: 13px; font-weight: 500; border-radius: 4px; }
    .tbl-input td { vertical-align: middle; font-size: 13px; }
    .tbl-input input[type="time"] { max-width: 120px; }
</style>
<div class="navbar-breadcrumb">
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('hrd/home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Absensi</li>
        <li class="breadcrumb-item"><a href="{{ url('hrd/absensi/input') }}">Input Absensi Harian</a></li>
        </ul>
    </nav>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title">Input Absensi Harian</h4>
                </div>
            </div>
            <div class="iq-card-body" style="width:100%; height:auto">
                <div class="row align-items-end mb-3">
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                        <label class="d-block font-weight-bold mb-2">Departemen</label>
                        <select class="form-control" name="pil_departemen" id="pil_departemen">
                            <option value="">Pilih Departemen</option>
                            @foreach($all_departemen as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->nm_dept }} | {{ $dept->get_master_divisi->nm_divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                        <label class="d-block font-weight-bold mb-2">Jabatan</label>
                        <select class="form-control" name="pil_jabatan" id="pil_jabatan">
                            <option value="">- Semua Jabatan</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                        <label class="d-block font-weight-bold mb-2">Tanggal</label>
                        <input type="date" name="inp_tanggal" id="inp_tanggal" value="{{ date('Y-m-d') }}" class="form-control" required>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <button type="button" class="btn btn-primary" onClick="actTampil();"><i class="fa fa-search mr-2"></i>Tampilkan</button>
                    </div>
                </div>
                <hr class="my-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="spinner-div" class="pt-5 justify-content-center spinner-div"><div class="spinner-border text-primary" role="status"></div></div>
                        <div id="grid_input"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#spinner-div').hide();
    });

    // Auto-format jam ke HH:MM (ketik 0730 -> 07:30). Berlaku utk input yg dimuat via AJAX.
    $(document).on('input', '.jam-input', function(){
        var v = this.value.replace(/[^0-9]/g, '').slice(0, 4);
        if (v.length >= 3) {
            v = v.slice(0, 2) + ':' + v.slice(2);
        }
        this.value = v;
    });
    // Validasi saat selesai mengetik: jam 00-23, menit 00-59
    $(document).on('blur', '.jam-input', function(){
        var v = this.value.trim();
        if (v === '') { this.classList.remove('is-invalid'); return; }
        var m = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/.test(v);
        this.classList.toggle('is-invalid', !m);
    });

    // muat daftar jabatan sesuai departemen terpilih
    $("#pil_departemen").on('change', function(){
        var id_dept = $(this).val();
        $("#pil_jabatan").html('<option value="">- Semua Jabatan</option>');
        if(id_dept=="") return;
        $.ajax({
            type: "post",
            headers: { 'X-CSRF-TOKEN': '<?php echo csrf_token() ?>' },
            url: "{{ url('hrd/absensi/getJabatanDept') }}",
            data: { id_dept:id_dept },
            success: function(res){
                $.each(res, function(i, item){
                    $("#pil_jabatan").append('<option value="'+item.id+'">'+item.nm_jabatan+'</option>');
                });
            }
        });
    });

    var actTampil = function()
    {
        var id_dept = $("#pil_departemen").val();
        var id_jabatan = $("#pil_jabatan").val();
        var tanggal = $("#inp_tanggal").val();
        if(id_dept=="") { alert('Pilih Departemen terlebih dahulu !'); return false; }
        if(tanggal=="") { alert('Pilih Tanggal terlebih dahulu !'); return false; }
        $.ajax({
            type: "post",
            headers: { 'X-CSRF-TOKEN': '<?php echo csrf_token() ?>' },
            url: "{{ url('hrd/absensi/inputGrid') }}",
            data: { id_dept:id_dept, id_jabatan:id_jabatan, tanggal:tanggal },
            beforeSend: function(){ $('#spinner-div').show(); },
            success: function(respond){ $("#grid_input").html(respond); },
            complete: function(){ $('#spinner-div').hide(); }
        });
    };

    var actSimpan = function()
    {
        // pastikan tidak ada format jam yang salah
        var invalid = false;
        $('.jam-input').each(function(){
            var v = this.value.trim();
            if (v !== '' && !/^([0-1][0-9]|2[0-3]):([0-5][0-9])$/.test(v)) {
                this.classList.add('is-invalid');
                invalid = true;
            }
        });
        if (invalid) { alert('Ada format jam yang salah. Gunakan format HH:MM (mis. 07:30).'); return false; }

        if(!confirm('Simpan data absensi tanggal ini ?')) return false;
        $.ajax({
            type: "post",
            headers: { 'X-CSRF-TOKEN': '<?php echo csrf_token() ?>' },
            url: "{{ url('hrd/absensi/inputStore') }}",
            data: $('#frm_absensi_input').serialize(),
            beforeSend: function(){ $('#spinner-div').show(); },
            success: function(res){
                alert(res.message);
            },
            error: function(xhr){
                alert('Terjadi kesalahan saat menyimpan data.');
            },
            complete: function(){ $('#spinner-div').hide(); }
        });
    };
</script>
@endsection
