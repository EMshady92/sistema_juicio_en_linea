<div class="modal fade" id="modal_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="javascript:validaPassword();" id="formulario_pass" name="formulario_pass" >
         
                    
                   

                        <div class="form-group">
                            <label for="userName">Ingrese su contraseña de inicio del sistema sit-zac.org.mx<span class="text-danger">*</span></label>
                            <input type="password" name="mypassword"
                                maxlength="60" minlength="1"
                                parsley-trigger="change" required placeholder="Ingresa la contraseña" class="form-control"
                                id="mypassword">
                                <div class="text-danger" id='error_pass' name="error_pass" ></div>
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