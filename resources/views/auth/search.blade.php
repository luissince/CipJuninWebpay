@extends('layouts.app')

@section('title', 'CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h3>Búsqueda de Colegiado</h3>
        <p>En esta sección podras realizar una busqueda por datos personales o por el número de CIP, tan solo llenando los
            campos que aparecen en la parte inferior.</p>
    </div>
</div>

<br />

<div class="row">
    <div class="col-md-4">
        <h4>Filtro por N° CIP o Apellidos</h4>
        <div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Presione enter para buscar" maxlength="25" id="txtBuscar">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info btn-block btn-flat" id="btnBuscar">Buscar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <h4>Resultado</h4>

        <table width="100%" style="background-color:#E3E3E3;">
            <tbody>
                <tr>
                    <td colspan="2">
                        <div style="padding:5px; background-color:#A40003; text-align:center; color:#ffffff;">DATOS DEL COLEGIADO </div>
                    </td>
                </tr>
                <tr>
                    <td width="50%" class="text-right">NÚMERO DE CIP:&emsp;</td>
                    <td width="50%"><strong id="lblCip">-</strong></td>
                </tr>
                <tr>
                    <td width="50%" class="text-right">APELLIDOS:&emsp;</td>
                    <td width="50%"><strong id="lblApellidos">-</strong></td>
                </tr>
                <tr>
                    <td width="50%" class="text-right">NOMBRES:&emsp;</td>
                    <td width="50%"><strong id="lblNombres">-</strong></td>
                </tr>
                <tr>
                    <td width="50%" class="text-right">TIPO:&emsp;</td>
                    <td width="50%"><strong id="lblTipo">-</strong></td>

                </tr>
                <tr>
                    <td width="50%" class="text-right">FECHA INCORPORACIÓN:&emsp;</td>
                    <td width="50%"><strong id="lblFechaIncorporacion">-</strong></td>

                </tr>
                <tr>
                    <td width="50%" class="text-right">CONDICIÓN:&emsp;</td>
                    <td width="50%"><strong id="lblCondicion">-</strong></td>
                </tr>
            </tbody>
        </table>

        <br />

        <table width="100%" cellpadding="0" cellspacing="1" style="background-color:#E3E3E3;">
            <thead>
                <tr class="bg-primary">
                    <th class="text-center" width="5%">N°</th>
                    <th class="text-center" width="15%">Capitulo</th>
                    <th class="text-center" width="10%">Especialidad</th>
                    <th class="text-center" width="10%">Fecha Reconocimiento CIP</th>
                </tr>
            </thead>
            <tbody id="dataGrid" style="opacity: 1;">
                <tr>
                    <td colspan="4" class="text-center">Información de colegitura</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>


@endsection

@section('script')
<script src="{{ asset('js/tools.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();
        window.CSRF_TOKEN = '{{ csrf_token() }}';
        let state = false;
        let dataGrid = $("#dataGrid");

        $("#txtBuscar").focus();

        $("#btnBuscar").click(function() {
            if ($("#txtBuscar").val().trim() === '') {
                $("#txtBuscar").focus();
                tools.AlertWarning('', 'Ingrese un valor.');
            } else {
                loadInfo($("#txtBuscar").val().trim())
            }
        });

        $("#txtBuscar").keyup(function(event) {
            if (event.keyCode == 13) {
                if ($("#txtBuscar").val().trim() === '') {
                    $("#txtBuscar").focus();
                    tools.AlertWarning('', 'Ingrese un valor.');
                } else {
                    loadInfo($("#txtBuscar").val().trim())
                }
            }
        });

        async function loadInfo(text) {

            if (state) return;

            try {

                state = true;
                clearInfo();
                dataGrid.empty();
                // dataGrid.html(
                //     `<tr>
                //         <td colspan="4" class="text-center">Información de colegitura</td>
                //     </tr>`
                // );
                arrayPersona = [];

                let result = await axios.get("{{ route('search.data')}}", {
                    params: {
                        "text": text
                    }
                }, {
                    headers: {
                        'X-CSRF-TOKEN': window.CSRF_TOKEN,
                    }
                });

                if (result.data.status === 1) {
                    arrayPersona = result.data.person;

                    $("#lblCip").html('' + arrayPersona.CIP);
                    $("#lblApellidos").html(arrayPersona.Apellidos);
                    $("#lblNombres").html(arrayPersona.Nombres);
                    $("#lblTipo").html(arrayPersona.Condicion);
                    $("#lblFechaIncorporacion").html(arrayPersona.FechaColegiado);
                    $("#lblCondicion").html(arrayPersona.Habilidad === 'Habilitado' ? '<span class="text-info">Habilitado</sapan>' : '<span class="text-danger">No Habilitado</sapan>');

                    tools.AlertSuccess('', 'Consulta realisada exitosamente.');

                    if (result.data.colegiatura.length === 0) {
                        dataGrid.empty();
                        dataGrid.html(
                            `<tr>
                                <td colspan="4" class="text-center">Información de colegitura no encontrada</td>
                            </tr>`
                        );
                        tools.AlertWarning('', 'Información de colegitura no encontrada.');
                        $("#txtBuscar").focus();
                    } else {

                        let count = 0

                        for (let colegituta of result.data.colegiatura) {
                            count++
                            dataGrid.append(
                                `
                                    <tr>
                                        <td class="text-center">${count}</td>
                                        <td>${colegituta.Capitulo}</td>
                                        <td>${colegituta.Especialidad}</td>
                                        <td class="text-center">${colegituta.FechaColegiado}</td>
                                    </tr>
                                `
                            );
                        }
                    }

                } else {
                    clearInfo();
                    dataGrid.empty();
                    dataGrid.html(
                        `<tr>
                            <td colspan="4" class="text-center">Información de colegitura</td>
                        </tr>`
                    );
                    tools.AlertWarning('', 'Datos no encontrados.');
                    $("#txtBuscar").focus();
                }
                state = false;
            } catch (error) {
                if (error.response) {
                    tools.AlertWarning('', error.response);
                    state = false;
                } else {
                    tools.AlertWarning('', 'Se genero un error intente nuevamente.');
                    state = false;
                }

                clearInfo();
                dataGrid.empty();
                dataGrid.html(
                    `<tr>
                        <td colspan="4" class="text-center">Información de colegitura</td>
                    </tr>`
                );
            }
        }

        function clearInfo() {
            $("#lblCip").html('-')
            $("#lblApellidos").html('-')
            $("#lblNombres").html('-')
            $("#lblTipo").html('-')
            $("#lblFechaIncorporacion").html('-')
            $("#lblCondicion").html('-');
        }

    })
</script>
@endsection