@extends('layouts.app')

@section('title', 'CIP CD JUNÍN')

@section('content')

<div class="login-box">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header">
                    <h3 class="box-title">Recupera tu cuenta</h3>
                </div>
                <div class="box-body" id="formPrimer">
                    <form id="frmValid" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Si es ingeniero colegiado en el CIP CD Junín, ingrese su Colegiatura (CIP)</label>
                            <input type="text" class="form-control" placeholder="Número cip" name="cip" maxlength="10">
                        </div>
                        <div class="form-group">
                            <a href="{{route('login.index')}}" class="btn btn-default">Cancelar</a>
                            <button type="button" class="btn btn-info" name="button">Enviar</button>
                        </div>
                    </form>
                </div>
                <div class="box-body" id="formSegundo">
                </div>
                <div class="box-body" id="formTercero">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/tools.js') }}"></script>
<script>
    let tools = new Tools();

    document.addEventListener('DOMContentLoaded', function() {
        let isProccess = false;

        let formValid = document.getElementById('frmValid');
        formValid.elements['cip'].focus();

        formValid.elements['cip'].addEventListener('keypress', function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        formValid.elements['button'].addEventListener('click', function(event) {
            onEventSubmitValid();
        });

        formValid.addEventListener('keydown', function(event) {
            if (event.keyCode == 13) {
                onEventSubmitValid();
                event.preventDefault();
            }
        });

        function onEventSubmitValid() {
            if (isProccess) return;
            if (formValid.elements['cip'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su n° cip.');
                formValid.elements['cip'].focus();
            } else {
                tools.ModalAlertInfo('Validando', 'Procesando petición...');
                isProccess = true;
                const data = new FormData(formValid);
                fetch("{{ route('identify.valid') }}", {
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
                        if (result.status === 1) {
                            tools.ModalAlertSuccess('Validando', result.message, function() {
                                $("#formPrimer").remove();
                                $("#formSegundo").append(`
                                <form id="frmCode" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Ingresa el código de verificación que fue enviado a tu correo electrónico previamente registrado.</label>
                                        <input type="text" class="form-control" placeholder="Código de verificación" name="code">
                                    </div>
                                    <div class="form-group">
                                        <a href="{{route('login.index')}}" class="btn btn-default">Cancelar</a>
                                        <button type="button" class="btn btn-info" name="button">Validar</button>
                                    </div>
                                </form>
                                `);
                                let frmCode = document.getElementById('frmCode');
                                frmCode.elements['code'].focus();
                                frmCode.elements['code'].addEventListener('keypress', function() {
                                    var key = window.Event ? event.which : event.keyCode;
                                    var c = String.fromCharCode(key);
                                    if ((c < '0' || c > '9') && (c != '\b')) {
                                        event.preventDefault();
                                    }
                                });

                                frmCode.elements['button'].addEventListener('click', function(event) {
                                    onEventSubmitCode(frmCode, result.token, result.user.idDNI);
                                });

                                frmCode.addEventListener('keydown', function(event) {
                                    if (event.keyCode == 13) {
                                        onEventSubmitCode(frmCode, result.token, result.user.idDNI);
                                        event.preventDefault();
                                    }
                                });

                            });
                            isProccess = false;
                        } else if (result.status === 2) {
                            tools.ModalAlertWarning('Validando', result.message, function() {
                                window.location.href = "{{ route('register.index') }}";
                            });
                            isProccess = false;
                        } else {
                            tools.ModalAlertWarning('Validando', result.message, function() {
                                formValid.elements['cip'].focus();
                            });
                            isProccess = false;
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertError('Validando', error.message);
                        isProccess = false;
                    });
            }
        }

        function onEventSubmitCode(frmCode, token, idDNI) {
            if (frmCode.elements['code'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese el código de verificación.');
                frmCode.elements['code'].focus();
            } else {
                const data = new FormData(frmCode);
                data.append('idToken', token);
                tools.ModalAlertInfo('Validando', 'Procesando petición...');

                fetch("{{ route('identify.code') }}", {
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
                        if (result.status == 1) {
                            tools.ModalAlertSuccess('Validando', result.message, function() {
                                $("#formSegundo").remove();
                                $("#formTercero").append(`
                                <form id="frmSave" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Ingresa su nueva contraseña.</label>
                                        <input type="password" class="form-control" placeholder="Contraseña" name="password">
                                    </div>
                                    <div class="form-group">
                                        <a href="{{route('login.index')}}" class="btn btn-default">Cancelar</a>
                                        <button type="button" class="btn btn-info" name="button">Guardar</button>
                                    </div>
                                </form>
                                `);
                                let frmSave = document.getElementById('frmSave');
                                frmSave.elements['password'].focus();

                                frmSave.elements['button'].addEventListener('click', function(event) {
                                    onEventSubmitPassword(frmSave, idDNI);
                                });

                                frmSave.addEventListener('keydown', function(event) {
                                    if (event.keyCode == 13) {
                                        onEventSubmitPassword(frmSave, idDNI);
                                        event.preventDefault();
                                    }
                                });
                            });
                        } else {
                            tools.ModalAlertWarning('Validando', result.message, function() {
                                frmCode.elements['code'].focus();
                            });
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertError('Validando', error.message);
                    });
            }
        }

        function onEventSubmitPassword(frmSave, idDNI) {
            if (frmSave.elements['password'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su nueva contraseña.');
                frmSave.elements['password'].focus();
            } else {
                const data = new FormData(frmSave);
                data.append('idDNI', idDNI);
                tools.ModalAlertInfo('Guardando', 'Procesando petición...');

                fetch("{{ route('identify.save') }}", {
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
                        if (result.status == 1) {
                            tools.ModalAlertSuccess('Guardando', result.message, function() {
                                window.location.href = "{{ route('login.index') }}";
                            });
                        } else {
                            tools.ModalAlertWarning('Guardando', result.message, function() {
                                frmSave.elements['password'].focus();
                            });
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertError('Guardando', error.message);
                    });
            }
        }

    });
</script>
@endsection