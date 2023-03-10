@php
  session_start();

@endphp
@if (!empty($_SESSION) and strtoupper($_SESSION['cargo']) == 'ADMINISTRADOR' )
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ADMIN</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <!--link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"-->
    <!--link href="{{asset('css/all.min.css')}}" rel="stylesheet"-->
    <!--link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"-->
    <link href="{{asset('font-awesome47/css/font-awesome.min.css')}}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <!--div class="position-relative">
                        <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div-->
                    <div class="ms-3">
                        <h6 class="mb-0">{{$_SESSION["nombre"]." ".$_SESSION["ap_pat"]}}</h6>
                        <span>{{$_SESSION['cargo']}}</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a class="nav-item nav-link active"><i class="fa fa-dashboard me-2"></i>Dashboard</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th-list me-2"></i>Funcionario</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{url('/crearFuncionario')}}" class="dropdown-item">Nuevo Funcionario</a>
                            <a href="{{url('/actualizarFuncionarioProducto')}}" class="dropdown-item">Actualizar Datos</a>
                            <a id="listar-funcionarios" class="dropdown-item">Listar Funcionarios</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-th me-2"></i>Producto</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="{{url('/registroProducto')}}" class="dropdown-item">Nuevo Producto</a>
                            <a href="{{url('/actualizarProducto')}}" class="dropdown-item">Actulizar Produc.</a>
                            <a id="listar-productos" class="dropdown-item">Listar Productos</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-th me-2"></i>Reportes</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a id="item-reporte-casjas" class="dropdown-item" data-toggle="modal" data-target="#staticBackdrop">Reporte Cajas</a>
                        </div>
                    </div>
                    <a href="#" class="nav-item nav-link" id="cerrar-session-admin"><i class="fa fa-user me-2"></i>Cerrar Sesion</a>
                    <!--div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="signin.html" class="dropdown-item">Sign In</a>
                            <a href="signup.html" class="dropdown-item">Sign Up</a>
                            <a href="404.html" class="dropdown-item">404 Error</a>
                            <a href="blank.html" class="dropdown-item">Blank Page</a>
                        </div>
                    </div-->
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
        
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0">Chifa el Leito</h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <!--form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search">
                </form-->
                <div class="navbar-nav align-items-center ms-auto">
                    <!--div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">New user added</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Password changed</h6>
                                <small>15 minutes ago</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown text-right">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex">John Doe</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div-->
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-line-chart fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2" >Total Venta hoy</p>
                                <h6 class="mb-0" id="totalVentaHoy">Bs. 0</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-calendar-check-o fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Ventas del Mes</p>
                                <h6 class="mb-0" id="totalVentaMes">Bs. 0</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sale & Revenue End -->


            <!-- Sales Chart Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Productos mas vendidos</h6>
                                <!--a href="">Show All</a-->
                            </div>
                            <div id="dona-reporte-venta-producto" class="text-center" style="width: 400px !important; height: 500px !important;">
                                <canvas id="worldwide-sales" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales Chart End -->


            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4" >
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0" id="titulo-lista-funcionario-producto"></h6>
                    </div>
                    <div class="table-responsive" id="tabla-scroll-funcionario-producto">
                        <table class="table text-start align-middle table-bordered table-hover mb-0" style="overflow-x: hidden; overflow-y: scroll;">
                            <thead id="cabecera-lista-funcionario-producto">
                                <!--tr class="text-dark">
                                    <th scope="col">No.</th>
                                    <th scope="col">Nombre Completo</th>
                                    <th scope="col">CI</th>
                                    <th scope="col">Fec Nac.</th>
                                    <th scope="col">Tel/Cel</th>
                                    <th scope="col">Domicilio</th>
                                    <th scope="col">Cod. Funcionario</th>
                                    <th scope="col">Cargo</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr-->
                            </thead>
                            <tbody id="cuerpo-lista-funcionario-producto">
                                <!--tr>
                                    <td>1</td>
                                    <td>Juan Brian Salamanca Alvares</td>
                                    <td>8547262</td>
                                    <td>24/02/1989</td>
                                    <td>78452219</td>
                                    <td>Villa Pabon Calle Tte. Rosendo Villa #1515</td>
                                    <td>JSM262</td>
                                    <td>Administrador</td>
                                    <td>jsalamanca007@hmail.com</td>
                                    <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                                </tr-->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Recent Sales End -->

        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!--Modal de Formulario-->        
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalAdmin">Introduzca el Rango de Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form>
                        @csrf
                        <div class="form-group">
                          <label for="rango-fecha-inicial">Fecha Incial</label>
                          <input type="date" class="form-control" id="rango-fecha-inicial" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                          <label for="rango-fecha-final">Fecha Final</label>
                          <input type="date" class="form-control" id="rango-fecha-final">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar-modal-reporte-rango-admin">Cerrar</button>
                <button type="button" class="btn btn-primary" id="generar-reporte-rango-adim">Generar</button>
                </div>
            </div>
            </div>
        </div>
    <!--Fin Modal de Formulario-->

    <!-- JavaScript Libraries -->
    <script src="{{asset("jquery/jquery-3.6.3.min.js")}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('lib/chart/chart.min.js')}}"></script>
    <script src="{{asset('lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{asset('lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('jquery/jquery-admin.js')}}"></script>

    <script>
        var url_cerrar_session = "{{url('/cerrarSession')}}";
        var url_login = '{{url("/login")}}';
    </script>
</body>
</html>
@else
  <script>
    window.location.href='{{url("/login")}}';
  </script>
@endif
<script>
  var url_aceptar= '{{url("/buscarProductos")}}';
  var url_cerrar_session = '{{url("/cerrarSession")}}';
  var url_reporte_arqueo_funcionario = '{{url("/reporteArqueoFuncionario")}}';
  var url_login = '{{url("/")}}';
  var url_principal= '{{url("/")}}';
  var url_imprimir = '{{url("/imprimirDetalleVentaFuncionario")}}';
  var url_actualizacionDeDatos = '{{url("/actualizacionDeDatos")}}';
  var url_reporte_rango_cajas_admin='{{url("/reporteRangoFechasCajasAdmin")}}'
  var url_listar_funcionario_productos='{{url("/listarFuncionariosProductos")}}'
</script>