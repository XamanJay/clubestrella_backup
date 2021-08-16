@extends('layouts.app')

@section('page-styles')
    <!-- DataTables Styles with Bootstrap -->
    
    <!-- DataTables Editor Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/datatable-editor/css/dataTables.bootstrap4.css') }}">
    <!--link rel="stylesheet" href="{{ asset('plugins/datatable-editor/css/responsive.bootstrap4.css') }}"-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.0.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@endsection

@section('content')
    <div class="container" style="margin-top: 80px;">

        <div class="headline">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h1 class="gold-title cinzel-font"><small style="font-size: 15px;">SR.</small> {{ $user['data']['nombre'] }}</h1>
                </div>
                <div class="col-12 col-sm-6 info-client">
                    <img src="{{ asset('img/icons/coins.png') }}" alt="Puntos Clubestrella" id="points-img">
                    <p>Puntos: {{ number_format($user['data']['puntos']['puntos_totales']) }}</p>
                    <p>E-mail: {{ $user['data']['email']}}</p>
                    <p>Empresa: {{ $user['data']['cliente']['empresa']}}</p>
                    <p>Número de Socio: {{ $user['data']['cliente']['numero_socio']}}</p>
                    <p>Fecha de Registro: {{ \Carbon\Carbon::parse( $user['data']['created_at'])->format('d/m/Y') }}</p>
                </div>
            </div>
            
        </div>


        <ul class="nav nav-pills mb-3" id="pills-cargos" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-carga-puntos" data-toggle="pill" href="#puntos-cargados" role="tab" aria-controls="puntos-cargados" aria-selected="true">Puntos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-puntos-redimidos" data-toggle="pill" href="#puntos-redimidos" role="tab" aria-controls="puntos-redimidos" aria-selected="false">Canjes</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-puntos-devueltos" data-toggle="pill" href="#puntos-devueltos" role="tab" aria-controls="puntos-devueltos" aria-selected="false">Devoluciones</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="puntos-cargados" role="tabpanel" aria-labelledby="pills-carga-puntos">
                <table id="carga_puntos" class="display hover responsive" style="width:100%">
                    <thead>
                        <tr style="text-align:center;">
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Folio</th>
                            <th class="gold-T">RFC</th>
                            <th class="gold-T">Fecha</th>
                            <th class="gold-T">Puntos</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="text-align: center;">
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Folio</th>
                            <th class="gold-T">RFC</th>
                            <th class="gold-T">Fecha</th>
                            <th class="gold-T">Puntos</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane fade" id="puntos-redimidos" role="tabpanel" aria-labelledby="pills-puntos-redimidos">
                <table id="puntos_redimidos" class="display hover responsive" style="width:100%">
                    <thead>
                        <tr style="text-align:center;">
                            <th></th>
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Regalo</th>
                            <th class="gold-T">Cantidad</th>
                            <th class="gold-T">Fecha de Canje</th>
                            <th class="gold-T">Puntos</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="text-align: center;">
                            <th></th>
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Regalo</th>
                            <th class="gold-T">Cantidad</th>
                            <th class="gold-T">Fecha de Canje</th>
                            <th class="gold-T">Puntos</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="tab-pane fade" id="puntos-devueltos" role="tabpanel" aria-labelledby="pills-puntos-devueltos">
                <table id="puntos_devueltos" class="display hover responsive" style="width:100%">
                    <thead>
                        <tr style="text-align:center;">
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Nombre</th>
                            <th class="gold-T">Puntos</th>
                            <th class="gold-T">Responsable</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr style="text-align: center;">
                            <th class="gold-T">Id</th>
                            <th class="gold-T">Nombre</th>
                            <th class="gold-T">Puntos</th>
                            <th class="gold-T">Responsable</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
    
@endsection

@section('page-scripts')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugins/datatable-editor/js/dataTables.editor.js') }}"></script>
    <script src="{{ asset('plugins/datatable-editor/js/editor.bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/datatable-editor/js/editor.bootstrap4.js') }}"></script>
    <script src="{{ asset('plugins/datatable-editor/js/editor.foundation.js') }}"></script>
    <script src="{{ asset('plugins/datatable-editor/js/editor.jqueryui.js') }}"></script>
    <script src="{{ asset('plugins/datatable-editor/js/editor.semanticui.js') }}"></script>
    <!-- Select Datatables -->
    <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <!-- Datatables Responsive -->
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <!-- ColReorder Datatables -->
    <script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
    <!-- Buttons Datatables -->
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <!-- jszip Datatables -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script type="text/javascript"> 

        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            var CheckIn = d.redencion_puntos.fecha_inicio;
            var CheckOut =d.redencion_puntos.fecha_salida;
            var noches = d.redencion_puntos.noches;
            var cuartos = d.redencion_puntos.cuartos;
            if(CheckIn == null){
                CheckIn = "No Aplica";
            }
            if(CheckOut == null){
                CheckOut = "No Aplica";
            }
            if(noches == null){
                noches = "No Aplica";
            }
            if(cuartos == null){
                cuartos = "No Aplica";
            }
            return '<table cellpadding="5" cellspacing="0" border="0" class="detail_cargo" style="">'+
                '<tr>'+
                    '<td>CheckIn:</td>'+
                    '<td>'+CheckIn+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>CheckOut:</td>'+
                    '<td>'+CheckOut+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Noches:</td>'+
                    '<td>'+noches+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Cuartos:</td>'+
                    '<td>'+cuartos+'</td>'+
                '</tr>'+
            '</table>';
        }

        $(document).ready(function() {

            
            $('#carga_puntos').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Puntos_Cargados.php?user_id={{Auth::id()}}',
                responsive: {
                    details: true
                },
                dom: 'Bfrtip',
                columns: [
                    { data: 'id' },
                    { data: 'factura_folio' },
                    { data: 'rfc' },
                    { data: 'fecha_carga' },
                    { data: 'puntos' },
                ],
                select: true,
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fas fa-file-download" style="margin-right:15px;"></i>Exportar',
                        buttons: [
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ]
            });

            
            var table =  $('#puntos_redimidos').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Puntos_Redimidos.php?user_id={{Auth::id()}}',
                responsive: {
                    details: true
                },
                dom: 'Bfrtip',
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": '<i class="fas fa-plus-circle"></i>'
                    },
                    { data: 'redencion_puntos.id' },
                    { data: 'regalos.nombre' },
                    { data: 'redencion_puntos.cantidad' },
                    { data: 'redencion_puntos.fecha_redencion' },
                    { data: 'redencion_puntos.puntos' },
                ],
                "order": [[1, 'desc']],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                select: true,
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fas fa-file-download" style="margin-right:15px;"></i>Exportar',
                        buttons: [
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ]
            });


            // Add event listener for opening and closing details
            $('#puntos_redimidos tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                console.log(tr);
                var row = table.row( tr );
        
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });

            $('#puntos_devueltos').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Puntos_Devueltos.php?user_id={{Auth::id()}}',
                responsive: {
                    details: true
                },
                dom: 'Bfrtip',
                columns: [
                    { data: 'devoluciones.id' },
                    { data: 'regalos.nombre' },
                    { data: 'devoluciones.puntos' },
                    { data: 'devoluciones.representante' }
                ],
                select: true,
                buttons: [
                    {
                        extend: 'collection',
                        text: '<i class="fas fa-file-download" style="margin-right:15px;"></i>Exportar',
                        buttons: [
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ]
            });
        });
        
        
    </script>
@endsection
