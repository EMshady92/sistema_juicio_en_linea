<div class="modal fade" id="modalTercera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo tercer interesado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="javascript:modal_actor('tercero');" id="formulario_tercera">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group">

                        <label for="userName">Tipo de Persona<span class="text-danger">*</span></label>
                        <select class="form-control" name="tipoPersonaTercera" onchange="mostrar_datos_modal(this.value);"
                            id="tipoPersonaTercera" required>
                            <option value="" selected>Seleccione una opción</option>
                            <option value="FISICA">Persona Fisica</option>
                            <option value="MORAL">Persona Moral</option>
                        </select>


                    </div>

                    <div class="form-group" id='display_fisicaTercera' style='display:none;'>

                        <div class="form-group">
                            <label for="userName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="nombreTercera"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                parsley-trigger="change" required placeholder="Ingresar el nombre" class="form-control"
                                id="nombreTercera">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                            <input type="text" name="apellidoPaternoTercera" parsley-trigger="change" required
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido paterno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoPaternoTercera">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                            <input type="text" name="apellidoMaternoTercera" parsley-trigger="change"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido materno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoMaternoTercera">
                        </div>

                        <div class="form-group">
                                    <label for="sexo">Sexo<span class="text-danger">*</span></label><br>
                                    <select class="form-control" name="sexo" id="sexotercera" required
                                        data-toggle="">
                                        <option value="" selected>Seleccione una opción</option>
                                        <option value="MASCULINO">Masculino</option>
                                        <option value="FEMENINO">Femenino</option>
                                    </select>

                        </div>

                    </div>

                    <div class="form-group" id='display_moralTercera' style='display:none;'>

                        <div class="form-group">
                            <label for="userName">Razón Social<span class="text-danger">*</span></label>
                            <input type="text" name="razonSocialTercera" parsley-trigger="change" required
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" placeholder="Ingresar el nombre"
                                class="form-control" id="razonSocialTercera">
                        </div>
                    </div>






                    <div class="form-group">
                        <label for="emailAddress">Email<span class="text-danger">*</span></label>
                        <input type="email" name="emailTercera" parsley-trigger="change" onchange="valida_email_tercerasmod('0');"
                        required placeholder="Ingresar el email" class="form-control" id="emailTercera">
                        <div class="text-danger" id='error_emailmod' name="error_emailmod" ></div>
                    </div>

                    <div class="modal-footer">
                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary waves-effect waves-light mr-1" id="submit" type="submit">
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