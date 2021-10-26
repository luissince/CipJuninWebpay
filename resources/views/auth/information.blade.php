@extends('layouts.app')

@section('title', 'CIP VIRTUAL - JUNÍN')

@section('content')

<h3>Documentación de la aplicación</h3>
<p>En este seccion te enseñará a configurar y usar la aplicacion de pagos del "Colegio de Ingenieros del Perú - Cede Junin" en tu iPhone o en un smartphone con Android. En esta aplicaión prodras ver tu datos, ver tus comprobantes pagados virtualmente o presencialmente, realizar pagos de sus cuotas y tramitar sus certificados cuando estás conectado a wifi o a los datos del celular.</p>
<p>Para mayot información contactenos a:</p>
<div class="row" style="margin: 1em">
    <div class="col-md-4 col-sm-4">
        <label>Dirección:</label>
        Av. Centenario N° 604 (Costao de la iglesia pichicus) Junín - Huancayo - Huancayo
    </div>
    <div class="col-md-4 col-sm-4">
        <label>Celular:</label>
        +51 935 845 791
    </div>
    <div class="col-md-4 col-sm-4">
        <label>Correo:</label>
        informatica@cip-junin.org.pe
    </div>
</div>
<hr>
<br>
<div class="row">

    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>1. Descarga e instalación de la app</h4>
        </div>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Android - <a href="https://play.google.com/store/apps/details?id=org.pe.cipjunin&hl=es_PE&gl=US">https://play.google.com/store/apps/details?id=org.pe.cipjunin&hl=es_PE&gl=US</a>
        </p>

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            IOS - Pronto
        </p>
        <div class="text-muted well well-sm no-shadow tex text-center" style="margin-top: 10px;">
            <img class="img-fluid" src="{{asset('images/tienda.png')}}" />
        </div>

    </div>

