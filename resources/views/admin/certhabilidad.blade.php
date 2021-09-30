@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <h3 class="box-title">Lista de Certificados de Habilidad</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label>Filtrar por N° certificado.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" id="buscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success" id="btnBuscar"> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label>Fecha de inicio.</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="fechaInicio">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label>Fecha de fin.</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="fechaFinal">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <label>Opción.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                <thead style="background-color: #FDB2B1;color: #B72928;">
                                    <tr>
                                        <th width="4%;" class="text-center">#</th>
                                        <th width="4%;" class="text-center">P.D.F</th>
                                        <th width="10%;">Colegiado</th>
                                        <th width="10%;">Especialidad</th>
                                        <th width="9%;">N° Certificado</th>
                                        <th width="5%;">Estado</th>
                                        <th width="10%;">Asunto</th>
                                        <th width="10%;">Entidad</th>
                                        <th width="10%;">Lugar</th>
                                        <th width="8%;">Fecha Pago</th>
                                        <th width="8%;">Fecha Venci.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbTable">
                                    <tr class="text-center">
                                        <td colspan="13">
                                            <p>No hay ingresos para mostrar.</p>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                            <ul class="pagination">
                                <li>
                                    <button class="btn btn-info" id="btnIzquierda">
                                        <i class="fa fa-toggle-left"></i>
                                    </button>
                                </li>
                                <li>
                                    <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                </li>
                                <li><span>a</span></li>
                                <li>
                                    <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                </li>
                                <li>
                                    <button class="btn btn-info" id="btnDerecha">
                                        <i class="fa fa-toggle-right"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        let state = false;
        let opcion = 0;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let tbTable = $("#tbTable");
        let idCertHabilidad = 0;

        $("#fechaInicio").val(tools.getCurrentDate());
        $("#fechaFinal").val(tools.getCurrentDate());

        $("#btnIzquierda").click(function() {
            if (!state) {
                if (paginacion > 1) {
                    paginacion--;
                    onEventPaginacion();
                }
            }
        });

        $("#btnDerecha").click(function() {
            if (!state) {
                if (paginacion < totalPaginacion) {
                    paginacion++;
                    onEventPaginacion();
                }
            }
        });

        $("#btnRecargar").click(function() {
            loadInitCertificado();
        });

        $("#btnRecargar").keypress(function(event) {
            if (event.keyCode === 13) {
                loadInitCertificado();
            }
            event.preventDefault();
        });

        $("#fechaInicio").on("change", function() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableCertificado(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        });

        $("#fechaFinal").on("change", function() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableCertificado(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        });

        $("#buscar").keyup(function(event) {
            if (event.keyCode === 13) {
                if ($("#buscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTableCertificado(1, $("#buscar").val().trim(), "", "");
                        opcion = 1;
                    }
                }
            }
        });

        $("#btnBuscar").click(function() {
            if ($("#buscar").val().trim() != '') {
                if (!state) {
                    paginacion = 1;
                    loadTableCertificado(1, $("#buscar").val().trim(), "", "");
                    opcion = 1;
                }
            }
        });


        $("#btnBuscar").keypress(function(event) {
            if (event.keyCode == 13) {
                if ($("#buscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTableCertificado(1, $("#buscar").val().trim(), "", "");
                        opcion = 1;
                    }
                }
                event.preventDefault();
            }
        })

        loadInitCertificado();

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadTableCertificado(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    break;
                case 1:
                    loadTableCertificado(1, $("#buscar").val().trim(), "", "");
                    break;
            }
        }

        function loadInitCertificado() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableCertificado(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        }

        async function loadTableCertificado(opcion, buscar, fechaInicio, fechaFinal) {
            try {
                tbTable.empty();
                tbTable.append(
                    `<tr class="text-center"><td colspan="11"><img src="{{asset('images/spiner.gif')}}"/><p>Cargando información.</p></td></tr>`
                );
                state = true;
                totalPaginacion = 0;

                let result = await tools.fetch_timeout("{{ route('voucher.certhabilidadall')}}", {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                        "Content-Type": "application/json"
                    },
                    method: 'POST',
                    body: JSON.stringify({
                        "opcion": opcion,
                        "buscar": buscar,
                        "fechaInicio": fechaInicio,
                        "fechaFinal": fechaFinal,
                        "posicionPagina": ((paginacion - 1) * filasPorPagina),
                        "filasPorPagina": filasPorPagina
                    })
                });


                if (result.status == 1) {
                    tbTable.empty();
                    if (result.data.length == 0) {
                        tbTable.append(
                            '<tr class="text-center"><td colspan="11"><p>No hay ingresos para mostrar.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    } else {
                        for (let ingresos of result.data) {

                            let btnPdf = '<a class="btn btn-danger btn-xs" href="https://www.intranet.cip-junin.org.pe/app/sunat/pdfCertHabilidadView.php?idIngreso=' + ingresos.idIngreso + '" target="_blank" >' +
                                '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                '</a>';

                            tbTable.append('<tr>' +
                                '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                '<td>' + btnPdf + '</td>' +
                                '<td>' + ingresos.numeroCip + " - " + ingresos.dni + '</br>' + ingresos.usuario + ' ' + ingresos.apellidos + '</td>' +
                                '<td>' + ingresos.especialidad + '</td>' +
                                '<td>' + ingresos.numCertificado + '</td>' +
                                '<td>' + (ingresos.estado == 0 ? '<label class="text-danger">ANULADO</label>' : '<label class="text-success">ACTIVO</label>') + '</td>' +
                                '<td>' + ingresos.asunto + '</td>' +
                                '<td>' + ingresos.entidad + '</td>' +
                                '<td>' + ingresos.lugar + '</td>' +
                                '<td>' + ingresos.fechaPago + '</td>' +
                                '<td>' + ingresos.fechaVencimiento + '</td>' +
                                '</tr>'
                            );
                        }
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    }
                } else {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="11"><p>' + result.mensaje + '</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            } catch (error) {
                tbTable.empty();
                tbTable.append(
                    '<tr class="text-center"><td colspan="11"><p>' + error.responseText + '</p></td></tr>'
                );
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        }

    });
</script>

@endsection