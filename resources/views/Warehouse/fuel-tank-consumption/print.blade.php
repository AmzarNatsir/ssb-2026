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
    <body>
        <table style="border-collapse: collapse; border-radius: 5px; margin: 0 auto; width: 100%" border="1" >
            <tr>
                <td rowspan="2">logo</td>
                <td><h3>STOCK CARD</h3></td>
                <td>Part Name : {{ $sparePart->part_name }}</td>
            </tr>
            <tr>
                <td>Item Code : </td>
                <td>Part Number : {{ $sparePart->part_number }}</td>
            </tr>
            <tr>
                <td colspan="2">Location : {{ $sparePart->location }}</td>
                <td>Unit : </td>
            </tr>
        </table>
        <br>
        <br>
        <table class="table" style="border-collapse: collapse; margin:0 auto; width: 100%" border="1"  >
            <thead>
               <tr>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Uraian</th>
                  <th scope="col">In</th>
                  <th scope="col">Out</th>
                  <th scope="col">Stock</th>

               </tr>
            </thead>
            <tbody>
                @forelse ($stockChanges as $stockChange)
                    <tr>
                        <td>{{ $stockChange->created_at }}</td>
                        <td>
                            {!! $stockChange->description !!}
                        </td>
                        <td>{{ $stockChange->method == \App\Models\Warehouse\StockChanges::INCREASE ? $stockChange->updated_stock - $stockChange->stock : 0 }} </td>
                        <td>{{ $stockChange->method == \App\Models\Warehouse\StockChanges::DEDUCT ? $stockChange->stock - $stockChange->updated_stock : 0 }}</td>
                        <td>{{{ $stockChange->updated_stock }}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>
