<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>    
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/tender.css') }}"/>
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
    </style>	
</head>
<body>
  <header>
		<div style="display: flex;flex-direction: row;justify-content: center;text-align: right;">
			<div style="flex:1;">&nbsp;</div>
			<div style="flex:1;padding-bottom: 1.5rem;">			
				<h7 class="font-weight-bold" style="font-size:.9rem;margin-bottom:0cm;">PT. SUMBER SETIA BUDI</h7>
        <p style="font-size:.8rem;margin-bottom:0cm;padding-bottom:0cm;">https://pt-ssb.co.id</p>
        <p style="font-size:.8rem;margin-bottom:0cm;padding-bottom:0cm;">POMALA - KOLAKA</p>
        <p style="font-size:.8rem;margin-bottom:0cm;padding-bottom:0cm;">Sulawesi Tenggara, Indonesia</p>
			</div>	
		</div>
  </header>
  <h5 class="font-poppins font-weight-bold" style="text-align:left;margin-top:1rem;margin-bottom:0px;">Inspection P2H</h5>
  <p class="font-poppins " style="margin-top:0px;">No. Assignment : {{ $p2h->assignment_no }}</p>

  <br/>
	<table style="width:100%;border:none;margin-bottom:2rem;">
    <tbody>
			<tr>
				<td style="width:5%;">Tanggal</td>
				<td style="width:40%;">{{ date("d/m/Y H:i:s", strtotime($p2h->created_at)) }}</td>
			</tr>
      <tr>
				<td style="width:5%;">Equipment</td>
				<td style="width:40%;">{{ $p2h->equipment->name }}</td>
			</tr>
      <tr>
				<td style="width:5%;">Lokasi</td>
				<td style="width:40%;">{{ $p2h->location->location_name }}</td>
			</tr>
      <tr>
				<td style="width:5%;">Officer</td>
				<td style="width:40%;">{{ $p2h->officer->karyawan->nm_lengkap }}</td>
			</tr>
      <tr>
				<td  colspan="2"></td>
			</tr>
    </tbody>
  </table>
  
  <h6 class="font-poppins font-weight-bold">Inspection Item</h6>
  <hr/>
  @foreach($p2h->checkpoints as $key => $checkpoint)
    <p class="font-poppins font-weight-bold">{{ ucfirst($checkpoint->checkpointItems[0]['name']) }}</p>    
    <table style="width:100%;border:none;margin-bottom:2rem;">
      <tbody>
      @foreach ($checkpoint->properties as $keyProp => $properties)
        <tr>
          <td style="width:30%;">{{ str_replace("_", " ", $keyProp) }}</td>
          <td>
            @if($key > 0)
              {{ $properties == "1" ? "baik" : "rusak" }}
            @else
              {{ $properties }}
            @endif
          </td>
          </tr>
      @endforeach
      </tbody>
    </table>
  @endforeach
  <footer>
    <span class="printed_by">printed by : {{ auth()->user()->nama }} {{ date("d/m/Y H:i:s", strtotime(now())) }}</span>
		Hal <span class="pagenum"></span>
	</footer>
</body>
</html>