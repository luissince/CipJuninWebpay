function Experiencia() {

    this.loadExperiencia = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getexperiencia",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbExperiencia").empty();
                $("#tbExperiencia").append('<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbExperiencia").empty();
                    if (result.data.length == 0) {
                        $("#tbExperiencia").append('<tr class="text-center"><td colspan="6"><p>No tiene registrado ninguna experiencia.</p></td></tr>');
                    } else {
                        for (let experiencia of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateExperiencia(\'' + experiencia.IdExperiencia + '\',\'' +
                                experiencia.Entidad + '\',\'' + experiencia.Experiencia + '\',\'' + experiencia.FechaInicio + '\',\'' + experiencia.FechaFin + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteExperiencia(\'' + experiencia.IdExperiencia + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbExperiencia").append('<tr>' +
                                '<td>' + experiencia.Id + '</td>' +
                                '<td>' + experiencia.Entidad + '</td>' +
                                '<td>' + experiencia.Experiencia + '</td>' +
                                '<td>' + experiencia.FechaInicio + '</td>' +
                                '<td>' + experiencia.FechaFin + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbExperiencia").empty();
                    $("#tbExperiencia").append('<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function (error) {
                $("#tbExperiencia").empty();
                $("#tbExperiencia").append('<tr class="text-center"><td colspan="6"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddExperiencia = function () {
        $("#txtEntidad").val('');
        $("#txtExperiencia").val('');
        $("#FechaInicio").val(null);
        $("#FechaFin").val(null);
    }

    this.crudExperiencia = function () {

        if ($("#txtEntidad").val() == '') {
            tools.AlertWarning('Experiencia', "Ingrese una entidad valida");
            $("#txtEntidad").focus();
        } else if ($("#txtExperiencia").val() == '') {
            tools.AlertWarning('Experiencia', "Ingrese una experiencia valida");
            $("#txtExperiencia").focus();
        } else if (!tools.validateDate($("#FechaInicio").val())) {
            tools.AlertWarning('Experiencia', "Ingrese una fecha de inicio valida");
            $("#FechaInicio").focus();
        } else if (!tools.validateDate($("#FechaFin").val())) {
            tools.AlertWarning('Experiencia', "Ingrese una fecha de fin valida");
            $("#FechaFin").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertExperiencia",
                    "dni": idDNI,
                    "entidad": ($("#txtEntidad").val()).trim(),
                    "experiencia": ($("#txtExperiencia").val()).trim(),
                    "fechaInicio": $("#FechaInicio").val(),
                    "fechaFin": $("#FechaFin").val(),
                },
                beforeSend: function () {
                    tools.AlertInfo("Experiencia", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addExperiencia").modal("hide");
                        tools.AlertSuccess("Experiencia", "Se registro correctamente.");
                        modelExperiencia.loadExperiencia(idDNI);
                    } else if (result.estado == 3) {
                        tools.AlertWarning("Experiencia", result.message);
                    } else {
                        tools.AlertWarning("Experiencia", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}

function updateExperiencia(Id, Entidad, Experiencia, Inicio, Fin) {
    $("#editExperiencia").modal("show");

    let fInicio = Inicio.split("/").reverse().join("-");
    let fFin = Fin.split("/").reverse().join("-");

    $("#EtxtEntidad").val(Entidad);
    $("#EtxtExperiencia").val(Experiencia);
    document.getElementById("EFechaInicio").value = tools.getDateForma(fInicio, 'yyyy-mm-dd');
    document.getElementById("EFechaFin").value = tools.getDateForma(fFin, 'yyyy-mm-dd');


    $("#EbtnAceptarExperiencia").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarExperiencia").bind('click', function () {
        AceptarUpdateExperiencia(Id);
    });
}

function AceptarUpdateExperiencia(Id) {
    if ($("#EtxtEntidad").val() == '') {
        tools.AlertWarning('Experiencia', "Ingrese una entidad");
        $("#EtxtEntidad").focus();
    } else if ($("#EtxtExperiencia").val() == '') {
        tools.AlertWarning('Experiencia', "Ingrese una experiencia");
        $("#EtxtExperiencia").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateExperiencia",
                "idExperiencia": Id,
                "Entidad": $("#EtxtEntidad").val(),
                "Experiencia": $('#EtxtExperiencia').val(),
                "Inicio": $("#EFechaInicio").val(),
                "Fin": $('#EFechaFin').val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Experiencia", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editExperiencia").modal("hide");
                    tools.AlertSuccess("Experiencia", "Se actualizo correctamente.");
                    modelExperiencia.loadExperiencia(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Experiencia", result.message);
                } else {
                    tools.AlertWarning("Experiencia", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteExperiencia(Id) {
    $("#deleteExperiencia").modal("show");

    let idExperiencia = Id;

    $("#btnDeleteExperiencia").unbind();

    $("#btnDeleteExperiencia").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteExperiencia",
                "idExperiencia": idExperiencia,
            },
            beforeSend: function () {
                tools.AlertInfo("Experiencia", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Experiencia", result.message);
                    $("#deleteExperiencia").modal("hide");
                    modelExperiencia.loadExperiencia(idDNI);
                } else {
                    tools.AlertWarning("Experiencia", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}