<style>
    .my-0 {
        margin-top: 0;
        margin-bottom: 0;
    }

    .my-1 {
        margin-top: 0.25em;
        margin-bottom: 0.25em;
    }
    .my-2 {
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }
</style>
<div class="row">
    <div class="modal fade" id="modalInscription" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseInscription">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-th-list">
                        </i> Inscripción
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">CURSO:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblCurso">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">INSTRUCTOR:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblInstructor">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">ORGANIZADOR:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblOrganizador">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">CAPITULO:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblCapitulo">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">MODALIDAD:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblModalidad">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">FECHA - HORA:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblfechaHora">-</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">PRECIO:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1"><strong id="lblPrecioCurso">-</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">CERTIFICADO:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1"><strong id="lblPrecioCertificado">-</strong></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-left">
                                    <h5 class="text-dark my-1">CONTACTO:</h5>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-primary my-1" id="lblContacto">-</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr class="my-2"/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-12">
                                    <div class="checkbox">
                                        <label for="cbEstado">
                                            <input type="checkbox" id="cbEstado"> Aceptar terminos
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <p style="color: #686868e3; font-size: 13PX;">Para realizar la incripción aceptar los terminos y condiciones de la misma.</p>
                        </div>
                    </div>
                    <!-- <hr class="my-1"/>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="box-title">
                                Tarjeta
                            </h4>
                            <form novalidate autocomplete="on" id="formSaveCard" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Número de tarjeta: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <div class="form-group has-feedback">
                                            <input class="form-control" name="card" type="text" pattern="\d*" x-autocompletetype="cc-number" placeholder="0000 0000 0000 0000" maxlength="20" autocomplete="off">
                                            <span class="fa fa-credit-card form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Fecha expiración (MM / YY): <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <div class="form-group has-feedback">
                                            <input class="form-control" name="exp" type="text" pattern="\d*" x-autocompletetype="cc-exp" placeholder="MM / YY" autocomplete="off">
                                            <span class="fa fa-calendar form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Código de seguridad: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <div class="form-group has-feedback">
                                            <input class="form-control" name="cvv" type="text" placeholder="cvv/cvc" maxlength="4" autocomplete="off">
                                            <span class="fa fa-lock form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Correo electrónico: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                        <div class="form-group has-feedback">
                                            <input class="form-control" name="email" type="text" placeholder="ejemplo@company.com" />
                                            <span class="fa fa-at form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnAceptarInscripcion" disabled>
                        <i class="fa fa-check"></i> Guardar</button>
                    <button type="button" class="btn btn-danger" id="btnCancelInscription">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    $("#cbEstado").change(function() {
        if ($("#cbEstado").is(":checked")){
            $( "#btnAceptarInscripcion" ).prop( "disabled", false );
        } else{
            $( "#btnAceptarInscripcion" ).prop( "disabled", true );
        }
       
    });
</script>