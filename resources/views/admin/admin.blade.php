@extends('layouts.admin')

@section('title','CIP VIRTUAL - JUNÍN')

@section('content')

<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
      <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{$image==''?asset('images/usuario.png'):$image}}" alt="User profile picture">

        <h3 class="profile-username text-center"> {{$persona->Apellidos}} {{$persona->Nombres}}</h3>

        <p class="text-muted text-center">{{$persona->Especialidad}}</p>
        <p class="text-muted text-center">N° CIP: {{$persona->CIP}}</p>
        <p class="text-muted text-center">{{$persona->Condicion}}</p>

        <ul class="list-group list-group-unbordered">
          <li class="list-group-item">
            <b>Deuda</b> <a class="pull-right">S/ {{ number_format(round($deuda, 2, PHP_ROUND_HALF_UP), 2, '.', '')}}</a>
          </li>
          <li class="list-group-item">
            <b>Ultima Cuota</b> <a class="pull-right">{{date("m/Y", strtotime($persona->FechaUltimaCuota)) }}</a>
          </li>
          <li class="list-group-item">
            <b>Habil hasta</b> <a class="pull-right">{{date("m/Y", strtotime($persona->HabilitadoHasta)) }}</a>
          </li>
        </ul>

        <a href="#" class="btn btn-block {{$persona->Habilidad == 1 ? 'btn-success' : 'btn-danger'}}"><b>{{$persona->Habilidad == 1 ? "HABILITADO":"NO HABILITADO"}}</b></a>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#activity" data-toggle="tab">Noticias</a></li>
      </ul>
      <div class="tab-content">
        <div class="active tab-pane" id="activity">
          <!-- Post -->
          <div class="post">
            <div class="user-block">
              <img class="img-circle img-bordered-sm" src="{{asset('images/insignia.png')}}" alt="user image">
              <span class="username">
                <a href="#">CIP CD JUNÍN.</a>
                <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
              </span>
              <span class="description">Compartido públicamente - 7:30 PM AHORA</span>
            </div>
            <!-- /.user-block -->
            <p>
              Gracias por comenzar a usar la plataforma del cip virtual, ahora podra realizar el pago de sus cuotas y tramite de sus certificados desde aquí.
            </p>
          </div>
          <!-- /.post -->
        </div>
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

@endsection