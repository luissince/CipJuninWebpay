function Otros() {


    this.componentesOtros = function () {
        $("#btnOtro").click(function () {
            if (idDNI == 0 && $("#cbEmpresa").val() == "") {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero o empresa para aceder al modulo otros.")
            } else {
                $('#mdOtros').modal('show');
                loadOtros();
            }
        });

        $("#btnOtro").keypress(function (event) {
            if (event.keyCode === 13) {
                if (idDNI == 0 && $("#cbEmpresa").val() == "") {
                    tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero o empresa para aceder al modulo otros.")
                } else {
                    $('#mdOtros').modal('show');
                    loadOtros();
                }
            }
            event.preventDefault();
        });
        $("#btnAceptarOtros").click(function () {
            validateIngresoOtros();
        });

        $("#btnAceptarOtros").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresoOtros();
            }
            event.preventDefault();
        });
        $("#cbOtrosConcepto").change(function (event) {
            $("#txtMontoOtrosConceptos").val($("#cbOtrosConcepto").find('option:selected').attr('id'))
        });
    }

    function loadOtros() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 100,
            },
            beforeSend: function () {
                $("#cbOtrosConcepto").empty();
                $("#lblConceptos").empty();
                $("#lblConceptos").append('Conceptos <img src="./images/spiner.gif" width="20"/>');
            },
            success: function (result) {
                if (result.estado === 1) {
                    $("#lblConceptos").empty();
                    $("#lblConceptos").css("color", "#333");
                    $("#lblConceptos").append('Conceptos');
                    $("#cbOtrosConcepto").append(' <option id="" value="">- Seleccione -</option>');
                    for (let value of result.data) {
                        $("#cbOtrosConcepto").append('<option id="' + value.Precio + '" value="' + value.IdConcepto + '">' + value.Concepto + ' (' + tools.formatMoney(value.Precio) + ')</option>');
                    }
                } else {
                    $("#lblConceptos").empty();
                    $("#lblConceptos").css("color", "red");
                    $("#lblConceptos").append(result.message);
                }
            },
            error: function (error) {
                $("#lblConceptos").empty();
                $("#lblConceptos").css("color", "red");
                $("#lblConceptos").append("Se produjo un error del servidor intente nuevamente.");
            }
        });
    }

    function validateIngresoOtros() {
        if ($("#cbOtrosConcepto").val() != "") {
            if ($("#txtCantidadOtrosConceptos").val() !== "") {
                if (tools.isNumeric($("#txtMontoOtrosConceptos").val())) {
                    if (!validateDuplicate($("#cbOtrosConcepto").val())) {
                        arrayIngresos.push({
                            "idConcepto": parseInt($("#cbOtrosConcepto").val()),
                            "categoria": 100,
                            "cantidad": parseFloat($('#txtCantidadOtrosConceptos').val()),
                            "concepto": $('#cbOtrosConcepto option:selected').html(),
                            "precio": parseFloat($("#txtMontoOtrosConceptos").val()),
                            "monto": parseFloat($("#txtCantidadOtrosConceptos").val()) * parseFloat($("#txtMontoOtrosConceptos").val())
                        });
                        addIngresos();
                        $('#mdOtros').modal('hide');
                        $("#txtCantidadOtrosConceptos").val("1");
                        $("#txtMontoOtrosConceptos").val("");
                    } else {
                        tools.AlertWarning("Ingresos Diversos", "Ya existe un concepto con los mismo datos.");
                        $("#cbOtrosConcepto").focus().select();
                    }
                } else {
                    tools.AlertWarning("Ingresos Diversos", "Debe ingresar un precio numérico")
                }
            } else {
                tools.AlertWarning("Ingresos Diversos", "Debe ingresar una cantidad mayor a cero")
            }
        } else {
            tools.AlertWarning("Ingresos Diversos", "Debe escoger un concepto")
        }
    }

}