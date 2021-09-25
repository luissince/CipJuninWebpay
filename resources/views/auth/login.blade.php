@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Colegio de Ingenieros del Perú - JUNÍN</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingrese sus datos para continuar.</p>

        <form id="frmLogin" method="POST">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Usuario" name="user">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Contraseña" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btn-block btn-flat">Iniciar</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<script src="{{ asset('js/tools.js') }}"></script>
<script>
    let tools = new Tools();
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('frmLogin').addEventListener('submit', function(event) {
            event.preventDefault();

            let form = document.getElementById('frmLogin');
            if (form.elements['user'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su usuario por favor.');
                form.elements['user'].focus();
            } else if (form.elements['password'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su contraseña por favor.');
                form.elements['password'].focus();
            } else {
                tools.ModalAlertInfo('Login', 'Procesando petición...');
                const data = new FormData(form);
                fetch("{{ route('login.valid') }}", {
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
                        if (result.estatus === 1) {
                            window.location.href = "{{ route('admin.index') }}";
                        } else {
                            tools.ModalAlertWarning('Login', result.message);
                        }
                    })
                    .catch(function(error) {
                        tools.ModalAlertWarning('Login', error.message);
                    });
            }
        });
    });
</script>
@endsection