<div class="modal fade bs-example-modal-xl" id="modalAcuerdo" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de acuerdos pendientes por generar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">                         
                            <table id="responsive-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 80%;">
                                <thead>
                                    <tr>
                                        <th>Tipo de expediente</th>
                                        <th>Número de expediente</th>
                                        <th>Asignado</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Ver expediente</th>                                       
                                        <th>Fecha de registro</th>                                                                            
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($acuerdos_por_generar as $expediente)             
                                    @if($expediente->estado == "VALIDADO")                               
                                    <tr>
                                        <td>{{$expediente->tipo}}</td>
                                        <td>{{$expediente->num_expediente}}</td>
                                        <td>{{$expediente->name}} {{$expediente->apellido_p}} {{$expediente->apellido_m}}</td>
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