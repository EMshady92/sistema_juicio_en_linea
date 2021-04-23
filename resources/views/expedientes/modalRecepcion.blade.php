@include('users.modalPasswordRecepcion')
<div class="modal fade" id="modalAsignacion{{$expediente->id}}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recepción del expediente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/recibirExpediente/{{$expediente->id}}"
                    onsubmit="return valida_recepcion_expediente('{{$expediente->id}}');" id="form_enviar"
                    name="formularioRecepcion">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                    <label for="userName">Confirmar la recepción del expediente: {{$expediente->id}} <span
                            class="text-danger">*</span></label>
                    <div class="form-group">

                        <label for="userName">Origen:<span class="text-danger">*</span></label>
                        <input type="text" name="origen"
                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                            onkeypress="return soloLetras(event)" value="{{$expediente->ubicacion}}" maxlength="30"
                            minlength="1" parsley-trigger="change" placeholder="Ingresar el nombre" required
                            class="form-control" id="origen" required disabled>

                        <label for="userName">Destino:<span class="text-danger">*</span></label>
                        <input type="text" name="destino{{$expediente->id}}"
                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                            onkeypress="return soloLetras(event)" value="SALA {{$expediente->num_sala}}" maxlength="30"
                            minlength="1" parsley-trigger="change" placeholder="Ingresar el nombre" required
                            class="form-control" id="destino{{$expediente->id}}" required readonly>

                        <label for="userName">Lo envia:<span class="text-danger">*</span></label>
                        <input type="text" name="origen"
                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                            onkeypress="return soloLetras(event)"
                            value="{{$expediente->name}}  {{$expediente->apellido_p}} {{$expediente->apellido_m}}"
                            maxlength="30" minlength="1" parsley-trigger="change" placeholder="Ingresar el nombre"
                            required class="form-control" id="origen" required disabled>

                        <label for="userName">Lo recibe:<span class="text-danger">*</span></label>
                        <input type="text" name="origen"
                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                            onkeypress="return soloLetras(event)"
                            value="{{Auth::user()->name}}  {{Auth::user()->apellido_p}} {{Auth::user()->apellido_m}}"
                            maxlength="30" minlength="1" parsley-trigger="change" placeholder="Ingresar el nombre"
                            required class="form-control" id="origen" required disabled>

                        <div class="card-box tilebox-three">
                            <p class="text-danger mb-0 font-13">Nota: Al aceptar el expediente, se asignara a su cargo, si lo rechaza se regresara al usuario {{$expediente->name}}  {{$expediente->apellido_p}} {{$expediente->apellido_m}}.
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sexo">Que desea hacer con la asignación<span class="text-danger">*</span></label><br>
                        <select  parsley-trigger="change" name="estado_envio{{$expediente->id}}" id="estado_envio{{$expediente->id}}" required
                        class="form-control" data-toggle="select2" style="width: 100%" data-placeholder="Seleccione una opción ..." >
                            <option value='' selected>Seleccione una opción</option>
                            <option value="ACEPTAR">Aceptar la recepción del expediente</option>
                            <option value="RECHAZAR">Rechazar la recepción del expediente</option>                           
                        </select>
                        <div class="text-danger" id='error_envio' name="error_envio"></div>
                    </div>











                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary waves-effect waves-light mr-1" id="btnSubmit" type="submit">
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