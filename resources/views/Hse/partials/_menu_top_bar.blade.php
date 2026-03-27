<div id="root" userId="{{ auth()->id() }}" class="tab-menu-horizontal-x">
    {{-- <div class="container">
        <div class="row">
            <div class="iq-menu-horizontal-tab">
            <nav class="iq-sidebar-menu">
                    <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
                        <li><a href="{{ url('') }}" class="iq-waves-effect"><i class="ri-pie-chart-box-line"></i><span>Dashboard</span></a></li>
    <li>
        <a href="#menu-level" class="iq-waves-effect collapsed" data-toggle="collapse">
            <i class="ri-chat-check-line"></i>
            <span>Project Management</span>
            <i class="ri-arrow-right-s-line iq-arrow-right"></i>
        </a>

        <ul id="menu-level" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <li>
                <a href="#masterstruktur" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                    <span>Project</span>
                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                </a>
                <ul id="masterstruktur" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ url('project/') }}">Daftar Project</a></li>
                    <li><a href="{{ route('preanalyst.index') }}">Pre Analyst, Scoring & Rekomendasi Project</a></li>
                    <li><a href="{{ url('project/approval') }}">Project Approval</a></li>
                    <li><a href="{{ route('boq.index') }}">Bill Of Quantity</a></li>
                    <li><a href="{{ route('bond.index') }}">JamPel & Penyusunan Dokumen</a></li>
                    <li><a href="{{ route('fulfillment.index') }}">Pemenuhan Unit</a></li>
                    <li><a href="{{ route('lho.index') }}">Operasional Harian</a></li>
                    <li><a href="{{ route('project.mutasi.index') }}">Pengajuan Mutasi</a></li>
                </ul>

            </li>
            <li>
                <a href="#masterstruktur" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><span>Survey</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                <ul id="masterstruktur" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ url('survey') }}">Daftar Survey</a></li>
                </ul>
            </li>
            <li>
                <a href="#masterstruktur" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><span>Komite</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                <ul id="masterstruktur" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ url('project/komite') }}">Daftar Komite</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#menu-level" class="iq-waves-effect collapsed" data-toggle="collapse">
            <i class="ri-chat-check-line"></i>
            <span>HSE</span>
            <i class="ri-arrow-right-s-line iq-arrow-right"></i>
        </a>
        <ul id="menu-setup" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <li>
                <a href="#master-data" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                    <span>Safety Induction</span>
                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                </a>
                <ul id="master-data" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ route('hse.safetyinduction.index') }}">Daftar Safety Induction</a></li>
                    <li><a href="{{ route('hse.safetyinduction.quesioner') }}">Daftar Quesioner</a></li>
                    <li><a href="{{ route('hse.safetyinduction.template') }}">Template Quesioner</a></li>
                </ul>
            </li>
            <li>
                <a href="#master-data" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                    <span>P2H</span>
                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                </a>
                <ul id="master-data" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ route('hse.p2h') }}">Daftar P2H</a></li>
                    <li><a href="{{ route('hse.p2h.create') }}">Form P2H</a></li>
                </ul>
            </li>

        </ul>
    </li>
    <li>
        <a href="#menu-setup" class="iq-waves-effect collapsed" data-toggle="collapse">
            <i class="ri-chat-check-line"></i>
            <span>Setup</span>
            <i class="ri-arrow-right-s-line iq-arrow-right"></i>
        </a>

        <ul id="menu-setup" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <li>
                <a href="#master-data" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                    <span>Master Data</span>
                    <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                </a>
                <ul id="master-data" class="iq-submenu collapse iq-submenu-data">
                    <li><a href="{{ route('MasterData.dokumen') }}">Dokumen</a></li>
                    <li><a href="{{ route('document.index') }}">Fixed Dokumen</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#pelaporan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-pie-chart-box-line"></i><span>Pelaporan</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
        <ul id="pelaporan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
            <li><a href="{{ url('hrd/pelaporan/karyawan') }}">Karyawan</a></li>
        </ul>
    </li>
    </ul>
    </nav>
</div>
</div>
</div> --}}
</div>
@push('scripts')
<script type="text/javascript">
    if (window) {
        localStorage.setItem("HseUserId", "{{ auth()->id() }}");
    }

</script>
<script type="module" crossorigin src="{{ asset('js/hse/vite/assets/index-369d15a7.js') }}"></script>


@endpush
