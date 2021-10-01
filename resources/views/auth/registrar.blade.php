@extends('layouts.app')

@section('title','CIP VIRTUAL - JUNÍN')

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

    document.addEventListener('DOMContentLoaded', function() {
        let isProccess = false;

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

        async function onEventSubmitRegister() {
            if (isProccess) return;

            if (form.elements['dni'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su n° de dni.');
                form.elements['dni'].focus();
            } else if (form.elements['cip'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su n° del cip.');
                form.elements['cip'].focus();
            } else {
                try {
                    tools.ModalAlertInfo('Registrar', 'Procesando petición...');
                    isProccess = true;
                    const data = new FormData(form);

                    let result = await tools.fetch_timeout("{{ route('register.valid')}}", {
                        method: 'POST',
                        body: data
                    });

                    if (result.status == 1) {
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

                            frmPassword.elements['button'].addEventListener('click', async function(event) {
                                onEventSubmitPassword(frmPassword, result.user.idDNI);
                            });

                            frmPassword.addEventListener('keydown', async function(event) {
                                if (event.keyCode == 13) {
                                    onEventSubmitPassword(frmPassword, result.user.idDNI);
                                    event.preventDefault();
                                }
                            });

                        });
                        isProccess = false;
                    } else if (result.status == 2) {
                        tools.ModalAlertWarning('Registrar', result.message, function() {
                            form.elements['dni'].focus();
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
                } catch (error) {
                    tools.ModalAlertError('Registrar', "Se produjo un error interno, intente nuevamente en par de minutos.");
                    isProccess = false;
                }
            }
        }

        async function onEventSubmitPassword(frmPassword, idDNI) {
            if (frmPassword.elements['password'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese una contraseña.');
                frmPassword.elements['password'].focus();
            } else if (!tools.validateEmail(frmPassword.elements['email'].value.trim())) {
                tools.AlertWarning('', 'Ingrese su correo electrónico.');
                frmPassword.elements['email'].focus();
            } else {
                try {
                    const data = new FormData(frmPassword);
                    data.append("idDNI", idDNI);

                    tools.ModalAlertInfo('Guardando', 'Procesando petición...');

                    let result = await tools.fetch_timeout("{{ route('register.save')}}", {
                        method: 'POST',
                        body: data
                    });

                    if (result.status == 1) {
                        tools.ModalAlertSuccess('Guardando', result.message, function() {
                            window.location.href = "{{ route('login.logout') }}";
                        });
                        isProccess = false;
                    } else {
                        tools.ModalAlertWarning('Login', result.message);
                        isProccess = false;
                    }

                } catch (error) {
                    tools.ModalAlertError('Guardando', "Se produjo un error interno, intente nuevamente en par de minutos.");
                    isProccess = false;
                }
            }
        }
    });
</script>
@endsection