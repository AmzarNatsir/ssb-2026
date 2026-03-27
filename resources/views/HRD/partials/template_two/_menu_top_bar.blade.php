<!-- Sidebar  -->
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
       <a href="{{ url('hrd/home') }}">
        <img src="{{ asset('assets/images/logo.png') }}" class="img-fluid" alt="">
        <span>SSB-HRD</span>
       </a>
       <div class="iq-menu-bt align-self-center">
          <div class="wrapper-menu">
             <div class="line-menu half start"></div>
             <div class="line-menu"></div>
             <div class="line-menu half end"></div>
          </div>
       </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li><a href="{{ url('hrd/home') }}" class="iq-waves-effect"><i class="ri-home-4-line"></i><span>Home</span></a></li>
                @if (auth()->user()->nik=="999999999")
                <li><a href="{{ url('hrd/dashboard') }}" class="iq-waves-effect"><i class="ri-pie-chart-box-line"></i><span>Dashboard</span></a></li>
                <li>
                    <a href="#menu-level" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-chat-check-line"></i><span>Data Master</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="menu-level" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/masterdata/profilperusahaan') }}">Profil Perusahaan</a></li>
                        <li>
                            <a href="#masterstruktur" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Struktur</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="masterstruktur" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/masterdata/leveljabatan') }}">Level Jabatan</a></li>
                                <li><a href="{{ url('hrd/masterdata/divisi') }}">Divisi</a></li>
                                <li><a href="{{ url('hrd/masterdata/departemen') }}">Departemen</a></li>
                                <li><a href="{{ url('hrd/masterdata/subdepartemen') }}">Sub Departemen</a></li>
                                <li><a href="{{ url('hrd/masterdata/jabatan') }}">Jabatan</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('hrd/masterdata/bankpenggajian') }}">Bank Penggajian</a></li>
                        <li><a href="{{ url('hrd/masterdata/dokumenkaryawan') }}">Dokumen Karyawan</a></li>
                        <li><a href="{{ url('hrd/masterdata/jeniscutiizin') }}">Jenis Cuti/Izin</a></li>
                        <li>
                            <a href="#masterperdis" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Perjalanan Dinas</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="masterperdis" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/masterdata/perdis/fasilitas') }}">Fasilitas</a></li>
                                <li><a href="{{ url('hrd/masterdata/perdis/uangsaku') }}">Uang Saku</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('hrd/masterdata/pelaksana_diklat') }}">Lembaga Pelaksana Diklat</a></li>
                        <li><a href="{{ url('hrd/masterdata/pelatihan') }}">Pelatihan</a></li>
                        <li><a href="{{ url('hrd/masterdata/jenissp') }}">Tingkatan SP</a></li>
                        <li><a href="{{ url('hrd/masterdata/jenisPelanggaran') }}">Jenis Pelanggaran</a></li>
                        <li><a href="{{ url('hrd/masterdata/potongan_gaji') }}">Item Potongan Gaji</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#Setup" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><i class="fa fa-gear"></i><span>Setup</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="Setup" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/setup/harilibur') }}">Pengaturan Hari Libur</a></li>
                        <li><a href="{{ url('hrd/setup/persetujuan') }}">Pengaturan Persetujuan</a></li>
                        <li>
                            <a href="#setupmanajemenpengguna" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Manajemen Pengguna</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="setupmanajemenpengguna" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/setup/manajemengroup') }}">Manajemen Group</a></li>
                                <li><a href="{{ url('hrd/setup/manajemenpengguna') }}">Manajemen Pengguna</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('hrd/setup/memointernal') }}">Memo Internal</a></li>
                        <li>
                            <a href="#masterpenggajian" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="masterpenggajian" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/setup/manajemengapok') }}">Gaji Pokok</a></li>
                                <li><a href="{{ url('hrd/setup/manajemenbpjs') }}">Pengaturan BPJS</a></li>
                                <li><a href="{{ url('hrd/setup/manajemenpot') }}">Potongan Gaji</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#recruitment" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-address-book-o"></i><span>Recruitment</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="recruitment" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/recruitment/daftar_pengajuan_tenaga_kerja') }}">Permintaan TK</a></li>
                        <li><a href="{{ url('hrd/recruitment/aplikasi_pelamar') }}">Aplikasi Pelamar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#Pendataan" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><i class="ri-profile-line"></i><span>Pendataan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="Pendataan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/karyawan/daftar') }}">Karyawan</a></li>
                        <li><a href="{{ url('hrd/perubahanstatus') }}">Perubahan Status</a></li>
                        <li><a href="{{ url('hrd/mutasi') }}">Mutasi Rotasi</a></li>
                        <li><a href="{{ url('hrd/cutiizin') }}">Cuti/Izin</a></li>
                        <li><a href="{{ url('hrd/perjalanandinas') }}">Perjalanan Dinas</a></li>
                        <li><a href="{{ url('hrd/suratperingatan') }}">Surat Peringatan (SP)</a></li>
                        <li><a href="{{ url('hrd/pelatihan') }}">Pelatihan</a></li>
                        <li>
                            <a href="#penggajian" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="penggajian" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/penggajian') }}">Penggajian</a></li>
                                <li><a href="{{ url('hrd/penggajian/slipgaji') }}">Pembuatan Slip Gaji</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('hrd/absensi') }}">Absensi</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pengajuan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-user-line"></i><span>Pengajuan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="pengajuan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja') }}">Permintaan Tenaga Kerja</a></li>
                        <li><a href="{{ url('hrd/perubahanstatus/list_pengajuan') }}">Perubahan Status</a></li>
                        <li><a href="{{ url('hrd/mutasi/listpengajuan') }}">Mutasi Rotasi</a></li>
                        <li><a href="{{ url('hrd/perjalanandinas/listpengajuan') }}">Perjalanan Dinas</a></li>
                        <li><a href="{{ url('hrd/pelatihan/listpengajuan') }}">Pelatihan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#persetujuan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-user-line"></i><span>Persetujuan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="persetujuan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja/list_persetujuan') }}">Permintaan Tenaga Kerja</a></li>
                        <li><a href="{{ route('persetujaunRecruitment') }}">Aplikasi Pelamar</a></li>
                        <li><a href="{{ url('hrd/cutiizin/daftarpengajuancuti') }}">Cuti</a></li>
                        <li><a href="{{ url('hrd/cutiizin/daftarpengajuanizin') }}">Izin</a></li>
                        <li><a href="{{ url('hrd/penggajian/persetujuan') }}">Penggajian</a></li>
                        <li><a href="{{ url('hrd/perubahanstatus/list_persetujuan') }}">Perubahan Status</a></li>
                        <li><a href="{{ url('hrd/mutasi/listpersetujuan') }}">Mutasi Rotasi</a></li>
                        <li><a href="{{ url('hrd/perjalanandinas/persetujuan/listpengajuan') }}">Perjalanan Dinas</a></li>
                        <li><a href="{{ url('hrd/pelatihan/persetujuan/listpengajuan') }}">Pelatihan</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#pelaporan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pie-chart-box-line"></i><span>Pelaporan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="pelaporan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li><a href="{{ url('hrd/pelaporan/karyawan') }}">Karyawan</a></li>
                        <li>
                            <a href="#penggajian_lap" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="penggajian_lap" class="iq-submenu collapse iq-submenu-data">
                                <li><a href="{{ url('hrd/pelaporan/penggajian') }}">Penggajian</a></li>
                                <li><a href="{{ url('hrd/pelaporan/bpjsketenagakerjaan') }}">BPJS Ketenagakerjaan</a></li>
                                <li><a href="{{ url('hrd/pelaporan/bpjskesehatan') }}">BPJS Kesehatan</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('hrd/pelaporan/perubahanstatus') }}">Perubahan Status</a></li>
                        <li><a href="{{ url('hrd/pelaporan/mutasi') }}">Mutasi</a></li>
                        <li><a href="{{ url('hrd/pelaporan/cutiizin') }}">Cuti/Izin</a></li>
                        <li><a href="{{ url('hrd/pelaporan/perdis') }}">Perjalanan Dinas</a></li>
                        <li><a href="{{ url('hrd/pelaporan/sp') }}">Surat Peringatan</a></li>
                    </ul>
                </li>
                 @else
                    @php
                    foreach(auth()->user()->roles->pluck('id') as $val){
                        $id_role = $val;
                    }
                    @endphp
                    @if(!empty($id_role))
                        @php $menu_user = App\Helpers\Hrdhelper::get_permission_user($id_role); @endphp
                        @if(auth()->user()->can('dashboard_view'))
                        <li><a href="{{ url('hrd/dashboard') }}" class="iq-waves-effect"><i class="ri-pie-chart-box-line"></i><span>Dashboard</span></a></li>
                        @endif
                        @if(auth()->user()->can('master_data_view'))
                        <li>
                            <a href="#menu-level" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-chat-check-line"></i><span>Data Master</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="menu-level" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @if(auth()->user()->can('master_data_profil_perusahaan_view'))
                                <li><a href="{{ url('hrd/masterdata/profilperusahaan') }}">Profil Perusahaan</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_struktur_view'))
                                <li>
                                    <a href="#masterstruktur" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Struktur</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="masterstruktur" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/masterdata/leveljabatan') }}">Level Jabatan</a></li>
                                        <li><a href="{{ url('hrd/masterdata/divisi') }}">Divisi</a></li>
                                        <li><a href="{{ url('hrd/masterdata/departemen') }}">Departemen</a></li>
                                        <li><a href="{{ url('hrd/masterdata/subdepartemen') }}">Sub Departemen</a></li>
                                        <li><a href="{{ url('hrd/masterdata/jabatan') }}">Jabatan</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('master_data_bank_penggajian_view'))
                                <li><a href="{{ url('hrd/masterdata/bankpenggajian') }}">Bank Penggajian</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_dokumen_karyawan_view'))
                                <li><a href="{{ url('hrd/masterdata/dokumenkaryawan') }}">Dokumen Karyawan</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_jenis_cuti_view'))
                                <li><a href="{{ url('hrd/masterdata/jeniscutiizin') }}">Jenis Cuti/Izin</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_perjalanan_dinas_view'))
                                <li>
                                    <a href="#masterperdis" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Perjalanan Dinas</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="masterperdis" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/masterdata/perdis/fasilitas') }}">Fasilitas</a></li>
                                        <li><a href="{{ url('hrd/masterdata/perdis/uangsaku') }}">Uang Saku</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('master_data_lembaga_pelaksanaan_diklat_view'))
                                <li><a href="{{ url('hrd/masterdata/pelaksana_diklat') }}">Lembaga Pelaksana Diklat</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_pelatihan_view'))
                                <li><a href="{{ url('hrd/masterdata/pelatihan') }}">Pelatihan</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_tingkatan_sp_view'))
                                <li><a href="{{ url('hrd/masterdata/jenissp') }}">Tingkatan SP</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_jenis_pelanggaran_view'))
                                <li><a href="{{ url('hrd/masterdata/jenisPelanggaran') }}">Jenis Pelanggaran</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_item_potongan_gaji_view'))
                                <li><a href="{{ url('hrd/masterdata/potongan_gaji') }}">Item Potongan Gaji</a></li>
                                @endif
                                @if(auth()->user()->can('master_data_kpi_view'))
                                <li>
                                    <a href="#masterKPI" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>KPI</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="masterKPI" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/masterdata/perspektifKPI') }}">Perspektif KPI</a></li>
                                        <li><a href="{{ url('hrd/masterdata/sasaranKPI') }}">Sasaran Strategi KPI</a></li>
                                        <li><a href="{{ url('hrd/masterdata/tipeKPI') }}">Tipe KPI</a></li>
                                        <li><a href="{{ url('hrd/masterdata/satuanKPI') }}">Satuan KPI</a></li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->can('setup_view'))
                        <li>
                            <a href="#Setup" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><i class="fa fa-gear"></i><span>Setup</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="Setup" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @if(auth()->user()->can('setup_pengaturan_hari_libur_view'))
                                <li><a href="{{ url('hrd/setup/harilibur') }}">Pengaturan Hari Libur</a></li>
                                @endif
                                @if(auth()->user()->can('setup_pengaturan_persetujuan_view'))
                                <li><a href="{{ url('hrd/setup/persetujuan') }}">Pengaturan Persetujuan</a></li>
                                @endif
                                @if(auth()->user()->can('setup_manajemen_pengguna_view'))
                                <li>
                                    <a href="#setupmanajemenpengguna" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Manajemen Pengguna</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="setupmanajemenpengguna" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/setup/manajemengroup') }}">Manajemen Group</a></li>
                                        <li><a href="{{ url('hrd/setup/manajemenpengguna') }}">Manajemen Pengguna</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('setup_memo_internal_view'))
                                <li><a href="{{ url('hrd/setup/memointernal') }}">Memo Internal</a></li>
                                @endif
                                @if(auth()->user()->can('setup_penggajian_view'))
                                <li>
                                    <a href="#masterpenggajian" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="masterpenggajian" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/setup/manajemengapok') }}">Gaji Pokok</a></li>
                                        <li><a href="{{ url('hrd/setup/manajemenbpjs') }}">Pengaturan BPJS</a></li>
                                        <li><a href="{{ url('hrd/setup/manajemenpot') }}">Potongan Gaji</a></li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->can('job_description_view'))
                        <li><a href="{{ url('hrd/jobdesc') }}" class="iq-waves-effect"><i class="ri-folder-line"></i><span>Job Description</span></a></li>
                        @endif
                        @if(auth()->user()->can('key_performance_indicator_view'))
                        <li><a href="{{ url('hrd/kpi') }}" class="iq-waves-effect"><i class="ri-key-line"></i><span>KPI</span></a></li>
                        @endif
                        @if(auth()->user()->can('pendataan_recruitment_view'))
                        <li>
                            <a href="#recruitment" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="fa fa-address-book-o"></i><span>Recruitment</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="recruitment" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                <li><a href="{{ url('hrd/recruitment/daftar_pengajuan_tenaga_kerja') }}">Permintaan TK</a></li>
                                <li><a href="{{ url('hrd/recruitment/aplikasi_pelamar') }}">Aplikasi Pelamar</a></li>
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->can('pendataan_view'))
                        <li>
                            <a href="#Pendataan" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><i class="ri-profile-line"></i><span>Pendataan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="Pendataan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @if(auth()->user()->can('pendataan_karyawan_view'))
                                <li><a href="{{ url('hrd/karyawan/daftar') }}">Karyawan</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_perubahan_status_view'))
                                <li><a href="{{ url('hrd/perubahanstatus') }}">Perubahan Status</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_mutasi_view'))
                                <li><a href="{{ url('hrd/mutasi') }}">Mutasi</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_cuti_izin_view'))
                                <li><a href="{{ url('hrd/cutiizin') }}">Cuti/Izin</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_perjalanan_dinas_view'))
                                <li><a href="{{ url('hrd/perjalanandinas') }}">Perjalanan Dinas</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_surat_peringatan_view'))
                                <li><a href="{{ url('hrd/suratperingatan') }}">Surat Peringatan (SP)</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_pendidikan_dan_pelatihan_view'))
                                <li><a href="{{ url('hrd/pelatihan') }}">Pelatihan</a></li>
                                @endif
                                @if(auth()->user()->can('pendataan_penggajian_view'))
                                <li>
                                    <a href="#penggajian" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="penggajian" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/penggajian') }}">Penggajian</a></li>
                                        <li><a href="{{ url('hrd/penggajian/slipgaji') }}">Pembuatan Slip Gaji</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('pendataan_absensi_view'))
                                <li><a href="{{ url('hrd/absensi') }}">Absensi</a></li>
                                @endif
                                <li><a href="{{ url('hrd/pinjaman_karyawan') }}">Pinjaman Karyawan</a></li>
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->can('pengajuan_view'))
                        <li>
                            <a href="#pengajuan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-user-line"></i><span>Pengajuan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="pengajuan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @if(auth()->user()->can('pengajuan_permintaan_tenaga_kerja_view'))
                                <li><a href="{{ url('hrd/recruitment/pengajuan_tenaga_kerja') }}">Permintaan Tenaga Kerja</a></li>
                                @endif
                                @if(auth()->user()->can('pengajuan_perubahan_status_view'))
                                <li><a href="{{ url('hrd/perubahanstatus/list_pengajuan') }}">Perubahan Status</a></li>
                                @endif
                                @if(auth()->user()->can('pengajuan_mutasi_rotasi_view'))
                                <li><a href="{{ url('hrd/mutasi/listpengajuan') }}">Mutasi Rotasi</a></li>
                                @endif
                                @if(auth()->user()->can('pengajuan_perjalanan_dinas_view'))
                                <li><a href="{{ url('hrd/perjalanandinas/listpengajuan') }}">Perjalanan Dinas</a></li>
                                @endif
                                @if(auth()->user()->can('pengajuan_pelatihan_view'))
                                <li><a href="{{ url('hrd/pelatihan/listpengajuan') }}">Pelatihan</a></li>
                                @endif
                                @if(auth()->user()->can('pengajuan_surat_peringatan_view'))
                                <li><a href="{{ url('hrd/suratperingatan/listPengajuan') }}">Surat Peringatan</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->can('persetujuan_view'))
                        <li><a href="{{ url('hrd/persetujuan') }}" class="iq-waves-effect"><i class="ri-user-line"></i><span>Approval</span></a></li>
                        @endif
                        @if(auth()->user()->can('pelaporan_view'))
                        <li>
                            <a href="#pelaporan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pie-chart-box-line"></i><span>Pelaporan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                            <ul id="pelaporan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @if(auth()->user()->can('pelaporan_karyawan_view'))
                                <li><a href="{{ url('hrd/pelaporan/karyawan') }}">Karyawan</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_penggajian_view'))
                                <li>
                                    <a href="#penggajian_lap" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><span>Penggajian</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                                    <ul id="penggajian_lap" class="iq-submenu collapse iq-submenu-data">
                                        <li><a href="{{ url('hrd/pelaporan/penggajian') }}">Penggajian</a></li>
                                        <li><a href="{{ url('hrd/pelaporan/bpjsketenagakerjaan') }}">BPJS Ketenagakerjaan</a></li>
                                        <li><a href="{{ url('hrd/pelaporan/bpjskesehatan') }}">BPJS Kesehatan</a></li>
                                    </ul>
                                </li>
                                @endif
                                @if(auth()->user()->can('pelaporan_perubahan_status_view'))
                                <li><a href="{{ url('hrd/pelaporan/perubahanstatus') }}">Perubahan Status</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_mutasi_view'))
                                <li><a href="{{ url('hrd/pelaporan/mutasi') }}">Mutasi</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_cuti_izin_view'))
                                <li><a href="{{ url('hrd/pelaporan/cutiizin') }}">Cuti/Izin</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_perjalanan_dinas_view'))
                                <li><a href="{{ url('hrd/pelaporan/perdis') }}">Perjalanan Dinas</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_surat_peringatan_view'))
                                <li><a href="{{ url('hrd/pelaporan/sp') }}">Surat Peringatan</a></li>
                                @endif
                                @if(auth()->user()->can('pelaporan_absensi_view'))
                                <li><a href="{{ url('hrd/pelaporan/absensi') }}">Absensi</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                    @endif
                @endif
            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
</div>
