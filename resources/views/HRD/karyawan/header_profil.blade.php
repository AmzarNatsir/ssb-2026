<div class="col-sm-12">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
        <div class="iq-card-body profile-page p-0">
           <div class="profile-header">
              <div class="cover-container">
                 <img src="{{ asset('assets/images/page-img/profile-bg.jpg') }}" alt="profile-bg" class="rounded img-fluid w-100">
                 {{-- <ul class="header-nav d-flex flex-wrap justify-end p-0 m-0">
                    <li><a href="{{ url('hrd/karyawan/editbiodata/'.$res->id)}}"><i class="ri-pencil-line"></i></a></li>
                    <li><a href="javascript:void();"><i class="fa fa-print"></i></a></li>
                 </ul> --}}
              </div>
              <div class="profile-info p-4">
                 <div class="row">
                    <div class="col-sm-12 col-md-7">
                       <div class="user-detail pl-5">
                          <div class="d-flex flex-wrap align-items-center">
                             <div class="profile-img pr-4">
                                @if(empty($res->photo))
                                    <a href="{{ asset('assets/images/no_image.png') }}" data-fancybox data-caption='{{ $res->nm_lengkap }}'><img class="avatar-130 img-fluid" src="{{ asset('assets/images/no_image.png') }}" alt="profile"></a>
                                @else
                                    <a href="{{ url(Storage::url('hrd/photo/'.$res->photo)) }}" data-fancybox data-caption='{{ $res->nm_lengkap }}'><img class="avatar-130 img-fluid" src="{{ url(Storage::url('hrd/photo/'.$res->photo)) }}" alt="profile"></a>
                                @endif
                             </div>
                             <div class="profile-detail d-flex align-items-center">
                                <h4>{{ $res->nm_lengkap }}</h4>
                                <p class="m-0 pl-3"> - {{ (empty($res->get_jabatan->nm_jabatan) || (empty($res->id_jabatan)) ) ? "Non Jabatan" :  $res->get_jabatan->nm_jabatan }} {{ (!empty($res->id_departemen)) ? " - ".$res->get_departemen->nm_dept : "" }}</p>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </div>
</div>
