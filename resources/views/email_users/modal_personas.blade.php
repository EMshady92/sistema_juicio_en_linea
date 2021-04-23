<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="javascript:modal_personas();"  id="formulario_personas">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                        <div class="form-group">
                            <label for="userName">Nombre<span class="text-danger">*</span></label>
                            <select class="form-control" style="width: 100%" name="id_personas[]"
                                data-placeholder="Seleccione una opción ..."
                                id="id_personas" required
                                data-toggle="select2">
                                @foreach($personas as $persona)
                                <option value="{{$persona->id}}" selected>{{$persona->nombre}} {{$persona->apellido_paterno}} {{$persona->apellido_materno}}</option>
                                @endforeach
                                <option value="" selected>Selecciona una opción... </option>
                            </select>
                            <div class="text-danger" id='error_sala_asg' name="error_sala_asg"></div>
                        </div> 

                        <div class="form-group">
                            <label for="emailAddress">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" parsley-trigger="change" required
                                placeholder="Ingresar el email" class="form-control" id="email">
                                <div class="text-danger" id='error_emailactor' name="error_emailactor" ></div>
                        </div>

                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
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

