<!-- modal start certificado -->
<div class="row">
    <div class="modal fade" id="mdCertHabilidad" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseCertificado">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title" id="modal-title-certificado-habilidad">
                        <i class="fa fa-plus">
                        </i> Certificado de Habilidad
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label id="lblCertificadoHabilidadEstado"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtIngenieroCertificado">Ingeniero(a)</label>
                                <input type="text" class="form-control" id="txtIngenieroCertificado" placeholder="Datos completos del ingeniero" disabled>
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
                                <label for="txtFechaCertificado">Fecha</label>
                                <input type="date" class="form-control" id="txtFechaCertificado">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtCorrelativoCertificado">Certificado N°</label>
                                <input type="text" class="form-control" id="txtCorrelativoCertificado" placeholder="0">
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
<!-- modal end certificado -->

<!-- modal start certificado de residencia de obra -->
<div class="row">
    <div class="modal fade" id="mdCertResidenciaObra" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseCertResidenciaObra">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title" id="modal-title-residencia-obra">
                        <i class="fa fa-plus">
                        </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label id="lblCertificadoResidenciaObraEstado"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtIngenieroObra">Ingeniero(a)</label>
                                <input type="text" class="form-control" id="txtIngenieroObra" placeholder="Datos completos del ingeniero" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="lblEspecialidadObra">Especialidad(es)</label>
                                <select class="form-control" id="cbEspecialidadObra">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtFechaObra">Hábil Hasta</label>
                                <input type="date" class="form-control" id="txtFechaObra">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtCertificadoNumeroObra">Certificado N°</label>
                                <input type="text" class="form-control" id="txtCertificadoNumeroObra" placeholder="Número del Certificado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtModalidadObra">Modalidad</label>
                                <input type="text" class="form-control" id="txtModalidadObra" placeholder="Ingrese la Modalidad">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtProyectoObra">Proyecto</label>
                                <input type="text" class="form-control" id="txtProyectoObra" placeholder="Ingrese el nombre del Proyecto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtPropietarioObra">Propietario</label>
                                <input type="text" class="form-control" id="txtPropietarioObra" placeholder="Ingrese la Propiedad">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtMontoContratoObra">Monto del Contrato:</label>
                                <input type="text" class="form-control" id="txtMontoContratoObra" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Departamento/Provincia/Distrito</label>
                                <select class="form-control select2" style="width: 100%;" id="cbDepartamentoObra">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtMontoCobrarObra">Monto a Cobrar:</label>
                                <input type="text" class="form-control" id="txtMontoCobrarObra" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnAceptarCertResidenciaObra">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-primary" id="btnCloseCertRecidenciaObra">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end certificado de residencia de obra-->

<!-- modal start certificado de proyecto -->
<div class="row">
    <div class="modal fade" id="mdCertProyecto" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseCertProyecto">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title" id="modal-title-certificado-proyecto">
                        <i class="fa fa-plus">
                        </i> Certificado de Proyecto
                    </h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <label id="lblCertificadoProyectoEstado"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtIngenieroProyecto">Ingeniero(a)</label>
                                <input type="text" class="form-control" id="txtIngenieroProyecto" placeholder="Datos completos del ingeniero" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label id="lblEspecialidadProyecto">Especialidad(es)</label>
                                <select class="form-control" id="cbEspecialidadProyecto">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtFechaProyecto">Hábil Hasta</label>
                                <input type="date" class="form-control" id="txtFechaProyecto">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtNumeroCertificadoProyecto">Certificado N°</label>
                                <input type="text" class="form-control" id="txtNumeroCertificadoProyecto" placeholder="Número del certificado">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtModalidadProyecto">Modalidad</label>
                                <input type="text" class="form-control" id="txtModalidadProyecto" placeholder="Ingrese la modalidad">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtPropietarioProyecto">Propietario</label>
                                <input type="text" class="form-control" id="txtPropietarioProyecto" placeholder="Ingrese el propietario">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtProyectoProyecto">Proyecto</label>
                                <input type="text" class="form-control" id="txtProyectoProyecto" placeholder="Ingrese el nombre del proyecto">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtMontoContratoProyecto">Monto de Contrato</label>
                                <input type="text" class="form-control" id="txtMontoContratoProyecto" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Departamento/Provincia/Distrito</label>
                                <select class="form-control select2" style="width: 100%;" id="cbDepartamentoProyecto">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtUrbProyecto">Urb./A.A.H.H./PP.JJ/Asoc</label>
                                <input type="text" class="form-control" id="txtUrbProyecto" placeholder="Urb./A.A.H.H./PP.JJ/Asoc">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtCalleProyecto">Jr./Av./Calle/Pasaje</label>
                                <input type="text" class="form-control" id="txtCalleProyecto" placeholder="Jr./Av./Calle/Pasaje">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txtMontoCobrarProyecto">Monto a Cobrar</label>
                                <input type="text" class="form-control" id="txtMontoCobrarProyecto" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btnAceptarCertProyecto">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-primary" id="btnCancelCertProyecto">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal end certificado de proyecto -->