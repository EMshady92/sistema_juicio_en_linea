<div class="modal fade bs-example-modal-xl" id="modalEscrito{{$expediente->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Escrito inicial de demanda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <div class="row">

                    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title">Expediente {{$expediente->num_expediente}}</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">


                                    <tr class="bg-white text-dark">
                                        <th>Número de anexos: </th>
                                        <td id="hojas_anexo"><select class="form-control " style="width: 100%"
                                                data-toggle="select2" name="hojas_anexo[]" id="hojas_anexo"
                                                multiple="multiple" disabled>
                                                <option value="{{$expediente->id}}" selected>
                                                    {{$expediente->num_anexos}}
                                                </option>

                                            </select></td>
                                    </tr>

                                    <tr class="bg-white text-dark">
                                        <th>Hojas de escrito: </th>
                                        <td id="hojas_escrito"><select class="form-control " style="width: 100%"
                                                name="hojas_escrito[]" id="hojas_escrito" data-toggle="select2"
                                                multiple="multiple" disabled>
                                                <option value="{{$expediente->id}}" selected>
                                                    {{$expediente->hojas_escrito}}
                                                </option>

                                            </select></td>
                                    </tr>

                                    <tr class="bg-white text-dark">
                                        <th>Hojas de traslados: </th>
                                        <td id="hojas_traslados"><select class="form-control " style="width: 100%"
                                                name="hojas_traslados[]" id="hojas_traslados" data-toggle="select2"
                                                multiple="multiple" disabled>
                                                <option value="{{$expediente->id}}" selected>
                                                    {{$expediente->hojas_traslados}}
                                                </option>

                                            </select></td>
                                    </tr>



                                    <tr class="bg-white text-dark">
                                        <th>Escaneo escrito: </th>
                                        <td id="hojas_traslados">
                                            <a href='/OFICIALIA/archivos/ingresos/{{$expediente->escaneo_escrito}}'
                                                target="_blank" class="btn waves-effect waves-light btn-info btn-sm"
                                                role="button">
                                                <i class="fas fa-file-pdf"></i></a>
                                        </td>
                                    </tr>


                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                
                <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Anexos</h4>
                                @if($escaneos)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Tipo de documento</th>
                                                <th>Forma</th>
                                                <th>N° Anexo</th>
                                                <th>N° Hojas</th>
                                                <th>Ver anexo</th>
                                                <th>Fecha de captura</th>                                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($escaneos as $escaneo)
                                            <tr>
                                                <td>{{$escaneo->tipo}}</td>
                                                <td>{{$escaneo->forma}}</td>
                                                <td>{{$escaneo->num_anexo}}</td>
                                                <td>{{$escaneo->num_hojas}}</td>
                                                <td><a href='/OFICIALIA/archivos/ingresos/{{$escaneo->escaneo_anexos}}'
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        role="button" target="_blank">
                                                        <i class="mdi mdi-eye"></i></a></td>
                                                <td>{{$escaneo->created_at}}</td>                                                                                  
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-warning" role="alert">
                                    <strong>Lo sentimos!</strong> No hay anexos registrados en este
                                    expediente.
                                </div>
                                @endif


                            </div>

                        </div>

                    </div>
                    <!--FIN ROW ANEXOS-->
                    <button data-dismiss="modal" class="btn btn-secondary waves-effect">
                Cerrar
            </button>
            </div>

           
        </div>

    </div>
</div>