function Domicilio() {

    this.loadDomicilio = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getdomicilio",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbDomicilio").empty();
                $("#tbDomicilio").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbDomicilio").empty();
                    if (result.data.length == 0) {
                        $("#tbDomicilio").append('<tr class="text-center"><td colspan="5"><p>No tiene registrado ningun domicilio.</p></td></tr>');
                    } else {
                        for (let domicilio of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateDomicilio(\'' + domicilio.IdDireccion + '\',\'' +
                                domicilio.IdTipo + '\',\'' + domicilio.direccion + '\',\'' + domicilio.IdUbigeo + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteDomicilio(\'' + domicilio.IdDireccion + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbDomicilio").append('<tr>' +
                                '<td>' + domicilio.Id + '</td>' +
                                '<td>' + domicilio.tipo + '</td>' +
                                '<td>' + domicilio.direccion + '</td>' +
                                '<td>' + domicilio.ubigeo + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbDomicilio").empty();
                    $("#tbDomicilio").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                }

            },
            error: function (error) {
                console.log(error);
                $("#tbDomicilio").empty();
                $("#tbDomicilio").append('<tr class="text-center"><td colspan="5"><p>Se produjo un error interno, comuniquese con el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddDomicilio = function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getadddomicilio",
            },
            beforeSend: function () {
                $("#tipoDomicilio").empty();
                $("#Departamento").empty();
                $("#Direccion").val(null);
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tipoDomicilio").append('<option value="">- Seleccione -</option>');
                    for (let tipoDomicilio of result.tipodomicilio) {
                        $("#tipoDomicilio").append('<option value="' + tipoDomicilio.IdTipo + '">' + tipoDomicilio.Descripcion + '</option>');
                    }
                    $("#Departamento").append('<option value="">- Seleccione -</option>');
                    for (let Departamento of result.ubicacion) {
                        $("#Departamento").append('<option value="' + Departamento.IdUbicacion + '" selected="">' + Departamento.Ubicacion + '</option>');
                    }
                    // $("#Departamento").selectpicker("refresh");
                } else {
                    tools.AlertWarning("domicilio", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("domicilio", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudDomicilio = function () {

        if ($("#tipoDomicilio").val() == '') {
            tools.AlertWarning('Domicilio', "Seleccione un tipo");
            $("#tipoDomicilio").focus();
        } else if ($("#Departamento").val() == '') {
            tools.AlertWarning('Domicilio', "Seleccione un departamento");
            $("#Departamento").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertDomicilio",
                    "dni": idDNI,
                    "tipo": $("#tipoDomicilio").val(),
                    "departamento": $('#Departamento').val(),
                    "direccion": $("#Direccion").val(),
                },
                beforeSend: function () {
                    tools.AlertInfo("Domicilio", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addDomicilio").modal("hide");
                        tools.AlertSuccess("Domicilio", "Se registro correctamente.");
                        modelDomicilio.loadDomicilio(idDNI);
                    } else {
                        tools.AlertWarning("Domicilio", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }

}

function updateDomicilio(Id, Tipo, Direccion, Ubigeo) {
    $("#editDomicilio").modal("show");

    let cbxTipo = $("#EtipoDomicilio");
    let cbxDepartamento = $("#EDepartamento");
    let direccion = $("#EDireccion");


    $.ajax({
        url: "../app/controller/PersonaController.php",
        method: "GET",
        data: {
            type: "getadddomicilio",
        },
        beforeSend: function () {
            $("#EtipoDomicilio").empty();
            $("#EDepartamento").empty();
            $("#EDireccion").empty();
        },
        success: function (result) {
            if (result.estado == 1) {
                // $("#EtipoDomicilio").append('<option value="">- Seleccione -</option>');
                for (let tipoDomicilio of result.tipodomicilio) {
                    $("#EtipoDomicilio").append('<option value="' + tipoDomicilio.IdTipo + '">' + tipoDomicilio.Descripcion + '</option>');
                }
                cbxTipo.val(Tipo); //rellena la informacion con el tipo que esta registrada

                // $("#EDepartamento").append('<option value="">- Seleccione -</option>');
                for (let Departamento of result.ubicacion) {
                    $("#EDepartamento").append('<option value="' + Departamento.IdUbicacion + '" selected="">' + Departamento.Ubicacion + '</option>');
                }
                cbxDepartamento.val(Ubigeo); //rellena la informacion con el departamento que esta registrada

                direccion.val(Direccion);

            } else {
                tools.AlertWarning("Domicilio", "Se produjo un error al cargar los datos en el modal");
            }
        },
        error: function (error) {
            tools.AlertError("Domicilio", "Error Fatal: Comuniquese con el administrador del sistema");
        }
    })

    $("#EbtnAceptarDomicilio").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarDomicilio").bind('click', function () {
        AceptarUpdateDomicilio(Id);
    });
}

function AceptarUpdateDomicilio(Id) {
    if ($("#EDireccion").val() == '') {
        tools.AlertWarning('Domicilio', "Ingrese una direccion valida");
        $("#EDireccion").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateDomicilio",
                "idDomicilio": Id,
                "tipo": $("#EtipoDomicilio").val(),
                "departamento": $('#EDepartamento').val(),
                "direccion": $("#EDireccion").val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Domicilio", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editDomicilio").modal("hide");
                    tools.AlertSuccess("Domicilio", "Se actualizo correctamente.");
                    modelDomicilio.loadDomicilio(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Domicilio", result.message);
                } else {
                    tools.AlertWarning("Domicilio", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Domicilio", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteDomicilio(Id) {
    $("#deleteDomicilio").modal("show");

    let idDireccion = Id;

    $("#btnDeleteDomicilio").unbind();

    $("#btnDeleteDomicilio").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteDomicilio",
                "iddomicilio": idDireccion,
            },
            beforeSend: function () {
                tools.AlertInfo("Domicilio", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Domicilio", result.message);
                    $("#deleteDomicilio").modal("hide");
                    modelDomicilio.loadDomicilio(idDNI);
                } else {
                    tools.AlertWarning("Domicilio", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Domicilio", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}