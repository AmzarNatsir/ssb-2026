<html>
    <title>Stock Card - PT. Sumber Setia Budi </title>
    <head>
        <style>
            body{
              font-size: 10px;
              font-family: Arial, Helvetica, sans-serif;
              margin: 10px;
              text-transform: uppercase;
            }
        </style>
    </head>
    <div style="text-align: center">
        <h1>STOK OPNAME</h1>
    </div>
    <body>
        <table style="border-collapse: collapse;width:100%" >
            <tr>
                <td style="border-bottom: solid black 1px">Kode Barang</td>
                <td style="border-bottom: solid black 1px">Nama Barang</td>
                <td style="border-bottom: solid black 1px">Kategori Barang</td>
                <td style="border-bottom: solid black 1px">Kuantitas</td>
                <td style="border-bottom: solid black 1px">Satuan</td>
                <td style="border-bottom: solid black 1px">Hitung #1</td>
                <td style="border-bottom: solid black 1px">Hitung 32</td>
            </tr>
            @foreach ($sparePart as $item)
            <tr>
                <td>{{ $item->part_number }}</td>
                <td>{{ $item->part_name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->uop->name }}</td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </table>
    </body>
</html>
