@extends('layouts.app')

@section('title','CIP CD JUNÍN')

@section('content')
<!-- Navbar goes here -->

<div class="error-page">
    <h2 class="headline text-yellow"> 500</h2>

    <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> ¡UPS! Algo salió mal.</h3>

        <p>
            Trabajaremos para solucionarlo de inmediato. Mientras tanto, puede <a href="{{route('index')}}">retornar al inicio</a>.
        </p>

    </div>
    <!-- /.error-content -->
</div>
@endsection