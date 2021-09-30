<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('images/insignia.png')}}">

    <title>@yield('title')</title>
    <meta name="description" content="Inicia sesión en el Cip Virtual para poder ver el estado de sus cuotas, visualizar boletas y facturas, realizar pagos de sus cuotas y tramitar sus certificados(A,B,C).">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/themes/semantic.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/sweetalert.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <!-- eliminar en caso falle-->
    <!-- jQuery 3 -->
    <script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.js')}}"></script>
    <!-- Select 2 -->
    <script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('adminlte/bower_components/chart.js/Chart.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('adminlte/dist/js/demo.js')}}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="{{asset('js/payment.js')}}"></script>
    <script src="{{asset('js/tools.js') }}"></script>
</head>

<body class="skin-blue layout-top-nav">
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{route('index')}}" class="logo">
                            <span class="logo-lg">
                                <img src="{{asset('images/cip.png')}}" width="28"> CIP CD JUNÍN
                            </span>
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false">
                        <ul class="nav navbar-nav">
                            <li class="{{ Route::currentRouteNamed('index')?'active':'' }}"><a href="{{route('index')}}">Inicio</a></li>
                            <li class="{{ Route::currentRouteNamed('service.index')?'active':'' }}"><a href="{{route('service.index')}}">Servicios</a></li>
                            <li class="{{ Route::currentRouteNamed('voucher.index')?'active':'' }}"><a href="{{route('voucher.index')}}">Comprobantes</a></li>
                        </ul>
                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="{{asset('images/usuario.png')}}" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">ING.</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="{{asset('images/usuario.png')}}" class="img-circle" alt="User Image">
                                        <p>
                                            {{$persona->Apellidos}} {{$persona->Nombres}}
                                            <small>{{$persona->Especialidad}}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{route('login.logout')}}" class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
        <!-- Full Width Column -->
        <div class="content-wrapper" style="min-height: 528px;">
            <div class="container">
                <!-- Main content -->
                <section class="content">
                    @yield('content')
                </section>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.0
                </div>
                <strong>Copyright © 2021 <a href="http://www.cip-junin.org.pe">Colegio de Ingenieros del Perú - CD Junín </a>.</strong> Todos los derechos reservados.
            </div>
            <!-- /.container -->
        </footer>
    </div>
</body>


</html>