<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo actor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" action="javascript:modal_actor('actor');" onsubmit="return valida_email('0');" id="formulario">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group">

                        <label for="userName">Tipo de Persona<span class="text-danger">*</span></label>
                        <select class="form-control" data-toggle="select2" style="width: 100%"  name="tipoPersona" onchange="mostrar_datos(this.value);"
                            id="tipoPersona" data-placeholder="Seleccione una opción ..." required>
                            <option value="" selected>Seleccione una opción</option>
                            <option value="FISICA">Persona Fisica</option>
                            <option value="MORAL">Persona Moral</option>
                        </select>


                    </div>

                    <div class="form-group" id='display_fisica' style='display:none;'>

                        <div class="form-group">
                            <label for="userName">Nombre<span class="text-danger">*</span></label>
                            <input type="text" name="nombre"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                parsley-trigger="change" required placeholder="Ingresar el nombre" class="form-control"
                                id="nombre">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                            <input type="text" name="apellidoPaterno" parsley-trigger="change" required
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido paterno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoPaterno">
                        </div>

                        <div class="form-group">
                            <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                            <input type="text" name="apellidoMaterno" parsley-trigger="change"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                placeholder="Ingresar el apellido materno" onkeypress="return soloLetras(event)"
                                class="form-control" id="apellidoMaterno">
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

                    </div>

                    <div class="form-group" id='display_moral' style='display:none;'>

                        <div class="form-group">
                            <label for="userName">Razón Social<span class="text-danger">*</span></label>
                            <input type="text" name="razonSocial" parsley-trigger="change" required
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                onkeypress="return soloLetras(event)" placeholder="Ingresar el nombre"
                                class="form-control" id="razonSocial">
                        </div>
                    </div>






                    <div class="form-group">
                        <label for="emailAddress">Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" onchange="valida_email('0');valida_sexo();" parsley-trigger="change" required
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