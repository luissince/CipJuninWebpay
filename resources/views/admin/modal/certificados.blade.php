<div class="row">
    <div class="modal fade" id="mdCertHabilidad" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseCertificado">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus">
                        </i> Certificado de Habilidad
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="box no-border ">
                        <div class="box-body no-padding">

                            <div class="row">
                                <div class="col-md-12">
                                    <label id="lblCertificadoHabilidadEstado"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtIngenieroCertificado">Ingeniero(a)</label>
                                        <input type="text" class="form-control" id="txtIngenieroCertificado" placeholder="Datos completos del ingeniero" value="{{$persona->Apellidos}} {{$persona->Nombres}}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label id="lblEspecialidadCertificado">Especialidad(es)</label>
                                        <select class="form-control" id="cbEspecialidadCertificado">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtAsuntoCertificado">Asunto</label>
                                        <input type="text" class="form-control" id="txtAsuntoCertificado" value="EJERCICIO DE LA PROFESIÓN" placeholder="Ingrese el asunto">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtEntidadCertificado">Entidad o Propietario</label>
                                        <input type="text" class="form-control" id="txtEntidadCertificado" value="VARIOS" placeholder="Ingrese la entidad o el propietario">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtLugarCertificado">Lugar</label>
                                        <input type="text" class="form-control" id="txtLugarCertificado" value="A NIVEL NACIONAL" placeholder="Ingrese el lugar">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="idOverlayCertificado">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnAceptarCertificado">
                            <i class="fa fa-check"></i> Aceptar</button>
                        <button type="button" class="btn btn-primary" id="btnCancelarCertificado">
                            <i class="fa fa-remove"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>