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
                <li>Cuentas Comerciales</li>
            </ul>
        </div>
    </div>
    <h2 class="title-dashboard"><i class="fas fa-pencil-alt edit-icon"></i>Listado de Empresas</h2>
    @if(session('error'))
        <div class="alert alert-danger " >
            <ul style="list-style: none;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('error') }}</li>
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success " >
            <ul style="list-style: none;">
                <li><i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>{{ session('success') }}</li>
            </ul>
        </div>
    @endif
    <a href="{{ route('new.empresa',App::getLocale()) }}" class="btn btn-add"><i class="fas fa-plus" style="margin-right: 10px;"></i>Nueva Cuenta Comercial</a>
    <table id="cuenta_comercial" class="display hover center-text" style="width:100%">
        <thead>
            <tr style="text-align:center;">
                <th></th>
                <th class="gold-T">Código</th>
                <th class="gold-T">Nombre Cuenta</th>
                <th class="gold-T">Limite Credito</th>
                <th class="gold-T">RFC</th>
                <th class="gold-T">Credito Hab.</th>
                <th class="gold-T">Credito Ali.</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="text-align: center;">
                <th></th>
                <th class="gold-T">Código</th>
                <th class="gold-T">Nombre Cuenta</th>
                <th class="gold-T">Limite Credito</th>
                <th class="gold-T">RFC</th>
                <th class="gold-T">Credito Hab.</th>
                <th class="gold-T">Credito Ali.</th>
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
                        '<a class="btn item_btn" href="'+url+'/es/edit-empresa/'+id+'"><i class="fas fa-building"></i> Editar Empresa</a>'+
                    '</div>'+
                    '<div class="col-12 col-sm-3">'+
                        '<a class="btn item_btn" href="'+url+'/es/delete-empresa/'+id+'"><i class="fas fa-trash-alt"></i> Eliminar Empresa</a>'+
                    '</div>'+
                '</div>';
        }

        $(document).ready(function() {

            
            var table = $('#cuenta_comercial').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Cuenta_Comercial.php',
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
                    { data: 'codigo' },
                    { data: 'nombre_cuenta' },
                    { data: 'limite_credito' },
                    { data: 'company_rfc' },
                    { 
                        data: 'credito_habitacion',
                        render: function(data, type) {
                            if (data == true) {
                                return "Si"
                            }else{
                                return "No"
                            }
                        }
                    },
                    { 
                        data: 'credito_alimentos' ,
                        render: function(data, type) {
                            if (data == true) {
                                return "Si"
                            }else{
                                return "No"
                            }
                        }
                    }
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
            $('#cuenta_comercial tbody').on('click', 'td.details-control', function () {
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