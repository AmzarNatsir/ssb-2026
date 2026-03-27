@extends('Tender.layouts.master')
@include('Tender.project.partials.project_modal')
@include('Tender.project.partials.survey_assignment_modal')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="navbar-breadcrumb">
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Project Management</li>
                    <li class="breadcrumb-item">Project</li>
                    <li class="breadcrumb-item active" aria-current="page">Breakdown</li>
                </ul>
            </nav>
        </div>
    </div>
</div>

{{-- NEW WITH PROGRESS BAR --}}

<div class="iq-card">
    <div class="card p-4 pl-lg-5">

        <div class="row align-items-center">
            <div class="col-12 col-lg-8 col-sm-8">
                <h4 class="card-title text-primary">
                    <a href="{{ url()->previous() }}"><span class="fa fa-arrow-left pr-2 h5" aria-hidden="true"></span></a>
                    Project Breakdown
                </h4>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 col-sm-4 text-center text-sm-center text-lg-right text-xl-right">
            </div>
        </div>
        <div class="row d-flex justify-content-between px-3 top mx-0 py-3">
            <div class="d-flex">
                <h4 class="text-primary font-weight-bold">Progress</h4>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            @php
            $wdth = $project->type->id < 3 ? "width:16.4%!important;" : "width:20%!important;" @endphp <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li id="project" class="active step0" style="{{ $wdth }}"></li>
                    <li id="survey" class="{{ ($project->survey && $project->survey->results->count() > 0) ? "active" : "" }} step0" style="{{ $wdth }}"></li>
                    <li id="preanalyst" class="{{ isset($project->preAnalystApproval) ? "active" : "" }} step0" style="{{ $wdth }}"></li>
                    <li id="Persetujuan" class="{{ $project->approval->count() > 0 ? "active" : "" }} step0" style="{{ $wdth }}"></li>
                    @if($project->type->id < 2) <li id="Penyusunan Dokumen Lelang" class="{{ $project->auction->count() > 0 ? "active" : "" }} step0" style="{{ $wdth }}">
                        </li>
                        @endif
                        <li id="Aktivasi Project" class="{{ $project->status->id == "4" ? "active" : "" }} step0" style="{{ $wdth }}"></li>
                </ul>
        </div>
    </div>

    <div class="row justify-content-between top" style="margin:0px 6rem!important;">
        <div class="row d-flex icon-content">
            <div class="d-flex flex-column">
                <p class="font-weight-bold">Data Project</p>
            </div>
        </div>
        <div class="row d-flex icon-content">
            <div class="d-flex flex-column">
                <p class="font-weight-bold">Survey</p>
            </div>
        </div>
        <div class="row d-flex icon-content">
            <div class="d-flex flex-column align-items-center">
                <p class="font-weight-bold">PreAnalisa, Scoring <br /> & Rekomendasi</p>
            </div>
        </div>
        <div class="row d-flex icon-content">
            <div class="d-flex flex-column">
                <p class="font-weight-bold">Persetujuan<br>Project</p>
            </div>
        </div>

        @if($project->type->id < 3) <div class="row d-flex icon-content">
            <div class="d-flex flex-column">
                <p class="font-weight-bold">Penyusunan<br>Dokumen</p>
            </div>
    </div>
    @endif

    <div class="row d-flex icon-content">
        {{-- <h1 class="px-3 mr-3 border-right">6</h1> --}}
        <div class="d-flex flex-column">
            <p class="font-weight-bold">Aktivasi<br>Project</p>
        </div>
    </div>
</div>

{{-- </div>
	</div> --}}


{{-- END --}}

{{-- {property}{sides}-{size} for xs --}}
{{-- {property}{sides}-{breakpoint}-{size} for sm, md, lg, and xl. --}}
{{-- style="padding:1.5rem 3rem;" --}}

