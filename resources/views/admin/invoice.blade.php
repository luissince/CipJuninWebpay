@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <h3 class="box-title">Lista de comprobantes emitos (Boletas y Facturas)</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Filtrar por serie, numeración(Presione Enter).</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success" id="btnBuscar"> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label>Fecha de inicio(Entre Fechas).</label>
                        <div class="form-group">
                            <input type="date" class="form-control" id="fechaInicio">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <label>Fecha de fin(Entre Fechas).</label>
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
                                        <th style="width:5%;" class="text-center">#</th>
                                        <th style="width:4%;">P.D.F</th>
                                        <th style="width:10%;">Fecha</th>
                                        <th style="width:12%;">Comprobante</th>
                                        <th style="width:24%;">Colegiado</th>
                                        <th style="width:15%;">Forma Pago</th>
                                        <th style="width:9%;">Estado</th>
                                        <th style="width:9%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="tbTable">
                                    <tr class="text-center">
                                        <td colspan="12">
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

        $("#fechaInicio").on("change", function() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        });

        $("#fechaFinal").on("change", function() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        });

        $("#txtBuscar").keyup(function(event) {
            if (event.keyCode == 13) {
                if ($("#txtBuscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "");
                        opcion = 1;
                    }
                }
            }
        });

        $("#btnBuscar").click(function() {
            if ($("#txtBuscar").val().trim() != '') {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "");
                    opcion = 1;
                }
            }
        });

        $("#btnBuscar").keyup(function(event) {
            if (event.keyCode == 13) {
                if ($("#txtBuscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "");
                        opcion = 1;
                    }
                }
            }
        });

        $("#btnRecargar").click(function() {
            loadInitIngresos();
        });

        $("#btnRecargar").keypress(function(event) {
            if (event.keyCode === 13) {
                loadInitIngresos();
            }
            event.preventDefault();
        });

        loadInitIngresos();

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    break;
                case 1:
                    loadTableIngresos(1, $("#txtBuscar").val().trim(), "", "");
                    break;
            }
        }

        function loadInitIngresos() {
            if (tools.validateDate($("#fechaInicio").val()) && tools.validateDate($("#fechaFinal").val())) {
                if (!state) {
                    paginacion = 1;
                    loadTableIngresos(0, "", $("#fechaInicio").val(), $("#fechaFinal").val());
                    opcion = 0;
                }
            }
        }

        async function loadTableIngresos(opcion, buscar, fechaInicio, fechaFinal) {
            try {
                tbTable.empty();
                tbTable.append(
                    `<tr class="text-center"><td colspan="12"><img src="{{asset('images/spiner.gif')}}"/><p>Cargando información.</p></td></tr>`
                );
                arrayIngresos = [];
                state = true;

                let result = await tools.fetch_timeout("{{ route('voucher.invoiceall')}}", {
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
                    arrayIngresos = result.data;
                    if (arrayIngresos.length == 0) {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="8"><p>No hay ingresos para mostrar.</p></td></tr>'
                        );
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html("0");
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } else {
                        tbTable.empty();
                        for (let ingresos of arrayIngresos) {

                            let btnPdf = '<a class="btn btn-danger btn-xs" href="https://www.intranet.cip-junin.org.pe/app/sunat/pdfingresos.php?idIngreso=' + ingresos.idIngreso + '" title="PDF" target="_blank">' +
                                '<i class="fa fa-file-pdf-o" style="font-size:25px;"></i></br>' +
                                '</a>';

                            let formaPago = "";
                            if (ingresos.tipo == 1) {
                                formaPago = "EFECTIVO";
                            } else if (ingresos.tipo == 2) {
                                formaPago = "DEPOSTIO" + "<br>" + "<span class='h6 text-blue'>" + ingresos.bancoName + ": " + ingresos.numOperacion + "</span>";
                            } else {
                                formaPago = "TARJETA";
                            }

                            tbTable.append('<tr>' +
                                '<td class="text-center text-primary">' + ingresos.id + '</td>' +
                                '<td>' + btnPdf + '</td>' +
                                '<td>' + ingresos.fecha + '<br>' + tools.getTimeForma(ingresos.hora, true) + '</td>' +
                                '<td>' + ingresos.comprobante + '<br>' + ingresos.serie + '-' + ingresos.numRecibo + '</td>' +
                                '<td>' + ingresos.nombreDocumento + ' - ' + ingresos.numeroDocumento + '</br>' + ingresos.persona + '</td>' +
                                '<td>' + formaPago + '</td>' +
                                '<td>' + (ingresos.estado == "C" ? '<span class="text-green">Pagado</span>' : '<span class="text-red">Anulado</span>') + '</td>' +
                                '<td>' + tools.formatMoney(ingresos.total) + '</td>' +
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
                        '<tr class="text-center"><td colspan="8"><p>' + result.mensaje + '</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            } catch (error) {
                tbTable.empty();
                tbTable.append(
                    '<tr class="text-center"><td colspan="8"><p>' + error.responseText + '</p></td></tr>'
                );
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        }

    });
</script>

@endsection