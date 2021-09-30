@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
    <div class="col-md-6">
        <a href="{{route('voucher.invoice')}}">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa  fa-file"></i>

                    <h3 class="box-title">BOLETAS/FACTURAS</h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p>En esta sección podra consultar sus comprobante de pago.</p>
                        <small><i class="fa fa-hand-pointer-o"></i></small>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{route('voucher.certhabilidad')}}">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="glyphicon glyphicon-list-alt"></i>

                    <h3 class="box-title">CERTIFICADO DE HABILIDAD</h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p>En esta sección podra consultar sus certificados de habilidad.</p>
                        <small><i class="fa fa-hand-pointer-o"></i></small>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{route('voucher.certobra')}}">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="glyphicon glyphicon-list-alt"></i>

                    <h3 class="box-title">CERTIFICADO DE OBRA PÚBLICA</h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p>En esta sección podra consultar sus certificados de obra pública.</p>
                        <small><i class="fa fa-hand-pointer-o"></i></small>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{route('voucher.certproyecto')}}">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="glyphicon glyphicon-list-alt"></i>

                    <h3 class="box-title">CERTIFICADO DE PROYECTO</h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p>En esta sección podra consultar sus certificados de obra proyecto.</p>
                        <small><i class="fa fa-hand-pointer-o"></i></small>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let tools = new Tools();



    });
</script>

@endsection