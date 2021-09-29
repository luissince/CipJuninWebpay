@extends('layouts.admin')

@section('title','Admin')

@section('content')
<!-- <div class="row"> -->
<!-- modal start cuotas -->
@include('admin.modal.cuotas')
<!-- modal end cuotas -->
<!-- modal start certificado -->
@include('admin.modal.certificados')
<!-- modal end certificado -->
<!-- modal tipo de pago -->
@include('admin.modal.cobrar')
<!-- end modal tipo de pago --->
<div class="row">
    <div class="col-md-8">
        <!-- panel izquierdo superior-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="no-margin"> Seleccione un servicio</h5>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group" role="group">
                            <button id="btnCuotas" type="button" class="btn btn-default" data-toggle="modal">
                                <i class="fa fa-plus"></i> Cuotas
                            </button>
                            <div class="btn-group" role="group">
                                <button id="btnCertificado" type="button" class="btn btn-default dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus"></i> Certificado <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li><button id="btnCertHabilidad" type="button" class="btn btn-default">Certificado de Habilidad(A)</button></li>
                                    <li><button id="btnCertResidenciaObra" type="button" class="btn btn-default">Certificado de Residencia de Obra(B)</button></li>
                                    <li><button id="btnCertProyecto" type="button" class="btn btn-default">Certificado de Proyecto(C)</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Cantidad</th>
                                    <th width="35%">Concepto</th>
                                    <th width="20%">Monto</th>
                                    <th width="10%">Quitar</th>
                                </tr>
                            </thead>
                            <tbody id="tbIngresos">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- panel derecho de cobro -->
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="no-margin">Detalle del Cobro</h5>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12">
                        <button id="btnCobrar" class="btn btn-success btn-block">
                            <div class="col-md-6 text-left">
                                <h4>PAGAR</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4 id="lblSumaTotal">0.00</h4>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5>Empresa a Facturar</h5>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" id="btnAddEmpresa" class="btn btn-primary btn-flat">Nuevo</button>
                                </div>
                                <select class="form-control select2" id="cbEmpresa">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-left no-margin">
                        <h5>Comprobante</h5>
                        <select class="form-control" id="cbComprobante">
                            <option value="">- Seleccione -</option>
                        </select>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();

        //cuotas
        let cuotas = [];
        let countCurrentDate = 0;
        let yearCurrentView = "";
        let monthCurrentView = "";
        let cuotasEstate = false;
        let cuotasInicio = "";
        let cuotasFin = "";

        //colegiado
        let idDNI = "{{ $persona->idDNI }}";
        window.CSRF_TOKEN = '{{ csrf_token() }}';

        // 
        let comprobantes = [];
        let UsarRuc = false;
        let newEmpresa = 0;

        //ingresos totales
        let arrayIngresos = [];
        let sumaTotal = 0;

        let J = Payment.J;
        let formSaveCard = document.getElementById('formSaveCard');

        loadComprobantes();
        componentesCuotas();

        function componentesCuotas() {
            $("#btnCertificado").attr('data-toggle', 'dropdown');
            $("#btnCertificado").attr('aria-expanded', 'true');

            $("#btnCuotas").click(function() {
                eventCuota();
            });

            $("#btnCuotas").keypress(function(event) {
                if (event.keyCode == 13) {
                    eventCuota();
                }
                event.preventDefault();
            });

            $("#btnAddCuota").click(function() {
                addCuotas();
            });

            $("#btnAddCuota").keypress(function(event) {
                if (event.keyCode === 13) {
                    addCuotas();
                }
                event.preventDefault();
            });

            $("#btnDeleteCuota").click(function() {
                removeCuota();
            });

            $("#btnDeleteCuota").keypress(function(event) {
                if (event.keyCode === 13) {
                    removeCuota();
                }
                event.preventDefault();
            });

            $("#btnCloseCuotas").click(function() {
                eventCloseCuota();
            });

            $("#btnCancelarCuotas").click(function() {
                eventCloseCuota();
            });

            $("#btnAceptarCuotas").click(function() {
                validateIngresoCuotas();
            });

            $("#btnAceptarCuotas").keypress(function(event) {
                if (event.keyCode === 13) {
                    validateIngresoCuotas();
                }
                event.preventDefault();
            });

            $("#cbComprobante").change(function() {
                for (let i = 0; i < comprobantes.length; i++) {
                    if (comprobantes[i].IdTipoComprobante == $(this).val()) {
                        if (comprobantes[i].UsarRuc == "1") {
                            UsarRuc = true;
                        } else {
                            UsarRuc = false;
                        }
                        break;
                    }
                }
            });

            $("#btnCobrar").click(function() {
                registrarIngreso();
            });

            $("#btnCobrar").keypress(function(event) {
                if (event.keyCode === 13) {
                    registrarIngreso();
                    event.preventDefault();
                }
            });

            Payment.formatCardNumber(formSaveCard.elements['card'], 16);

            formSaveCard.elements['card'].addEventListener('keyup', function() {
                if (Payment.fns.validateCardNumber(J.val(formSaveCard.elements['card']))) {
                    formSaveCard.elements['exp'].focus();
                }
            });

            Payment.formatCardExpiry(formSaveCard.elements['exp']);

            formSaveCard.elements['exp'].addEventListener('keyup', function() {
                if (Payment.fns.validateCardExpiry(Payment.cardExpiryVal(formSaveCard.elements['exp']))) {
                    formSaveCard.elements['cvv'].focus();
                }
            });

            formSaveCard.elements['cvv'].addEventListener('keypress', function() {
                var key = window.Event ? event.which : event.keyCode;
                var c = String.fromCharCode(key);
                if ((c < '0' || c > '9') && (c != '\b')) {
                    event.preventDefault();
                }
            });

            formSaveCard.addEventListener('keydown', function(event) {
                if (event.keyCode == 13) {
                    enviarCobro();
                    event.preventDefault();
                }
            });

            $("#btnAceptarTipoPago").click(function() {
                enviarCobro();
            });

            $("#btnAceptarTipoPago").keypress(function(event) {
                if (event.keyCode == 13) {
                    enviarCobro();
                    event.preventDefault();
                }
            });

            $("#btnCloseTipoPago").click(function() {
                closeModalCobrar();
            });

            $("#btnCloseTipoPago").keypress(function(event) {
                if (event.keyCode == 13) {
                    closeModalCobrar();
                    event.preventDefault();
                }
            });

            $("#btnCancelTipoPago").click(function() {
                closeModalCobrar();
            });

            $("#btnCancelTipoPago").keypress(function(event) {
                if (event.keyCode == 13) {
                    closeModalCobrar();
                    event.preventDefault();
                }
            });
        }

        function eventCuota() {
            $("#mdCuotas").modal("show");
            countCurrentDate = 0;
            loadCuotas();
        }

        function addCuotas() {
            countCurrentDate = 1;
            loadCuotas();
        }

        function loadCuotas() {
            const data = new FormData();
            data.append('mes', countCurrentDate);
            data.append('yearCurrentView', yearCurrentView);
            data.append('monthCurrentView', monthCurrentView);
            cuotas = [];
            $("#tbCuotas").empty();
            $("#tbCuotas").append(
                '<tr class="text-center"><td colspan="3"><img src="./images/spiner.gif"/><p>Cargando información...</p></td></tr>'
            );

            fetch("{{ route('service.cuotas')}}", {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN
                    },
                    method: 'POST',
                    body: data
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw "Error de conexión, intente nuevamente.";
                    }
                })
                .then(function(result) {
                    if (result.estatus == 1) {
                        $("#tbCuotas").empty();

                        cuotas = result.data;
                        if (cuotas.length > 0) {
                            let totalCuotas = 0;
                            let idCheck = 1;
                            for (let value of cuotas) {
                                let monto = 0;
                                let lol = '<input id="' + idCheck + '" type="checkbox" checked onclick="selectCheck(' + idCheck + ')">';
                                for (let c of value.concepto) {
                                    monto += parseFloat(c.Precio);
                                }
                                $("#tbCuotas").append(
                                    '<tr id="' + (value.mes + "-" + value.year) + '">' +
                                    '<td style="width:3%">' + lol + '</td>' +
                                    '<td class="no-padding" style="vertical-align:middle;">' + tools.nombreMes(value.mes) + " - " + value.year + "</td>" +
                                    '<td class="no-padding text-center" style="vertical-align:middle;">' + tools.formatMoney(monto) + "</td>" +
                                    +"</tr>"
                                );
                                totalCuotas += parseFloat(monto);
                                idCheck++;
                            }
                            $("#lblTotalCuotas").html("TOTAL DE " + cuotas.length + " CUOTAS: " + tools.formatMoney(totalCuotas));

                            if (cuotas.length > 0) {
                                $("#lblNumeroCuotas").html(
                                    "CUOTAS DEL: " +
                                    cuotas[0].mes +
                                    "/" +
                                    cuotas[0].year +
                                    " al " +
                                    cuotas[cuotas.length - 1].mes +
                                    "/" +
                                    cuotas[cuotas.length - 1].year
                                );
                                yearCurrentView = cuotas[cuotas.length - 1].year;
                                monthCurrentView = cuotas[cuotas.length - 1].mes;
                            }
                        } else {
                            $("#tbCuotas").append(
                                '<tr class="text-center"><td colspan="3"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+Agregar) para más cuotas.</p></td></tr>'
                            );
                            $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                            $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                        }
                    } else {
                        $("#tbCuotas").empty();
                        $("#tbCuotas").append(
                            '<tr class="text-center"><td colspan="3"><p>' +
                            result.message +
                            "</p></td></tr>"
                        );
                        $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                        $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                    }
                })
                .catch(function(error) {
                    $("#tbCuotas").empty();
                    $("#tbCuotas").append(
                        '<tr class="text-center"><td colspan="2"><p>' +
                        error.responseText +
                        "</p></td></tr>"
                    );
                });
        }

        function eventCloseCuota() {
            $("#mdCuotas").modal("hide");
            countCurrentDate = 0;
            yearCurrentView = "";
            monthCurrentView = "";
        }

        selectCheck = function(idCheckBox) {
            let nmroCheckbox = idCheckBox;
            while (cuotas.length >= nmroCheckbox) {
                if ($("#" + nmroCheckbox).prop('checked')) {
                    $("#" + nmroCheckbox).prop('checked', false);

                }
                nmroCheckbox++;
            }

            let nCheckBox = idCheckBox;
            while (nCheckBox >= 0) {
                if (!$("#" + nCheckBox).is(':checked')) {
                    $("#" + nCheckBox).prop('checked', true);
                }
                nCheckBox--;
            }

            let newArray = [];
            $("#tbCuotas tr").each(function(row, tr) {
                for (let value of cuotas) {
                    if ((value.mes + "-" + value.year) == $(tr).attr('id')) {
                        let isChecked = $(tr).find("td:eq(0)").find('input[type="checkbox"]').is(':checked');
                        if (isChecked) {
                            newArray.push(value);
                        }
                        break;
                    }
                }
            });


            if (newArray.length > 0) {
                let totalCuotas = 0;
                for (let value of newArray) {
                    let monto = 0;
                    for (let c of value.concepto) {
                        monto += parseFloat(c.Precio);
                    }
                    totalCuotas += parseFloat(monto);
                }
                $("#lblTotalCuotas").html(
                    "TOTAL DE " +
                    newArray.length +
                    " CUOTAS: " +
                    tools.formatMoney(totalCuotas)
                );
                if (newArray.length > 0) {
                    $("#lblNumeroCuotas").html(
                        "CUOTAS DEL: " +
                        newArray[0].mes +
                        "/" +
                        newArray[0].year +
                        " al " +
                        newArray[newArray.length - 1].mes +
                        "/" +
                        newArray[newArray.length - 1].year
                    );
                    yearCurrentView = newArray[newArray.length - 1].year;
                    monthCurrentView = newArray[newArray.length - 1].mes;
                }
            } else {
                $("#tbCuotas").append(
                    '<tr class="text-center"><td colspan="3"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+Agregar) para más cuotas.</p></td></tr>'
                );
                $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                if (yearCurrentView != "" && monthCurrentView != "") {
                    monthCurrentView = monthCurrentView - 1;
                }
            }
        }

        function removeCuota() {
            if (cuotas.length != 0) {
                cuotas.pop();

                $("#tbCuotas").empty();
                if (cuotas.length > 0) {
                    let totalCuotas = 0;
                    let idCheck = 1;
                    for (let value of cuotas) {
                        let monto = 0;

                        let lol = '<input id="' + idCheck + '" type="checkbox" checked onclick="selectCheck(' + idCheck + ')">';
                        for (let c of value.concepto) {
                            monto += parseFloat(c.Precio);
                        }
                        $("#tbCuotas").append(
                            '<tr id="' +
                            (value.mes + "-" + value.year) +
                            '">' +
                            '<td style="width:3%">' + lol + '</td>' +
                            '<td class="no-padding" style="vertical-align:middle;"> ' +
                            tools.nombreMes(value.mes) +
                            " - " +
                            value.year +
                            "</td>" +
                            '<td class="no-padding text-center" style="vertical-align:middle;">' +
                            tools.formatMoney(monto) +
                            "</td>" +
                            // '<td class="no-padding text-center"><button class="btn btn-danger btn-sm" onclick="removeCuota(\'' + (value.mes + '-' + value.year) + '\')"><i class="fa fa-trash"></i></button></td>' +
                            +"</tr>"
                        );
                        totalCuotas += parseFloat(monto);
                        idCheck++;
                    }
                    $("#lblTotalCuotas").html(
                        "TOTAL DE " +
                        cuotas.length +
                        " CUOTAS: " +
                        tools.formatMoney(totalCuotas)
                    );
                    if (cuotas.length > 0) {
                        $("#lblNumeroCuotas").html(
                            "CUOTAS DEL: " +
                            cuotas[0].mes +
                            "/" +
                            cuotas[0].year +
                            " al " +
                            cuotas[cuotas.length - 1].mes +
                            "/" +
                            cuotas[cuotas.length - 1].year
                        );
                        yearCurrentView = cuotas[cuotas.length - 1].year;
                        monthCurrentView = cuotas[cuotas.length - 1].mes;
                    }
                } else {
                    $("#tbCuotas").append(
                        '<tr class="text-center"><td colspan="3"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+Agregar) para más cuotas.</p></td></tr>'
                    );
                    $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                    $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                    if (yearCurrentView != "" && monthCurrentView != "") {
                        monthCurrentView = monthCurrentView - 1;
                    }

                }
            }
        }

        function validateIngresoCuotas() {
            if (cuotas.length > 0) {
                removeIngresos(0, 1);
                removeIngresos(0, 2);
                removeIngresos(0, 3);
            }
            let newArray = [];
            $("#tbCuotas tr").each(function(row, tr) {
                for (let value of cuotas) {
                    if ((value.mes + "-" + value.year) == $(tr).attr('id')) {
                        let isChecked = $(tr).find("td:eq(0)").find('input[type="checkbox"]').is(':checked');
                        if (isChecked) {
                            newArray.push(value);
                        }
                        break;
                    }
                }
            });

            for (let value of newArray) {
                for (let c of value.concepto) {
                    if (!validateDuplicate(c.IdConcepto)) {
                        arrayIngresos.push({
                            idConcepto: parseInt(c.IdConcepto),
                            categoria: parseInt(c.Categoria),
                            cantidad: 1,
                            concepto: c.Concepto,
                            precio: parseFloat(c.Precio),
                            monto: parseFloat(c.Precio),
                        });
                    } else {
                        for (let i = 0; i < arrayIngresos.length; i++) {
                            if (arrayIngresos[i].idConcepto == c.IdConcepto) {
                                let newConcepto = arrayIngresos[i];
                                newConcepto.categoria = parseInt(c.Categoria);
                                newConcepto.cantidad = newConcepto.cantidad + 1;
                                newConcepto.precio = c.Precio;
                                newConcepto.monto =
                                    parseFloat(newConcepto.precio) *
                                    parseFloat(newConcepto.cantidad);
                                arrayIngresos[i] = newConcepto;
                                break;
                            }

                        }

                    }
                }
            }

            if (newArray.length > 0) {
                cuotasEstate = true;
                cuotasInicio = newArray[0].year + "-" + newArray[0].mes + "-" + newArray[0].day;
                cuotasFin =
                    newArray[newArray.length - 1].year +
                    "-" +
                    newArray[newArray.length - 1].mes +
                    "-" +
                    newArray[newArray.length - 1].day;
            }
            addIngresos();
            $("#mdCuotas").modal("hide");
            countCurrentDate = 0;
            yearCurrentView = "";
            monthCurrentView = "";
        }

        removeIngresos = function(idConcepto, categoria) {
            for (let i = 0; i < arrayIngresos.length; i++) {
                if (arrayIngresos[i].categoria == 100) {
                    if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        break;
                    }
                } else {
                    if (arrayIngresos[i].categoria == categoria && categoria == 1) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    } else if (arrayIngresos[i].categoria == categoria && categoria == 2) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    } else if (arrayIngresos[i].categoria == categoria && categoria == 3) {
                        arrayIngresos.splice(i, 1);
                        i--;
                        cuotasEstate = false;
                    }
                }
            }
            addIngresos();
        }

        function addIngresos() {
            $("#tbIngresos").empty();
            sumaTotal = 0;
            let arrayRenderTable = [];

            for (let value of arrayIngresos) {
                let cuotasFechas = cuotasEstate == true ? tools.getDateFormaDDMM(cuotasInicio) + " al " + tools.getDateFormaDDMM(cuotasFin) : '-';

                if (!arrayRenderTable.find(ar => ar.categoria == value.categoria && value.categoria == 1 ||
                        ar.categoria == value.categoria && value.categoria == 2 ||
                        ar.categoria == value.categoria && value.categoria == 3 ||
                        ar.categoria == value.categoria && value.categoria == 4 ||
                        ar.categoria == value.categoria && value.categoria == 9 ||
                        ar.categoria == value.categoria && value.categoria == 10 ||
                        ar.categoria == value.categoria && value.categoria == 11 ||
                        ar.categoria == value.categoria && value.categoria == 12
                    )) {

                    arrayRenderTable.push({
                        "idConcepto": parseInt(value.idConcepto),
                        "categoria": value.categoria,
                        "cantidad": value.cantidad,
                        "concepto": value.categoria == 1 ? "Cuotas Ordinarias(Del " + cuotasFechas + ")" : value.categoria == 2 ? "Cuotas de Administia(Del " + cuotasFechas + ")" : value.categoria == 3 ? "Cuotas de Vitalicio(Del " + cuotasFechas + ")" : value.categoria == 12 ? "Cuota Ordinarias - Resolución 15 (Del " + cuotasFechas + ")" : value.categoria == 4 ? "Colegiatura Ordinaria" : value.categoria == 9 ? "Colegiatura Otras Modalidades" : value.categoria == 10 ? "Colegiatura por Tesis Local" : value.categoria == 11 ? "Colegiatura por Tesis Externa" : value.concepto,
                        "precio": parseFloat(value.precio),
                        "monto": parseFloat(value.monto)
                    });
                } else {
                    for (let i = 0; i < arrayRenderTable.length; i++) {
                        if (arrayRenderTable[i].categoria == value.categoria) {
                            let newConcepto = arrayRenderTable[i];
                            newConcepto.idConcepto = parseInt(value.idConcepto);
                            newConcepto.categoria = parseInt(value.categoria);
                            newConcepto.cantidad = newConcepto.cantidad;

                            newConcepto.concepto =
                                value.categoria == 1 ? "Cuotas Ordinarias(Del " + cuotasFechas + ")" :
                                value.categoria == 2 ? "Cuotas de Administia(Del " + cuotasFechas + ")" :
                                value.categoria == 3 ? "Cuotas de Vitalicio(Del " + cuotasFechas + ")" :
                                value.categoria == 12 ? "Cuota Ordinarias - Resolución 15 (Del " + cuotasFechas + ")" :
                                value.categoria == 4 ? "Colegiatura Ordinaria" :
                                value.categoria == 9 ? "Colegiatura Otras Modalidades" :
                                value.categoria == 10 ? "Colegiatura por Tesis Local" :
                                value.categoria == 11 ? "Colegiatura por Tesis Externa" :
                                value.concepto;

                            newConcepto.precio += parseFloat(value.precio);
                            newConcepto.monto += value.monto;
                            arrayRenderTable[i] = newConcepto;
                        }
                    }
                }
            }

            let count = 0;
            for (let value of arrayRenderTable) {
                count++;
                $("#tbIngresos").append('<tr>' +
                    '<td>' + count + '</td>' +
                    '<td>' + value.cantidad + '</td>' +
                    '<td>' + value.concepto + '</td>' +
                    '<td>' + tools.formatMoney(value.monto) + '</td>' +
                    '<td><button class="btn btn-warning" onClick="removeIngresos(\'' + value.idConcepto + '\',\'' + value.categoria + '\')"><i class="fa fa-trash"></i></button></td>' +
                    '</tr>');
                sumaTotal += parseFloat(value.monto);
            }

            $("#lblSumaTotal").html(tools.formatMoney(sumaTotal));
        }

        function validateDuplicate(idConcepto) {
            let ret = false;
            for (let i = 0; i < arrayIngresos.length; i++) {
                if (arrayIngresos[i].idConcepto === parseInt(idConcepto)) {
                    ret = true;
                    break;
                }
            }
            return ret;
        }

        function loadComprobantes() {
            $("#cbComprobante").empty();
            comprobantes = [];
            fetch("{{ route('service.allComprobantes')}}", {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN
                    },
                    method: 'POST'
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.json()
                    } else {
                        throw "Error de conexión, intente nuevamente.";
                    }
                })
                .then(function(result) {
                    if (result.estatus === 1) {
                        comprobantes = result.data;
                        $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                        for (let value of comprobantes) {
                            $("#cbComprobante").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>')
                        }
                        for (let value of comprobantes) {
                            if (value.Predeterminado == "1") {
                                $("#cbComprobante").val(value.IdTipoComprobante);
                                break;
                            }
                        }
                    } else {
                        $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                    }
                })
                .catch(function(error) {
                    $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                });
        }

        // 
        function registrarIngreso() {
            if ($("#cbComprobante").val() == '') {
                tools.AlertWarning("Cobros", "Seleccione un comprobante para continuar.");
            } else if (arrayIngresos.length == 0) {
                tools.AlertWarning("Cobros", "No hay conceptos para continuar.");
            } else if (idDNI == 0 && $("#cbEmpresa").val() == "") {
                tools.AlertWarning("Cobros", "No selecciono ningún ingeneniero o Empresa para continuar.");
            } else if (UsarRuc && $("#cbEmpresa").val() == '') {
                tools.AlertWarning("Cobros", "El comprobante requiere usar una empresa asociada.");
                $("#cbEmpresa").focus();
            } else {
                let porcetaje = 4.20 / 100; //0.042
                let montoAum =
                    sumaTotal > 0 && sumaTotal <= 50 ?
                    sumaTotal + 0.5 :
                    sumaTotal > 50 && sumaTotal <= 100 ?
                    sumaTotal + 1 :
                    sumaTotal > 100 && sumaTotal <= 500 ?
                    sumaTotal + 1.50 :
                    sumaTotal > 500 && sumaTotal <= 1000 ?
                    sumaTotal + 2 :
                    sumaTotal + 3;

                let igvp = 18;
                let comision = montoAum * porcetaje; //4.20
                let igv = comision * (igvp / 100); //0.756
                let total = Math.round(montoAum + comision + igv);

                $("#totalModal").html('S/ ' + tools.formatMoney(total));

                $("#modalTipoPago").modal("show");
                $('#modalTipoPago').on('shown.bs.modal', function() {
                    formSaveCard.elements['card'].focus();
                })
            }
        }

        function enviarCobro() {
            if (formSaveCard.elements['card'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese el número de su tarjeta.');
                formSaveCard.elements['card'].focus();
            } else if (!Payment.fns.validateCardExpiry(Payment.cardExpiryVal(formSaveCard.elements['exp']))) {
                tools.AlertWarning('', 'Ingrese la fecha de expiración.');
                formSaveCard.elements['exp'].focus();
            } else if (formSaveCard.elements['cvv'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su cvv/cvc.');
                formSaveCard.elements['cvv'].focus();
            } else if (!tools.validateEmail(formSaveCard.elements['email'].value.trim())) {
                tools.AlertWarning('', 'Ingrese su correo electrónico.');
                formSaveCard.elements['email'].focus();
            } else {
                let valexp = formSaveCard.elements['exp'].value.trim().replace(/ /g, "");
                let arrayexp = valexp.split("/");

                tools.ModalDialog("Cobros", "¿Está seguro de continuar?", function(value) {
                    if (value == true) {
                        // cancelarIngreso();
                        // tools.ModalAlertInfo("Cobros", "Procesando petición..");       

                        let porcetaje = 4.20 / 100; //0.042
                        let montoAum =
                            sumaTotal > 0 && sumaTotal <= 50 ?
                            sumaTotal + 0.5 :
                            sumaTotal > 50 && sumaTotal <= 100 ?
                            sumaTotal + 1 :
                            sumaTotal > 100 && sumaTotal <= 500 ?
                            sumaTotal + 1.50 :
                            sumaTotal > 500 && sumaTotal <= 1000 ?
                            sumaTotal + 2 :
                            sumaTotal + 3;

                        let igvp = 18;
                        let comision = montoAum * porcetaje; //4.20
                        let igv = comision * (igvp / 100); //0.756
                        let total = Math.round(montoAum + comision + igv);

                        fetch("{{ route('service.savePay')}}", {
                                headers: {
                                    'X-CSRF-TOKEN': window.CSRF_TOKEN,
                                    "Content-Type": "application/json"
                                },
                                method: 'POST',
                                body: JSON.stringify({
                                    "idTipoDocumento": parseInt($("#cbComprobante").val()),
                                    "idCliente": idDNI == 0 ? 0 : idDNI,
                                    "idEmpresaPersona": $("#cbEmpresa").val() == '' ? null : $("#cbEmpresa").val(),
                                    "idUsuario": -1,
                                    "estado": 'C',
                                    "tipo": 3,
                                    "idBanco": 0,
                                    "numOperacion": '',
                                    "estadoCuotas": cuotasEstate,
                                    "ingresos": arrayIngresos,
                                    "cuotasInicio": cuotasInicio,
                                    "cuotasFin": cuotasFin,
                                    "card_number": formSaveCard.elements['card'].value.trim().replace(/ /g, ""),
                                    "cvv": formSaveCard.elements['cvv'].value.trim(),
                                    "expiration_month": arrayexp[0],
                                    "expiration_year": arrayexp[1],
                                    "email": formSaveCard.elements['email'].value.trim(),
                                    "monto": total
                                })
                            })
                            .then(function(response) {
                                if (response.ok) {
                                    return response.json()
                                } else {
                                    throw "Error de conexión, intente nuevamente.";
                                }
                            })
                            .then(function(result) {
                                console.log(result);
                                // if (result.estado === 1) {

                                //     $("#btnCertificado").attr('data-toggle', '');
                                //     $("#btnCertificado").attr('aria-expanded', 'false');
                                //     loadEmpresaPersona();
                                //     loadComprobantes();

                                //     tools.ModalAlertSuccess("Cobros", result.mensaje, function() {
                                //         $("#modalEndIngreso").modal("show");
                                //         $("#modalFotterEndIngresos").empty();
                                //         $("#modalFotterEndIngresos").append('' +
                                //             '<a href="../app/sunat/pdfingresos.php?idIngreso=' + result.idIngreso + '" target="_blank" class="btn btn-success">' +
                                //             '<i class="fa fa-file-pdf-o"></i> Ingreso' +
                                //             '</a>');

                                //         if (result.colegiado != null) {
                                //             $("#modalFotterEndIngresos").append('' +
                                //                 '<button class="btn btn-info" onclick="getCorreo(\'' + result.colegiado.idDNI + '\', \'' + result.idIngreso + '\', \'' + '\')">' +
                                //                 '<i class="fa fa-envelope"></i> Correo</br>' +
                                //                 '</button>');
                                //         }

                                //         if (result.cerHabilidad == true) {
                                //             $("#modalFotterEndIngresos").append('' +
                                //                 '<a href="../app/sunat/pdfCertHabilidad.php?idIngreso=' + result.idIngreso + '" target="_blank" class="btn btn-success">' +
                                //                 '<i class="fa fa-file-pdf-o"></i> Cert. Habilidad(A)' +
                                //                 '</a>');
                                //         }
                                //         if (result.cerObra == true) {
                                //             $("#modalFotterEndIngresos").append('' +
                                //                 '<a href="../app/sunat/pdfCertObra.php?idIngreso=' + result.idIngreso + '" target="_blank" class="btn btn-success">' +
                                //                 '<i class="fa fa-file-pdf-o"></i> Cert. Obra(B)' +
                                //                 '</a>');
                                //         }
                                //         if (result.cerProyecto == true) {
                                //             $("#modalFotterEndIngresos").append('' +
                                //                 '<a href="../app/sunat/pdfCertProyecto.php?idIngreso=' + result.idIngreso + '" target="_blank" class="btn btn-success">' +
                                //                 '<i class="fa fa-file-pdf-o"></i> Cert. Proyecto(C)' +
                                //                 '</a>');
                                //         }
                                //         $("#modalFotterEndIngresos").append('' +
                                //             '<button type="button" data-dismiss="modal" class="btn btn-danger">' +
                                //             '<i class="fa fa-remove"></i> Cerrar</button>');
                                //     });
                                // } else {
                                //     tools.ModalAlertWarning("Cobros", result.mensaje);
                                // }
                            })
                            .catch(function(error) {
                                console.error(error)
                                // tools.ModalAlertError("Cobros", "Se produjo un error: " + error.responseText);
                            });
                    }
                });

            }
        }

        function closeModalCobrar() {
            $("#modalTipoPago").modal("hide");
            formSaveCard.elements['card'].value = '';
            formSaveCard.elements['exp'].value = '';
            formSaveCard.elements['cvv'].value = '';
        }

        function cancelarIngreso() {
            arrayIngresos.splice(0, arrayIngresos.length);
            addIngresos();

            newEmpresa = 0;
            idDNI = 0;
            cuotasEstate = false;
            UsarRuc = false;
            countCurrentDate = 0;
            cuotasInicio = "";
            cuotasFin = "";

            for (let i = 0; i < comprobantes.length; i++) {
                if (comprobantes[i].Predeterminado == "1") {
                    $("#cbComprobante").val(comprobantes[i].IdTipoComprobante)
                }
                if (comprobantes[i].UsarRuc == "1") {
                    UsarRuc = true;
                } else {
                    UsarRuc = false;
                }
                break;
            }
        }

    });
</script>

@endsection