@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<style type="text/css" media="all">
    .cardColor {
        background-color: #e3e3e3;
    }

    .cardColor:hover {
        background-color: #d9edf7;
    }

    .cardBox {
        padding: .5em;
    }

    .separador {
        margin-top: 0;
        margin-bottom: 0;
    }

    .contenidoBox {
        background-color: #e3e3e3;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .linkWhatsapp{
        color: #00a65a;
    }

    .linkWhatsapp:hover{
        text-decoration: underline;
    }

    .azulMarino{
        color: #003366;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <h3 class="box-title">Lista de ofertas laborales</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-sm-12 col-xs-12">
                        <label>Filtrar por nombre de publicación.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe y presiona enter para filtrar" aria-describedby="search" value="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success" id="btnBuscar"> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <label>Opción.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div style="overflow: auto; height: 400px;">
                            <div id="listaEmpleo">

                            </div>
                        </div>

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

                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="media" style="background: #e3e3e3; padding: .5em; height: 400px; overflow: auto">
                            <div id="empleoContenido">
                                <div class="text-center" style="height: 385px; display: flex; justify-content: center; align-items: center;"><h4 class="azulMarino fw-bold"><strong>Comuníquese con informática para publicar su oferta laboral.</h4></strong></div>
                            </div>
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
        let listaEmpleo = $("#listaEmpleo");
        let empleoContenido = $("#empleoContenido");

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
                listaEmpleo.empty();
                listaEmpleo.append(
                    `<div class="text-center contenidoBox"><img src="{{asset('images/spiner.gif')}}"/><p>Cargando información.</p></div>`
                );
                arrayEmpleo = [];
                state = true;

                let result = await axios.post("{{ route('jobs.alljobs')}}", {
                    "opcion": opcion,
                    "buscar": buscar,
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                arrayEmpleo = result.data.empleos;

                if (arrayEmpleo.length == 0) {
                    tools.tableMessage(listaEmpleo, "No hay ofertas laborales para mostrar.");
                    $("#lblPaginaActual").html("0");
                    $("#lblPaginaSiguiente").html("0");
                    state = false;
                } else {
                    listaEmpleo.empty();
                    for (let empleo of arrayEmpleo) {
                        listaEmpleo.append(
                            '<div class="card cardColor" role="button" onclick="loadDataId(\''+ empleo.idEmpleo+ '\')">'+
                                `<div class="card-body">
                                    <div class="cardBox">
                                        <h5 class="card-title"><strong class="azulMarino"> ${empleo.Titulo}</strong></h5>
                                        <h6 class="card-subtitle text-muted">${empleo.Fecha} - ${tools.getTimeForma(empleo.Hora, true)}</h6>
                                        <p class="card-text azulMarino"><i class="fa fa-cube"></i> ${empleo.Empresa}</p>
                                        <span class="text-success">${empleo.Celular}</span>&emsp;<span class="text-success">${empleo.Correo}</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="separador">`
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
                    tools.tableMessage(listaEmpleo, error.response.data.message);
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                } else {
                    tools.tableMessage(listaEmpleo, "Se genero un error intente nuevamente.");
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }

            }
        }

        this.loadDataId =async function (idEmpleo) {
            
            try {
                empleoContenido.empty();
                empleoContenido.append(
                    `<div class="text-center contenidoBox"><img src="{{asset('images/spiner.gif')}}"/><p>Cargando información.</p></div>`
                );

                state = true;

                let result = await axios.get("{{ route('jobs.dataid')}}", {
                        params: {
                            "idEmpleo": idEmpleo
                        }
                    }
                    , {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                let empleo = result.data.objet;

                if(Object.entries(empleo).length === 0){
                    tools.tableMessage(empleoContenido,"No hay ofertas laborales para mostrar.");
                    state = false;
                } else{
                    empleoContenido.empty();
                    empleoContenido.append(
                            ` 
                                <h4><strong class="azulMarino">${empleo.Titulo}</strong></h4>
                                <div class="media-body">
                                    <p>${empleo.Descripcion}</p>
                                    <h5 class="mt-0 azulMarino"><i class="fa fa-cube"></i> ${empleo.Empresa}</h5>
                                    <p class="mt-0 text-success">
                                        <span><a href="https://api.whatsapp.com/send?phone=51${empleo.Celular}" target="_blank" class="linkWhatsapp"><i class="fa fa-whatsapp"></i> ${empleo.Celular}</a></span>&emsp;
                                        <span><i class="fa fa-envelope"></i> ${empleo.Correo === '' ? 'Ninguno' : empleo.Correo}</span>&emsp;
                                        <span><i class="fa fa-phone-square"></i> ${empleo.Telefono === '' ? 'Ninguno' : empleo.Telefono}</span>
                                    </p>
                                    <h5 class="mt-0"><i class="fa fa-home"></i> ${empleo.Direccion === '' ? 'Ninguna' : empleo.Direccion}</h5>
                                </div>
                            `
                        );

                    state = false
                }

            } catch (error) {
                if (error.response) {
                    tools.tableMessage(empleoContenido, error.response.data.message);
                    state = false;
                } else {
                    tools.tableMessage(empleoContenido, "Se genero un error intente nuevamente.");
                    state = false;
                }

            }
        }

    });
</script>

@endsection