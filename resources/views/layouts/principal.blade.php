@inject('metodo','App\Http\Controllers\ExpedientesController')
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Sistema Integral de Manejo de Expedientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />

    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="">

    <!-- Table datatable css -->

    {!! Html::style('assets/libs/datatables/dataTables.bootstrap4.min.css') !!}

    {!!Html::style('assets/libs/datatables/buttons.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/responsive.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/select.bootstrap4.min.css')!!}




    <!-- App css -->

    {!!Html::style('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.css')!!}
    {!!Html::style('assets/libs/dropify/dropify.min.css')!!}
    {!!Html::style('assets/libs/custombox/custombox.min.css')!!}
    {!!Html::style('assets/css/bootstrap.min.css')!!}
    {!!Html::style('assets/libs/select2/select2.min.css')!!}
    {!!Html::style('assets/libs/multiselect/multi-select.css')!!}
    {!!Html::style('assets/css/icons.min.css')!!}
    {!!Html::style('assets/css/app.min.css')!!}
    {!!Html::style('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')!!}

    {!!Html::style('assets/libs/datatables/dataTables.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/buttons.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/responsive.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/select.bootstrap4.min.css')!!}

    {!!Html::script('js/script.js')!!}
    {!!Html::script('js/vendor/jquery.min.js')!!}
    {!!Html::script('js/vendor/bootstrap.js')!!}
    {!!Html::script('js/vendor/bootstrap.bundle.js')!!}

    <!-- SWEET ALERT -->
    {!!Html::script('assets/libs/sweetalert2/sweetalert2.min.css')!!}

    <!-- Plugins css -->
    {!!Html::style('assets/libs/switchery/switchery.min.css')!!}
    {!!Html::style('assets/libs/jstree/style.css')!!}






</head>

