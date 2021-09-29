<div class="row">
    <div class="modal fade" id="modalTipoPago" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="btnCloseTipoPago">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-check-circle">
                        </i> Cobrar
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                    <h4>TOTAL A PAGAR:</h4>
                                </div>
                                <div class="col-md-3">
                                    <h4 id="totalModal" style="color: #C4373B;">0.00</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="form-group">
                                        <h5>Se le va a cobrar un monto adicional por transacción de plataforma.</h5>
                                        <img src="{{asset('images/visa.png')}}" alt="Visa">
                                        <img src="{{asset('images/mastercard.png')}}" alt="Mastercard">
                                        <img src="{{asset('images/american-express.png')}}" alt="American Express">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <input class="form-control" name="email" type="text" placeholder="ejemplo@company.com" value={{$email}} />
                                            <span class="fa fa-at form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btnAceptarTipoPago">
                        <i class="fa fa-check"></i> Aceptar</button>
                    <button type="button" class="btn btn-danger" id="btnCancelTipoPago">
                        <i class="fa fa-remove"></i> Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>