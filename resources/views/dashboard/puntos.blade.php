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
    <div class="headline">
        <div class="row">
            <div class="col-12">
                <ul class="breadcrumbCustom">
                    <li><a href="{{ route('dashboard',App::getLocale()) }}" class="purple-T"><i class="fas fa-home"></i>Dashboard</a></li>
                    <li>-></li>
                    <li>Cliente</li>
                </ul>
            </div>
            <div class="col-12 col-sm-6">
                <h1 class="gold-title cinzel-font"><small style="font-size: 15px;">SR.</small> {{ $user->nombre }}</h1>
            </div>
            <div class="col-12 col-sm-6 info-client">
                <img src="{{ asset('img/icons/coins.png') }}" alt="Puntos Clubestrella" class="img-fluid">
                <p>Puntos: {{ number_format($user->puntos->puntos_totales) }}</p>
                <p>E-mail: {{ $user->email}}</p>
                <p>Empresa: {{ $user->cliente->empresa}}</p>
                <p>Número de Socio: {{ $user->cliente->numero_socio}}</p>
                <p>Fecha de Registro: {{ \Carbon\Carbon::parse( $user->created_at)->format('d/m/Y') }}</p>
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
            <table id="carga_puntos" class="display hover center-text" style="width:100%">
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
            <table id="puntos_redimidos" class="display hover center-text" style="width:100%">
                <thead>
                    <tr style="text-align:center;">
                        <th></th>
                        <th class="gold-T">Id</th>
                        <th class="gold-T">Regalo</th>
                        <th class="gold-T">Cantidad</th>
                        <th class="gold-T">Fecha de Canje</th>
                        <th class="gold-T">Puntos</th>
                        <th class="gold-T">Representante</th>
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
                        <th class="gold-T">Representante</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane fade" id="puntos-devueltos" role="tabpanel" aria-labelledby="pills-puntos-devueltos">
            <table id="puntos_devueltos" class="display hover center-text" style="width:100%">
                <thead>
                    <tr style="text-align:center;">
                        <th></th>
                        <th class="gold-T">Id</th>
                        <th class="gold-T">Canje</th>
                        <th class="gold-T">Puntos</th>
                        <th class="gold-T">Fecha</th>
                        <th class="gold-T">Representante</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr style="text-align: center;">
                        <th></th>
                        <th class="gold-T">Id</th>
                        <th class="gold-T">Canje</th>
                        <th class="gold-T">Puntos</th>
                        <th class="gold-T">Fecha</th>
                        <th class="gold-T">Representante</th>
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
        var representante = "{{ $user->nombre. " ".$user->apellidos }}";
        var url = "{{ url('/') }}";
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
            // `d` is the original data object for the row
            var CheckIn = d.redencion_puntos.fecha_inicio;
            var CheckOut =d.redencion_puntos.fecha_salida;
            var noches = d.redencion_puntos.noches;
            var cuartos = d.redencion_puntos.cuartos;
            var comentarios = d.redencion_puntos.comentarios;
            var id = d.redencion_puntos.id;
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
            return '<div class="row detail_cargo">'+
                    '<div class="col-12 col-sm-3">'+
                        '<div class="row" style="padding:0px;margin:0px;">'+
                            '<div class="col-12">CheckIn:</div>'+
                            '<div class="col-12">CheckOut:</div>'+
                            '<div class="col-12">Noches:</div>'+
                            '<div class="col-12">Cuartos:</div>'+
                            '<div class="col-12">Comentarios:</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-12 col-sm-4">'+
                        '<div class="row" style="padding:0px;margin:0px;">'+
                            '<div class="col-12">'+CheckIn+'</div>'+
                            '<div class="col-12">'+CheckOut+'</div>'+
                            '<div class="col-12">'+noches+'</div>'+
                            '<div class="col-12">'+cuartos+'</div>'+
                            '<div class="col-12">'+comentarios+'</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-12 col-sm-4">'+
                        '<button class="btn item_btn" onclick="deleteConfirmation('+id+')">Devolver Canje</button>'+
                        '<div class="spinner">'+
                            '<div class="rect1"></div>'+
                            '<div class="rect2"></div>'+
                            '<div class="rect3"></div>'+
                            '<div class="rect4"></div>'+
                            '<div class="rect5"></div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
        }

        /* Formatting function for row details - modify as you need */
        function restore ( d ) {
            // `d` is the original data object for the row
            var puntos_id = d.devoluciones.id;

            return '<div class="row detail_cargo">'+
                    '<div class="col-12 col-sm-4">'+
                        '<button class="btn item_btn" onclick="restoreCanje('+puntos_id+')">Restaurar Canje</button>'+
                    '</div>'+
                '</div>';
        }

        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success btn-devolucion',
            cancelButton: 'btn btn-danger btn-devolucion'
        },
        buttonsStyling: false
        });

        $(document).ready(function() {

            
            $('#carga_puntos').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Puntos_Cargados.php?user_id={{$user->id}}',
                responsive: {
                    details: true
                },
                dom: 'Bfrtip',
                order: ['2','desc'],
                columns: [
                    { data: 'id' },
                    { data: 'factura_folio' },
                    { data: 'rfc' },
                    { data: 'fecha_carga' },
                    { data: 'puntos' }
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
                ajax: '/plugins/datatable-editor/lib/Puntos_Redimidos.php?user_id={{$user->id}}',
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
                    { data: 'redencion_puntos.representante' }
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

            var tableD = $('#puntos_devueltos').DataTable( {
                language: {
                    url: "/js/spanish.lang"
                },
                ajax: '/plugins/datatable-editor/lib/Puntos_Devueltos.php?user_id={{$user->id}}',
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
                    { data: 'devoluciones.id' },
                    { data: 'regalos.nombre' },
                    { data: 'devoluciones.puntos' },
                    { data: 'devoluciones.created_at' },
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

            // Add event listener for opening and closing details
            $('#puntos_devueltos tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                console.log(tr);
                var row = tableD.row( tr );
        
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( restore(row.data()) ).show();
                    tr.addClass('shown');
                }
            });

            
            $('.item_btn').click(function(){
                console.log('fire');
                swalWithBootstrapButtons.fire({
                    title: 'Desea hacer devolucion de este cargo?',
                    text: 'Id: '+$(this).attr('data_id'),
                    imageAlt: $(this).attr('name_item'),
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: add_button,
                    cancelButtonText: cancel_button,
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    preConfirm: (login) => {
                        return fetch(url+'/es/devolucion/'+$(this).attr('data_id'))
                        .then(response => {
                            console.log(response);
                            if (!response.ok) {
                            throw new Error(response.statusText)
                            }
                            return response.json()
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                            `Request failed: ${error}`
                            )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'La devolución se realizó exitosamente'
                        })
                    }
                })

            });
        });
        
        function deleteConfirmation(id) {
            swalWithBootstrapButtons.fire({
                title: 'Deseas hacer devolución?',
                text: 'Id: '+id,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Devolver',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                icon:'warning'
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/es/devolucion')}}/" + {{ $user->id }},
                        data: {
                            _token: CSRF_TOKEN,
                            puntos_id: id,
                            representante: "{{ Auth::user()->nombre }}"
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

        function restoreCanje(id) {
            swalWithBootstrapButtons.fire({
                title: 'Deseas restaurar el canje?',
                text: 'Id: '+id,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Devolver',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                icon:'warning'
            }).then(function (e) {
                if (e.value === true) {
                    
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/es/restore-canje')}}/" + {{ $user->id }},
                        data: {
                            _token: CSRF_TOKEN,
                            puntos_id: id
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
                                    text: results.error,
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
    </script>
@endsection