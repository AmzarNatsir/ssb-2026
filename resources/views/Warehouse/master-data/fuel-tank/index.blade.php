@extends('Workshop.layouts.master')

@section('content')
    <div id="content-page" class="content-page">
        <div class="cantainer-fluid">
            <div class="row" style="margin-bottom: 10px">
                @if (current_user_has_permission_to('warehouse-master_data.fuel_tank.create'))
                    <div class="col-lg-12">
                        <button onclick="resetModal();" style="margin-top: auto" type="button" class="btn btn-success mb-3"
                            data-toggle="modal" data-target="#addModal">Add New Fuel Tank</button>
                    </div>
                @endif
            </div>
            <div class="row">
                @foreach ($fuel_tanks as $fuelTank)
                    <div class="col-lg-3">
                        <div class="iq-card iq-card-block iq-card-stretch">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">{{ $fuelTank->number }}</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle text-primary" id="dropdownMenuButton3"
                                            data-toggle="dropdown">
                                            <i class="ri-more-2-fill"></i>
                                        </span>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            @if (current_user_has_permission_to('warehouse-master_data.fuel_tank.print'))
                                                <a class="dropdown-item"
                                                    href="{{ route('warehouse.master-data.fuel-tank.history', $fuelTank->id) }}"><i
                                                        class="ri-eye-fill mr-2"></i>View History</a>
                                            @endif
                                            @if (current_user_has_permission_to('warehouse-master_data.fuel_tank.delete'))
                                                <form method="POST" id="delete-{{ $fuelTank->id }}"
                                                    action="{{ route('warehouse.master-data.fuel-tank.destroy', $fuelTank->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="confirmDelete({{ $fuelTank->id }});" type="button"
                                                        class="dropdown-item"><i
                                                            class="ri-delete-bin-6-fill mr-2"></i>Delete</button>
                                                </form>
                                            @endif
                                            @if (current_user_has_permission_to('warehouse-master_data.fuel_tank.edit'))
                                                <a class="dropdown-item" href="#" data-id={{ $fuelTank->id }}
                                                    data-capacity={{ $fuelTank->capacity }}
                                                    data-stock={{ $fuelTank->stock }} data-number="{{ $fuelTank->number }}"
                                                    onclick="editFuelTank(this)" data-toggle="modal"
                                                    data-target="#addModal">
                                                    <i class="ri-pencil-fill mr-2"></i>Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="iq-card-body p-2">
                                <div id="menu-chart-{{ $fuelTank->id }}"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Fuel Tank</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addModalForm" action={{ route('warehouse.master-data.fuel-tank.store') }} method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="email">Number</label>
                            <input class="form-control" name="number" type="text" id="number" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Capacity</label>
                            <input class="form-control" name="capacity" type="text" id="capacity" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Stock</label>
                            <input class="form-control" name="stock" type="text" id="stock" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="submitAdd" type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editFuelTank(el) {
            $('#addModalForm').attr('action', '/master-data/fuel-tank/' + $(el).data('id'));
            $('#addModalForm').prepend('<input type="hidden" name="_method" value="put">');
            $('input[name="number"]').val($(el).data('number'));
            $('input[name="capacity"]').val($(el).data('capacity'));
            $('input[name="stock"]').val($(el).data('stock'));
        }

        function resetModal(method = 'add') {

            if (method == 'add') {
                $('#addModalForm').attr('action', '/master-data/fuel-tank/');
                $('#addModalForm').find('input[name="_method"]').remove();
            }

            $('input[name="number"]').val('');
            $('input[name="capacity"]').val('');
            $('input[name="stock"]').val('');
        }

        function confirmDelete(id) {
            $confirm = confirm('Anda Yakin?')
            if ($confirm) {
                $('#delete-' + id).submit();
            }
        }

        $(document).ready(function() {

            @foreach ($fuel_tanks as $fuelTank)
                var option{{ $fuelTank->id }} = {
                    series: [{{ number_format(($fuelTank->stock / $fuelTank->capacity) * 100, 2) }}],
                    chart: {
                        height: 300,
                        type: 'radialBar',
                        // offsetY: -10
                    },
                    colors: ["#1759a1"],
                    plotOptions: {
                        radialBar: {
                            startAngle: -135,
                            endAngle: 135,
                            dataLabels: {
                                name: {
                                    fontSize: '16px',
                                    color: undefined,
                                    offsetY: 120
                                },
                                value: {
                                    offsetY: 76,
                                    fontSize: '22px',
                                    color: undefined,
                                    formatter: function(val) {
                                        return val + "%";
                                    }
                                }
                            }
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            // shadeIntensity: 0.15,
                            // inverseColors: false,
                            type: "horizontal",
                            // opacityFrom: 1,
                            // opacityTo: 1,
                            gradientToColors: ["#a0765a"],
                            stops: [0, 100]
                        },
                    },
                    stroke: {
                        lineCap: "butt"
                    },
                    labels: ['{{ $fuelTank->stock . '/' . $fuelTank->capacity }} L'],
                };

                var chart{{ $fuelTank->id }} = new ApexCharts(document.querySelector(
                    "#menu-chart-{{ $fuelTank->id }}"), option{{ $fuelTank->id }});
                chart{{ $fuelTank->id }}.render();
            @endforeach

        });
    </script>
@endsection
