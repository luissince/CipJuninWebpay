function Estudios() {
    this.loadGradosyEstudios = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getgradosyestudios",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbGradosyExperiencia").empty();
                $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbGradosyExperiencia").empty();
                    if (result.data.length == 0) {
                        $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="6"><p>No tiene registrado ningun grado o estudio.</p></td></tr>');
                    } else {
                        for (let gradosyestudios of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateEstudios(\'' + gradosyestudios.IdEstudio + '\',\'' +
                                gradosyestudios.IdTipo + '\',\'' + gradosyestudios.Materia + '\',\'' + gradosyestudios.IdUniversidad + '\',\'' +
                                gradosyestudios.Fecha + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteEstudios(\'' + gradosyestudios.IdEstudio + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbGradosyExperiencia").append('<tr>' +
                                '<td>' + gradosyestudios.Id + '</td>' +
                                '<td>' + gradosyestudios.Grado + '</td>' +
                                '<td>' + gradosyestudios.Materia + '</td>' +
                                '<td>' + gradosyestudios.Universidad + '</td>' +
                                '<td>' + gradosyestudios.Fecha + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbGradosyExperiencia").empty();
                    $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="6"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function (error) {
                $("#tbGradosyExperiencia").empty();
                $("#tbGradosyExperiencia").append('<tr class="text-center"><td colspan="6"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddEstudios = function () {

        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddestudios",
            },
            beforeSend: function () {
                $("#selectGrado").empty();
                $("#txtMateria").val('');
                $("#selectUniversidad").empty();
                $("#fechaEstudios").val('');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#selectGrado").append('<option value="">- Seleccione -</option>');
                    for (let grados of result.grados) {
                        $("#selectGrado").append('<option value="' + grados.IdGrado + '">' + grados.Grado + '</option>');
                    }
                    $("#selectUniversidad").append('<option value="">- Seleccione -</option>');
                    for (let universidades of result.universidades) {
                        $("#selectUniversidad").append('<option value="' + universidades.IdUniversidad + '">' + universidades.Universidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Estudios", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("Estudios", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudEstudios = function () {

        if ($("#selectGrado").val() == '') {
            tools.AlertWarning('Estudios', "Seleccione un grado");
            $("#selectGrado").focus();
        } else if ($("#txtMateria").val() == '') {
            tools.AlertWarning('Estudios', "Ingrese una materia valida");
            $("#txtMateria").focus();
        } else if ($("#selectUniversidad").val() == '') {
            tools.AlertWarning('Estudios', "Seleccione una universidad antes de continuar");
            $("#selectUniversidad").focus();
        } else if (!tools.validateDate($("#fechaEstudios").val())) {
            tools.AlertWarning('Estudios', "Ingrese una fecha valida");
            $("#fechaEstudios").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertEstudios",
                    "dni": idDNI,
                    "grado": $("#selectGrado").val(),
                    "materia": $("#txtMateria").val(),
                    "universidad": $("#selectUniversidad").val(),
                    "fechaEstudios": $("#fechaEstudios").val(),
                },
                beforeSend: function () {
                    tools.AlertInfo("Estudios", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addGradosyEstudios").modal("hide");
                        tools.AlertSuccess("Estudios", "Se registro correctamente.");
                        modelEstudios.loadGradosyEstudios(idDNI);
                    } else if (result.estado == 3) {
                        tools.AlertWarning("Estudios", result.message);
                    } else {
                        tools.AlertWarning("Estudios", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    tools.AlertError("Experiencia", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}

function updateEstudios(Id, Tipo, Materia, Universidad, Fecha) {
    $("#editarGradosyEstudios").modal("show");

    let cbxGrado = $("#EselectGrado");
    let cbxUniversidad = $("#EselectUniversidad");
    let fecha = Fecha.split("/").reverse().join("-");

    $.ajax({
        url: "../app/controller/PersonaController.php",
        method: "GET",
        data: {
            type: "getaddestudios",
        },
        beforeSend: function () {
            $("#EselectGrado").empty();
            $("#EtxtMateria").val('');
            $("#EselectUniversidad").empty();
            $("#EfechaEstudios").val('');
        },
        success: function (result) {
            if (result.estado == 1) {
                // $("#selectGrado").append('<option value="">- Seleccione -</option>');
                for (let grados of result.grados) {
                    $("#EselectGrado").append('<option value="' + grados.IdGrado + '">' + grados.Grado + '</option>');
                }
                cbxGrado.val(Tipo);
                // $("#selectUniversidad").append('<option value="">- Seleccione -</option>');
                for (let universidades of result.universidades) {
                    $("#EselectUniversidad").append('<option value="' + universidades.IdUniversidad + '">' + universidades.Universidad + '</option>');
                }
                cbxUniversidad.val(Universidad);

                $("#EtxtMateria").val(Materia);
                document.getElementById("EfechaEstudios").value = tools.getDateForma(fecha, 'yyyy-mm-dd');

            } else {
                tools.AlertWarning("Estudios", "Se produjo un error al cargar los datos en el modal");
            }
        },
        error: function (error) {
            tools.AlertError("Estudios", "Error Fatal, Comuniquese con el administrador del sistema");
        }
    });

    $("#EbtnAceptarEstudios").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarEstudios").bind('click', function () {
        AceptarUpdateEstudios(Id);
    });
}

function AceptarUpdateEstudios(Id) {
    if ($("#EtxtMateria").val() == '') {
        tools.AlertWarning('Estudios', "Ingrese una materia antes de continuar");
        $("#EtxtMateria").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateEstudios",
                "idEstudios": Id,
                "grado": $("#EselectGrado").val(),
                "materia": ($('#EtxtMateria').val()).trim(),
                "universidad": $("#EselectUniversidad").val(),
                "fecha": $("#EfechaEstudios").val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Estudios", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editarGradosyEstudios").modal("hide");
                    tools.AlertSuccess("Estudios", "Se actualizo correctamente.");
                    modelEstudios.loadGradosyEstudios(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Estudios", result.message);
                } else {
                    tools.AlertWarning("Estudios", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Estudios", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteEstudios(Id) {
    $("#deleteEstudio").modal("show");

    let idEstudio = Id;

    $("#btnDeleteEstudio").unbind();

    $("#btnDeleteEstudio").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteEstudio",
                "idestudio": idEstudio,
            },
            beforeSend: function () {
                tools.AlertInfo("Estudio", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Estudio", result.message);
                    $("#deleteEstudio").modal("hide");
                    modelEstudios.loadGradosyEstudios(idDNI);
                } else {
                    tools.AlertWarning("Estudio", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Estudio", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}