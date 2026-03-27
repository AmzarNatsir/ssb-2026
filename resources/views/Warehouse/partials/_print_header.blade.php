<table style="text-align: center; border-bottom: solid black 1px" width="100%">
    <tr>
        <td style="text-align:left">
        <img src="{{ \App\ProfilPerusahaan::getLogoPerusahaanUrl() }}" alt=""
                style="max-width: 50px">
        </td>
        <td style="vertical-align: top">
            <h1
                style="font-family: Arial, Helvetica, sans-serif;font-weight:bolder;font-size:30px; color:rgb(49, 190, 255);margin:0px">
                {{ strtoupper(\App\ProfilPerusahaan::getNmPerusahaan()) }}</h1>
            <p style="margin: 0px;font-size:12px ">{{ \App\ProfilPerusahaan::getAlamat() }}</p>
        </td>
    </tr>
</table>
