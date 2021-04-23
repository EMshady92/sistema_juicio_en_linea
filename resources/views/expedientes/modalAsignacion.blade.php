@include('users.modalPassword')
<div class="modal fade" id="modalAsignacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Enviar expediente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">      
                <form method="POST" action="/enviarExpediente/{{$expediente->id}}" onsubmit="return valida_envio_expediente();"
                    id="form_enviar" name="formulario">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">


                    <div class="form-group">
                        <label for="userName">Seleccione el usuario al que desea enviar el expediente<span class="text-danger">*</span></label>
                        <select class="form-control" data-toggle="select2" style="width: 100%" name="user" id="user"
                            data-placeholder="Seleccione una opción ..." required>
                        </select>
                        <div class="card-box tilebox-three">                               
                                    <p class="text-danger mb-0 font-13">Nota: El usuario al que le envié el expediente, deberá aceptar el envió para poder completar la acción.</p>
                        </div>
                    </div>

                 
                







                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                        <button class="btn btn-primary waves-effect waves-light mr-1" id="btnSubmit"
                                            type="submit">
                                            Guardar
                                        </button>
                            <button data-dismiss="modal" class="btn btn-secondary waves-effect">
                                Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>