@extends('layouts.admin')

@section('title','CIP CD JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box no-border">
            <div class="box-header not-border">
                <h3 class="box-title">Lista de Certificados de Habilidad</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <label>Filtrar por N° certificado.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="search" id="txtBuscar" class="form-control" placeholder="Escribe para filtrar automaticamente" aria-describedby="search" value="">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success" id="btnBuscar"> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <label>Opción.</label>
                        <div class="form-group">
                            <div class="input-group">
                                <button type="button" class="btn btn-default" id="btnRecargar"><i class="fa fa-refresh"></i> Recargar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                                <thead style="background-color: #FDB2B1;color: #B72928;">
                                    <tr>
                                        <th width="4%;" class="text-center">#</th>
                                        <th width="4%;" class="text-center">P.D.F</th>
                                        <th width="4%;" class="text-center">Editar</th>
                                        <th width="8%;">N° CIP</th>
                                        <th width="10%;">Colegiado</th>
                                        <th width="10%;">Especialidad</th>
                                        <th width="9%;">N° Certificado</th>
                                        <th width="5%;">Estado</th>
                                        <th width="10%;">Asunto</th>
                                        <th width="10%;">Entidad</th>
                                        <th width="10%;">Lugar</th>
                                        <th width="8%;">Fecha Pago</th>
                                        <th width="8%;">Fecha Venci.</th>
                                    </tr>
                                </thead>
                                <tbody id="tbTable">
                                    <tr class="text-center">
                                        <td colspan="13">
                                            <p>No hay ingresos para mostrar.</p>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();



    });
</script>

@endsection