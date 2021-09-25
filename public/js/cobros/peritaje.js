function Peritaje() {
    this.componentesPeritaje = function() {
        $("#btnPeritaje").click(function() {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener peritajes.")
            } else {
                $('#mdPeritaje').modal('show');
                loadPeritaje();
            }
        });

        $("#btnPeritaje").keypress(function() {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener peritajes.")
            } else {
                $('#mdPeritaje').modal('show');
                loadPeritaje();
            }
        });

        $('#mdPeritaje').on('shown.bs.modal', function() {
            $('#txtDescripcionPeritaje').focus();
        });

        $("#btnClosePeritaje").click(function() {
            $('#mdPeritaje').modal('hide');
        });

        $("#btnClosePeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('hide');
            }
            event.preventDefault();
        });

        $("#btnCancelarPeritaje").click(function() {
            $('#mdPeritaje').modal('hide');
        });

        $("#btnCancelarPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdPeritaje').modal('hide');
            }
            event.preventDefault();
        });

        $("#btnAceptarPeritaje").click(function() {
            validateIngresoPeritaje();
        });

        $("#btnAceptarPeritaje").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
            event.preventDefault();
        });

        $("#txtDescripcionPeritaje").keydown(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
        });

        $("#txtMontoPeritaje").keydown(function(event) {
            if (event.keyCode === 13) {
                validateIngresoPeritaje();
            }
        });

        $("#txtMontoPeritaje").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoPeritaje").val().includes(".")) {
                event.preventDefault();
            }
        });

    }

    function loadPeritaje() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 8,
            },
            beforeSend: function() {
                $("#lblPeritajeEstado").removeClass();
                $("#lblPeritajeEstado").empty();
                $("#lblPeritajeEstado").addClass("text-info");
                $("#lblPeritajeEstado").append('<i class="fa fa-spinner"> </i> Cargando información...');

                peritaje = {};
            },
            success: function(result) {
                $("#lblPeritajeEstado").removeClass();
                $("#lblPeritajeEstado").empty();

                if (result.estado == 1) {
                    peritaje = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio)
                    }
                    $("#lblPeritajeEstado").addClass("text-success");
                    $("#lblPeritajeEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');

                } else {
                    $("#lblPeritajeEstado").addClass("text-warning");
                    $("#lblPeritajeEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                }
            },
            error: function(error) {
                $("#lblPeritajeEstado").removeClass();
                $("#lblPeritajeEstado").empty();

                $("#lblPeritajeEstado").addClass("text-danger");
                $("#lblPeritajeEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);
            }
        });
    }

    function validateIngresoPeritaje() {
        if ($("#txtDescripcionPeritaje").val().trim() == '') {
            tools.AlertWarning("Peritaje", "Ingrese una descripción del peritaje.");
            $("#txtDescripcionPeritaje").focus();
        } else if (!tools.isNumeric($("#txtMontoPeritaje").val())) {
            tools.AlertWarning("Peritaje", "Ingrese el monto del peritaje.");
            $("#txtMontoPeritaje").focus();
        } else if ($.isEmptyObject(peritaje)) {
            tools.AlertWarning("Peritaje", "No se pudo crear el objeto por error en cargar los datos.")
        } else {

            peritaje.descripcion = $("#txtDescripcionPeritaje").val().trim().toUpperCase();
            peritaje.precio = parseFloat($("#txtMontoPeritaje").val());
            peritaje.monto = parseFloat($("#txtMontoPeritaje").val());

            if (!validateDuplicate(peritaje.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": peritaje.idConcepto,
                    "categoria": peritaje.categoria,
                    "cantidad": peritaje.cantidad,
                    "concepto": peritaje.concepto,
                    "precio": peritaje.precio,
                    "monto": peritaje.precio * peritaje.cantidad
                });
                addIngresos()
                $('#mdPeritaje').modal('hide')
                peritajeEstado = true;
                clearIngresoPeritaje()
            } else {
                tools.AlertWarning("Certificado de Residencia de Obra", "Ya existe un concepto con los mismo datos.");
            }
        }
    }

    function clearIngresoPeritaje() {
        $("#txtDescripcionPeritaje").val("")
        $("#txtMontoPeritaje").val("")
    }
}