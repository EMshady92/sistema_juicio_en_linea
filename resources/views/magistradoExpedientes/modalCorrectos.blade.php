<div class="modal fade bs-example-modal-xl" id="modalCorrectos" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de acuerdos realizados correctamente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="table-responsive" data-pattern="priority-columns">
                                <table id="tech-companies-1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipo de expediente</th>
                                            <th>Tipo de acuerdo</th>
                                            <th>Número de expediente</th>
                                            <th>Folio del acuerdo</th>
                                            <th>Estado del acuerdo</th>
                                            <th>Fecha</th>
                                            <th>Ver expediente</th>

                                        </tr>
                                    </thead>


                                    <tbody>
                                        @foreach($acuerdos_correctos as $acuerdo_correcto)

                                        <tr>
                                            <td>{{$acuerdo_correcto->tipo}}</td>
                                            <td>{{$acuerdo_correcto->tipo_acuerdo}}</td>
                                            <td>{{$acuerdo_correcto->num_expediente}}</td>
                                            <td>{{$acuerdo_correcto->num_folio}}</td>                                          
                                            <td><span class="badge badge-danger">{{$acuerdo_correcto->estado_acuerdo}}</span>
                                            </td>                                            
                                            <td><strong>{{$acuerdo_correcto->fecha}}<strong></td>
                                            <td>
                                                <a href="{{URL::action('ExpedientesController@show',$acuerdo_correcto->id)}}"
                                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                                        class="mdi mdi-eye"></i></a>
                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
    </div>
</div>