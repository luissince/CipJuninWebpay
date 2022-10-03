@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

@include('admin.modal.coursedetail')

<style>
    .ml-1 {
        margin-left: 0.25em;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <!-- <a class="btn btn-default" title="Atras" href="{{route('course.index')}}"><i class="fa fa-arrow-circle-left "></i> Atras</a> -->
                <h3 class="box-title">Mi lista de cursos inscritos</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Opción.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <a class="btn btn-info" title="Atras" href="{{route('course.index')}}"><i class="fa fa-arrow-circle-left "></i> Atras</a>
                                <button type="button" class="btn btn-default ml-1" id="btnRecargar" title="Recargar"><i class="fa fa-refresh"></i> Recargar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <label>Filtrar por nombre de curso o capitulo.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe y presiona enter para filtrar" aria-describedby="search" value="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success" id="btnBuscar"> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div style="overflow-x: auto;">

                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead style="background: #337ab7;color: white;">
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">#</th>
                                        <th style="text-align: center; vertical-align: middle;">Curso</th>
                                        <th style="text-align: center; vertical-align: middle;">Capitulo</th>
                                        <th style="text-align: center; vertical-align: middle;">Fecha/Hora</th>
                                        <th style="text-align: center; vertical-align: middle;">Estado</th>
                                        <th style="text-align: center; vertical-align: middle;">Detalle</th>
                                        <th style="text-align: center; vertical-align: middle;">Certificado</th>
                                    </tr>
                                </thead>
                                <tbody id="tbCourses">

                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="text-center">
                            <ul class="pagination">
                                <li>
                                    <button class="btn btn-info" id="btnIzquierda">
                                        <i class="fa fa-toggle-left"></i>
                                    </button>
                                </li>
                                <li>
                                    <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                </li>
                                <li><span>a</span></li>
                                <li>
                                    <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                </li>
                                <li>
                                    <button class="btn btn-info" id="btnDerecha">
                                        <i class="fa fa-toggle-right"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        let state = false;
        let opcion = 0;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let tbCourses = $("#tbCourses")


        let idPersona = "{{$persona->idDNI}}";

        let idCurso = '';

        $("#btnIzquierda").click(function() {
            if (!state) {
                if (paginacion > 1) {
                    paginacion--;
                    onEventPaginacion();
                }
            }
        });

        $("#btnDerecha").click(function() {
            if (!state) {
                if (paginacion < totalPaginacion) {
                    paginacion++;
                    onEventPaginacion();
                }
            }
        });

        $("#txtBuscar").keyup(function(event) {
            if (event.keyCode == 13) {
                if ($("#txtBuscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTable(1, $("#txtBuscar").val().trim());
                        opcion = 1;
                    }
                }
            }
        });

        $("#btnBuscar").click(function() {
            if ($("#txtBuscar").val().trim() != '') {
                if (!state) {
                    paginacion = 1;
                    loadTable(1, $("#txtBuscar").val().trim());
                    opcion = 1;
                }
            }
        });

        $("#btnBuscar").keyup(function(event) {
            if (event.keyCode == 13) {
                if ($("#txtBuscar").val().trim() != '') {
                    if (!state) {
                        paginacion = 1;
                        loadTable(1, $("#txtBuscar").val().trim());
                        opcion = 1;
                    }
                }
            }
        });

        $("#btnRecargar").click(function() {
            loadInit();
        });

        $("#btnRecargar").keypress(function(event) {
            if (event.keyCode === 13) {
                loadInit();
            }
            event.preventDefault();
        });

        $("#btnCancelDetail").click(function() {
            closeModalDetail();
        });

        $("#btnCancelDetail").keypress(function(event) {
            if (event.keyCode == 13) {
                closeModalDetail();
                event.preventDefault();
            }
        });

        $("#btnCloseDetail").click(function() {
            closeModalDetail();
        });

        $("#btnCloseDetail").keypress(function(event) {
            if (event.keyCode == 13) {
                closeModalDetail();
                event.preventDefault();
            }
        });

        loadInit();

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadTable(0, "");
                    break;
                case 1:
                    loadTable(1, $("#txtBuscar").val().trim());
                    break;
            }
        }

        function loadInit() {

            if (!state) {
                paginacion = 1;
                loadTable(0, "");
                opcion = 0;
            }
        }

        async function loadTable(opcion, buscar) {
            try {
                tbCourses.empty();
                tbCourses.append(
                    `<tr class="text-center"><td colspan="7"><img src="{{asset('images/spiner.gif')}}"/><p> cargando información.</p></td></tr>`
                );
                arrayCourse = [];
                state = true;


                let result = await axios.post("{{ route('course.allmycourses')}}", {
                    "opcion": opcion,
                    "buscar": buscar,
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina,
                    "idParticipante": idPersona
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });


                arrayCourse = result.data.cursos;

                if (arrayCourse.length === 0) {
                    tbCourses.empty();
                    tbCourses.append(
                        '<tr class="text-center"><td colspan="7"><p>No se pudo cargar la información.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html("0");
                    $("#lblPaginaSiguiente").html("0");
                    state = false;
                } else {
                    tbCourses.empty();

                    for (let course of arrayCourse) {

                        let btnDetail = `<button class="btn btn-primary btn-sm" onclick="modalDetail(${course.idCurso} )" title="Ver detalle del curso"><i class="fa fa-eye" style="font-size:14px;"></i></button>`;
                        let btnCetificado = `<button class="btn btn-success btn-sm" onclick="modalCertificado(${course.idCurso})" title="Descargar Certificado"><i class="fa fa-file" style="font-size:14px;"></i></button>`

                        let estado = course.Estado == 1 ? '<span class="badge btn-info">ACTIVO</span>' : '<span class="badge btn-danger">INACTIVO</span>'

                        tbCourses.append('<tr>' +
                            '<td style="">' + course.id + '</td>' +
                            '<td style="">' + course.Nombre + '</td>' +
                            '<td style="text-align: center;">' + course.Capitulo + '</td>' +
                            '<td style="font-size:14px;">' + course.FechaInicio + '<br>' + tools.getTimeForma(course.HoraInicio, true) + '</td>' +
                            '<td style="text-align: center;">' + estado + '</td>' +
                            '<td style="text-align: center;" class="text-danger">' + btnDetail + '</td>' +
                            '<td style="text-align: center;" class="text-success">' + '' + '</td>' +
                            '</tr>'
                        );

                    }
                    totalPaginacion = parseInt(Math.ceil((parseFloat(result.data.total) / parseInt(
                        filasPorPagina))));
                    $("#lblPaginaActual").html(paginacion);
                    $("#lblPaginaSiguiente").html(totalPaginacion);
                    state = false;
                }
            } catch (error) {
                if (error.response) {
                    tbCourses.empty();
                    tbCourses.append(
                        '<tr class="text-center"><td colspan="7"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                } else {
                    tbCourses.empty();
                    tbCourses.append(
                        '<tr class="text-center"><td colspan="7"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }

            }
        }

        async function loadDataId(id) {

            try {

                state = true;

                let result = await axios.get("{{ route('course.dataid')}}", {
                    params: {
                        "idCurso": id
                    }
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                let course = result.data.objet;

                if (Object.entries(course).length === 0) {
                    state = false;
                } else {

                    let modalidad = course.Modalidad === '1' ? `PRESENCIAL - ${course.Direccion}` : 'VIRTUAL';
                    let correo = course.Correo === '' ? '' : ` - ${course.Correo}`

                    idCurso = course.idCurso

                    course.PrecioCertificado > 0 ? document.getElementById("lblPrecioCertificado").style.textDecoration = "none" : document.getElementById("lblPrecioCertificado").style.textDecoration = "line-through";

                    $("#lblCurso").html(course.Nombre);
                    $("#lblInstructor").html(course.Instructor);
                    $("#lblOrganizador").html(course.Organizador);
                    $("#lblCapitulo").html(course.Capitulo);
                    $("#lblModalidad").html(modalidad);
                    $("#lblfechaHora").html(course.FechaInicio + " - " + tools.getTimeForma(course.HoraInicio, true));
                    $("#lblPrecioCurso").html("S/ " + course.PrecioCurso);
                    $("#lblPrecioCertificado").html("S/ " + course.PrecioCertificado);
                    $("#lblContacto").html(course.Celular + "" + correo);
                    $("#lblDescripcion").html(course.Descripcion);
                    state = false

                    tools.AlertInfo('', 'Se cargo correctamente los datos.');
                }

            } catch (error) {
                tools.AlertError('', error.message);
                state = false;
            }
        }
        
        /*
        async function onSave() {
            try {
                state = true;

                let result = await axios.post("{{ route('course.addinscription')}}", {
                    "idCurso": idCurso,
                    "idParticipante": idPersona
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                if (result.data.status === 1) {
                    tools.AlertSuccess("", result.data.message)
                    state = false;
                    closeModalDetail();
                    loadInit();
                } else {
                    tools.AlertInfo("", result.data.message)
                    state = false;
                }

            } catch (error) {
                tools.AlertError("", error.message)
                state = false;

            }
        }
        */

        this.modalDetail = async function(idCurso) {
            $("#modalCourseDetail").modal("show");
            loadDataId(idCurso);
        }

        function closeModalDetail() {
            $("#modalCourseDetail").modal("hide");

            $("#lblCurso").html('-');
            $("#lblInstructor").html('-');
            $("#lblOrganizador").html('-');
            $("#lblCapitulo").html('-');
            $("#lblModalidad").html('-');
            $("#lblfechaHora").html('-');
            $("#lblPrecioCurso").html('-');
            $("#lblPrecioCertificado").html('-');
            $("#lblContacto").html('-');
            $("#lblDescripcion").html('-');

            idCurso = '';
        }
    });
</script>

@endsection