function CorreoyWeb() {
    this.loadCorreoyWeb = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getcorreoyweb",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbGradosyWeb").empty();
                $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbGradosyWeb").empty();
                    if (result.data.length == 0) {
                        $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="4"><p>No tiene registrado ningun correo o sitio web.</p></td></tr>');
                    } else {
                        for (let correoyweb of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateCorreoyweb(\'' + correoyweb.IdWeb + '\',\'' +
                                correoyweb.IdTipo + '\',\'' + correoyweb.Direccion + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteCorreoyweb(\'' + correoyweb.IdWeb + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbGradosyWeb").append('<tr>' +
                                '<td>' + correoyweb.Id + '</td>' +
                                '<td>' + correoyweb.Tipo + '</td>' +
                                '<td>' + correoyweb.Direccion + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbGradosyWeb").empty();
                    $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="4"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function (error) {
                $("#tbGradosyWeb").empty();
                $("#tbGradosyWeb").append('<tr class="text-center"><td colspan="4"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddCorreoyWeb = function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcorreo",
            },
            beforeSend: function () {
                $("#TipoCorreo").empty();
                $("#txtCorreo").val('');
            },
            success: function (result) {
                console.log(result);
                if (result.estado == 1) {
                    $("#TipoCorreo").append('<option value="">- Seleccione -</option>');
                    for (let tipoCorreo of result.correos) {
                        $("#TipoCorreo").append('<option value="' + tipoCorreo.IdCorreo + '">' + tipoCorreo.Correoyweb + '</option>');
                    }
                } else {
                    tools.AlertWarning("Correo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("Correo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudCorreo = function () {

        if ($("#TipoCorreo").val() == '') {
            tools.AlertWarning('Correo', "Seleccione un tipo");
            $("#TipoCorreo").focus();
        } else if ($("#txtCorreo").val() == '') {
            tools.AlertWarning('Correo', "Ingrese un correo o web");
            $("#txtCorreo").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertCorreo",
                    "dni": idDNI,
                    "tipo": $("#TipoCorreo").val(),
                    "correo": ($("#txtCorreo").val()).trim(),
                },
                beforeSend: function () {
                    tools.AlertInfo("Correo", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addCorreoyWeb").modal("hide");
                        tools.AlertSuccess("Correo", "Se registro correctamente.");
                        modelCorreoyWeb.loadCorreoyWeb(idDNI);
                    } else if (result.estado == 3) {
                        tools.AlertWarning("Correo", result.message);
                    } else {
                        tools.AlertWarning("Correo", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    tools.AlertError("Correo", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}

function updateCorreoyweb(Id, Tipo, Direccion) {
    $("#editCorreoyWeb").modal("show");

    let cbxTipo = $("#ETipoCorreo");

    $.ajax({
        url: "../app/controller/PersonaController.php",
        method: "GET",
        data: {
            type: "getaddcorreo",
        },
        beforeSend: function () {
            $("#ETipoCorreo").empty();
            $("#EtxtCorreo").val('');
        },
        success: function (result) {
            if (result.estado == 1) {
                // $("#TipoCorreo").append('<option value="">- Seleccione -</option>');
                for (let tipoCorreo of result.correos) {
                    $("#ETipoCorreo").append('<option value="' + tipoCorreo.IdCorreo + '">' + tipoCorreo.Correoyweb + '</option>');
                }
                cbxTipo.val(Tipo);

                $("#EtxtCorreo").val(Direccion);

            } else {
                tools.AlertWarning("Correo", "Se produjo un error al cargar los datos en el modal");
            }
        },
        error: function (error) {
            tools.AlertError("Correo", "Error Fatal, Comuniquese con el administrador del sistema");
        }
    })

    $("#EbtnAceptarCorreo").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarCorreo").bind('click', function () {
        AceptarUpdateCorreo(Id);
    });
}

function AceptarUpdateCorreo(Id) {
    if ($("#EtxtCorreo").val() == '') {
        tools.AlertWarning('Correo', "Ingrese una direccion valida");
        $("#EtxtCorreo").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateCorreo",
                "idCorreo": Id,
                "tipo": $("#ETipoCorreo").val(),
                "direccion": $('#EtxtCorreo').val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Correo", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editCorreoyWeb").modal("hide");
                    tools.AlertSuccess("Correo", "Se actualizo correctamente.");
                    modelCorreoyWeb.loadCorreoyWeb(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Correo", result.message);
                } else {
                    tools.AlertWarning("Correo", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Correo", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteCorreoyweb(Id) {
    $("#deleteCorreo").modal("show");

    let idCorreo = Id;

    $("#btnDeleteCorreo").unbind();

    $("#btnDeleteCorreo").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteCorreo",
                "idCorreo": idCorreo,
            },
            beforeSend: function () {
                tools.AlertInfo("Correo", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Correo", result.message);
                    $("#deleteCorreo").modal("hide");
                    modelCorreoyWeb.loadCorreoyWeb(idDNI);
                } else {
                    tools.AlertWarning("Correo", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Correo", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}