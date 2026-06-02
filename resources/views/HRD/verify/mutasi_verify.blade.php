<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutation Document Verification - PT. SSB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f3ff;
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
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.05);
            max-width: 500px;
            width: 100%;
            overflow: hidden;
            border: 1px solid rgba(124, 58, 237, 0.08);
        }
        .card-header-status {
            background: #7c3aed;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .status-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
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
            background: #fdfdfd;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .approver-avatar {
            width: 40px;
            height: 40px;
            background: #f3e8ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7c3aed;
            margin-right: 12px;
        }
        .footer-note {
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
            padding: 20px;
            line-height: 1.5;
            background-color: #faf5ff;
        }
        .badge-mutasi {
            background: #f3e8ff;
            color: #6b21a8;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .mutation-path {
            background: #faf5ff;
            border: 1px solid #f3e8ff;
            border-radius: 12px;
            padding: 15px;
            margin-top: 8px;
        }
        .path-block {
            display: flex;
            flex-direction: column;
        }
        .path-step {
            display: flex;
            align-items: flex-start;
        }
        .step-indicator {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .step-indicator.old {
            background-color: #e2e8f0;
            color: #475569;
        }
        .step-indicator.new {
            background-color: #7c3aed;
            color: white;
        }
        .step-details {
            display: flex;
            flex-direction: column;
        }
        .step-title {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .step-value {
            font-weight: 600;
            font-size: 13px;
        }
        .path-divider {
            width: 2px;
            height: 15px;
            background-color: #e2e8f0;
            margin-left: 11px;
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
                    <div class="value text-primary">Surat Keputusan Mutasi Karyawan (SK Mutasi)</div>
                </div>
                <div class="detail-item">
                    <div class="label">Document Number</div>
                    <div class="value">{{ $dt->no_surat ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Employee Name</div>
                    <div class="value">{{ $dt->get_profil->nm_lengkap ?? 'N/A' }}</div>
                </div>
                <div class="detail-item">
                    <div class="label">Employee NIK</div>
                    <div class="value">
                        <span class="badge-mutasi">{{ $dt->get_profil->nik ?? 'N/A' }}</span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="label">Position & Department Mutation</div>
                    <div class="mutation-path">
                        <div class="path-block">
                            <!-- Old Position -->
                            <div class="path-step">
                                <div class="step-indicator old">
                                    <i class="ti ti-arrow-back-up"></i>
                                </div>
                                <div class="step-details">
                                    <div class="step-title">Previous Job & Department</div>
                                    <div class="step-value text-muted">
                                        {{ $dt->get_jabatan_lama->nm_jabatan ?? 'N/A' }}
                                        <div style="font-size: 11px;">Dept: {{ $dt->get_dept_lama->nm_dept ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Connector -->
                            <div class="path-divider"></div>
                            
                            <!-- New Position -->
                            <div class="path-step">
                                <div class="step-indicator new">
                                    <i class="ti ti-chevron-down"></i>
                                </div>
                                <div class="step-details">
                                    <div class="step-title" style="color: #7c3aed;">New Job & Department</div>
                                    <div class="step-value text-dark">
                                        {{ $dt->get_jabatan_baru->nm_jabatan ?? 'N/A' }}
                                        <div style="font-size: 11px; font-weight: 500;" class="text-primary">Dept: {{ $dt->get_dept_baru->nm_dept ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="label">Effective Date</div>
                    <div class="value text-success">
                        {{ $dt->tgl_efektif_br ? date('d M Y', strtotime($dt->tgl_efektif_br)) : 'N/A' }}
                    </div>
                </div>
                <div class="detail-item">
                    <div class="label">Document Date</div>
                    <div class="value">
                        {{ $dt->tgl_surat ? date('d M Y', strtotime($dt->tgl_surat)) : 'N/A' }}
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
            This is an electronically generated Mutation Document by SSB Smart System.
            Validation was successful against the original system records.
        </div>
    </div>
</body>
</html>
