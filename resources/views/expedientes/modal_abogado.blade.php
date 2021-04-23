<div class="modal fade" id="modal_abogado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo abogado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="javascript:modal_abogado();" id="formulario_abogado">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    

 
                        <div class="form-group">
                            <label for="userName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="nombre_abogado"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                parsley-trigger="change" required placeholder="Ingresar el nombre" class="form-control"
                                id="nombre_abogado">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                            <input type="text" name="apellidoPaternoAbogado" parsley-trigger="change" required
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido paterno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoPaternoAbogado">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                            <input type="text" name="apellidoMaternoAbogado" parsley-trigger="change"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido materno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoMaternoAbogado">
                        </div>

                        <div class="form-group">
                                    <label for="sexo">Sexo<span class="text-danger">*</span></label><br>
                                    <select class="form-control" name="sexo" onchange="valida_sexo();" id="sexo" required
                                        data-toggle="">
                                        <option value="" selected>Seleccione una opción</option>
                                        <option value="MASCULINO">Masculino</option>
                                        <option value="FEMENINO">Femenino</option>
                                    </select>
                                    <div class="text-danger" id='error_email' name="error_email" ></div>
                        </div>

                
                        

                        <div class="form-group">
                            <label for="userName">Número de Cedula<span class="text-danger">*</span></label>
                            <input type="text" name="cedulaAbogado" parsley-trigger="change" onchange="valida_cedula_abogado('0');valida_sexo();"
                                 onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                 placeholder="Ingrese número de Cedula, maximo 8 digitos" onkeypress="return soloNumeros(event)" maxlength="8"
                                 class="form-control" id="cedulaAbogado" required>
                                 <div class="text-danger" id='error_num_cedula' name="error_num_cedula" ></div>    
                         </div>

                         <div class="form-group">
                                    <label for="emailAddress">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="emailAbogado" onchange="valida_email_abogado('0');valida_sexo();" parsley-trigger="change" required
                                        placeholder="Ingresar el email" class="form-control" id="emailAbogado">
                                        <div class="text-danger" id='error_emailabogado' name="error_emailabogado" ></div>
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