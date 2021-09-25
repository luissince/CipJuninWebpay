function Certificado() {
    this.componentesCertificado = function () {
        //********************************************* */
        $("#btnCertificado").click(function () {
            if (idDNI == 0) {
                tools.AlertWarning("Certificado", "No selecciono ningún ingeniero para obtener sus certificados.")
            } else {
                $("#btnCertificado").attr('data-toggle', 'dropdown');
                $("#btnCertificado").attr('aria-expanded', 'true');
            }
        });

        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD
        $("#btnCertHabilidad").click(function () {
            $('#mdCertHabilidad').modal('show');
            loadCertificadoHabilidad(idDNI);
        });

        $("#btnCertHabilidad").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
                loadCertificadoHabilidad(idDNI);
            }
            event.preventDefault();
        });

        $("#txtCorrelativoCertificado").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#btnAceptarCertificado").click(function () {
            validateIngresosCertificadoHabilidad();
        });

        $("#btnAceptarCertificado").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoHabilidad();
            }
            event.preventDefault();
        });

        $("#btnCancelarCertificado").click(function () {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        $("#btnCloseCertificado").click(function () {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD OBRA PUBLICA O RESIDENCIA
        $("#btnCertResidenciaObra").click(function () {
            $('#mdCertResidenciaObra').modal('show');
            loadCertificadoObra(idDNI);
        });

        $("#btnCertResidenciaObra").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertResidenciaObra').modal('show');
                loadCertificadoObra(idDNI);
            }
            event.preventDefault();
        });

        $("#txtCertificadoNumeroObra").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#txtMontoContratoObra").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoContratoObra").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#txtMontoCobrarObra").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoCobrarObra").val().includes(".")) {
                event.preventDefault();
            }
        });


        $("#btnAceptarCertResidenciaObra").click(function () {
            validateIngresosCertificadoResidenciaObra();
        });

        $("#btnAceptarCertResidenciaObra").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoResidenciaObra();
            }
            event.preventDefault();
        });

        $("#btnCloseCertResidenciaObra").click(function () {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObra();
        });

        $("#btnCloseCertRecidenciaObra").click(function () {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObra();
        });

        /****************************************************/
        //-----CERTIFICADO DE PROYECTO
        $("#btnCertProyecto").click(function () {
            $('#mdCertProyecto').modal('show');
            loadCertificadoProyecto(idDNI);
        });

        $("#btnCertProyecto").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertProyecto').modal('show');
                loadCertificadoProyecto(idDNI);
            }
            event.preventDefault();
        });

        $("#txtNumeroCertificadoProyecto").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#txtMontoContratoProyecto").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoContratoProyecto").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#txtMontoCobrarProyecto").keypress(function (event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoCobrarProyecto").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#btnAceptarCertProyecto").click(function () {
            validateIngresosCertificadoProyecto()
        });

        $("#btnAceptarCertProyecto").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoProyecto()
            }
            event.preventDefault();
        });

        $("#btnCloseCertProyecto").click(function () {
            $('#mdCertProyecto').modal('hide');
            clearIngresoCertificadoProyecto();
        });

        $("#btnCancelCertProyecto").click(function () {
            $('#mdCertProyecto').modal('hide');
            clearIngresoCertificadoProyecto();
        });
        /****************************************************/

    }

    function loadCertificadoHabilidad($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            dataType: "json",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadCertificado").empty();
                $("#modal-title-certificado-habilidad").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoHabilidadEstado").removeClass();
                $("#lblCertificadoHabilidadEstado").empty();
                certificadoHabilidad = {}
            },
            success: function (result) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"> </i> Certificado de Habilidad');
                if (result.estado == 1) {
                    certificadoHabilidad = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };

                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idColegiado + '">' + especialidades.Especialidad + '</option>');
                    }

                    if (result.especialidades.length != 0) {
                        $("select#cbEspecialidadCertificado").prop('selectedIndex', 1);
                    }

                    if (result.especialidades.length > 1) {
                        $("#lblEspecialidadCertificado").html('Especialidad(es) <em class=" text-primary text-bold small"><i class="fa fa-info-circle"></i> Tiene más de 2 especialidades</em>');
                    }

                    if (cuotasEstate) {
                        if (tools.validateDate(cuotasFin)) {
                            let mes = tipoColegiado == "V" ? 9 : 3;
                            let fechaCertHabilidad = new Date(cuotasFin);
                            fechaCertHabilidad.setDate(1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + 1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + mes);
                            let year = fechaCertHabilidad.getFullYear();
                            let month = (fechaCertHabilidad.getMonth() + 1) <= 9 ? "0" + (fechaCertHabilidad.getMonth() + 1) : (fechaCertHabilidad.getMonth() + 1);
                            var lastDayOfMonth = new Date(year, month, 0);
                            let date = lastDayOfMonth.getDate() <= 9 ? "0" + lastDayOfMonth.getDate() : lastDayOfMonth.getDate();
                            let newDate = year + '-' + month + '-' + date;
                            $("#txtFechaCertificado").val(newDate);
                        }
                    } else {
                        $("#txtFechaCertificado").val(result.ultimopago);
                    }

                    $("#lblCertificadoHabilidadEstado").addClass("text-success");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');

                    $("#txtCorrelativoCertificado").val(result.numeracion);
                } else {
                    $("#lblCertificadoHabilidadEstado").addClass("text-warning");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                }
            },
            error: function (error) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"></i> Certificado de Habilidad');
                $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoHabilidadEstado").addClass("text-danger");
                $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + error.responseText);
            }
        });
    }

    function loadCertificadoObra($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 6,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadObra").empty();
                $("#cbDepartamentoObra").empty();
                $("#modal-title-residencia-obra").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoResidenciaObraEstado").removeClass();
                $("#lblCertificadoResidenciaObraEstado").empty();
                certificadoResidenciaObra = {}
            },
            success: function (result) {
                $("#modal-title-residencia-obra").empty();
                $("#modal-title-residencia-obra").append('<i class="fa fa-plus"> </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');

                if (result.estado == 1) {
                    certificadoResidenciaObra = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };
                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadObra").append('<option value="' + especialidades.idColegiado + '">' + especialidades.Especialidad + '</option>');
                    }
                    if (result.especialidades.length != 0) {
                        $("select#cbEspecialidadObra").prop('selectedIndex', 1);
                    }

                    if (result.especialidades.length > 1) {
                        $("#lblEspecialidadObra").html('Especialidad(es) <em class=" text-primary text-bold small"><i class="fa fa-info-circle"></i> Tiene más de 2 especialidades</em>');
                    }

                    if (cuotasEstate) {
                        if (tools.validateDate(cuotasFin)) {
                            let fechaCertHabilidad = new Date(cuotasFin);
                            let mes = tipoColegiado == "V" ? 9 : 3;
                            fechaCertHabilidad.setDate(1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + 1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + mes);
                            let year = fechaCertHabilidad.getFullYear();
                            let month = (fechaCertHabilidad.getMonth() + 1) <= 9 ? "0" + (fechaCertHabilidad.getMonth() + 1) : (fechaCertHabilidad.getMonth() + 1);
                            var lastDayOfMonth = new Date(year, month, 0);
                            let date = lastDayOfMonth.getDate() <= 9 ? "0" + lastDayOfMonth.getDate() : lastDayOfMonth.getDate();
                            let newDate = year + '-' + month + '-' + date;
                            $("#txtFechaObra").val(newDate);
                        }
                    } else {
                        $("#txtFechaObra").val(result.ultimopago);
                    }

                    $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let ubigeo of result.ubigeo) {
                        $("#cbDepartamentoObra").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoObra').select2();

                    $("#lblCertificadoResidenciaObraEstado").addClass("text-success");
                    $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');

                    $("#txtCertificadoNumeroObra").val(result.numeracion);
                } else {
                    $("#lblCertificadoResidenciaObraEstado").addClass("text-warning");
                    $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i>' + result.message);
                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                }
            },
            error: function (error) {
                $("#modal-title-residencia-obra").empty();
                $("#modal-title-residencia-obra").append('<i class="fa fa-plus"> </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');
                $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoResidenciaObraEstado").addClass("text-danger");
                $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);
            }
        });
    }

    function loadCertificadoProyecto($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 7,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadProyecto").empty();
                $("#cbDepartamentoProyecto").empty();
                $("#modal-title-certificado-proyecto").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoProyectoEstado").removeClass();
                $("#lblCertificadoProyectoEstado").empty();
                certificadoProyecto = {};
            },
            success: function (result) {
                $("#modal-title-certificado-proyecto").empty();
                $("#modal-title-certificado-proyecto").append('<i class="fa fa-plus"> </i> Certificado de Proyecto');
                if (result.estado == 1) {
                    certificadoProyecto = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idColegiado + '">' + especialidades.Especialidad + '</option>');
                    }
                    if (result.especialidades.length != 0) {
                        $("select#cbEspecialidadProyecto").prop('selectedIndex', 1);
                    }

                    if (result.especialidades.length > 1) {
                        $("#lblEspecialidadProyecto").html('Especialidad(es) <em class=" text-primary text-bold small"><i class="fa fa-info-circle"></i> Tiene más de 2 especialidades</em>');
                    }

                    if (cuotasEstate) {
                        if (tools.validateDate(cuotasFin)) {
                            let fechaCertHabilidad = new Date(cuotasFin);
                            let mes = tipoColegiado == "V" ? 9 : 3;
                            fechaCertHabilidad.setDate(1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + 1);
                            fechaCertHabilidad.setMonth(fechaCertHabilidad.getMonth() + mes);
                            let year = fechaCertHabilidad.getFullYear();
                            let month = (fechaCertHabilidad.getMonth() + 1) <= 9 ? "0" + (fechaCertHabilidad.getMonth() + 1) : (fechaCertHabilidad.getMonth() + 1);
                            var lastDayOfMonth = new Date(year, month, 0);
                            let date = lastDayOfMonth.getDate() <= 9 ? "0" + lastDayOfMonth.getDate() : lastDayOfMonth.getDate();
                            let newDate = year + '-' + month + '-' + date;
                            $("#txtFechaProyecto").val(newDate);
                        }
                    } else {
                        $("#txtFechaProyecto").val(result.ultimopago);
                    }

                    $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let ubigeo of result.ubigeo) {
                        $("#cbDepartamentoProyecto").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoProyecto').select2();

                    $("#lblCertificadoProyectoEstado").addClass("text-success");
                    $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');

                    $("#txtNumeroCertificadoProyecto").val(result.numeracion);
                } else {
                    $("#lblCertificadoProyectoEstado").addClass("text-warning");
                    $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                }
            },
            error: function (error) {
                $("#modal-title-certificado-proyecto").empty();
                $("#modal-title-certificado-proyecto").append('<i class="fa fa-plus"> </i> Certificado de Proyecto');
                $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoProyectoEstado").addClass("text-danger");
                $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);

            }
        });
    }

    function validateIngresosCertificadoHabilidad() {
        if ($("#cbEspecialidadCertificado").val() == '') {
            $("#cbEspecialidadCertificado").focus();
        } else if (!tools.validateDate($("#txtFechaCertificado").val())) {
            $("#txtFechaCertificado").focus();
        } else if ($("#txtCorrelativoCertificado").val() == "") {
            $("#txtCorrelativoCertificado").focus();
        } else if ($("#txtAsuntoCertificado").val() == '') {
            $("#txtAsuntoCertificado").focus();
        } else if ($("#txtEntidadCertificado").val() == '') {
            $("#txtEntidadCertificado").focus();
        } else if ($("#txtLugarCertificado").val() == '') {
            $("#txtLugarCertificado").focus();
        } else if ($.isEmptyObject(certificadoHabilidad)) {
            tools.AlertWarning("Certificado de Habilidad", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoHabilidad.fechaPago = tools.getCurrentDate();
            certificadoHabilidad.idEspecialidad = $("#cbEspecialidadCertificado").val();
            certificadoHabilidad.numero = $("#txtCorrelativoCertificado").val();
            certificadoHabilidad.asunto = $("#txtAsuntoCertificado").val().toUpperCase();
            certificadoHabilidad.entidad = $("#txtEntidadCertificado").val().toUpperCase();
            certificadoHabilidad.lugar = $("#txtLugarCertificado").val().toUpperCase();
            certificadoHabilidad.ultimoPago = $("#txtFechaCertificado").val();
            certificadoHabilidad.anulado = 0;
            validateCertHabilidadNum(certificadoHabilidad.numero);
        }
    }

    function validateCertHabilidadNum(numero) {
        tools.AlertInfo("Certificado de Habilidad", "Validando numeración del certificado");
        $.get("../app/controller/ConceptoController.php", { "type": "numCertHabilidad", "numero": numero }, function (data, status) {
            if (data.estado == false) {
                if (!validateDuplicate(certificadoHabilidad.idConcepto)) {
                    arrayIngresos.push({
                        "idConcepto": certificadoHabilidad.idConcepto,
                        "categoria": certificadoHabilidad.categoria,
                        "cantidad": certificadoHabilidad.cantidad,
                        "concepto": certificadoHabilidad.concepto,
                        "precio": certificadoHabilidad.precio,
                        "monto": certificadoHabilidad.precio * certificadoHabilidad.cantidad
                    });
                    addIngresos();
                    $('#mdCertHabilidad').modal('hide')
                    certificadoHabilidadEstado = true;
                    clearIngresosCertificadoHabilidad()
                } else {
                    tools.AlertWarning("Certificado de Habilidad", "Ya existe un concepto con los mismo datos.");
                }
            } else {
                tools.AlertWarning("Certificado de Habilidad", "La numeración del certificado ya existe en los registros.");
                $("#txtCorrelativoCertificado").focus();
            }
        });
    }

    function validateIngresosCertificadoResidenciaObra() {
        if ($("#cbEspecialidadObra").val() == '') {
            $("#cbEspecialidadObra").focus();
        } else if ($("#txtFechaObra").val() == '') {
            $("#txtFechaObra").focus();
        } else if ($("#txtCertificadoNumeroObra").val() == '') {
            $("#txtCertificadoNumeroObra").focus();
        } else if ($("#txtModalidadObra").val() == '') {
            $("#txtModalidadObra").focus();
        } else if ($("#txtProyectoObra").val() == '') {
            $("#txtProyectoObra").focus();
        } else if ($("#txtPropietarioObra").val() == '') {
            $("#txtPropietarioObra").focus();
        } else if (!tools.isNumeric($("#txtMontoContratoObra").val())) {
            $("#txtMontoContratoObra").focus();
        } else if ($("#cbDepartamentoObra").val() == '') {
            $("#cbDepartamentoObra").focus();
        } else if (!tools.isNumeric($("#txtMontoCobrarObra").val())) {
            $("#txtMontoCobrarObra").focus();
        } else if ($.isEmptyObject(certificadoResidenciaObra)) {
            tools.AlertWarning("Certificado de Residencia de Obra", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoResidenciaObra.fechaPago = tools.getCurrentDate();
            certificadoResidenciaObra.idEspecialidad = $("#cbEspecialidadObra").val();
            certificadoResidenciaObra.numero = $("#txtCertificadoNumeroObra").val();
            certificadoResidenciaObra.modalidad = $("#txtModalidadObra").val().toUpperCase();
            certificadoResidenciaObra.proyecto = $("#txtProyectoObra").val().toUpperCase();
            certificadoResidenciaObra.propietario = $("#txtPropietarioObra").val().toUpperCase();
            certificadoResidenciaObra.montocontrato = parseFloat($("#txtMontoContratoObra").val());
            certificadoResidenciaObra.ubigeo = $("#cbDepartamentoObra").val();
            certificadoResidenciaObra.precio = parseFloat($("#txtMontoCobrarObra").val());
            certificadoResidenciaObra.monto = parseFloat($("#txtMontoCobrarObra").val());
            certificadoResidenciaObra.ultimoPago = $("#txtFechaObra").val();
            certificadoResidenciaObra.anulado = 0;

            if (!validateDuplicate(certificadoResidenciaObra.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": certificadoResidenciaObra.idConcepto,
                    "categoria": certificadoResidenciaObra.categoria,
                    "cantidad": certificadoResidenciaObra.cantidad,
                    "concepto": certificadoResidenciaObra.concepto,
                    "precio": certificadoResidenciaObra.precio,
                    "monto": certificadoResidenciaObra.precio * certificadoResidenciaObra.cantidad
                });
                addIngresos();
                $('#mdCertResidenciaObra').modal('hide');
                certificadoResidenciaObraEstado = true;
                clearIngresosCertificadoResidenciaObra();
            } else {
                tools.AlertWarning("Certificado de Residencia de Obra", "Ya existe un concepto con los mismo datos.");
            }
        }
    }

    function validateIngresosCertificadoProyecto() {
        if ($("#cbEspecialidadProyecto").val() == '') {
            $("#cbEspecialidadProyecto").focus();
        } else if (!tools.validateDate($("#txtFechaProyecto").val())) {
            $("#txtFechaProyecto").focus();
        } else if ($("#txtNumeroCertificadoProyecto").val() == '') {
            $("#txtNumeroCertificadoProyecto").focus();
        } else if ($("#txtModalidadProyecto").val() == '') {
            $("#txtModalidadProyecto").focus();
        } else if ($("#txtPropietarioProyecto").val() == '') {
            $("#txtPropietarioProyecto").focus();
        } else if ($("#txtProyectoProyecto").val() == '') {
            $("#txtProyectoProyecto").focus();
        } else if (!tools.isNumeric($("#txtMontoContratoProyecto").val())) {
            $("#txtMontoContratoProyecto").focus();
        } else if ($("#cbDepartamentoProyecto").val() == '') {
            $("#cbDepartamentoProyecto").focus();
        } else if ($("#txtUrbProyecto").val() == '') {
            $("#txtUrbProyecto").focus();
        } else if ($("#txtCalleProyecto").val() == '') {
            $("#txtCalleProyecto").focus();
        } else if (!tools.isNumeric($("#txtMontoCobrarProyecto").val())) {
            $("#txtMontoCobrarProyecto").focus();
        } else if ($.isEmptyObject(certificadoProyecto)) {
            tools.AlertWarning("Certificado de Proyecto", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoProyecto.fechaPago = tools.getCurrentDate();
            certificadoProyecto.idEspecialidad = $("#cbEspecialidadProyecto").val();
            certificadoProyecto.numero = $("#txtNumeroCertificadoProyecto").val();
            certificadoProyecto.modalidad = $("#txtModalidadProyecto").val().toUpperCase();
            certificadoProyecto.proyecto = $("#txtProyectoProyecto").val().toUpperCase();
            certificadoProyecto.propietario = $("#txtPropietarioProyecto").val().toUpperCase();
            certificadoProyecto.montocontrato = parseFloat($("#txtMontoContratoProyecto").val());
            certificadoProyecto.ubigeo = $("#cbDepartamentoProyecto").val();
            certificadoProyecto.asociacion = $("#txtUrbProyecto").val().toUpperCase();
            certificadoProyecto.pasaje = $("#txtCalleProyecto").val().toUpperCase();
            certificadoProyecto.precio = parseFloat($("#txtMontoCobrarProyecto").val());
            certificadoProyecto.monto = parseFloat($("#txtMontoCobrarProyecto").val());
            certificadoProyecto.ultimoPago = $("#txtFechaProyecto").val();
            certificadoProyecto.anulado = 0;

            if (!validateDuplicate(certificadoProyecto.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": certificadoProyecto.idConcepto,
                    "categoria": certificadoProyecto.categoria,
                    "cantidad": certificadoProyecto.cantidad,
                    "concepto": certificadoProyecto.concepto,
                    "precio": certificadoProyecto.precio,
                    "monto": certificadoProyecto.precio * certificadoProyecto.cantidad
                });
                addIngresos();
                $('#mdCertProyecto').modal('hide');
                certificadoProyectoEstado = true;
                clearIngresoCertificadoProyecto();
            } else {
                tools.AlertWarning("Certificado de Proyecto", "Ya existe un concepto con los mismo datos.");
            }

        }
    }

    function clearIngresosCertificadoHabilidad() {
        $("#cbEspecialidadCertificado").val("")
        $("#txtCorrelativoCertificado").val("")
        $("#lblEspecialidadCertificado").html('Especialidad(es)');
        $("#txtAsuntoCertificado").val("EJERCICIO DE LA PROFESIÓN")
        $("#txtEntidadCertificado").val("VARIOS")
        $("#txtLugarCertificado").val("A NIVEL NACIONAL")
    }

    function clearIngresosCertificadoResidenciaObra() {
        $("#cbEspecialidadObra").val("")
        $("#lblEspecialidadObra").html('Especialidad(es)');
        $("#txtFechaObra").val("")
        $("#txtCertificadoNumeroObra").val("")
        $("#txtModalidadObra").val("")
        $("#txtProyectoObra").val("")
        $("#txtPropietarioObra").val("")
        $("#txtMontoContratoObra").val("")
        $("#cbDepartamentoObra").empty()
        $("#txtMontoCobrarObra").val("")
    }

    function clearIngresoCertificadoProyecto() {
        $("#cbEspecialidadProyecto").val("")
        $("#lblEspecialidadProyecto").html('Especialidad(es)');
        $("#txtFechaProyecto").val("")
        $("#txtNumeroCertificadoProyecto").val("")
        $("#txtModalidadProyecto").val("")
        $("#txtPropietarioProyecto").val("")
        $("#txtProyectoProyecto").val("")
        $("#txtMontoContratoProyecto").val("")
        $("#cbDepartamentoProyecto").val("")
        $("#txtUrbProyecto").val("")
        $("#txtCalleProyecto").val("")
        $("#txtMontoCobrarProyecto").val("")
    }
}