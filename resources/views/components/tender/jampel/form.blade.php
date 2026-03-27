  <div class="modal-content">
      <div class="modal-body px-1">

          <button type="button" class="absolute-close" data-dismiss="modal" aria-label="Close">
              <i class="ri-close-line"></i>
          </button>

          <ul class="nav nav-pills mb-3 nav-fill" id="myTab-three" role="tablist">
              <li class="nav-item">
                  <a class="nav-link active" id="home-tab-three" data-toggle="tab" href="#pills-home-fill" role="tab" aria-controls="home" aria-selected="true">Jaminan Pelaksanaan</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="profile-tab-three" data-toggle="tab" href="#pills-profile-fill" role="tab" aria-controls="profile" aria-selected="false">Dokumen Tahap I</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="contact-tab-three" data-toggle="tab" href="#pills-contact-fill" role="tab" aria-controls="contact" aria-selected="false">Dokumen Tahap II</a>
              </li>
          </ul>

          <div class="tab-content mt-5" id="pills-tabContent-1">
              {{-- TAB 1 --}}
              <div class="tab-pane fade active show" id="pills-home-fill" role="tabpanel" aria-labelledby="pills-home-tab-fill">
                  <form id="create-jampel-form" method="POST" enctype="multipart/form-data" autocomplete="off" action="{{ route('bond.store') }}">
                      @csrf
                      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
                          <div class="form-group with-validation">
                              <label for="colFormLabel" class="font-weight-500">
                                  Nomor surat penunjukkan dan permintaan Jaminan pelaksanaan
                              </label>
                              {{-- <p>user id: {{ $userId }}</p> --}}
                              <input type="text" id="assignment_number" name="assignment_number" class="form-control" value="{{ isset($workAssignment->assignment_number) ? $workAssignment->assignment_number : '' }}" />
                              <div class="invalid-feedback"></div>
                          </div>
                          <div class="form-group with-validation">
                              <label for="colFormLabel" class="font-weight-500">Tanggal Surat</label>
                              <input type="date" id="bond_assignment_date" name="bond_assignment_date" class="form-control" value="{{ $workAssignment->assignment_date ?? '' }}">
                              <div class="invalid-feedback"></div>
                          </div>
                          <div class="form-group with-validation">
                              <label for="colFormLabel" class="font-weight-500">Nilai jaminan</label>
                              <input type="text" id="bond_amount" name="bond_amount" class="form-control" value="{{ $bond->bond_amount ?? '' }}">
                              <div class="invalid-feedback"></div>
                          </div>
                          <div class="form-group mb-0">
                              <label for="colFormLabel" class="font-weight-500">Tanggal Berlaku Jaminan</label>
                          </div>
                          <div class="row">
                              <div class="col-6">
                                  <div class="form-group with-validation">
                                      <input type="date" id="bond_start_date" name="bond_start_date" class="form-control" value="{{ $bond->bond_start_date ?? '' }}">
                                      <div class="invalid-feedback"></div>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="form-group with-validation">
                                      <input type="date" id="bond_end_date" name="bond_end_date" class="form-control" value="{{ $bond->bond_end_date ?? '' }}">
                                      <div class="invalid-feedback"></div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
                          <label for="colFormLabel" class="font-weight-bold">Data Bank</label>
                          <div class="form-group with-validation">
                              <label for="colFormLabel" class="font-weight-500">Nama Bank Garansi</label>
                              <input type="text" id="bank_name" name="bank_name" class="form-control" value="{{ $bond->bank_name ?? '' }}">
                              <div class="invalid-feedback"></div>
                          </div>
                          <div class="form-group with-validation">
                              <label for="colFormLabel" class="font-weight-500">Nomor Jaminan Pelaksanaan</label>
                              <input type="text" id="bond_number" name="bond_number" class="form-control" value="{{ $bond->bond_number ?? '' }}">
                              <div class="invalid-feedback"></div>
                          </div>
                          <div class="form-group">
                              <label for="colFormLabel" class="font-weight-500">Tanggal Jaminan Pelaksanaan</label>
                              <input type="date" id="bond_date" name="bond_date" class="form-control" value="{{ $bond->bond_date ?? '' }}">
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" id="project_id" name="project_id" value="{{ $projectId ?? '' }}">
                              <button type="button" id="btn-bond-submit" name="btn-bond-submit" class="btn btn-lg btn-next-step btn-block btn-primary font-weight-bold">
                                  {{ isset($bond->id) ? "Update" : "Submit" }}
                              </button>
                          </div>
                      </div>

                  </form>

              </div>
              {{-- END TAB 1 --}}

              {{-- TAB 2 --}}
              <div class="tab-pane fade" id="pills-profile-fill" role="tabpanel" aria-labelledby="pills-profile-tab-fill">
                  <form id="create-auction-phase1-form" method="POST" action="{{ route('auction.store') }}" enctype="multipart/form-data" autocomplete="off">

                      {{-- action="{{ isset($auctionPhase1->id) ? route('auction.update') : route('auction.store') }}" --}}

                      {{-- @if(isset($auctionPhase1->id))
                @method('PATCH')
              @endif --}}

                      @csrf
                      {{-- {{ dd($auctionPhase1['send_date']) }} --}}
                      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
                          <label for="colFormLabel" class="font-weight-bold">Checklist Dokumen</label>
                          <div class="form-group">
                              @php
                              $files = collect($fileTypesPhase1);
                              // dd($files);
                              @endphp

                              @foreach($masterFileTypes as $key => $masterFile)
                              <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input" id="file-check-{{ $masterFile['id'] }}" name="file-{{ $masterFile['id'] }}" {{
                          $files->where('id', $masterFile['id'])
                                  ->whereNotNull('file_types_id')
                                  ->count() > 0 ? 'checked' : '' }}>
                                  <label class="custom-control-label" for="file-check-{{ $masterFile['id'] }}">{{ $masterFile['name'] }}</label>
                              </div>
                              @endforeach

                          </div>
                      </div>
                      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
                          <label for="colFormLabel" class="font-weight-bold">Data Tahap I</label>
                          <div class="form-group">
                              <label for="colFormLabel" class="font-weight-500">Tanggal Penyerahan Dokumen</label>
                              <input type="date" id="send_date" name="send_date" class="form-control" value="{{ isset($auctionPhase1->send_date) ? $auctionPhase1->send_date : '' }}">
                          </div>
                          <div class="form-group d-flex flex-column">
                              <label for="colFormLabel" class="font-weight-500">Yang menyerahkan</label>
                              <select id="sender_id" name="sender_id" class="form-control" style="border-right: 8px transparent solid;border-bottom: 15px;">
                                  <option value=""></option>
                                  @foreach($userOptions as $option)
                                  {{-- @if( $option->id == !empty($auctionPhase1->sender_id) || !empty($auctionPhase1->sender_id) ) --}}
                                  @if( isset($auctionPhase1->sender_id) && $auctionPhase1->sender_id == $option->id )
                                  <option selected value="{{ $option->id }}">{{ $option->nm_lengkap }}</option>
                                  @else
                                  <option value="{{ $option->id }}">{{ $option->nm_lengkap }}</option>
                                  @endif
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="colFormLabel" class="font-weight-500">No. Surat Lulus Dokumen Tahap I</label>
                              <input type="text" id="accepted_document_number" name="accepted_document_number" class="form-control" value="{{ isset($auctionPhase1->accepted_document_number) ? $auctionPhase1->accepted_document_number : '' }}">
                          </div>
                          <div class="form-group">
                              <label for="colFormLabel" class="font-weight-500">Tanggal Lulus Dokumen Tahap I</label>
                              <input type="date" id="accepted_date" name="accepted_date" class="form-control" value="{{ isset($auctionPhase1->accepted_date) ? $auctionPhase1->accepted_date : '' }}">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" id="project_id" name="project_id" value="{{ $projectId ?? '' }}" />
                              <input type="hidden" id="auction_id" name="auction_id" value="{{ isset($auctionPhase1->id) ? $auctionPhase1->id : '' }}" />
                              <input type="hidden" id="phase_number" name="phase_number" value="1" />
                              <button type="button" id="btn-auction1-submit" name="btn-auction1-submit" class="btn btn-lg btn-next-step btn-block btn-primary font-weight-bold" {{ isset($auctionPhase2->id) ? 'disabled' : '' }}>
                                  {{ isset($auctionPhase1->id) ? "Update" : "Submit" }}
                              </button>
                          </div>
                      </div>
                  </form>
              </div>
              {{-- END TAB 2 --}}

              {{-- TAB 3 --}}
              <div class="tab-pane fade" id="pills-contact-fill" role="tabpanel" aria-labelledby="pills-contact-tab-fill">
                  @if(isset($auctionPhase1->id) || isset($auctionPhase2->id))

                  <form id="create-auction-phase2-form" method="POST" action="{{ isset($auctionPhase2->id) ? route('auction.update') : route('auction.store') }}" enctype="multipart/form-data" autocomplete="off">

                      @if(isset($auctionPhase2->id))
                      @method('PATCH')
                      @endif

                      @csrf

                      {{-- <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
                <label for="colFormLabel" class="font-weight-bold">Checklist Dokumen</label>
                <div class="form-group">

                  @php
                    $files = collect($fileTypesPhase2);
                    dd($files);
                  @endphp

                  @foreach($masterFileTypes as $key => $masterFile)
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="file-check-2-{{ $masterFile['id'] }}"
                      name="file-2-{{ $masterFile['id'] }}"
                      {{ $files->where('id', $masterFile['id'])->whereNotNull('file_types_id')->count() > 0 ? 'checked' : '' }}
                      {{ $files->where('id', $masterFile['id'])->whereNotNull('file_types_id')->count() > 0 ? 'disabled' : '' }}>
                      <label class="custom-control-label" for="file-check-2-{{ $masterFile['id'] }}">{{ $masterFile['name'] }}</label>
              </div>
              @endforeach

          </div>
      </div> --}}
      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
          <label for="colFormLabel" class="font-weight-bold">Data Tahap II</label>

          <div class="form-group">
              <label for="colFormLabel" class="font-weight-500">Tanggal Penyerahan Dokumen</label>
              <input type="date" id="send_date" name="send_date" class="form-control" value="{{ $auctionPhase2->send_date ?? '' }}">
          </div>
          <div class="form-group">
              <label for="colFormLabel" class="font-weight-500">Yang menyerahkan</label>
              <select id="sender_id" name="sender_id" class="form-control" style="border-right: 8px transparent solid;border-bottom: 15px;">
                  <option value=""></option>
                  @foreach($userOptions as $option)
                  {{-- @if( $option->id == !empty($auctionPhase2->sender_id) || !empty($auctionPhase2->sender_id) ) --}}
                  @if( isset($auctionPhase2->sender_id) && $auctionPhase2->sender_id == $option->id )
                  <option selected value="{{ $option->id }}">{{ $option->nm_lengkap }}</option>
                  @else
                  <option value="{{ $option->id }}">{{ $option->nm_lengkap }}</option>
                  @endif
                  @endforeach
              </select>
          </div>
          <div class="form-group">
              <label for="colFormLabel" class="font-weight-500">No. Surat Lulus Dokumen Tahap II</label>
              <input type="text" id="accepted_document_number" name="accepted_document_number" class="form-control" value="{{ $auctionPhase2->accepted_document_number ?? '' }}">
          </div>
          <div class="form-group">
              <label for="colFormLabel" class="font-weight-500">Tanggal Lulus Dokumen Tahap II</label>
              <input type="date" id="accepted_date" name="accepted_date" class="form-control" value="{{ $auctionPhase2->accepted_date ?? '' }}">
          </div>
      </div>
      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column">
          <label for="colFormLabel" class="font-weight-bold">Penawaran Harga</label>
          <div class="form-group">
              <input type="file" id="quotation_letter_id" name="quotation_letter_id" class="form-control" accept="image/png, image/jpeg, image/jpg, application/pdf" />
              <input type="file" id="lampiran_lain" name="lampiran_lain" class="form-control" accept="image/png, image/jpeg, image/jpg, application/pdf" />

              <input name="fileIdsToBeDelete[]" type="hidden">
              <input name="fileNamesToBeDelete[]" type="hidden">

          </div>
      </div>
      @if(isset($phase2Files->files))
      <div class="row px-4 mx-0 my-3 py-3 rounded border border-light d-flex flex-column" style="max-height:300px;overflow-x:scroll;overflow-y:hidden;">
          <div class="images-wrapper flex-row mb-3">
              @foreach($phase2Files->files as $file)
              @if(!in_array(pathinfo("storage/project".$file->name, PATHINFO_EXTENSION), ['pdf','xls','xlsx','doc','docx']))
              {{-- jika file tipe gambar --}}
              <a id="document-{{ $file->id }}" href="{{ url("storage/project/".$file->name) }}" data-lightbox="documents" data-title="{{ url("storage/project/".$file->name) }}" class="bg-light p-2 rounded-lg mr-2">
                  <div class="d-flex flex-column mx-0 align-items-center">
                      <p class="badge badge-pill badge-light my-1">{{ $file->filetype->name }}</p>
                      <img data-id="{{ $file->id }}" src="{{ url("storage/project/".$file->name) }}" class="rounded mb-0" width="90px" height="70px" style="object-fit: contain;" data-toggle="tooltip" title="{{ $file->filetype->name }}" />
                  </div>
              </a>

              <button id="btn-delete-document_{{ $file->id }}" data-filename="{{ $file->name }}" type="button" class="btn-circular-delete mr-2" data-toggle="tooltip" title="hapus dokumen">
                  <i class="ri-delete-bin-line h6"></i>
              </button>
              @else

              @endif
              {{-- <p>{{ $file->name }}</p> --}}
              @endforeach
          </div>
      </div>
      @endif
      <div class="row">
          <div class="col-sm-12">
              <input type="hidden" id="project_id" name="project_id" value="{{ $projectId ?? '' }}" />
              <input type="hidden" id="auction_id" name="auction_id" value="{{ $auctionPhase2->id ?? '' }}" />
              <input type="hidden" id="phase_number" name="phase_number" value="2" />
              <button type="button" id="btn-auction2-submit" name="btn-auction2-submit" class="btn btn-lg btn-next-step btn-block btn-primary font-weight-bold">
                  {{ isset($auctionPhase2->id) ? "Update" : "Submit" }}
              </button>
          </div>
      </div>
      </form>
      <form id="close-project-form" method="POST" action="{{ route('project.closed') }}" enctype="multipart/form-data" autocomplete="off">
          @csrf
          <div class="row mt-2">
              <div class="col-sm-12">
                  <input type="hidden" id="project_id" name="project_id" value="{{ $projectId ?? '' }}" />
                  <button type="button" id="btn-close-project" name="btn-close-project" class="btn btn-lg btn-next-step btn-block btn-danger font-weight-bold">Closed Project</button>
              </div>
          </div>
      </form>
      @else
      <div class="alert text-white bg-info" role="alert">
          <div class="iq-alert-icon">
              <i class="ri-information-line"></i>
          </div>
          <div class="iq-alert-text">Data Penyusunan Dokumen Tahap I belum ada</div>
      </div>
      @endif
  </div>
  {{-- END TAB 3 --}}
  </div>

  </div>
  </div>

  <script type="text/javascript">
      $(document).ready(function() {

          $("#bond_amount").number(true, 0);

          var userId = "{{ $userId }}";
          var btnSubmit = $("#btn-bond-submit")
              , deletedDocumentId
              , deletedDocumentIds = []
              , deletedDocumentNames = [];

          function formValidationArea(selector, message) {
              selector.addClass("is-invalid");
              selector
                  .closest("div.with-validation")
                  .find(".invalid-feedback")
                  .html(message);
          }

          function beforeValidate() {
              $("input, select").removeClass("is-invalid");
              $("div").removeClass("is-invalid");
              $("div").find(".invalid-feedback").empty();
          }

          function doesntHasValidationError() {
              return (
                  !$("input").hasClass("is-invalid") && !$("div").hasClass("is-invalid") && !$("select").hasClass("is-invalid")
              );
          }

          function validateFormJampel() {
              let nomorPenunjukkan = $("#assignment_number")
                  , tanggalSuratPenunjukkan = $("#bond_assignment_date")
                  , tanggalMulaiBerlakuJaminan = $("#bond_start_date")
                  , tangalAkhirBerlakuJaminan = $("#bond_end_date")
                  , tanggalJaminanPelaksanaan = $("#bond_date")
                  , nilaiJaminan = $("#bond_amount")
                  , namaBank = $("#bank_name")
                  , nomorJaminan = $("#bond_number");

              if (nomorPenunjukkan.val().length < 1) {
                  formValidationArea(nomorPenunjukkan, "Nomor surat penunjukkan dan permintaan Jaminan pelaksanaan harus diisi");
              } else if (tanggalSuratPenunjukkan.val() === "") {
                  formValidationArea(tanggalSuratPenunjukkan, "Tanggal surat penunjukkan dan permintaan Jaminan pelaksanaan harus diisi")
              } else if (tanggalMulaiBerlakuJaminan.val() === "") {
                  formValidationArea(tanggalMulaiBerlakuJaminan, "Tanggal mulai berlaku jaminan harus diisi")
              } else if (tangalAkhirBerlakuJaminan.val() === "") {
                  formValidationArea(tangalAkhirBerlakuJaminan, "Tanggal akhir berlaku jaminan harus diisi")
              } else if (tanggalJaminanPelaksanaan.val() === "") {
                  formValidationArea(tanggalJaminanPelaksanaan, "Tanggal jaminan pelaksanaan harus diisi")
              } else if (nilaiJaminan.val().length < 1) {
                  formValidationArea(nilaiJaminan, "Nilai jaminan harus diisi");
              } else if (namaBank.val().length < 1) {
                  formValidationArea(namaBank, "Nama bank harus diisi");
              } else if (nomorJaminan.val().length < 1) {
                  formValidationArea(nomorJaminan, "Nomor jaminan harus diisi");
              }

          }

          $("#create-jampel-form").submit(function(evt) {
              evt.preventDefault();
              beforeValidate();
              validateFormJampel();
              if (doesntHasValidationError()) {
                  this.submit();
                  //$("#create-jampel-form").submit();
              }
          })

          // hapus dokumen penawaran harga
          $(document).on('click', 'button[id^="btn-delete-document_"]', function() {
              deletedDocumentId = $(this).attr('id').split('_')[1];
              deletedFileName = $(this).data('filename');
              $("#deleteDocumentModal").modal('show');
          });

          // user klik icon delete di gambar, muncul modal konfirmasi
          $(document).on('click', '#deleteDocumentModal #btn-confirm-delete', function(e) {
              e.preventDefault();

              deletedDocumentIds.push(deletedDocumentId);
              deletedDocumentNames.push(deletedFileName);

              $('input:hidden[name=fileIdsToBeDelete\\[\\]]').val(deletedDocumentIds);
              $('input:hidden[name=fileNamesToBeDelete\\[\\]]').val(deletedDocumentNames);

              $(`#document-${deletedDocumentId},#btn-delete-document_${deletedDocumentId}`).addClass('d-none');
              $("#deleteDocumentModal").modal('hide');

          });

          // cancel konfirmasi hapus dokumen penawaran harga
          $(document).on('click', '#deleteDocumentModal #btn-cancel-delete', function() {
              // alert('tercancel')
              deletedDocumentId = "";
              $("#deleteDocumentModal").modal('hide');
          });

      })

  </script>
