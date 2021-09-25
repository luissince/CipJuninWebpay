function Colegiatura() {

    this.loadColegiatura = function(id) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getcolegiatura",
                "idDni": id
            },
            beforeSend: function() {
                $("#tbColegiaturas").empty();
                $("#tbColegiaturas").append('<tr class="text-center"><td colspan="13"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbColegiaturas").empty();
                    if (result.data.length == 0) {
                        $("#tbColegiaturas").append('<tr class="text-center"><td colspan="13"><p>No tiene registrado ninguna colegiatura.</p></td></tr>');
                    } else {
                        for (let cv of result.data) {

                            let btnUpdate = '<button class="btn btn-success btn-sm" onclick="updateColegiatura(\'' + cv.IdColegiatura + '\',\'' +
                                cv.IdSede + '\',\'' + cv.IdEspecialidad + '\',\'' + cv.fechaColegiado + '\',\'' +
                                cv.IdUnivEgreso + '\',\'' + cv.fechaEgreso + '\',\'' + cv.IdUnivTitulacion + '\',\'' + cv.fechaTitulacion + '\',\'' +
                                cv.resolucion + '\',\'' + cv.principal + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            let btnDelete = '<button class="btn btn-warning btn-sm" onclick="DeleteColegiatura(\'' + cv.IdColegiatura + '\')">' +
                                '<i class="fa fa-trash"></i> Eliminar' +
                                '</button>';

                            $("#tbColegiaturas").append('<tr>' +
                                '<td>' + cv.Id + '</td>' +
                                '<td>' + cv.sede + '</td>' +
                                '<td>' + cv.capitulo + '</td>' +
                                '<td>' + cv.especialidad + '</td>' +
                                '<td>' + cv.fechaColegiado + '</td>' +
                                '<td>' + cv.universidadEgreso + '</td>' +
                                '<td>' + cv.fechaEgreso + '</td>' +
                                '<td>' + cv.universidadTitulacion + '</td>' +
                                '<td>' + cv.fechaTitulacion + '</td>' +
                                '<td>' + cv.resolucion + '</td>' +
                                '<td>' + btnUpdate + '</td>' +
                                '<td>' + btnDelete + '</td>' +
                                '</tr>');
                        }
                    }
                } else {
                    $("#tbColegiaturas").empty();
                    $("#tbColegiaturas").append('<tr class="text-center"><td colspan="13"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbColegiaturas").empty();
                $("#tbColegiaturas").append('<tr class="text-center"><td colspan="13"><p>Se produjo un error interno, comuniquese con el administrador del sistema.</p></td></tr>');
            }
        });
    }

    this.loadAddColegiatura = function() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcolegiatura",
            },
            beforeSend: function() {
                $("#Sede").empty();
                $("#Especialidad").empty();
                $("#UniversidadEgreso").empty();
                $("#UniversidadTitulacion").empty();
                $("#txtResolucion").val('');
                $("#FechaColegiacion").val(null);
                $("#FechaEgreso").val(null);
                $("#FechaTitulo").val(null);
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#Sede").append('<option value="">- Seleccione -</option>');
                    for (let sede of result.sedes) {
                        $("#Sede").append('<option value="' + sede.IdConsejo + '">' + sede.Sede + '</option>');
                    }
                    $("#Especialidad").append('<option value="">- Seleccione -</option>');
                    for (let especialidad of result.espacialidades) {
                        $("#Especialidad").append('<option value="' + especialidad.IdEspecialidad + '">' + especialidad.Especialidad + '</option>');
                    }
                    $("#UniversidadEgreso").append('<option value="">- Seleccione -</option>');
                    for (let universidadegreso of result.universidades) {
                        $("#UniversidadEgreso").append('<option value="' + universidadegreso.IdUniversidad + '">' + universidadegreso.Universidad + '</option>');
                    }
                    $("#UniversidadTitulacion").append('<option value="">- Seleccione -</option>');
                    for (let universidadtitulacion of result.universidades) {
                        $("#UniversidadTitulacion").append('<option value="' + universidadtitulacion.IdUniversidad + '">' + universidadtitulacion.Universidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("colegiatura", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("colegiatura", "Error Fatal: Comuniquese con el administrador del sistema");
            }
        });
    }

    this.crudColegiatura = function() {
        if ($("#Sede").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una sede");
            $("#Sede").focus();
        } else if ($("#Especialidad").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una especialidad");
            $("#Especialidad").focus();
        } else if (!tools.validateDate($("#FechaColegiacion").val())) {
            tools.AlertWarning('Colegiatura', "Ingrese la fecha de colegiatura");
            $("#FechaColegiacion").focus();
        } else if ($("#UniversidadEgreso").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una universidad de egreso");
            $("#UniversidadEgreso").focus();
        } else if (!tools.validateDate($("#FechaEgreso").val())) {
            tools.AlertWarning('Colegiatura', "Ingree la fecha de egreso");
            $("#FechaEgreso").focus();
        } else if ($("#UniversidadTitulacion").val() == '') {
            tools.AlertWarning('Colegiatura', "Seleccione una universidad de titulacion");
            $("#UniversidadTitulacion").focus();
        } else if (!tools.validateDate($("#FechaTitulo").val())) {
            tools.AlertWarning('Colegiatura', "Ingrese una fecha de titulacion");
            $("#FechaTitulo").focus();
        } else if ($("#txtResolucion").val() == '') {
            tools.AlertWarning('Colegiatura', "Ingrese una resolucion valida");
            $("#txtResolucion").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "insertColegiatura",
                    "dni": idDNI,
                    "sede": $("#Sede").val(),
                    "especialidad": $("#Especialidad").val(),
                    "fechacolegiacion": $("#FechaColegiacion").val(),
                    "universidadegreso": $("#UniversidadEgreso").val(),
                    "fechaegreso": $("#FechaEgreso").val(),
                    "universidadtitulacion": $("#UniversidadTitulacion").val(),
                    "fechatitulo": $("#FechaTitulo").val(),
                    "resolucion": $("#txtResolucion").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Colegiatura", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#addColegiatura").modal("hide");
                        tools.AlertSuccess("Colegiatura", result.message);
                        modelColegiatura.loadColegiatura(idDNI);
                    } else {
                        tools.AlertWarning("Colegiatura", "Error al tratar de registrar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }

    updateColegiatura = function(Id, sede, especialidad, fechaColegiado, universidadEgreso, fechaEgreso, universidadTitulacion, fechaTitulacion, resolucion, principal) {
        $("#editColegiatura").modal("show");

        let cbxSede = $("#ESede");
        let cbxEspecialidad = $("#EEspecialidad");
        let cbxuniversidadEgreso = $("#EUniversidadEgreso");
        let cbxuniversidadTitulacion = $("#EUniversidadTitulacion");
        let fColegiado = fechaColegiado.split("/").reverse().join("-");
        let fEgreso = fechaEgreso.split("/").reverse().join("-");
        let fTitulacion = fechaTitulacion.split("/").reverse().join("-");
        $("#EtxtResolucion").val(resolucion);

        document.getElementById("EFechaColegiacion").value = tools.getDateForma(fColegiado, 'yyyy-mm-dd');
        document.getElementById("EFechaEgreso").value = tools.getDateForma(fEgreso, 'yyyy-mm-dd');
        document.getElementById("EFechaTitulo").value = tools.getDateForma(fTitulacion, 'yyyy-mm-dd');

        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                type: "getaddcolegiatura",
            },
            beforeSend: function() {
                $("#Sede").empty();
                $("#Especialidad").empty();
                $("#UniversidadEgreso").empty();
                $("#UniversidadTitulacion").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    // cbxSede.append('<option value="">- Seleccione -</option>');
                    for (let sede of result.sedes) {
                        $("#ESede").append('<option value="' + sede.IdConsejo + '">' + sede.Sede + '</option>');
                    }
                    cbxSede.val(sede); //rellena la informacion con la sede que esta registrada

                    // $("#EEspecialidad").append('<option value="">- Seleccione -</option>');
                    for (let especialidad of result.espacialidades) {
                        $("#EEspecialidad").append('<option value="' + especialidad.IdEspecialidad + '">' + especialidad.Especialidad + '</option>');
                    }
                    cbxEspecialidad.val(especialidad); //rellena la informacion con la Especialidad que esta registrada

                    // $("#EUniversidadEgreso").append('<option value="">- Seleccione -</option>');
                    for (let universidadegreso of result.universidades) {
                        $("#EUniversidadEgreso").append('<option value="' + universidadegreso.IdUniversidad + '">' + universidadegreso.Universidad + '</option>');
                    }
                    cbxuniversidadEgreso.val(universidadEgreso); //rellena la informacion con la Universidad de egreso que esta registrada

                    // $("#EUniversidadTitulacion").append('<option value="">- Seleccione -</option>');
                    for (let universidadtitulacion of result.universidades) {
                        $("#EUniversidadTitulacion").append('<option value="' + universidadtitulacion.IdUniversidad + '">' + universidadtitulacion.Universidad + '</option>');
                    }
                    cbxuniversidadTitulacion.val(universidadTitulacion); //rellena la informacion con la Universidad de titulacion que esta registrada 

                } else {
                    tools.AlertWarning("colegiatura", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("colegiatura", "Error Fatal: Comuniquese con el administrador del sistema");
            }
        })

        $("#EbtnAceptarColegiatura").unbind();
        // $("#EbtnAceptarColegiatura").bind('click',function() {
        //     console.log('diste click');
        //     // AceptarUpdate(idCapitulo, idEspecialidad);
        // });
        $("#EbtnAceptarColegiatura").bind('click', function() {
            AceptarUpdateColegiatura(Id);
        });
    }

    function AceptarUpdateColegiatura(Id) {
        if ($("#EtxtResolucion").val() == '') {
            tools.AlertWarning('Colegiatura', "Ingrese una resolucion valida");
            $("#EtxtResolucion").focus();
        } else {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "updateColegiatura",
                    "idColegiatura": Id,
                    "sede": $("#ESede").val(),
                    "especialidad": $("#EEspecialidad").val(),
                    "fechacolegiacion": $("#EFechaColegiacion").val(),
                    "universidadegreso": $("#EUniversidadEgreso").val(),
                    "fechaegreso": $("#EFechaEgreso").val(),
                    "universidadtitulacion": $("#EUniversidadTitulacion").val(),
                    "fechatitulo": $("#EFechaTitulo").val(),
                    "resolucion": $("#EtxtResolucion").val(),
                },
                beforeSend: function() {
                    tools.AlertInfo("Colegiatura", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        $("#editColegiatura").modal("hide");
                        tools.AlertSuccess("Colegiatura", "Se actualizo correctamente.");
                        modelColegiatura.loadColegiatura(idDNI);
                    } else if (result.estado == 2) {
                        tools.AlertWarning("Colegiatura", result.message);
                    } else {
                        tools.AlertWarning("Colegiatura", "Error al tratar de actualizar los datos " + result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        }
    }

    DeleteColegiatura = function(Id) {
        $("#deleteColegiatura").modal("show");

        let idColegiatura = Id;

        $("#btnDeleteColegiatura").unbind();

        $("#btnDeleteColegiatura").bind("click", function() {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "deleteColegiatura",
                    "idcolegiatura": idColegiatura,
                },
                beforeSend: function() {
                    tools.AlertInfo("Colegiatura", "Procesando información.");
                },
                success: function(result) {
                    if (result.estado == 1) {
                        tools.AlertSuccess("Colegiatura", result.message);
                        $("#deleteColegiatura").modal("hide");
                        modelColegiatura.loadColegiatura(idDNI);
                    } else {
                        tools.AlertWarning("Colegiatura", result.message);
                    }
                },
                error: function(error) {
                    tools.AlertError("Colegiatura", "Error fatal: Comuniquese con el administrador del sistema");
                }
            });
        })
    }
}