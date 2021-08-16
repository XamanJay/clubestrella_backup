@extends('layouts.dashboard')

@section('page-styles')
    <!-- DataTables Styles with Bootstrap -->
    
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
<div class="container">
    <h1 class="dashboard-h">Lista de StopSales Cuenta Comercial</h1>
    <a href="{{ route('create.stop.sale.comercial',App::getLocale()) }}" class="btn btn-detail" style="margin-bottom: 30px;">
        <i class="fas fa-plus"></i>Nuevo StopSale Cuenta Comercial
    </a>
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
    <table id="stop_sale_comercial" class="display hover center-text" style="width:100%">
        <thead>
            <tr style="text-align:center;">
                <th></th>
                <th class="gold-T">Id</th>
                <th class="gold-T">Empieza</th>
                <th class="gold-T">Termina</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="text-align: center;">
                <th></th>
                <th class="gold-T">Id</th>
                <th class="gold-T">Empieza</th>
                <th class="gold-T">Termina</th>
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
            var id = d.id;
            return '<div class="row detail_cargo">'+
                    '<div class="col-12 col-sm-3">'+
                        '<div class="row" style="padding:0px;margin:0px;">'+
                            '<div class="col-12">'+
                                '<a href="'+url+'/es/destroy-stop-sale-comercial/'+id+'" class="btn btn-detail">Eliminar StopSale</a>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        }
        $(document).ready(function() {

            
            var table = $('#stop_sale_comercial').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/StopSaleComercial.php',
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
                    { data: 'id' },
                    { data: 'startDate' },
                    { data: 'endDate' }
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
            $('#stop_sale_comercial tbody').on('click', 'td.details-control', function () {
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