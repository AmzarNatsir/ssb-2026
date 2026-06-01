<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Document Verification - PT. SSB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f6;
            color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .verification-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }
        .card-header-status {
            background: #10b981;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .status-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 15px;
        }
        .detail-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .value {
            font-weight: 600;
            font-size: 15px;
        }
        .approver-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .approver-avatar {
            width: 40px;
            height: 40px;
            background: #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            margin-right: 12px;
        }
        .footer-note {
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
            padding: 20px;
            line-height: 1.5;
        }
        .badge-cuti {
            background: #ccfbf1;
            color: #0f766e;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .leave-period {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 8px;
            padding: 12px;
            margin-top: 8px;
        }
        .leave-dates {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        .date-item {
            text-align: center;
            flex: 1;
        }
        .date-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .date-value {
            font-weight: 600;
            color: #0f766e;
            margin-top: 2px;
        }
        .arrow-separator {
            color: #64748b;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="verification-card">
        <div class="card-header-status">
            <div class="status-icon">
                <i class="ti ti-shield-check"></i>
            </div>
            <h4 class="mb-1 fw-bold">Document Authenticity Verified</h4>
            <p class="mb-0 opacity-75 small">PT. SUMBER SETIA BUDI</p>
        </div>

        <div class="p-4">
            <div class="mb-4">
                <div class="detail-item">
                    <div class="label">Document Type</div>
                    <div class="value text-primary">Surat Cuti (Employee Leave Document)</div>
                </div>
                <div class="detail-item">
                    <div class="label">Document Number</div>
                    <div class="value">{{ $dt->nomor_surat ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Employee Name</div>
                    <div class="value">{{ $dt->profil_karyawan->nm_lengkap ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Employee NIK</div>
                    <div class="value">
                        <span class="badge-cuti">{{ $dt->profil_karyawan->nik ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Leave Type</div>
                    <div class="value">{{ $dt->get_jenis_cuti->nm_jenis_ci ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Leave Period</div>
                    <div class="value">
                        <div class="leave-period">
                            <div class="leave-dates">
                                <div class="date-item">
                                    <div class="date-label">Start Date</div>
                                    <div class="date-value">
                                        {{ $dt->tgl_awal ? date('d M Y', strtotime($dt->tgl_awal)) : 'N/A' }}
                                    </div>
                                </div>
                                <div class="arrow-separator">
                                    <i class="ti ti-arrow-right"></i>
                                </div>
                                <div class="date-item">
                                    <div class="date-label">End Date</div>
                                    <div class="date-value">
                                        {{ $dt->tgl_akhir ? date('d M Y', strtotime($dt->tgl_akhir)) : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Total Leave Days</div>
                    <div class="value">{{ $dt->jumlah_hari ?? '0' }} Days</div>
                </div>
                <div class="detail-item">
                    <div class="label">Return to Work Date</div>
                    <div class="value">
                        @php
                        $tgl_masuk = (empty($dt->tgl_masuk)) ? date('Y-m-d', strtotime($dt->tgl_akhir . ' +1 day')) : $dt->tgl_masuk;
                        @endphp
                        {{ $tgl_masuk ? date('d M Y', strtotime($tgl_masuk)) : 'N/A' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Document Date</div>
                    <div class="value">
                        {{ $dt->tanggal_surat ? date('d M Y', strtotime($dt->tanggal_surat)) : 'N/A' }}
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <h6 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="ti ti-users me-2 text-primary"></i> Company Representative (Approver)
                </h6>
                @if($dt->get_current_approve)
                <div class="approver-item">
                    <div class="approver-avatar">
                        <i class="ti ti-user-check"></i>
                    </div>
                    <div>
                        <div class="fw-semibold small">{{ $dt->get_current_approve->nm_lengkap }}</div>
                        <div style="font-size: 11px; color: #64748b;">
                            {{ $dt->get_current_approve->get_jabatan->nm_jabatan ?? 'Company Representative' }}
                        </div>
                    </div>
                </div>
                @else
                <div class="approver-item">
                    <div class="approver-avatar">
                        <i class="ti ti-user"></i>
                    </div>
                    <div>
                        <div class="fw-semibold small">Company Representative</div>
                        <div style="font-size: 11px; color: #64748b;">
                            Information not available
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="footer-note">
            <i class="ti ti-info-circle me-1"></i>
            This is an electronically generated Leave Document by SSB Smart System.
            Validation was successful against the original system records.
        </div>
    </div>
</body>
</html>
