<table class="table table-striped table-bordered" style="width: 100%">
    <thead class="thead-light">
        <th style="width: 5%">No</th>
        <th>Pelatihan</th>
        <th style="width: 30%">Tanggal</th>
        <th style="width: 15%">Durasi</th>
    </thead>
    <tbody>
        @php $nom=1 @endphp
        @foreach($data_pelatihan as $key => $item)
        @php
        $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
        $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
        @endphp
        <tr>
            <td>{{ $nom }}</td>
            <td>{{ $nama_pelatihan }}</td>
            <td>{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</td>
            <td>{{ $item->durasi }}</td>
        </tr>
        @php $nom++ @endphp
        @endforeach
    </tbody>
</table>
{{-- <div class="tab-content">
    <div class="tab-pane fade show active" id="mail-inbox" role="tabpanel">
         @foreach ($data_pelatihan as $key => $item)
         @php
         $nama_pelatihan = ($item->kategori=='Internal') ? $item->get_nama_pelatihan->nama_pelatihan : $item->nama_pelatihan;
         $nama_vendor = ($item->kategori=='Internal') ? $item->get_pelaksana->nama_lembaga : $item->nama_vendor;
         @endphp
         <ul class="iq-email-sender-list">
             <li class="iq-unread">
             <div class="d-flex align-self-center">
                 <div class="iq-email-sender-info">
                     <div class="iq-checkbox-mail">
                         <div class="custom-control custom-checkbox">
                         <input type="checkbox" class="custom-control-input" id="mailk" checked disabled>
                         <label class="custom-control-label" for="mailk"></label>
                         </div>
                     </div>
                     <a href="javascript: void(0);" class="iq-email-title">{{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, NULL, NULL) }}</a>
                 </div>
                 <div class="iq-email-content">
                     <a href="javascript: void(0);" class="iq-email-subject">{{ $nama_pelatihan }}</a>
                 </div>
             </div>
             </li>
             <div class="email-app-details">
                 <div class="iq-card">
                    <div class="iq-card-body p-0">
                         <div class="">
                             <div class="iq-email-to-list p-3">
                                 <div class="d-flex justify-content-between">
                                    <ul>
                                       <li class="mr-3"><a href="javascript: void(0);"><h4 class="m-0"><i class="ri-arrow-left-line"></i></h4></a></li>
                                    </ul>
                                    <div class="iq-email-search d-flex">
                                       <ul><li class="mr-3"><a class="font-size-14" href="#">Detail</a></li></ul>
                                    </div>
                                 </div>
                             </div>
                             <hr class="mt-0">
                             <div class="iq-inbox-subject p-3">
                                 <h5 class="mt-0">{{ $nama_pelatihan }}</h5>
                                 <div class="iq-inbox-subject-info">
                                    <div class="iq-subject-info">
                                       <div class="iq-subject-status align-self-center">
                                             <h6 class="mb-0">Kategori : {{ $item->kategori }}</h6>
                                             <h6 class="mb-0">Durasi : {{  $item->durasi }}</h6>
                                             <h6 class="mb-0">Biaya/Investasi : Rp. {{ number_format($item->investasi_per_orang, 0, ",", ".") }}</h6>
                                       </div>
                                       <span class="float-right align-self-center">@if($item->tanggal_awal==$item->hari_sampai)
                                         {{ App\Helpers\Hrdhelper::get_hari($item->tanggal_awal) }}
                                         @else
                                         {{ App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_awal). " - ".App\Helpers\Hrdhelper::get_hari_ini($item->tanggal_sampai) }}
                                         @endif, {{ App\Helpers\Hrdhelper::get_tanggal_pelaksanaan($item->tanggal_awal, $item->tanggal_sampai, $item->hari_awal, $item->hari_sampai) }}</span>
                                    </div>
                                    <div class="iq-inbox-body mt-5">
                                       <p>Kompetensi Pelatihan :</p>
                                       <p>{{ $item->kompetensi }}</p>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">PESERTA:</h6>
                                    <div class="attegement container" style="width:100%; height:200px">
                                       <ul class="suggestions-lists m-0 p-0">
                                         @php $nom=1 @endphp
                                         @foreach ($item->get_peserta as $peserta)
                                         <li class="d-flex mb-4 align-items-center">
                                             <div class="user-img img-fluid">
                                                 @if(!empty($peserta->get_karyawan->photo))
                                                     <a href="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ url(Storage::url('hrd/photo/'.$peserta->get_karyawan->photo)) }}" alt="profile"></a>
                                                 @else
                                                     <a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $peserta->get_karyawan->nm_lengkap }}'><img class="rounded-circle img-fluid avatar-40" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
                                                 @endif
                                             </div>
                                             <div class="media-support-info ml-3">
                                                 <h6>{{ $peserta->get_karyawan->nm_lengkap }}</h6>
                                                 <p>{{ (blank($peserta->get_karyawan->id_departemen)) ? "" : $peserta->get_karyawan->get_departemen->nm_dept }} - {{ (blank($peserta->get_karyawan->id_jabatan)) ? "" : $peserta->get_karyawan->get_jabatan->nm_jabatan }}</p>
                                             </div>
                                          </li>
                                          @php $nom++ @endphp
                                         @endforeach
                                       </ul>
                                    </div>
                                 </div>
                             </div>
                         </div>
                    </div>
                 </div>
             </div>
         </ul>
         @endforeach
     </div>
 </div> --}}