</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>2. Acceder o abrir la app</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 col-sm-4">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Ver Contaseña <span class="badge bg-yellow">1</span>&nbsp;: </strong>
            Presionar en el boton del ojito para visualisar la contraseña o esconderla.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Ingresar <span class="badge bg-yellow">2</span>&nbsp;: </strong>
            Presionar en el boton de ingresar para dentar y usar la app, para ello previamente tiene que ingresar sus credenciales de número de cip o DNI más su contraseña.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Solicitar tus credenciales <span class="badge bg-yellow">3</span>&nbsp;: </strong>
            Entrar a este apardo solo si no tubiera su contraseña de colegiado.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>¿Olvido su contraseña? <span class="badge bg-yellow">4</span>&nbsp;: </strong>
            Ingresar a este apartado para recuperar su contraseña si no recuerda.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Formulario <span class="badge bg-yellow">5</span>&nbsp;: </strong>
            Para crear su contraseña de colegiado llenar los apartados de número de DNI y número de cip.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Enviar <span class="badge bg-yellow">6</span>&nbsp;: </strong>
            Solo crear la contraseña con los datos previamente ingresados, si aun no tubiera la misma.
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/logeo.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/solicilar-credenciales.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>3. Vista principal de la app</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6 col-sm-6">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Home <span class="badge bg-yellow">7</span>&nbsp;: </strong>
            La sección de home muetra algunos datos importantes de colegiado y esta sección es la que se muestra por defecto al ingresar a la app.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Documentos <span class="badge bg-yellow">8</span>&nbsp;: </strong>
            La sección de documentos sirve para hacer la consulta de los comprobantes de pago y certifiados.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Pagar <span class="badge bg-yellow">9</span>&nbsp;: </strong>
            La sección de pagar ofrece el servicio de realizar tus pagos de cuota social y cetificado de habilidad mediante tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Directorio <span class="badge bg-yellow">10</span>&nbsp;: </strong>
            La sección de directorio muestra los datos generales de la institución.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Perfil <span class="badge bg-yellow">11</span>&nbsp;: </strong>
            La sección de perfil muestra los datos mas detallados del colegiado.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Cerrar <span class="badge bg-yellow">12</span>&nbsp;: </strong>
            Pulsando este boton se cierra la sessión del colegiado
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/home.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>4. Consultar documentos</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 col-sm-4">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Documento de pago <span class="badge bg-yellow">13</span>&nbsp;: </strong>
            Dentrando al apartado se puede visualizar la lista de pagos que hiso el usuario.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Certificado de habilidad <span class="badge bg-yellow">14</span>&nbsp;: </strong>
            En este apartado se listan los certificados de habilidad.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Certificado de obra <span class="badge bg-yellow">15</span>&nbsp;: </strong>
            En este apartado se listan los certificados de poyecto.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Certificado de poyecto <span class="badge bg-yellow">16</span>&nbsp;: </strong>
            En este apartado se listan los certificados de poyecto.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Descargar <span class="badge bg-yellow">17</span>&nbsp;: </strong>
            Mediante esta funcionalidad descarga en formato pdf el certificado.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em">
            <strong>Compartir <span class="badge bg-yellow">18</span>&nbsp;: </strong>
            Comparte los comprobantes de pago a whatapp de forma sencilla.
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/documentos.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/cert-habilidad.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>5. Pagos de servicios</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 col-sm-4">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Cuota <span class="badge bg-yellow">19</span>&nbsp;: </strong>
            Dentrando al apartado prodras hacer el pago de la cuota social de habilidad.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Certificado <span class="badge bg-yellow">20</span>&nbsp;: </strong>
            Dentrando al apartado prodras hacer el pago del certificado de habilidad.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Agregar <span class="badge bg-yellow">21</span>&nbsp;: </strong>
            Por defecto agregado todas las cuotas pendientes. si es que se eliminara alguna cuota con este boton volver agregar.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Eliminar <span class="badge bg-yellow">22</span>&nbsp;: </strong>
            Elimina la cuota de un mes mediante es opción.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Pagar <span class="badge bg-yellow">23</span>&nbsp;: </strong>
            pulsando la opción podras realisar los pagos de las cuotas.
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/cuota-social.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>6. Proceso de pago</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6 col-sm-6">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Agregar nueva tarjeta <span class="badge bg-yellow">24</span>&nbsp;: </strong>
            Esta opción redirige para agregar los datos de la tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Número de tarjeta <span class="badge bg-yellow">25</span>&nbsp;: </strong>
            Dijitar el número de su tarjeta en este apartado.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Fecha de expiración <span class="badge bg-yellow">26</span>&nbsp;: </strong>
            Dijitar la fecha de expiración de su tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Número de CVC/CCV <span class="badge bg-yellow">27</span>&nbsp;: </strong>
            Dijitar la clave cvc/ccv de su tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Datos <span class="badge bg-yellow">28</span>&nbsp;: </strong>
            Ingrese los datos del propietario de la tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Guardar tarjeta <span class="badge bg-yellow">29</span>&nbsp;: </strong>
            Con esta opción guardar los datos de la tarjeta.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Tipo de comprobante <span class="badge bg-yellow">30</span>&nbsp;: </strong>
            Seleccionar el tipo de comprobante para continuar.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Validación de información <span class="badge bg-yellow">31</span>&nbsp;: </strong>
            Verificar los datos a procesar.
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Resumen de la transacción <span class="badge bg-yellow">32</span>&nbsp;: </strong>
            Confirmación del resultado de la transacción.
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-01.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-02.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-03.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-04.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-05.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-06.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-07.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-08.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/pagar-09.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-xs-12">
        <div class="callout callout-info">
            <h4>7. Directorio institucional y perfil del colegiado</h4>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-4 col-sm-4">
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Directorio <span class="badge bg-yellow">33</span>&nbsp;: </strong>
            Muestra la información del directorio institucional del "Colegio de Ingenieros del Perú Cede Junin".
        </div>
        <div style="padding-top: 1em; padding-left: 1em; padding-bottom: 1em;">
            <strong>Perfil <span class="badge bg-yellow">35</span>&nbsp;: </strong>
            Mustra los datos detallados del colegiado.
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/directorio.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

    <div class="col-md-4 col-sm-4">
        <div class="text-center" style="padding-bottom: 1em">
            <img src="{{asset('images/perfil-app.png')}}" width="200px" style="border: 1px solid #aaa" />
        </div>
    </div>

</div>


@endsection

@section('script')
<script src="{{ asset('js/tools.js') }}"></script>
<script>
    let tools = new Tools();

    document.addEventListener('DOMContentLoaded', function() {


    });
</script>

@endsection