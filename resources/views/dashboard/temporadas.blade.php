@extends('layouts.dashboard')

@section('page-styles')
    <!-- DataTables Editor Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/datatable-editor/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatable-editor/css/responsive.bootstrap4.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.2/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.1.2/css/rowGroup.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.0.0/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
@endsection

@section('content')
<div class="container box-edit">
    <div class="row">
        <div class="col-12">
            <ul class="breadcrumbCustom">
                <li><a href="{{ route('dashboard',App::getLocale()) }}" class="purple-T"><i class="fas fa-home"></i>Dashboard</a></li>
                <li>-></li>
                <li>Temporadas Comerciales</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-calendar-alt edit-icon"></i>Listado de Temporadas Comerciales</h2>
    <a href="{{ route('create.temporada',App::getLocale()) }}" class="btn btn-add"><i class="fas fa-plus" style="margin-right: 10px;"></i>Nueva Temporada Comercial</a>
    @if(session('success'))
        <div class="alert alert-success " >
            <ul style="list-style: none;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger " >
            <ul style="list-style: none;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    <table id="temporada_comercial" class="display hover center-text" style="width:100%">
        <thead>
            <tr style="text-align:center;">
                <th></th>
                <th class="gold-T">Id</th>
                <th class="gold-T">Fecha de Inicio</th>
                <th class="gold-T">Fecha de Termino</th>
                <th class="gold-T">Tarifa Base</th>
                <th class="gold-T">Tarifa Pax</th>
                <th class="gold-T">Tarifa Ali.</th>
                <th class="gold-T">Upgrade Hab.</th>
                <th class="gold-T">Hotel</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="text-align: center;">
                <th></th>
                <th class="gold-T">Id</th>
                <th class="gold-T">Fecha de Inicio</th>
                <th class="gold-T">Fecha de Termino</th>
                <th class="gold-T">Tarifa Base</th>
                <th class="gold-T">Tarifa Pax</th>
                <th class="gold-T">Tarifa Ali.</th>
                <th class="gold-T">Upgrade Hab.</th>
                <th class="gold-T">Hotel</th>
            </tr>
        </tfoot>
    </table>

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
        var url = "{{ url('/') }}";
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            var id = d.temporada_comercial.id;
            return '<div class="row detail_cargo">'+
                    '<div class="col-12 col-sm-4">'+
                        '<a class="btn item_btn" href="'+url+'/es/destroy-temporada/'+id+'"><i class="fas fa-calendar-alt"></i> Eliminar Temporada</a>'+
                    '</div>'+
                '</div>';
        }

        $(document).ready(function() {

            
            var table = $('#temporada_comercial').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Temporada_Comercial.php',
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
                    { data: 'temporada_comercial.id' },
                    { data: 'temporada_comercial.fecha_inicio' },
                    { data: 'temporada_comercial.fecha_termino' },
                    { 
                        data: 'temporada_comercial.tarifa_base',
                        render: function(data, type) {
                            return "$ "+data
                        }
                    },
                    { 
                        data: 'temporada_comercial.tarifa_pax',
                        render: function(data, type) {
                            return "$ "+data
                        }
                    },
                    { 
                        data: 'temporada_comercial.tarifa_alimentos',
                        render: function(data, type) {
                            return "$ "+data
                        }
                    },
                    { 
                        data: 'temporada_comercial.tarifa_upgrade_habitacion',
                        render: function(data, type) {
                            return "$ "+data
                        }
                    },
                    { data: 'hoteles_gph.nombre' }
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

            // Add event listener for opening and closing details
            $('#temporada_comercial tbody').on('click', 'td.details-control', function () {
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

        });

    </script>
@endsection