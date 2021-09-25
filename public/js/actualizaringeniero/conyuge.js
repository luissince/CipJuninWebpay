function Conyuge() {
    this.loadConyuge = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getconyuge",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbConyuge").empty();
                $("#tbConyuge").append('<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');

            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbConyuge").empty();
                    if (result.data.length == 0) {
                        $("#tbConyuge").append('<tr class="text-center"><td colspan="4"><p>No tiene registrado ningun conyuge.</p></td></tr>');
                    } else {
                        for (let conyuge of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateConyuge(\'' + conyuge.IdConyuge + '\',\'' +
                                conyuge.NombreCompleto + '\',\'' + conyuge.Hijos + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteConyuge(\'' + conyuge.IdConyuge + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbConyuge").append('<tr>' +
                                '<td>' + conyuge.Id + '</td>' +
                                '<td>' + conyuge.NombreCompleto + '</td>' +
                                '<td>' + conyuge.Hijos + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbConyuge").empty();
                    $("#tbConyuge").append('<tr class="text-center"><td colspan="4"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function (error) {
                $("#tbConyuge").empty();
                $("#tbConyuge").append('<tr class="text-center"><td colspan="4"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddConyuge = function () {
        $("#txtConyuge").val("");
        $("#txtHijos").val("");
    }

    this.crudConyuge = function () {

        if ($("#txtConyuge").val() == '') {
            tools.AlertWarning('Conyuge', "Ingrese nombre de un conyuge");
            $("#txtConyuge").focus();
        } else if (($("#txtHijos").val() == '') || ($("#txtHijos").val() <= 0)) {
            tools.AlertWarning('Conyuge', "Ingrese un numero de hijos valido");
            $("#txtHijos").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertConyuge",
                    "dni": idDNI,
                    "conyuge": ($("#txtConyuge").val()).trim(),
                    "hijos": $("#txtHijos").val(),
                },
                beforeSend: function () {
                    tools.AlertInfo("Conyuge", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addConyuge").modal("hide");
                        tools.AlertSuccess("Conyuge", "Se registro correctamente.");
                        modelConyuge.loadConyuge(idDNI);
                    } else if (result.estado == 3) {
                        tools.AlertWarning("Conyuge", result.message);
                    } else {
                        tools.AlertWarning("Conyuge", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    tools.AlertError("Conyuge", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}

function updateConyuge(Id, Nombre, Hijos) {
    $("#editConyuge").modal("show");

    $("#EtxtConyuge").val(Nombre);
    $("#EtxtHijos").val(Hijos);

    $("#EbtnAceptarConyuge").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarConyuge").bind('click', function () {
        AceptarUpdateConyuge(Id);
    });
}

function AceptarUpdateConyuge(Id) {
    if ($("#EtxtConyuge").val() == '') {
        tools.AlertWarning('Conyuge', "Ingrese el nombre de un conyuge");
        $("#EtxtConyuge").focus();
    } else if ($("#EtxtHijos").val() == '') {
        tools.AlertWarning('Conyuge', "Ingrese numero de hijos");
        $("#EtxtHijos").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateConyuge",
                "idConyuge": Id,
                "Conyuge": ($("#EtxtConyuge").val()).trim(),
                "Hijos": $('#EtxtHijos').val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Conyuge", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editConyuge").modal("hide");
                    tools.AlertSuccess("Conyuge", "Se actualizo correctamente.");
                    modelConyuge.loadConyuge(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Conyuge", result.message);
                } else {
                    tools.AlertWarning("Conyuge", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Conyuge", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteConyuge(Id) {
    $("#deleteConyuge").modal("show");

    let idConyuge = Id;

    $("#btnDeleteConyuge").unbind();

    $("#btnDeleteConyuge").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteConyuge",
                "idconyuge": idConyuge,
            },
            beforeSend: function () {
                tools.AlertInfo("Conyuge", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Conyuge", result.message);
                    $("#deleteConyuge").modal("hide");
                    modelConyuge.loadConyuge(idDNI);
                } else {
                    tools.AlertWarning("Conyuge", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Conyuge", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}