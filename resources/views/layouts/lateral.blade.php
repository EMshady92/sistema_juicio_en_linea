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
<!-- Right Sidebar -->
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="mdi mdi-close"></i>
        </a>
        <h4 class="font-18 m-0 text-white">Theme Customizer</h4>
    </div>
    <div class="slimscroll-menu">
        
        <div class="p-4">
            <div class="alert alert-warning" role="alert">
                <strong>Customize </strong> the overall color scheme, layout, etc.
            </div>
            <div class="mb-2">
                <img src="assets/images/layouts/light.png" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="light-mode-switch" checked />
                <label class="custom-control-label" for="light-mode-switch">Light Mode</label>
            </div>
            
            <div class="mb-2">
                <img src="assets/images/layouts/dark.png" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-3">
                <input type="checkbox" class="custom-control-input theme-choice" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" 
                    data-appStyle="assets/css/app-dark.min.css" />
                <label class="custom-control-label" for="dark-mode-switch">Dark Mode</label>
            </div>
            
            <div class="mb-2">
                <img src="assets/images/layouts/rtl.png" class="img-fluid img-thumbnail" alt="">
            </div>
            <div class="custom-control custom-switch mb-5">
                <input type="checkbox" class="custom-control-input theme-choice" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css" />
                <label class="custom-control-label" for="rtl-mode-switch">RTL Mode</label>
            </div>

            <a href="https://1.envato.market/XY7j5" class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-download mr-1"></i> Download Now</a>
        </div>
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<a href="javascript:void(0);" class="right-bar-toggle demos-show-btn">
    <i class="mdi mdi-settings-outline mdi-spin"></i> &nbsp;Choose Demos
</a>
            <div class="content" id="contenido">


                @yield('contenido')

                <!-- Start Content-->



            </div> <!-- end content -->



            <!-- Footer Start -->

            <!-- end Footer -->

        </div>
       
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