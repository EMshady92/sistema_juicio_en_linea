<div class="modal fade bs-example-modal-xl" id="modalCorreciones" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de acuerdos con correciónes por realizar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                        <div class="table-responsive" data-pattern="priority-columns">
                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 80%;">
                                <thead>
                                    <tr>
                                        <th>Tipo de expediente</th>
                                        <th>Tipo de acuerdo</th>
                                        <th>Número de expediente</th>
                                        <th>Folio del acuerdo</th>
                                        <th>Estado del acuerdo</th>
                                        <th>Fecha</th>
                                        <th>Corregir acuerdo</th>
                                                                      
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($acuerdos_correciones as $acuerdo_correcion)

                                    <tr>
                                        <td>{{$acuerdo_correcion->tipo}}</td>
                                        <td>{{$acuerdo_correcion->tipo_acuerdo}}</td>
                                        <td>{{$acuerdo_correcion->num_expediente}}</td>
                                        <td>{{$acuerdo_correcion->num_folio}}</td>                                      
                                        <td><span class="badge badge-danger">{{$acuerdo_correcion->estado_acuerdo}}</span></td>                                        
                                        <td><strong>{{$acuerdo_correcion->fecha}}<strong></td>
                                        <td>
                                            <a href="{{URL::action('acuerdosController@edit',$acuerdo_correcion->id_acuerdo)}}"
                                                class="btn waves-effect waves-light btn-secondary" role="button"><i
                                                    class="mdi mdi-account-edit-outline"></i></a>
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