<{{-- div class="iq-card">
	  <div class="iq-card-body p-4 pl-lg-5">	  --}} <div id="action-tags" class="row my-2 mx-3">
    <div class="col-12 text-right">
        @can('assignSurvey', $project)
        <button id="action-tag-assign-survey" type="button" class="tag mr-2" data-toggle="modal" data-target="#surveyAssignmentModal">
            <i class="ri-file-shield-2-line h5"></i>
        </button>
        @endcan

        @can('activateProject', $project)
        <button id="action-tag-aktivasi-project" data-id="" type="button" class="tag mr-2" data-toggle="modal" data-target="#aktivasiProjectModal" data-backdrop="static">
            <i class="ri-folder-shared-fill h5"></i>
        </button>
        @endcan
    </div>
    </div>
    <div class="row my-2 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Data Project</h4>
            {{-- {{ dd($project->files[0]->filetype->name) }} --}}
        </div>

    </div>

    <div class="row pt-3 pb-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Nomor Project</label>
        </div>
        <div class="col-4">
            <label>{{ isset($project->number) ? $project->number : '-' }}</label>
        </div>
        <div class="col-2">
            <label class="font-weight-bold">Tanggal Registrasi</label>
        </div>
        <div class="col-3">
            <label>{{ $project->created_at }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Nama Project</label>
        </div>
        <div class="col-4">
            <label>{{ $project->name }}</label>
        </div>
        <div class="col-2">
            <label class="font-weight-bold">Tanggal Registrasi</label>
        </div>
        <div class="col-3">
            <label>{{ $project->created_at }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Keterangan</label>
        </div>
        <div class="col-4">
            <label>{{ $project->desc }}</label>
        </div>
        <div class="col-2">
            <label class="font-weight-bold">Status</label>
        </div>
        <div class="col-3">
            <label>{{ $project->status->keterangan }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Tipe</label>
        </div>
        <div class="col-3">
            <label>{{ $project->type->keterangan }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Lokasi</label>
        </div>
        <div class="col-3">
            <label>{{ $project->location }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Kategori</label>
        </div>
        <div class="col-3">
            <label>{{ $project->category->keterangan }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Nilai</label>
        </div>
        <div class="col-3">
            <label>{{ number_format($project->value, 2, ',', '.') }}</label>
        </div>
    </div>

    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Pre Analisa & Scoring</h4>
        </div>
    </div>

    @if(isset($project->preAnalystApproval))

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">User</label>
        </div>
        <div class="col-5">
            <label>{{ $project->preAnalystApproval->user->karyawan->nm_lengkap ?? '-' }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Hasil Rekomendasi</label>
        </div>
        <div class="col-5">
            <label>{{ $project->preAnalystApproval->is_approve == "1" ? 'Rekomendasi Setuju' : 'Rekomendasi Tolak' }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Notes</label>
        </div>
        <div class="col-5">
            <label>{{ $project->preAnalystApproval->note ?? '-' }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Dokumen</label>
        </div>
        <div class="col-5 d-flex">
            @if(isset($project->preAnalystApproval->files))
            @foreach($project->preAnalystApproval->files as $file)
            @if(!in_array(pathinfo("storage/preanalyst".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
            <a href="{{ url("storage/preanalyst/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/preanalyst/".$file->name) }}" class="bg-light">
                <img src="{{ url("storage/preanalyst/".$file->name) }}" class="rounded mb-0" style="width:100px;height:80px;">
            </a>
            @else
            <a id="document-{{ $file->id }}" href="{{ url("storage/preanalyst/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                <div class="d-flex flex-column mx-0 align-items-center">
                    <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                    <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                        <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                    </div>
                </div>
            </a>
            @endif
            @endforeach
            @endif
        </div>
    </div>

    @else

    <x-tender.common.norecord />

    @endif



    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Tugas Survey</h4>
        </div>
    </div>

    @if(isset($project->survey))
    <div class="row py-1 mx-3">
        <div class="col-2">
            <label>Nama Surveyor</label>
        </div>
        <div class="col-5">
            <label>{{ $project->survey->surveyor->karyawan->nm_lengkap ?? '-' }}</label>
        </div>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label>Catatan Survey</label>
        </div>
        <div class="col-5">
            <label>{{ $project->survey->notes ?? '-' }}</label>
        </div>
    </div>
    @else

    <x-tender.common.norecord />

    @endif


    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Hasil Survey Lokasi</h4>
        </div>
    </div>

    @if( isset($project->survey->results) && $project->survey->results->count() > 0)

    <div class="row py-1 mx-5">
        <table class="table table-lg table-bordered">
            <thead>
                <th>lokasi Survey</th>
                {{-- <th>Latitude</th>
		      			<th>Longitude</th> --}}
                <th>Catatan</th>
            </thead>
            <tbody>
                @php
                $project_location = $project->location;

                @endphp
                @foreach($project->survey->results as $location)
                <tr>
                    <td>{{ $project_location }}</td>
                    {{-- <td>{{ $location->lat }}</td>
                    <td>{{ $location->lng }}</td> --}}
                    <td>{{ $location->note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row py-1 mx-3">
        <div class="col-2">
            <label class="font-weight-bold">Dokumen Hasil Survey</label>
        </div>
        <div class="col-5 d-flex">
            @if(isset($project->survey->files))
            @foreach($project->survey->files as $file)

            @if(!in_array(pathinfo("storage/preanalyst".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
            <a href="{{ url("storage/survey/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/survey/".$file->name) }}" class="bg-light">
                <img src="{{ url("storage/survey/".$file->name) }}" class="rounded mb-0" style="width:100px;height:80px;">
            </a>
            @else
            <a id="document-{{ $file->id }}" href="{{ url("storage/survey/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                <div class="d-flex flex-column mx-0 align-items-center">
                    <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                    <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                        <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                    </div>
                </div>
            </a>
            @endif

            @endforeach
            @endif
        </div>
    </div>

    @else

    <x-tender.common.norecord />

    @endif

    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Persetujuan Project</h4>
        </div>
    </div>

    @if( $project->approval->count() > 0)

    <div class="row py-1 mx-5">
        <table class="table table-bordered" style="font-size:18px;">
            <thead>
                <th>User Approval</th>
                <th>Rekomendasi</th>
                <th>Tanggal</th>
                <th>Note</th>
            </thead>
            <tbody>
                {{-- {{ dd($project->approval) }} --}}

                @foreach($project->approval as $approval)
                <tr>
                    <td>{{ $approval->user->nm_lengkap }}</td>
                    <td>{{ $approval->hasil == "1" ? 'setuju' : 'tidak' }}</td>
                    <td>{{ $approval->created_at }}</td>
                    <td>{{ $approval->note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else

    <x-tender.common.norecord />

    @endif

    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Anggaran Project (Bill of Quantity)</h4>
        </div>
    </div>

    {{-- {{ dd($project->boq->detail[0]['equipment']['name']) }} --}}
    {{-- {{ dd($project->boq->detail->count()) }} --}}

    @if( isset($project->boq) && $project->boq->count() > 0)

    <div class="row py-1 mx-5">
        <table class="table table-bordered">
            <thead>
                <th>Equipment</th>
                <th>Keterangan</th>
                <th>Quantity</th>
                <th>Target</th>
                <th>Harga</th>
                <th>cost</th>
            </thead>
            <tbody>
                @if($project->boq->detail->count() > 0)
                @foreach($project->boq->detail as $detail)
                <tr>
                    <td>{{ $detail->equipment->name }}</td>
                    <td>{{ $detail->desc }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->formattedTarget }}</td>
                    <td>{{ $detail->formattedPrice }}</td>
                    <td>{{ number_format($detail->cost) }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>

    @else

    <x-tender.common.norecord />

    @endif

    <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Jaminan Pelaksanaan</h4>
        </div>
    </div>

    @if( isset($project->bond) )

    <div class="row py-1 mx-5">
        <table class="table table-bordered">
            <thead>
                <th>No Jampel</th>
                <th>Tanggal Jampel</th>
                <th>Nama Bank</th>
                <th>Nilai Jaminan</th>
            </thead>
            <tbody>
                @if(isset($project->bond))
                <tr>
                    <td>{{ $project->bond->bond_number }}</td>
                    <td>{{ $project->bond->bond_date }}</td>
                    <td>{{ $project->bond->bank_name }}</td>
                    <td>{{ $project->bond->formattedBondAmount }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    @else

    <x-tender.common.norecord />

    @endif


    @if( $project->type->id < 3) <div class="row my-3 mx-0">
        <div class="col-12">
            <h4 class="text-primary font-weight-bold border-bottom py-2">Lelang</h4>
        </div>
        </div>

        @if( $project->auction->count() > 0 )

        <div class="row py-1 mx-5">
            <table class="table table-bordered">
                <thead>
                    <th>Tahap</th>
                    <th>No Surat Pemenangan Lelang</th>
                    <th>Tgl Kirim Dokumen</th>
                    <th>Tgl Lulus Lelang</th>
                </thead>
                <tbody>
                    @if(isset($project->auction))
                    @foreach($project->auction as $auction)
                    <tr>
                        <td>{{ $auction->phase_number }}</td>
                        <td>{{ $auction->accepted_document_number }}</td>
                        <td>{{ $auction->formattedSendDate }}</td>
                        <td>{{ $auction->formattedAcceptedDate }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @else

        <x-tender.common.norecord />

        @endif

        @endif

        <div class="row my-3 mx-0">
            <div class="col-12">
                <h4 class="text-primary font-weight-bold border-bottom py-2">Dokumen Project</h4>
            </div>
        </div>

        @if( $project->files->count() > 0)

        <div class="row py-1 mx-5">
            <div class="col-5 d-flex">
                @if(isset($project->files))
                @foreach($project->files as $file)

                @if(!in_array(pathinfo("storage/project".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
                <div class="d-flex flex-column mx-2 align-items-center">
                    <p class="badge badge-pill badge-light my-2">{{ $file->filetype->name }}</p>
                    <a href="{{ url("storage/project/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/project/".$file->name) }}" class="bg-light">
                        <img src="{{ url("storage/project/".$file->name) }}" class="rounded mb-0" style="width:100px;height:80px;">
                    </a>
                </div>
                @else
                <a id="document-{{ $file->id }}" href="{{ url("storage/project/".$file->name) }}" target="_blank" class="bg-light p-2 rounded-lg mr-2">
                    <div class="d-flex flex-column mx-0 align-items-center">
                        <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                        <div class="d-flex justify-content-center align-items-center rounded mb-0 mr-2" style="width:100px;height:80px;">
                            <i class="fa fa-file-pdf-o" style="font-size:2rem;" aria-hidden="true"></i>
                        </div>
                    </div>
                </a>
                @endif

                @endforeach
                @endif
            </div>
        </div>

        @else
        <x-tender.common.norecord />
        @endif

        <div class="row my-3 mx-0">
            <div class="col-12">
                <h4 class="text-primary font-weight-bold border-bottom py-2">Aktivasi Project</h4>
            </div>
        </div>

        @if(isset($project->contract))

        <div class="row pt-3 pb-1 mx-3">
            <div class="col-2">
                <label class="font-weight-bold">Nomor Kontrak</label>
            </div>
            <div class="col-4">
                <label>{{ isset($project->contract) ? $project->contract->contract_no : '-' }}</label>
            </div>
            <div class="col-2">
                <label class="font-weight-bold">Tanggal Kontrak</label>
            </div>
            <div class="col-3">
                <label>{{ isset($project->contract) ? $project->contract->contract_date : '-' }}</label>
            </div>
        </div>

        <div class="row pt-3 pb-1 mx-3">
            <div class="col-2">
                <label class="font-weight-bold">Tanggal Kickoff meeting</label>
            </div>
            <div class="col-4">
                <label>{{ isset($project->contract) ? $project->contract->kickoff_meeting_date : '-' }}</label>
            </div>
            <div class="col-2">
                <label class="font-weight-bold">Kickoff Note</label>
            </div>
            <div class="col-3">
                <label>{{ isset($project->contract) ? $project->contract->kickoff_meeting_note : '-' }}</label>
            </div>
        </div>

        <div class="row pt-3 pb-1 mx-3">
            <div class="col-2">
                <label class="font-weight-bold">Tanggal Aktivasi</label>
            </div>
            <div class="col-4">
                <label>{{ isset($project->contract) ? $project->contract->created_at : '-' }}</label>
            </div>
        </div>

        @else

        <x-tender.common.norecord />

        @endif


        </div>
        </div>

        @endsection
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/tender/index.js') }}"></script>
        <script type="text/javascript">
            var selectedRow = "{{ $projectId }}"
                , loadProjectsUrl = "{{ route('Project.loadDataTable') }}";
            // $(document).on('click', "#progressbar > li", function(){
            //      console.log($(this).attr('id'));
            //      $(this).toggleClass("active", true);

            //      var li = $(this).closest('li').prevAll('li'),
            //      	liNext = $(this).closest('li').nextAll('li');

            //      li.toggleClass("active", true);
            //      liNext.toggleClass("active", false);

            //      let currentTab = $(`#${$(this).attr('id')}-tab`);
            //      $('.tabContent').not(currentTab).each(function(){
            //      	$(this).addClass('d-none');
            //      });

            //  });

        </script>