<body onload="Home();">

    <!-- Begin page -->
    <div id="wrapper">


        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                @if (Auth::guest())
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-none d-sm-inline-block ml-1 font-weight-medium" id="etiq_name">Inicia
                            Sesión</span>
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow text-white m-0">Bienvenido !</h6>
                        </div>

                        <!-- item-->


                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="/auth/logout" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Iniciar sesión</span>
                        </a>

                        <!-- item-->
                        <a href="/auth/register" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Registrarse</span>
                        </a>

                    </div>
                </li>


                
              
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="mdi mdi-bell-outline noti-icon"></i>
                        <span class="noti-icon-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h5 class="font-16 text-white m-0">
                                <span class="float-right">
                                </span>Mis expedientes
                            </h5>
                        </div>
                                               
                        <div class="slimscroll noti-scroll">
                                 
                          
                          
                        </div>
                        <a href="javascript:void(0);" class="dropdown-item text-primary notify-item notify-all">
                            Ver todos mis expedientes
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>
              


                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-none d-sm-inline-block ml-1 font-weight-medium" id="etiq_name">
                            @if(Auth::user()->sexo == 'FEMENINO')
                            @if(Auth::user()->funcion == 'SECRETARIO AUXILIAR')
                            SECRETARIA AUXILIAR: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @elseif(Auth::user()->funcion == 'SECRETARIA GENERAL DE ACUERDOS')
                        SECRETARIA GENERAL DE ACUERDOS: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @elseif(Auth::user()->funcion == 'SECRETARIO DE ESTUDIO Y CUENTA')
                        SECRETARIA DE ESTUDIO Y CUENTA: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @elseif(Auth::user()->funcion == 'ACTUARIO')
                        ACTUARIA: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @elseif(Auth::user()->funcion == 'COORDINADOR')
                        COORDINADORA: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }} </span>
                        @elseif(Auth::user()->funcion == 'MAGISTRADO')
                        MAGISTRADA: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }} </span>
                        @else
                        {{ Auth::user()->funcion }}: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @endif

                        @else
                        {{ Auth::user()->funcion }}: {{ Auth::user()->name }} {{ Auth::user()->apellido_p }}</span>
                        @endif
                        <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow text-white m-0">Bienvenido !</h6>
                        </div>

                        <!-- item-->


                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="/auth/logout" class="dropdown-item notify-item">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Logout</span>
                        </a>

                    </div>
                </li>
                @endif



            </ul>

            <!-- LOGO -->
            <div class="logo-box">
                <a href="/" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="../../img/LogoTJA.png" style="width: 90%;">
                        <!-- <span class="logo-lg-text-dark">Uplon</span> -->
                    </span>
                    <span class="logo-sm">
                        <!-- <span class="logo-lg-text-dark">U</span> -->
                        <img src="" style="width: 80%;">
                    </span>
                </a>

            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>




            </ul>
            <h3 style="color: white;padding-top: 10px;">Sistema Integral de Manejo de Expedientes</h3>
        </div>
        <!-- end Topbar -->


        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu">

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <ul class="metismenu" id="side-menu">

                        <li class="menu-title">Navegación</li>
                        @if(Auth::user()->funcion == "OFICIALIA PARTES" || Auth::user()->funcion == "ADMINISTRADOR")
                        <li>
                            <a href="javascript: void(0);">
                                <i class="ion ion-md-business"></i>
                                <span>Oficialia de partes </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="/expedientes/create">Nuevo ingreso</a></li>
                                <li><a href="/expedientes">Expedientes</a></li>
                                <li><a href="/amparos_promociones">Promociones</a></li>
                                <li><a href="/generalidades">Generalidades/Otros</a></li>
                                <li><a href="/estadisticas_ofi">Estadísticas</a></li>

                            </ul>

                        </li>
                        @endif
                        @if(Auth::user()->funcion == "ACTUARIO" || Auth::user()->funcion == "ADMINISTRADOR")
                        <li>
                            <a href="javascript: void(0);">
                                <i class="ion ion-md-reorder"></i>
                                <span>Actuarios </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="/">Ver</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || Auth::user()->funcion ==
                        "SECRETARIO AUXILIAR" || Auth::user()->funcion == "PROYECTISTA" || Auth::user()->funcion ==
                        "ADMINISTRADOR")
                        <li>
                            <a href="javascript: void(0);">
                                <i class="ion ion-md-reorder"></i>
                                <span>Salas </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="/magistradoExpedientes">Expedientes</a></li>
                                <li><a href="/asignaciones">Asignaciones</a></li>
                                <li><a href="/acuerdos">Acuerdos</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->funcion != "ACTUARIO")
                        <li>
                            @if(Auth::user()->funcion == "ADMINISTRADOR")
                            <a href="javascript: void(0);">
                                <i class="ion ion-md-people"></i>
                                <span> Catálogos </span>
                                <span class="menu-arrow"></span>
                            </a>
                            @endif
                            <ul class="nav-second-level" aria-expanded="false">
                                @if(Auth::user()->funcion == "OFICIALIA PARTES" || Auth::user()->funcion ==
                                "ADMINISTRADOR")
                                <li><a href="/personas">Personas/Autoridades</a></li>
                                <li><a href="/subdependencias">Sub Dependencias</a></li>
                                @endif

                                @if(Auth::user()->funcion == "ADMINISTRADOR")
                                <li><a href="/salasMagistrado">Salas</a></li>
                                <li><a href="/personalSala">Asignación Salas</a></li>
                                <li><a href="/acuerdos_tipos">Tipos de Acuerdos</a></li>
                                @endif
                                @if(Auth::user()->funcion == "ADMINISTRADOR")
                                <li><a href="/tipos_juicios">Tipos de Juicios</a></li>
                                <li><a href="/tiposFalta">Tipos de Faltas</a></li>
                                <li><a href="/tiposDocumentos">Tipos de Documentos</a></li>
                                <li><a href="/tipos_actos">Tipos de Actos</a></li>
                                <li><a href="/tipos_promociones">Tipos de Promociónes</a></li>
                                <li><a href="/tiposDocumentos">Tipos de Documentos</a></li>
                            @endif
                               
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->funcion == "ADMINISTRADOR")
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fas fa-tools"></i>
                                <span> Ajustes </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                <li><a href="/users">Usuarios</a></li>
                                <li><a href="/historial_usuarios">Historial de usuarios</a></li>
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->funcion == "MAGISTRADO" || Auth::user()->funcion == "COORDINADOR" ||
                        Auth::user()->funcion == "SECRETARIA GENERAL DE ACUERDOS" || Auth::user()->funcion ==
                        "ADMINISTRADOR")
                        <li>
                            <a href="javascript: void(0);">
                                <i class="fas fa-pen-alt"></i>
                                <span> Firma electrónica </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                @if( Auth::user()->funcion == "ADMINISTRADOR")

                                <li><a href="/firmaElectronica">Firmas electronicas</a></li>
                                <li><a href="/firmaElectronica/create">Registro de firma electronica</a></li>
                                <li><a href="/firmasEmitidas">Ver firmas emitidas</a></li>
                                @endif

                                <li><a href="/misFirmas">Documentos firmados</a></li>
                                <li><a href="/firmarDocumento">Firmar documentos</a></li>
                                <li><a href="/revocarDocumentos">Cancelar documentos</a></li> 
                                <li><a href="/validadoc" target="_blank">Validar documentos</a></li> 
                                <li><a href="/validarFirma">Validar firmas</a></li> 
                                <li><a href="/estadisticasfirmas">Estadísticas firmas</a></li>  
                            </ul>
                        </li>
                        @endif



                    </ul>

                </div>

                <!-- End Sidebar -->

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">

            @if(Session::has('errors'))
            <div class="alert alert-warning  alert-dismissible fade show mt-4 bt-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


                <strong>{{$errors}}.</strong>


            </div>
            @endif

            @if(Session::has('success'))
            <div class="alert alert-success  alert-dismissible fade show mt-4 bt-4" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


                <strong>{{$success}}.</strong>


            </div>
            @endif








            <div class="content" id="contenido">


                @yield('contenido')

                         

                <!-- Start Content-->



            </div> <!-- end content -->



            <!-- Footer Start -->

            <!-- end Footer -->

        </div>
        <div class="modal fade" id="modal_temp">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">

                    </div>

                    <!-- Modal body -->
                    <div class="modal-body" id="modal_content">

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <!-- END wrapper -->

    <!-- Right Sidebar -->

    <!-- Plugin js-->
    {!!Html::script('assets/libs/parsleyjs/parsley.min.js')!!}
    <!-- Vendor js -->

    {!!Html::script('assets/js/vendor.min.js')!!}
    {!!Html::script('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')!!}
    {!!Html::script('assets/libs/multiselect/jquery.multi-select.js')!!}
    {!!Html::script('assets/libs/select2/select2.min.js')!!}
    {!!Html::script('assets/libs/jquery-mockjax/jquery.mockjax.min.js')!!}
    {!!Html::script('assets/libs/custombox/custombox.min.js')!!}

    {!!Html::script('assets/libs/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('assets/libs/datatables/dataTables.bootstrap4.min.js')!!}

    {!!Html::script('assets/libs/datatables/dataTables.responsive.min.js')!!}
    {!!Html::script('assets/libs/datatables/responsive.bootstrap4.min.js')!!}

    {!!Html::script('assets/libs/datatables/dataTables.buttons.min.js')!!}
    {!!Html::script('assets/libs/datatables/buttons.bootstrap4.min.js')!!}

    {!!Html::script('assets/libs/jszip/jszip.min.js')!!}
    {!!Html::script('assets/libs/pdfmake/pdfmake.min.js')!!}
    {!!Html::script('assets/libs/pdfmake/vfs_fonts.js')!!}
    {!!Html::script('assets/libs/datatables/buttons.html5.min.js')!!}
    {!!Html::script('assets/libs/datatables/buttons.print.min.js')!!}
    {!!Html::script('assets/libs/datatables/dataTables.keyTable.min.js')!!}
    {!!Html::script('assets/libs/datatables/dataTables.select.min.js')!!}
    {!!Html::script('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')!!}
    <!-- Datatables init -->
    {!!Html::script('assets/js/pages/datatables.init.js')!!}
    <!-- App js -->
    {!!Html::script('assets/js/pages/form-advanced.init.js')!!}
    {!!Html::script('assets/libs/dropify/dropify.min.js')!!}
    {!!Html::script('assets/js/pages/form-fileuploads.init.js')!!}
    <!-- App js -->
    {!!Html::script('assets/js/app.min.js')!!}
    <!-- Validation init js-->
    {!!Html::script('assets/js/pages/form-validation.init.js')!!}
    <!-- Sweet Alerts js -->
    {!!Html::script('assets/libs/sweetalert2/sweetalert2.min.js')!!}
    <!-- Sweet alert init js-->
    {!!Html::script('assets/js/pages/sweet-alerts.init.js')!!}
    {!!Html::script('https://cdn.jsdelivr.net/npm/sweetalert2@10')!!}


    {!!Html::script('aassets/libs/switchery/switchery.min.js')!!}
    {!!Html::script('assets/libs/jquery-quicksearch/jquery.quicksearch.min.js')!!}
    {!!Html::script('assets/libs/autocomplete/jquery.autocomplete.min.js')!!}
    {!!Html::script('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')!!}

    <!-- jstree js -->
    {!!Html::script('assets/libs/jstree/jstree.min.js')!!}
    {!!Html::script('assets/js/pages/treeview.init.js')!!}


    <!--Form Wizard-->
    {!!Html::script('assets/libs/jquery-steps/jquery.steps.min.js')!!}
    {!!Html::script('assets/libs/jquery-validation/jquery.validate.min.js')!!}
    {!!Html::script('assets/js/pages/form-wizard.init.js')!!}

    <!--CK EDITOR-->
    {!!Html::script('assets/vendor/ckeditor/ckeditor.js')!!}
    <!-- Plugins js -->
    {!!Html::script('assets/libs/jquery-mask-plugin/jquery.mask.min.js')!!}
    {!!Html::script('assets/libs/autonumeric/autoNumeric.min.js')!!}








    @yield('javascript')






</body>

</html>