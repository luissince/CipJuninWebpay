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

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nombres:</label>
                            <input type="text" class="form-control" name="names" placeholder="Ingrese su nombre(s)." value="{{$persona->Nombres}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Apellidos:</label>
                            <input type="text" class="form-control" name="lastName" placeholder="Ingrese sus apellidos." value="{{$persona->Apellidos}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>DNI:</label>
                            <input type="number" class="form-control" name="numDoc" placeholder="Ingrese el numero de su DNI." value="{{$persona->NumDoc}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Celular:</label>
                            <input type="text" class="form-control" name="phone" placeholder="Ingrese su número de celular." value="{{$telefono}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Dirección:</label>
                            <input type="text" class="form-control" name="address" placeholder="Ingrese su dirección." value="{{$direccion}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Correo Electrónico:</label>
                            <input type="text" class="form-control" name="email" placeholder="Ingrese su correo electrónico." value="{{$email}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Sexo:</label>
                            <select class="form-control" name="sexo">
                                <option value="M" {{$persona->Sexo == "M" ? 'selected' : ''}}>Masculino</option>
                                <option value="F" {{$persona->Sexo == "F" ? 'selected' : ''}}>Femenino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fechaNac" value="{{$persona->FechaNacimiento}}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group ">
                            <div class="col-md-12">
                                <div className="custom-control custom-switch">
                                    <input className="custom-control-input" type="checkbox" id="switch1" name="switch1" />
                                    <label className="custom-control-label" for="switch1"> Habilitar edición</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="button" name="button" class="btn btn-danger">Actualizar Datos</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    let tools = new Tools();
    let isProccess = false;
    document.addEventListener('DOMContentLoaded', function() {

        let form = document.getElementById('frmUpdate');
        // form.elements['phone'].focus();

        let elements = form.elements;
        for (var i = 0, len = elements.length; i < len; ++i) {
            elements[i].readOnly = true;
        }
        form.elements['sexo'].disabled = true;

        form.elements['switch1'].addEventListener('change', function() {
            if (form.elements['switch1'].checked) {
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].readOnly = false;
                }
                form.elements['sexo'].disabled = false;
            } else {
                for (var i = 0, len = elements.length; i < len; ++i) {
                    elements[i].readOnly = true;
                }
                form.elements['sexo'].disabled = true;
            }
        });

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
            if (! form.elements['switch1'].checked){
                tools.AlertWarning('', 'Habilitar la edición de datos.');
                form.elements['switch1'].focus();
            } else if (form.elements['names'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su nombre(s).');
                form.elements['names'].focus();
            } else if (form.elements['lastName'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese sus apellidos.');
                form.elements['lastName'].focus();
            } else if (form.elements['numDoc'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese el numero de su DNI.');
                form.elements['numDoc'].focus();
            } else if (form.elements['phone'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su número de celular.');
                form.elements['phone'].focus();
            }  else if (form.elements['address'].value.trim().length == 0) {
                tools.AlertWarning('', 'Ingrese su dirección.');
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