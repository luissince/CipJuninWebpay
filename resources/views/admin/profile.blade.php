@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{$image==''?asset('images/usuario.png'):$image}}" alt="User profile picture">

                <h3 class="profile-username text-center">{{$persona->Apellidos}} {{$persona->Nombres}}</h3>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>N° CIP</b> <a class="pull-right">{{$persona->CIP}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>N° D.N.I</b> <a class="pull-right">{{$persona->NumDoc}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Condición</b> <a class="pull-right">{{$persona->Condicion}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Sexo</b> <a class="pull-right">{{$persona->Sexo == "M" ? "MASCULINO" : "FEMENINO"}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>FNAC</b> <a class="pull-right">{{ date("d/m/Y", strtotime($persona->FechaNac))}}</a>
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <form id="frmUpdate" class="form-vertical">
                    @csrf
                    <div class="form-group">
                        <label>Celular:</label>
                        <input type="text" class="form-control" name="phone" placeholder="Ingrese su n° de celular." value="{{$telefono}}">
                    </div>
                    <div class="form-group">
                        <label>Dirección:</label>
                        <input type="text" class="form-control" name="address" placeholder="Ingrese su dirección." value="{{$direccion}}">
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico:</label>
                        <input type="text" class="form-control" name="email" placeholder="Ingrese su correo Electrónico." value="{{$email}}">
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" name="button" class="btn btn-danger">Actualizar Datos</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let tools = new Tools();
    let isProccess = false;
    document.addEventListener('DOMContentLoaded', function() {

        let form = document.getElementById('frmUpdate');
        form.elements['phone'].focus();

        form.elements['phone'].addEventListener('keypress', function() {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        form.elements['button'].addEventListener('click', function(event) {
            onEventSubmitValid();
        });

        form.addEventListener('keydown', function(event) {
            if (event.keyCode == 13) {
                onEventSubmitValid();
                event.preventDefault();
            }
        });

        async function onEventSubmitValid() {
            if (isProccess) return;
            if (form.elements['phone'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su número de celular.');
                form.elements['phone'].focus();
            } else if (form.elements['address'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su direccón de vivienda.');
                form.elements['address'].focus();
            } else if (!tools.validateEmail(form.elements['email'].value.trim())) {
                tools.AlertWarning('', 'Ingrese su correo electrónico.');
                form.elements['email'].focus();
            } else {

                try {
                    tools.ModalAlertInfo('Perfil', 'Procesando petición...');
                    isProccess = true;
                    const data = new FormData(form);

                    let result = await tools.fetch_timeout("{{ route('profile.update') }}", {
                        method: 'POST',
                        body: data
                    });

                    if (result.status === 1) {
                        tools.ModalAlertSuccess('Perfil', result.message, function() {
                            window.location.href = "{{ route('profile.index') }}";
                        });
                    } else {
                        tools.ModalAlertWarning('Perfil', result.message);
                        isProccess = false;
                    }
                } catch (error) {
                    tools.ModalAlertError('Perfil', error.message);
                    isProccess = false;
                }

            }
        }

    });
</script>

@endsection