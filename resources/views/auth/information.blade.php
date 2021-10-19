@extends('layouts.app')

@section('title', 'CIP VIRTUAL - JUNÍN')

@section('content')

<h2>CIP VIRTUAL</h2>
<p>En el cip virtual podra visualizar sus datos principales, sus comprobantes, realizar pagos de sus cuotas y tramitar sus certificados(A,B,C).</p>
<div class="row">
    <div class="col-xs-6">
        <p class="lead">Perfil:</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Tendrá un panel donde podrá visualizar sus datos principales.
        </p>
    </div>
    <div class="col-xs-6">
        <p class="lead">Comprobantes de Pago</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            En esta sección podra consulta de sus boletas, facturas electrónicas.
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p class="lead">Realizar Pago</p>
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            En esta sección podrá realizar sus pagos de cuotas ordinarias y certificados de tipo A, B, C.
        </p>
    </div>
    <div class="col-xs-6">
        <p class="lead">Metodos de Pago:</p>
        <img src="{{asset('images/visa.png')}}" alt="Visa">
        <img src="{{asset('images/mastercard.png')}}" alt="Mastercard">
        <img src="{{asset('images/american-express.png')}}" alt="American Express">
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Esta entidad está autorizada por Visa|Mastercard|American Express para realizar transacciones electrónicas.
        </p>
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