<div class="modal fade bs-example-modal-xl" id="modalPendientes" tabindex="-1" role="dialog"
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
                        <div class="table-responsive" data-pattern="priority-columns">
                            <table id="key-table" class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 80%;">
                                <thead>
                                    <tr>
                                        <th>Tipo de expediente</th>
                                        <th>Número de expediente</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                        <th>Generar acuerdo</th>
                                        <th>Fecha de registro</th>
                                        <th>Ubicación</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($acuerdos_pendientes as $acuerdo_pendiente)

                                    <tr>
                                        <td>{{$acuerdo_pendiente->tipo}}</td>
                                        <td>{{$acuerdo_pendiente->num_expediente}}</td>
                                        @if($acuerdo_pendiente->estado == "ACTIVO")
                                        <td><span class="badge badge-success">{{$acuerdo_pendiente->estado}}</span></td>
                                        @else
                                        <td><span class="badge badge-danger">{{$acuerdo_pendiente->estado}}</span></td>
                                        @endif
                                        <td><strong>{{$acuerdo_pendiente->fecha}}<strong></td>
                                        <td>
                                            <a href="{{URL::action('acuerdosController@create',$acuerdo_pendiente->id)}}"
                                                class="btn waves-effect waves-light btn-secondary" role="button"><i
                                                    class="mdi mdi-account-edit-outline"></i></a>
                                        </td>
                                        <td>{{$acuerdo_pendiente->created_at}}</td>
                                        <td>{{$acuerdo_pendiente->ubicacion}}</td>

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