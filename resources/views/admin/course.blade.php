@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

@include('admin.modal.inscription')


<style>
    .box-list {
        background-color: #e3e3e3;
        margin: .25em;
        padding: .5em 1em .5em 1em;
        border-radius: .25em;
        transition: 1s;
        border: 1px solid #e3e3e3;

    }

    .box-list:hover {
        border: 1px solid #17a2b8;
        box-shadow: 2px 2px #17a2b8;
        background-color: transparent;
    }

    .fs-13 {
        font-size: 13px;
    }

    .fs-15 {
        font-size: 15px;
    }

    .fs-15 {
        font-size: 15px;
    }

    .info-list {
        display: flex;
        justify-content: space-between;

    }

    .link-whatapp {
        color: #00a65a;
        transition: 1s;
    }

    .link-whatapp:hover {
        text-decoration: underline;
        color: #00a65a;
        font-size: 14.5px;
    }

    .link-whatapp:focus {
        color: #00a65a;
    }

    .separador {
        content: "";
        margin: 1.5em;
        display: block;
        font-size: 24%;
        outline: transparent;
    }

    .contenidoBox {
        background-color: #e3e3e3;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .ml-1{
        margin-left: 0.25em;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <h3 class="box-title">Lista de cursos</h3>
            </div>

            <div class="box-body">
                <div class="row">
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

                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <label>Opción.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn btn-default" id="btnRecargar" title="Recargar"><i class="fa fa-refresh"></i> Recargar</button>
                                <a class="btn btn-warning ml-1" title="Mis cursos" href="{{route('course.mycourses')}}"><i class="fa fa-book"></i> Mis Cursos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="list-course">
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
        let listCourses = $("#list-course")

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

        $("#btnAceptarInscripcion" ).click(function() {
            onSave();
        });

        $("#btnCancelInscription").click(function() {
            closeModalInscription();
        });

        $("#btnCancelInscription").keypress(function(event) {
            if (event.keyCode == 13) {
                closeModalInscription();
                event.preventDefault();
            }
        });

        $("#btnCloseInscription").click(function() {
            closeModalInscription();
        });

        $("#btnCloseInscription").keypress(function(event) {
            if (event.keyCode == 13) {
                closeModalInscription();
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
                listCourses.empty();
                listCourses.append(
                    `<div class="text-center contenidoBox"><img src="{{asset('images/spiner.gif')}}"/><p>Cargando información.</p></div>`
                );
                arrayCourse = [];
                state = true;

                let result = await axios.post("{{ route('course.allcourses')}}", {
                    "opcion": opcion,
                    "buscar": buscar,
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                arrayCourse = result.data.cursos;

                if (arrayCourse.length == 0) {
                    tools.tableMessage(listCourses, "No hay cursos para mostrar.");
                    $("#lblPaginaActual").html("0");
                    $("#lblPaginaSiguiente").html("0");
                    state = false;
                } else {
                    listCourses.empty();

                    for (let course of arrayCourse) {

                        let isRegistered = course.Registro !== '' ? '<span class="badge btn-warning">INSCRITO</span>' : ''

                        listCourses.append(
                            `
                                <div class="box-list">
                                    <div class="info-list">
                                        <h4 class="text-primary"><strong>${course.Nombre}</strong></h4>
                                        <div>
                                            <span class="text-info">${course.Capitulo}</span>
                                            ${isRegistered}
                                        </div>
                                    </div>
                                    <p class="fs-13">${course.Descripcion}</p>
                                    <h4><stron>S/ ${course.PrecioCurso}</stron> </h4>
                                    <div class="info-list">
                                        <p>
                                            <span class="text-success"><strong><a href="https://api.whatsapp.com/send?phone=51${course.Celular}" target="_blank style="color: #00a65a;" class="link-whatapp"><i class="fa fa-whatsapp"></i> ${course.Celular}</a></strong></span> &nbsp; 
                                            ${ course.Correo === '' ? '' : `<span class="text-primary"><strong><i class="fa fa-envelope"></i> ${course.Correo}</strong></span>`} 
                                        </p>
                                        <div>
                                            <button class="btn btn-success btn-sm" onclick="modalInscription(${course.idCurso})">Registrar</button>
                                        </div>
                                    </div>
                                </div>

                                <br class="separador">
                            `
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
                    tools.tableMessage(listCourses, error.response.data.message);
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                } else {
                    tools.tableMessage(listCourses, "Se genero un error intente nuevamente.");
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

                let curso = result.data.objet;

                if (Object.entries(curso).length === 0) {
                    state = false;
                } else {

                    let modalidad = curso.Modalidad === '1' ? `PRESENCIAL - ${curso.Direccion}` : 'VIRTUAL';
                    let correo = curso.Correo === '' ? '': ` - ${curso.Correo}`
                    
                    idCurso = curso.idCurso

                    $("#lblCurso").html(curso.Nombre);
                    $("#lblInstructor").html(curso.Instructor);
                    $("#lblOrganizador").html(curso.Organizador);
                    $("#lblCapitulo").html(curso.Capitulo);
                    $("#lblModalidad").html(modalidad);
                    $("#lblfechaHora").html(curso.FechaInicio +" - " +tools.getTimeForma(curso.HoraInicio, true));
                    $("#lblPrecioCurso").html("S/ "+curso.PrecioCurso);
                    $("#lblPrecioCertificado").html("S/ "+curso.PrecioCertificado);
                    $("#lblContacto").html(curso.Celular +""+ correo);
                    state = false

                    tools.AlertInfo('', 'Se cargo correctamente los datos.');
                }

            } catch (error) {
                tools.AlertError('', error.message);
                state = false;
            }
        }

        async function onSave(){
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

                if(result.data.status === 1){
                    tools.AlertSuccess("", result.data.message)
                    state = false;
                    closeModalInscription();
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

        this.modalInscription = async function(idCurso) {
            $("#modalInscription").modal("show");
            loadDataId(idCurso);
        }

        function closeModalInscription() {
            $("#modalInscription").modal("hide");

            $("#lblCurso").html('-');
            $("#lblInstructor").html('-');
            $("#lblOrganizador").html('-');
            $("#lblCapitulo").html('-');
            $("#lblModalidad").html('-');
            $("#lblfechaHora").html('-');
            $("#lblPrecioCurso").html('-');
            $("#lblPrecioCertificado").html('-');
            $("#lblContacto").html('-');

            document.getElementById("cbEstado").checked = false;

            $( "#btnAceptarInscripcion" ).prop( "disabled", true );

            idCurso = '';
        }

    });
</script>

@endsection