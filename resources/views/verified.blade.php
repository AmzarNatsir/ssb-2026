<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen — PT. Sumber Setia Budi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px 40px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .icon-wrapper {
            width: 96px;
            height: 96px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.35);
            animation: pulse-glow 2.5s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 30px rgba(16, 185, 129, 0.3); }
            50%       { box-shadow: 0 0 60px rgba(16, 185, 129, 0.6); }
        }

        .icon-wrapper svg {
            width: 48px;
            height: 48px;
            color: #ffffff;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #34d399;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 20px;
        }

        .badge::before {
            content: '';
            width: 7px;
            height: 7px;
            background: #34d399;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.3; }
        }

        h1 {
            font-size: 26px;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .subtitle {
            font-size: 15px;
            color: #94a3b8;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 20px 24px;
            text-align: left;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row .dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .info-row span {
            font-size: 13.5px;
            color: #cbd5e1;
            line-height: 1.5;
        }

        .footer {
            margin-top: 36px;
            font-size: 12px;
            color: #475569;
        }

        .footer strong {
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-wrapper">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <div class="badge">Dokumen Valid</div>

        <h1>QR Code Terverifikasi</h1>

        <p class="subtitle">
            Dokumen ini telah diterbitkan dan diverifikasi secara resmi oleh
            <strong style="color: #e2e8f0;">PT. Sumber Setia Budi</strong>
            melalui sistem HRD SSB.
        </p>

        <div class="info-box">
            <div class="info-row">
                <span class="dot"></span>
                <span>QR Code ini merupakan tanda keaslian dokumen resmi perusahaan.</span>
            </div>
            <div class="info-row">
                <span class="dot"></span>
                <span>Dokumen dinyatakan <strong style="color: #f1f5f9;">sah dan valid</strong> sesuai prosedur yang berlaku.</span>
            </div>
            <div class="info-row">
                <span class="dot"></span>
                <span>Untuk informasi lebih lanjut, hubungi bagian HRD PT. Sumber Setia Budi.</span>
            </div>
        </div>

        <div class="footer">
            Sistem HRD &mdash; <strong>PT. Sumber Setia Budi</strong><br>
            <a href="https://hrd.ptssb.my.id" style="color: #475569; text-decoration: none;">hrd.ptssb.my.id</a>
        </div>
    </div>
</body>
</html>
