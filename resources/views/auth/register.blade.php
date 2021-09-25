@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>Colegio de Ingenieros del Perú - JUNÍN</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Registrar Datos.</p>

        <form id="register" method="POST">
            @csrf
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Dni" name="dni">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="N° Cip" name="cip">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Contraseña" name="email">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btn-block btn-flat">Enviar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('register').addEventListener('submit', function(event) {
            event.preventDefault();
            const data = new FormData(document.getElementById('register'));
            fetch("{{ route('register.store')}}", {
                    method: 'POST',
                    body: data
                })
                .then(function(response) {
                    if (response.ok) {
                        return response.text()
                    } else {
                        throw "Error en la llamada Ajax";
                    }

                })
                .then(function(texto) {
                    console.log(texto);
                    window.location.href = "{{ route('login.index')}}";
                })
                .catch(function(err) {
                    console.log(err);
                });
        });

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