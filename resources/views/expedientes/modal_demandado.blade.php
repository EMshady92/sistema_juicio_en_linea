<div class="modal fade" id="modal_demandado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nueva autoridad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="javascript:modal_demandado();" id="formulario_demandado" onsubmit="return valida_nombreAutoridad('0');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    
                   

                        <div class="form-group">
                            <label for="userName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="nombre_demandado"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" onchange="valida_nombreAutoridad('0');" maxlength="60" minlength="1"
                                parsley-trigger="change" required placeholder="Ingresar el nombre" class="form-control"
                                id="nombre_demandado">
                                <div class="text-danger" id='error_nombre' name="error_nombre" ></div>
                        </div>

                       

                  

                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary waves-effect waves-light mr-1"  id="submit"  type="submit">
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