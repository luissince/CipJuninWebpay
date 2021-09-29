<div class="row">
    <div class="modal fade" id="mdCuotas" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button id="btnCloseCuotas" type="button" class="close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus">
                        </i> Pago de Cuotas
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                            <div class="form-group">
                                <button id="btnAddCuota" type="button" class="btn btn-warning">
                                    <i class="fa fa-plus"></i> Agregar
                                </button>
                                <button id="btnDeleteCuota" type="button" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="text-info" id="lblCuotasMensaje">
                                Cuotas Ordinarias
                            </h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="width:100%;  overflow-x: auto;height:260px">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="65%" colspan="2">Cuota del Mes</th>
                                        <th width="15%" class="text-center">Monto</th>
                                    </tr>
                                </thead>
                                <tbody id="tbCuotas">

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row no-padding border" style="background-color: #337ab7;color:white;">
                        <div class="col-md-12 text-center">
                            <h4 id="lblTotalCuotas" class="no-margin margin-5px">TOTAL DE CUOTAS: 0.00</h4>
                            <h5 id="lblNumeroCuotas" class="no-margin margin-5px">CUOTAS DEL: 0/0000 al 00/0000</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnAceptarCuotas">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-primary" id="btnCancelarCuotas">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>