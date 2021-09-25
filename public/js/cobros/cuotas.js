function Cuotas() {
    this.componentesCuotas = function () {
        $("#btnCuotas").click(function () {
            eventCuota();
        });

        $("#btnCuotas").keypress(function (event) {
            if (event.keyCode == 13) {
                eventCuota();
            }
            event.preventDefault();
        });

        $("#btnCuotaNormal").click(function () {
            eventCuotaOrdinaria();
        });

        $("#btnCuotaNormal").keypress(function (event) {
            if (event.keyCode === 13) {
                eventCuotaOrdinaria();
            }
            event.preventDefault();
        });

        $("#btnCuotaAmnistia").click(function () {
            eventCuotaAdmistia();
        });

        $("#btnCuotaAmnistia").keypress(function (event) {
            if (event.keyCode === 13) {
                eventCuotaAdmistia();
            }
            event.preventDefault();
        });

        $("#btnCuotaVitalicio").click(function () {
            eventCuotaVitalicio();
        });

        $("#btnCuotaVitalicio").keypress(function (event) {
            if (event.keyCode === 13) {
                eventCuotaVitalicio();
            }
            event.preventDefault();
        });

        $("#btnCuotaResolucion").click(function () {
            eventCuotaResolucion();
        });

        $("#btnCuotaResolucion").keypress(function (event) {
            if (event.keyCode === 13) {
                eventCuotaResolucion();
            }
            event.preventDefault();
        });

        $("#btnAddCuota").click(function () {
            addCuotas();
        });

        $("#btnAddCuota").keypress(function (event) {
            if (event.keyCode === 13) {
                addCuotas();
            }
            event.preventDefault();
        });

        $("#btnDeleteCuota").click(function () {
            removeCuota();
        });

        $("#btnDeleteCuota").keypress(function (event) {
            if (event.keyCode === 13) {
                removeCuota();
            }
            event.preventDefault();
        });

        $("#btnCloseCuotas").click(function () {
            eventCloseCuota();
        });

        $("#btnCancelarCuotas").click(function () {
            eventCloseCuota();
        });

        $("#btnAceptarCuotas").click(function () {
            validateIngresoCuotas();
        });

        $("#btnAceptarCuotas").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresoCuotas();
            }
            event.preventDefault();
        });
    };

    function eventCuota() {
        if (idDNI == 0) {
            tools.AlertWarning(
                "Cuotas",
                "No selecciono ningún ingeniero para obtener sus cuotas."
            );
        } else {
            if (tipoColegiado == "V") {
                $("#mdCuotas").modal("show");

                $("#lblCuotasMensaje").html("Cuotas de Vitalicio");

                $("#btnCuotaNormal").removeClass();
                $("#btnCuotaNormal").addClass("btn btn-default");

                $("#btnCuotaAmnistia").removeClass();
                $("#btnCuotaAmnistia").addClass("btn btn-default");

                $("#btnCuotaVitalicio").removeClass();
                $("#btnCuotaVitalicio").addClass("btn btn-success");

                $("#btnCuotaResolucion").removeClass();
                $("#btnCuotaResolucion").addClass("btn btn-default");

                tipoCuotas = 3;
                loadCuotas(tipoCuotas);
            } else {
                $("#mdCuotas").modal("show");

                $("#lblCuotasMensaje").html("Cuotas Ordinarias");

                $("#btnCuotaNormal").removeClass();
                $("#btnCuotaNormal").addClass("btn btn-success");

                $("#btnCuotaAmnistia").removeClass();
                $("#btnCuotaAmnistia").addClass("btn btn-default");

                $("#btnCuotaVitalicio").removeClass();
                $("#btnCuotaVitalicio").addClass("btn btn-default");

                $("#btnCuotaResolucion").removeClass();
                $("#btnCuotaResolucion").addClass("btn btn-default");

                tipoCuotas = 1;
                loadCuotas(tipoCuotas);
            }
        }
    }

    function eventCuotaOrdinaria() {
        $("#lblCuotasMensaje").html("Cuotas Ordinarias");

        $("#btnCuotaNormal").removeClass();
        $("#btnCuotaNormal").addClass("btn btn-success");

        $("#btnCuotaAmnistia").removeClass();
        $("#btnCuotaAmnistia").addClass("btn btn-default");

        $("#btnCuotaVitalicio").removeClass();
        $("#btnCuotaVitalicio").addClass("btn btn-default");

        $("#btnCuotaResolucion").removeClass();
        $("#btnCuotaResolucion").addClass("btn btn-default");

        tipoCuotas = 1;
        loadCuotas(tipoCuotas);
    }

    function eventCuotaAdmistia() {
        $("#lblCuotasMensaje").html("Cuotas de Amnistia");

        $("#btnCuotaNormal").removeClass();
        $("#btnCuotaNormal").addClass("btn btn-default");

        $("#btnCuotaAmnistia").removeClass();
        $("#btnCuotaAmnistia").addClass("btn btn-success");

        $("#btnCuotaVitalicio").removeClass();
        $("#btnCuotaVitalicio").addClass("btn btn-default");

        $("#btnCuotaResolucion").removeClass();
        $("#btnCuotaResolucion").addClass("btn btn-default");

        tipoCuotas = 2;
        loadCuotas(tipoCuotas);
    }

    function eventCuotaVitalicio() {
        $("#lblCuotasMensaje").html("Cuotas de Vitalicio");

        $("#btnCuotaNormal").removeClass();
        $("#btnCuotaNormal").addClass("btn btn-default");

        $("#btnCuotaAmnistia").removeClass();
        $("#btnCuotaAmnistia").addClass("btn btn-default");

        $("#btnCuotaVitalicio").removeClass();
        $("#btnCuotaVitalicio").addClass("btn btn-success");

        $("#btnCuotaResolucion").removeClass();
        $("#btnCuotaResolucion").addClass("btn btn-default");

        tipoCuotas = 3;
        loadCuotas(tipoCuotas);
    }

    function eventCuotaResolucion() {
        $("#lblCuotasMensaje").html("Cuotas de Resolución 15");

        $("#btnCuotaNormal").removeClass();
        $("#btnCuotaNormal").addClass("btn btn-default");

        $("#btnCuotaAmnistia").removeClass();
        $("#btnCuotaAmnistia").addClass("btn btn-default");

        $("#btnCuotaVitalicio").removeClass();
        $("#btnCuotaVitalicio").addClass("btn btn-default");

        $("#btnCuotaResolucion").removeClass();
        $("#btnCuotaResolucion").addClass("btn btn-success");

        tipoCuotas = 12;
        loadCuotas(tipoCuotas);
    }

    function eventCloseCuota() {
        $("#mdCuotas").modal("hide");
        $("#lblCuotasMensaje").html("Cuotas Ordinarias");

        $("#btnCuotaNormal").removeClass();
        $("#btnCuotaNormal").addClass("btn btn-success");

        $("#btnCuotaAmnistia").removeClass();
        $("#btnCuotaAmnistia").addClass("btn btn-default");

        $("#btnCuotaVitalicio").removeClass();
        $("#btnCuotaVitalicio").addClass("btn btn-default");
        countCurrentDate = 0;
        yearCurrentView = "";
        monthCurrentView = "";
        tipoCuotas = 0;
    }

    function addCuotas() {
        countCurrentDate = 1;
        loadCuotas(tipoCuotas);
    }

    function loadCuotas(categoria) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "typecolegiatura",
                categoria: categoria,
                dni: idDNI,
                mes: countCurrentDate,
                yearv: yearCurrentView,
                monthv: monthCurrentView,
            },
            beforeSend: function () {
                $("#tbCuotas").empty();
                $("#tbCuotas").append(
                    '<tr class="text-center"><td colspan="3"><img src="./images/spiner.gif"/><p>Cargando información...</p></td></tr>'
                );
                cuotas.splice(0, cuotas.length);
            },
            success: function (result) {

                if (result.estado == 1) {
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
            },
            error: function (error) {
                $("#tbCuotas").empty();
                $("#tbCuotas").append(
                    '<tr class="text-center"><td colspan="2"><p>' +
                    error.responseText +
                    "</p></td></tr>"
                );
            },
        });
    }

    selectCheck = function (idCheckBox) {
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
        $("#tbCuotas tr").each(function (row, tr) {
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
        $("#tbCuotas tr").each(function (row, tr) {
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
        tipoCuotas = 0;
    }
}
