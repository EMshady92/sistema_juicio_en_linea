<div class="modal fade bs-example-modal-xl" id="modalValidar" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de expedientes pendientes por validar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">                        
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 80%;">
                                <thead>
                                    <tr>
                                        <th>Tipo de expediente</th>
                                        <th>Número de expediente</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Ver expediente</th>                                       
                                        <th>Fecha de registro</th>
                                        <th>Ubicación</th>                                      
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($expedientes as $expediente)    
                                    @if($expediente->estado == "POR_VALIDAR")                               
                                    <tr>
                                        <td>{{$expediente->tipo}}</td>
                                        <td>{{$expediente->num_expediente}}</td>
                                        @if($expediente->estado == "ACTIVO")
                                        <td><span class="badge badge-success">{{$expediente->estado}}</span></td>
                                        @else
                                        <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                                        @endif
                                        <td><strong>{{$expediente->fecha}}<strong></td>
                                        <td>
                                            <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                                class="btn waves-effect waves-light btn-info" role="button"><i
                                                    class="mdi mdi-eye"></i></a>
                                        </td>                                       
                                        <td>{{$expediente->created_at}}</td>
                                        <td>{{$expediente->ubicacion}}</td>                                       

                                    </tr>
                                    @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
    </div>
</div>