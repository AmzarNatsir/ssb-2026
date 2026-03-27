@php
	$fl_logo = App\Helpers\Hrdhelper::get_profil_perusahaan()->logo_perusahaan;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <style>
    	@page {
            margin: 0cm 0cm;
        }

        .pagenum:before {
        	content: counter(page);
		}

    header {
        position: fixed;
        top: 0.5cm;
        left: 0.5cm;
        right: 0.5cm;
        height: 2cm;
    }

    footer {
      position: fixed;
      bottom:1cm;
      text-align: center;
    }

    .printed_by {
      position: fixed;
      bottom: 1cm;
      right: 1cm;
      text-align: right;
    }

    body {
      /*margin : 150px 50px;*/
      font-size: 12px;
      font-family: 'Poppins', sans-serif;
      margin-top: 3cm;
      margin-left: 1cm;
      margin-right: 1cm;
      margin-bottom: 2cm;
		}

		.font-poppins {
			font-family: 'Poppins', sans-serif;
		}

    .header {
      text-align:center;
      margin-top:1rem;
      margin-bottom:1rem;
    }

    .table-mutasi {
      width:100%;
      border:none;
      text-transform:uppercase;
      background-color: #ffffff;
      filter: alpha(opacity=40);
      opacity: 0.95;
      border:1px black solid;
      font-size:.6rem;
    }
    .table-mutasi th, td {
      padding: .5rem;
      font-size:.7rem;
    }

    .table-mutasi tfoot th, td {
      /* padding:1.5rem 1rem 1.5rem 1rem; */
    }
    </style>
</head>
<body>
    <header>
        <div class="information">
            <table width="100%">
                <tr>
                    <td align="left" style="width: 50%;">
                    <img src="{{ url(Storage::url('logo_perusahaan/'.$fl_logo)) }}" alt="Logo" width="100px" width="auto" class="logo"/>
                    </td>
                    <td align="right" style="width: 50%;">
                        <h2>PT. SUMBER SETIA BUDI</h2>
                        {{-- <pre> --}}
                            https://pt-ssb.co.id<br>
                            POMALA - KOLAKA - SULAWESI TENGGARA - INDONESIA
                        {{-- </pre> --}}
                    </td>
                </tr>
                <tr><td colspan="2"><hr></td></tr>
            </table>
        </div>
    </header>

  <h3 class="card-title" style="text-align: center;margin-top:2rem;">FORM PENGAJUAN MUTASI KARYAWAN</h3>

  <table class="table-mutasi">
    <thead>
      <tr>
        <th colspan="4">
            <h4>DATA KARYAWAN</h4>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Tanggal Pengajuan</td>
        <td>{{ date("d/m/Y H:i:s", strtotime($projectMutasi[0]->created_at)) }}</td>

        <td>Tanggal Efektif/Mutasi</td>
        <td>{{ date("d/m/Y H:i:s", strtotime($projectMutasi[0]->eff_date)) }}</td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>{{ $projectMutasi[0]->employee->nm_lengkap }}</td>
        <td>Alasan Mutasi</td>
        <td>{{ $projectMutasi[0]->ketera }}</td>
      </tr>
      <tr>
        <td>NIK</td>
        <td>{{ $projectMutasi[0]->employee->nik }}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>JABATAN</td>
        <td>{{ $projectMutasi[0]->employee->get_jabatan->nm_jabatan }}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>DEPARTEMEN</td>
        <td>{{ $projectMutasi[0]->employee->get_departemen->nm_dept }}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="4">Nama tersebut diusulkan mutasi</th>
      </tr>
      <tr>
        <td>Departemen</td>
        <td>{{ $projectMutasi[0]->department->nm_dept }}</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>{{ $projectMutasi[0]->jabatan->nm_jabatan }}</td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>

    <h3 class="card-title" style="text-align: center;margin-top:2rem;">
        TANDA TANGAN PERSETUJUAN
    </h3>

  <table style="width:100%;text-align:center;">
    <thead>
      <tr>
        <th style="text-align:center;height:5.5rem;vertical-align:bottom;text-decoration: underline;">1</th>
        <th style="text-align:center;height:5.5rem;vertical-align:bottom;text-decoration: underline;">2</th>
        <th style="text-align:center;height:5.5rem;vertical-align:bottom;text-decoration: underline;">3</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="width:35%;font-weight:700;">
            <p>Manager HRD</p>
        </td>
        <td style="width:35%;font-weight:700;">Ka. Mekanik</td>
        <td style="width:35%;font-weight:700;">Pengawas Lingkungan</td>
      </tr>
    </tbody>
  </table>

  <footer>
    <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span>
		Hal <span class="pagenum"></span>
	</footer>
</body>
</html>
