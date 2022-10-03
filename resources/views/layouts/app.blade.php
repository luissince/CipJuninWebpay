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
    <script src="{{asset('js/axios.js') }}"></script>
</head>


<body class="skin-blue layout-top-nav">
    <div class="wrapper" style="height: auto; min-height: 100%;">

        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{route('index')}}" class="logo">
                            <span class="logo-lg">
                                <img src="{{asset('images/cip.png')}}" width="28"> CIP VIRTUAL
                            </span>
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="navbar-collapse pull-left collapse" id="navbar-collapse" aria-expanded="false">
                        <ul class="nav navbar-nav">
                            <li class="{{ Route::currentRouteNamed('index')?'active':'' }}"><a href="{{route('index')}}">Inicio</a></li>
                            <li class="{{ Route::currentRouteNamed('login.index')?'active':'' }}"><a href="{{route('login.index')}}">Iniciar Sesión</a></li>
                            <li class="{{ Route::currentRouteNamed('search.index')?'active':'' }}"><a href="{{route('search.index')}}">Busqueda</a></li>
                            <li class="{{ Route::currentRouteNamed('register.index') ?'active':'' }}"><a href="{{route('register.index')}}">Registrarse</a></li>
                            <li class="{{ Route::currentRouteNamed('information.index') ?'active':'' }}"><a href="{{route('information.index')}}">Información</a></li>
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
                <strong>Copyright © {{date('Y')}} <a href="http://www.cip-junin.org.pe">Colegio de Ingenieros del Perú - CD Junín </a>.</strong> Todos los derechos reservados.
            </div>
            <!-- /.container -->
        </footer>
    </div>
    @yield('script')
</body>

</html>