@extends('layouts.principal')
@section('contenido')



<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      
                    </ol>
                </div>
                <h4 class="page-title"></h4>
                <!-- <a href="" class="button-list">
                    <button type="button" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                        </span></button>
                </a> -->
            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title"> Hola {{$user->name}} bienvenido al Sistema Integral de Manejo de Expedientes</h4>

                
               
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop