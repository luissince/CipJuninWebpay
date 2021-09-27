@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('index')}}"><b>Colegio de Ingenieros del Perú - CD Junín</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" id="formPrimer">
        <p class="login-box-msg">Registrar Cuenta.</p>
        <div class="no-padding" id="no-padding">
        </div>

        <form id="frmRegister" method="POST">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="N° Dni" name="dni" maxlength="8">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="N° Cip" name="cip" maxlength="10">
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info btn-block btn-flat" name="button">Enviar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>

    <div class="login-box-body" id="formSegundo">
    </div>
    <!-- /.login-box-body -->
</div>
<script src="{{ asset('js/tools.js') }}"></script>
<script>
    let tools = new Tools();
    let isProccess = false;

    document.addEventListener('DOMContentLoaded', function() {

        let form = document.getElementById('frmRegister');
        form.elements['dni'].focus();

        form.elements['dni'].addEventListener('keypress', function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        form.elements['cip'].addEventListener('keypress', function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        form.elements['button'].addEventListener('click', function(event) {
            onEventSubmitRegister();
        });

        form.addEventListener('keydown', function(event) {
            if (event.keyCode == 13) {
                onEventSubmitRegister();
                event.preventDefault();
            }
        });

        function onEventSubmitRegister() {
            if (isProccess) return;

            if (form.elements['dni'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su n° de dni.');
                form.elements['dni'].focus();
            } else if (form.elements['cip'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su n° del cip.');
                form.elements['cip'].focus();
            } else {
                tools.ModalAlertInfo('Registrar', 'Procesando petición...');
                isProccess = true;
                const data = new FormData(form);
                fetch("{{ route('register.valid')}}", {
                        method: 'POST',
                        body: data
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.json()
                        } else {
                            throw "Error de conexión, intente nuevamente.";
                        }
                    })
                    .then(function(result) {
                        if (result.estatus == 1) {
                            $("#formPrimer").remove();
                            tools.ModalAlertSuccess('Procesando', "Sus datos se validaron correctamente.", function() {
                                $("#formSegundo").empty();
                                $("#formSegundo").append(`
                                    <p class="login-box-msg">Guardar contraseña.</p>
                                    <div class="no-padding" id="no-padding">
                                    </div>
                                    <form id="frmPassword" method="POST">        
                                        @csrf                           
                                        <div class="form-group has-feedback">
                                            <input type="password" class="form-control" placeholder="Ingrese una contraseña" name="password">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <input type="email" class="form-control" placeholder="Correo Electrónico" name="email">
                                            <span class="fa fa-at form-control-feedback"></span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-info btn-block btn-flat" name="button">Guardar</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>
                                `);
                                let frmPassword = document.getElementById('frmPassword');
                                frmPassword.elements['password'].focus();

                                frmPassword.elements['button'].addEventListener('click', function(event) {
                                    onEventSubmitPassword(result.user.idDNI);
                                });

                                frmPassword.addEventListener('keydown', function(event) {
                                    if (event.keyCode == 13) {
                                        onEventSubmitPassword();
                                        event.preventDefault(result.user.idDNI);
                                    }

                                });

                            });
                            isProccess = false;
                        } else {
                            $("#no-padding").empty();
                            $("#no-padding").append(`<div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                                Los datos ingresados no coinciden con nuestra información interna, comuníquese con el área de sistemas para corroborar su n° dni o cip.
                                <div class="box-footer">
                                    <ul class="nav nav-stacked">
                                        <li><a href="#">Teléfono: <span class="pull-right badge bg-green text-white">064 562366</span></a></li>
                                        <li><a href="#">Celular: <span class="pull-right badge bg-green text-white">+51 999999999</span></a></li>
                                        <li><a href="#">Correo: <span class="pull-right badge bg-green text-white">ejemplo@hotmail.com</span></a></li>
                                    </ul>
                                </div>
                            </div>`);
                            tools.ModalAlertWarning('Registrar', result.message, function() {
                                form.elements['dni'].focus();
                            });
                            isProccess = false;
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertError('Registrar', "Se produjo un error interno, intente nuevamente en par de minutos.");
                        isProccess = false;
                    });
            }
        }

        function onEventSubmitPassword(idDNI) {
            if (frmPassword.elements['password'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese una contraseña.');
                frmPassword.elements['password'].focus();
            } else {
                const data = new FormData(frmPassword);
                data.append("idDNI", idDNI);

                tools.ModalAlertInfo('Guardando', 'Procesando petición...');
                fetch("{{ route('register.password')}}", {
                        method: 'POST',
                        body: data
                    })
                    .then(function(response) {
                        if (response.ok) {
                            return response.json()
                        } else {
                            throw "Error de conexión, intente nuevamente.";
                        }
                    })
                    .then(function(result) {
                        if (result.estatus == 1) {
                            tools.ModalAlertSuccess('Guardando', result.message, function() {
                                window.location.href = "{{ route('login.logout') }}";
                            });
                        } else {
                            tools.ModalAlertWarning('Login', result.message);
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertError('Guardando', "Se produjo un error interno, intente nuevamente en par de minutos.");
                        isProccess = false;
                    });
            }
        }

        // loadData();
    });

    async function loadData() {
        try {
            let response = await fetch("{{route('register.data')}}");
            if (!response.ok) {
                throw new Error("Recurso no encontrado");
            }
            let result = await response.json();
            console.log(result);
        } catch (error) {
            console.log(error.message);
        }
    }
</script>
@endsection