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
                <td><h3>FUEL HISTORY</h3></td>
                <td>Fuel Tank Number : {{ $fuelTank->number }}</td>
            </tr>
            <tr>
                <td>Capacity : {{ $fuelTank->capacity }}</td>
                <td>Stock : {{ $fuelTank->stock }} </td>
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
                @forelse ($fuelChanges as $fuelChange)
                    <tr>
                        <td>{{ $fuelChange->created_at }}</td>
                        <td>
                            {!! $fuelChange->description !!}
                        </td>
                        <td>{{ $fuelChange->method == \App\Models\Warehouse\FuelChanges::INCREASE ? $fuelChange->updated_stock - $fuelChange->stock : 0 }} </td>
                        <td>{{ $fuelChange->method == \App\Models\Warehouse\fuelChanges::DEDUCT ? $fuelChange->stock - $fuelChange->updated_stock : 0 }}</td>
                        <td>{{{ $fuelChange->updated_stock }}}</td>
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
