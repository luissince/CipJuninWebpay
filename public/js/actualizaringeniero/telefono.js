function Celular() {
    this.loadTelefono = function (id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "gettelefono",
                "idDni": id
            },
            beforeSend: function () {
                $("#tbTelefono").empty();
                $("#tbTelefono").append('<tr class="text-center"><td colspan="4"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbTelefono").empty();
                    if (result.data.length == 0) {
                        $("#tbTelefono").append('<tr class="text-center"><td colspan="4"><p>No tiene registrado ningun telefono o celular.</p></td></tr>');
                    } else {
                        for (let telefono of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateTelefono(\'' + telefono.IdTelefono + '\',\'' +
                                telefono.IdTipo + '\',\'' + telefono.numero + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" style ="margin-left:20px;" onclick="DeleteTelefono(\'' + telefono.IdTelefono + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbTelefono").append('<tr>' +
                                '<td>' + telefono.Id + '</td>' +
                                '<td>' + telefono.tipo + '</td>' +
                                '<td>' + telefono.numero + '</td>' +
                                '<td style="text-align: center;">' + btnUpdate + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbTelefono").empty();
                    $("#tbTelefono").append('<tr class="text-center"><td colspan="4"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function (error) {
                $("#tbTelefono").empty();
                $("#tbTelefono").append('<tr class="text-center"><td colspan="4"><p>Se produjo un error interno, comuniquese on el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddCelular = function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcelular",
            },
            beforeSend: function () {
                $("#TipoCelular").val('');
                $("#txtNumero").val('');
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#TipoCelular").append('<option value="">- Seleccione -</option>');
                    for (let tipoCelular of result.tipo) {
                        $("#TipoCelular").append('<option value="' + tipoCelular.IdTipo + '">' + tipoCelular.Tipo + '</option>');
                    }
                } else {
                    tools.AlertWarning("telefono", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                tools.AlertError("telefono", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudCelular = function () {

        if ($("#TipoCelular").val() == '') {
            tools.AlertWarning('Celular', "Seleccione un tipo");
            $("#TipoCelular").focus();
        } else if ($("#txtNumero").val() == '') {
            tools.AlertWarning('Celular', "Ingrese un numero");
            $("#txtNumero").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertCelular",
                    "dni": idDNI,
                    "tipo": $("#TipoCelular").val(),
                    "numero": $("#txtNumero").val(),
                },
                beforeSend: function () {
                    tools.AlertInfo("telefono", "Procesando información.");
                },
                success: function (result) {
                    if (result.estado == 1) {
                        $("#addTelefono").modal("hide");
                        tools.AlertSuccess("Celular", "Se registro correctamente.");
                        modelTelefono.loadTelefono(idDNI);
                    } else if (result.estado == 3) {
                        tools.AlertWarning("Celular", result.message);
                    } else {
                        tools.AlertWarning("Celular", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function (error) {
                    console.log(error);
                    tools.AlertError("Celular", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }
}

function updateTelefono(Id, Tipo, Numero) {
    $("#editTelefono").modal("show");

    let cbxTipo = $("#ETipoCelular");
    let numero = $("#EtxtNumero");;


    $.ajax({
        url: "../app/controller/PersonaController.php",
        method: "GET",
        data: {
            type: "getaddcelular",
        },
        beforeSend: function () {
            $("#ETipoCelular").empty();
            $("#EtxtNumero").empty();
        },
        success: function (result) {
            if (result.estado == 1) {
                // $("#TipoCelular").append('<option value="">- Seleccione -</option>');
                for (let tipoCelular of result.tipo) {
                    $("#ETipoCelular").append('<option value="' + tipoCelular.IdTipo + '">' + tipoCelular.Tipo + '</option>');
                }
                cbxTipo.val(Tipo); //rellena la informacion con el tipo que esta registrada

                numero.val(Numero);

            } else {
                tools.AlertWarning("Telefono", "Se produjo un error al cargar los datos en el modal");
            }
        },
        error: function (error) {
            tools.AlertError("Telefono", "Error Fatal: Comuniquese con el administrador del sistema");
        }
    })

    $("#EbtnAceptarCelular").unbind();
    // $("#EbtnAceptarColegiatura").bind('click',function() {
    //     console.log('diste click');
    //     // AceptarUpdate(idCapitulo, idEspecialidad);
    // });
    $("#EbtnAceptarCelular").bind('click', function () {
        AceptarUpdateTelefono(Id);
    });
}

function AceptarUpdateTelefono(Id) {
    if ($("#EtxtNumero").val() == '') {
        tools.AlertWarning('Telefono', "Ingrese una direccion valida");
        $("#EDireccion").focus();
    } else {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "updateTelefono",
                "idTelefono": Id,
                "tipo": $("#ETipoCelular").val(),
                "numero": $('#EtxtNumero').val(),
            },
            beforeSend: function () {
                tools.AlertInfo("Telefono", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#editTelefono").modal("hide");
                    tools.AlertSuccess("Telefono", "Se actualizo correctamente.");
                    modelTelefono.loadTelefono(idDNI);
                } else if (result.estado == 2) {
                    tools.AlertWarning("Telefono", result.message);
                } else {
                    tools.AlertWarning("Telefono", "Error al tratar de actualizar los datos " + result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Telefono", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    }
}

function DeleteTelefono(Id) {
    $("#deleteTelefono").modal("show");

    let idTelefono = Id;

    $("#btnDeleteTelefono").unbind();

    $("#btnDeleteTelefono").bind("click", function () {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "POST",
            data: {
                "type": "deleteTelefono",
                "idtelefono": idTelefono,
            },
            beforeSend: function () {
                tools.AlertInfo("Telefono", "Procesando información.");
            },
            success: function (result) {
                if (result.estado == 1) {
                    tools.AlertSuccess("Telefono", result.message);
                    $("#deleteTelefono").modal("hide");
                    modelTelefono.loadTelefono(idDNI);
                } else {
                    tools.AlertWarning("Telefono", result.message);
                }
            },
            error: function (error) {
                tools.AlertError("Telefono", "Error fatal: Comuniquese con el administrador del sistema");
            }
        });
    })
}