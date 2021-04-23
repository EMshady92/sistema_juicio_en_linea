<div class="modal fade" id="modal{{$expediente->id_expediente_sala}}" name="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar expediente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="{{ url('editarExpediente',[$expediente->id_expediente_sala]) }}" method="post"  id="formulario">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group">

                        <label for="userName">Seleccione personal<span class="text-danger">*</span></label>
                        <select class="form-control" data-toggle="select2" style="width: 100%"  name="personal{{$expediente->id_expediente_sala}}"
                            id="personal{{$expediente->id_expediente_sala}}" data-placeholder="Seleccione una opción ..." required>
                            <option value="" selected>Seleccione una opción</option>
                            @foreach($personas as $personas)
                            <option value="{{$personas->id}}">{{$personas->name}} {{$personas->apellido_p}} {{$personas->apellido_m}}</option> 
                            @endforeach
                        </select>
                    </div>

                                
                        <div class="form-group">
                            <label for="userName">Agregar observaciónes<span class="text-danger">*</span></label>
                            <input type="text" name="observaciones{{$expediente->id_expediente_sala}}" parsley-trigger="change"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                 placeholder="Observaciónes"
                                class="form-control" id="observaciones{{$expediente->id_expediente_sala}}">
                        </div>
                               

                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit" id="submit{{$expediente->id_expediente_sala}}">
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