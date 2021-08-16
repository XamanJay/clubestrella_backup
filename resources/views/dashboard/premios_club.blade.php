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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection

@section('content')
<div class="container">
    @if(session('privileges'))
        <div class="alert alert-danger">
            <p style="margin-bottom: 0px;color:black;"><i class="fas fa-bell" style="margin-right: 10px;"></i>{{session('privileges')}}</p>   
        </div>
    @endif
    <h1 class="dashboard-h"><i class="fas fa-pencil-alt edit-icon"></i>Listado Premios Club Estrella</h1>
    <table id="premios" class="display hover center-text" style="width:100%">
        <thead>
            <tr style="text-align:center;">
                <th></th>
                <th class="gold-T">Nombre</th>
                <th class="gold-T">Puntos</th>
                <th class="gold-T">Tags</th>
                <th class="gold-T">Categoria</th>
            </tr>
        </thead>
        <tfoot>
            <tr style="text-align: center;">
                <th></th>
                <th class="gold-T">Nombre</th>
                <th class="gold-T">Puntos</th>
                <th class="gold-T">Tags</th>
                <th class="gold-T">Categoria</th>
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
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success btn-devolucion',
                cancelButton: 'btn btn-danger btn-devolucion'
            },
            buttonsStyling: false
        });
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            var id = d.regalos.id;
            return '<div class="row detail_cargo">'+
                    '<div class="col-12 col-sm-3">'+
                        '<div class="row" style="padding:0px;margin:0px;">'+
                            '<div class="col-12">'+
                                '<a href="'+url+'/es/edit-premio-club/'+id+'" class="btn btn-detail">Editar</a>'+
                            '</div>'+
                            '<div class="col-12">'+
                                '<button class="btn item_btn" onclick="deleteConfirmation('+id+')">Eliminar</button>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        }

        function deleteConfirmation(id) {
            swalWithBootstrapButtons.fire({
                title: 'Deseas eliminar este Regalo?',
                text: 'Id: '+id,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                icon:'warning'
            }).then(function (e) {
                if (e.value === true) {
                    
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/es/delete-premio-club')}}",
                        data: {
                            _token: CSRF_TOKEN,
                            regalo_id: id,
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            console.log(results);
                            console.log(results.message);
                            if (results.code === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡¡Genial!!',
                                    text: results.message,
                                    showConfirmButton: false,
                                    footer: '<a class="btn btn_dev" href="javascript:window.location.reload();">Ok</a>'
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps!!',
                                    text: results.message,
                                    showConfirmButton: false,
                                    footer: '<a class="btn btn_dev" href>Ok</a>'
                                })
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }  

        $(document).ready(function() {

            
            var table = $('#premios').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Premios.php',
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
                    { data: 'regalos.nombre' },
                    { data: 'regalos.puntos' },
                    { data: 'regalos.tag' },
                    { data: 'categorias.nombre' }
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
            $('#premios tbody').on('click', 'td.details-control', function () {
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