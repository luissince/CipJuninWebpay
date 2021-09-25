@extends('layouts.app')

@section('title','Home')

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
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.getElementById('frmLogin').addEventListener('submit',function(event){
            event.preventDefault();
            console.log(event)
            const data = new FormData(document.getElementById('frmLogin'));
            fetch("{{ route('login.valid')}}", {
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
                    if(result.estatus === 1){
                        window.location.href = "{{ route('admin.index')}}";
                    }else{
                        console.log(result.message); 
                    }
                })
                .catch(function(error) {
                    console.log(error.message);
                });
        });
    });

</script>
@endsection