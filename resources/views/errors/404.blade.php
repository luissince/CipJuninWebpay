@extends('layouts.app')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')
<div class="error-page">
    <h2 class="headline text-yellow"> 404</h2>

    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> ¡UPS! Página no encontrada.</h3>

        <p>
            No pudimos encontrar la página que buscaba.
            Mientras tanto, puedes <a href="{{route('index')}}">retornar al inicio</a>.
        </p>

    </div>
    <!-- /.error-content -->
</div>
@endsection