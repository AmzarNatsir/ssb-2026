 <div class="modal-content">
     <div class="modal-header">
         <div class="row px-4 pt-2 d-flex flex-column">
             <h5 class="modal-title">Survey Approval</h5>
             <p class="font-weight-bold">{{ (isset($project) && count($project) > 0) ? $project[0]['name'] : '' }}</p>
         </div>
         <button type="button" id="closeSurveyRequestApprovalModal" data-dismiss="modal" aria-label="Close">
             <i class="ri-close-line"></i>
         </button>
     </div>
     <div class="modal-body">
         <small>
             <i class="ri-information-line pr-1"></i>
             klik pada tombol <strong>switch</strong> pada kolom action untuk menampilkan form persetujuan
         </small>
         <table class="table table-data mt-1">
             <thead>
                 <tr>
                     {{-- <th>#Urutan</th> --}}
                     <th>Nama</th>
                     <th>Jabatan</th>
                     <th>Persetujuan</th>
                     <th>Catatan</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody>
                 {{-- @if(isset($komiteDanApproval) && $komiteDanApproval->count())
                 @foreach($komiteDanApproval as $row)
                 @if( !is_null($row->hasil) && $row->hasil == "1" )
                 @php
                 $hasil = "Setuju"
                 @endphp
                 @elseif(!is_null($row->hasil) && $row->hasil == "0")
                 @php
                 $hasil = "Tolak"
                 @endphp
                 @elseif(is_null($row->hasil))
                 @php
                 $hasil = "Belum ada approval"
                 @endphp
                 @endif
                 <tr>
                     {{-- <td>{{ "#".$row->urutan }}</td> --}}
                 {{-- <td>{{ $row->nama_komite }}</td>
                 <td>{{ $row->jabatan }}</td>
                 <td>{{ $hasil }}</td>
                 <td>{{ $row->note }}</td> --}}
                 <td>

                     {{-- @if($row->karyawan_id == auth()->user()->karyawan->id)
                     <div class="custom-switch custom-switch-label-yesno custom-switch-xs pl-0 d-flex align-items-center">
                         <input class="custom-switch-input" id="show_form" name="show_form-{{ $row->komite_id }}" type="checkbox" {{ !empty($row->user_id) ? "disabled" : "" }}>
                     <label class="custom-switch-btn" for="show_form"></label>
     </div>
     @endif --}}
     </td>
     </tr>
     {{-- @endforeach --}}
     {{-- @endif --}}
     </tbody>
     </table>
     <hr />
     <div class="row">
         <div class="col-md-12">
             <form class="d-none" id="project-approval-form" name="project-approval-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('Approval.save') }}">
                 @csrf
                 <h5 class="modal-title mb-4 mt-2">
                     Formulir Approval
                 </h5>
                 <div class="form-group with-validation">
                     <label for="colFormLabel">Persetujuan</label>
                     <select class="form-control" id="hasil" name="hasil" style="border-right: 15px transparent solid;border-bottom: 15px;">
                         <option value=""></option>
                         <option value="1">Setuju</option>
                         <option value="0">Tidak Setuju</option>
                     </select>
                     <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group with-validation">
                     <label for="colFormLabel">Catatan</label>
                     <textarea id="note" name="note" class="form-control"></textarea>
                     <div class="invalid-feedback"></div>
                 </div>
                 <div class="form-group">
                     {{-- <input type="hidden" id="project_id" name="project_id" value="{{ isset($projectId) ? $projectId : '' }}" /> --}}
                     <button id="btn-save-approval" type="button" class="btn btn-lg btn-block btn-primary btn-save-approval">
                         <strong>Simpan Persetujuan</strong>
                     </button>
                 </div>
             </form>
         </div>
     </div>

 </div>
 </div>
