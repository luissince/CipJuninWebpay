function Colegiatura() {
    this.componentesColegiatura = function () {
        $("#cbTipodePago").change(function () {
            $("#ctnConceptos").empty();
            $("#lblTotalColegiatura").html("0.00");
            if ($("#cbTipodePago").val() == 0) {
                $("#ctnConceptos").append(
                    '<div id="" class="row">' +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>" +
                    '<div class="col-md-8">' +
                    '<p style="color:red"> No se ha seleccionado ningún tipo de pago</p>' +
                    "</div>" +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>"
                );
            } else {
                loadColegiatura($("#cbTipodePago").val());
                // console.log($("#cbTipodePago ").val());
            }
        });

        $("#btnColegitura").click(function () {
            if (idDNI == 0) {
                tools.AlertWarning("Colegiatura", "No selecciono ningún ingeniero para obtener su colegiatura.");
            } else {
                $("#mdColegiatura").modal("show");
                // loadColegiatura();
                $("#ctnConceptos").empty();
                $("#lblTotalColegiatura").html("0.00");
                $("#cbTipodePago").val("");
                $("#ctnConceptos").append(
                    '<div id="" class="row">' +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>" +
                    '<div class="col-md-8">' +
                    '<p style="color:red"> No se ha seleccionado ningún tipo de pago</p>' +
                    "</div>" +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>"
                );
            }
        });

        $("#btnColegitura").keypress(function (event) {
            if (event.keyCode === 13) {
                $("#mdColegiatura").modal("show");
                // loadColegiatura();
                $("#ctnConceptos").empty();
                $("#lblTotalColegiatura").html("0.00");
                $("#cbTipodePago").val("");
                $("#ctnConceptos").append(
                    '<div id="" class="row">' +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>" +
                    '<div class="col-md-8">' +
                    '<p style="color:red"> No se ha seleccionado ningún tipo de pago</p>' +
                    "</div>" +
                    '<div class="col-md-2">' +
                    "<p></p>" +
                    "</div>"
                );
            }
            event.preventDefault();
        });

        $("#btnAceptarColegiatura").click(function () {
            validateIngresoColegiatura();
        });

        $("#btnAceptarColegiatura").keypress(function (event) {
            var keycode = event.keyCode || event.which;
            if (keycode == "13") {
                validateIngresoColegiatura();
            }
            event.preventDefault();
        });
    };

    function loadColegiatura(tipoColegiatura) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "typecolegiatura",
                categoria: tipoColegiatura,
            },
            beforeSend: function () {
                $("#ctnConceptos").empty();
                $("#ctnConceptos").append(
                    '<img src="./images/spiner.gif"/><p>Cargando información.</p>'
                );
                colegiaturas = [];
            },
            success: function (result) {
                if (result.estado === 1) {
                    $("#ctnConceptos").empty();
                    let totalColegiatura = 0;
                    colegiaturas = result.data;
                    if (colegiaturas.length == 0) {
                        $("#ctnConceptos").append("<p>No hay concepto para mostrar.</p>");
                    } else {
                        for (let value of colegiaturas) {
                            $("#ctnConceptos").append(
                                '<div id="' +
                                value.idConcepto +
                                '" class="row">' +
                                '<div class="col-md-8 text-left">' +
                                "<p>" +
                                value.Concepto +
                                "</p>" +
                                "</div>" +
                                '<div class="col-md-4 text-right">' +
                                "<p>" +
                                tools.formatMoney(value.Precio) +
                                "</panel>" +
                                "</div>"
                            );
                            totalColegiatura += parseFloat(value.Precio);
                        }
                        $("#lblTotalColegiatura").html(tools.formatMoney(totalColegiatura));
                    }
                } else {
                    $("#ctnConceptos").empty();
                    $("#ctnConceptos").append("<p>" + result.message + "</p>");
                }
            },
            error: function (error) {
                $("#ctnConceptos").empty();
                $("#ctnConceptos").append(
                    "<p>Se produjo un error interno, intente nuevamente o comuníquese con el administrador.</p>"
                );
            },
        });
    }

    function validateIngresoColegiatura() {
        for (let value of colegiaturas) {
            if (!validateDuplicate(value.IdConcepto)) {
                arrayIngresos.push({
                    idConcepto: parseInt(value.IdConcepto),
                    categoria: parseInt(value.Categoria),
                    cantidad: 1,
                    concepto: value.Concepto,
                    precio: parseFloat(value.Precio),
                    monto: parseFloat(value.Precio),
                });
            } else {
                for (let i = 0; i < arrayIngresos.length; i++) {
                    if (arrayIngresos[i].idConcepto == value.IdConcepto) {
                        let newConcepto = arrayIngresos[i];
                        newConcepto.cantidad = newConcepto.cantidad + 1;
                        newConcepto.precio = value.Precio;
                        newConcepto.monto =
                            parseFloat(newConcepto.precio) * parseFloat(newConcepto.cantidad);
                        arrayIngresos[i] = newConcepto;
                        break;
                    }
                }
            }
        }
        if (colegiaturas.length > 0) {
            colegiaturaEstado = true;
        }
        addIngresos();
        $("#mdColegiatura").modal("hide");
    }
}
