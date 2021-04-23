//RUTA PARA LOCAL HOST
//var ruta_global = "http://localhost:8000";
//RUTA PARA EL SERVIDOR
var ruta_global = "https://www.sit-zac.org.mx";
///FUNCION PARA CONVERTIR LETRAS A MAYUSCULAS
function mayus(e) {
    var tecla = e.value;
    var tecla2 = tecla.toUpperCase();
}

//FUNCION PARA PERMITIR SOLO NUMEROS
function soloNumeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    letras = " 1,2,3,4,5,6,7,8,9,0,.";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}


//FUNCION PARA SOLO PERMITIR LETRAS
function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}

//FUNCION PARA MOSTRAR Y OCULTAR CAMPOS EN ACTORES SEGUN SI ES FISICA O MORAL
function mostrar_datos(value) {

    if (value == "FISICA") {
        document.getElementById('display_fisica').style.display = 'block';
        document.getElementById('display_moral').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'none';
        document.getElementById('display_autoridad').style.display = 'none';
        document.getElementById('display_sub').style.display = 'none';
        document.getElementById('nombre').required = true;
        document.getElementById('apellidoPaterno').required = true;
        document.getElementById('sexo').required = true;
        document.getElementById('abogado').required = true;
        document.getElementById('razonSocial').required = false;
        document.getElementById('nombre_aut').required = false;
        document.getElementById('autoridad').required = false;
        document.getElementById('cedulaAbogado').required = false;
        document.getElementById('file').required = false;
    } else if (value == "MORAL") {
        document.getElementById('display_sub').style.display = 'none';
        document.getElementById('display_autoridad').style.display = 'none';
        document.getElementById('display_fisica').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'none';
        document.getElementById('display_moral').style.display = 'block';
        document.getElementById('nombre').required = false;
        document.getElementById('apellidoPaterno').required = false;
        document.getElementById('sexo').required = false;
        document.getElementById('razonSocial').required = true;
        document.getElementById('nombre_aut').required = false;
        document.getElementById('autoridad').required = false;
        document.getElementById('cedulaAbogado').required = false;
        document.getElementById('file').required = false;
        document.getElementById('abogado').required = false;
    } else if (value == "AUTORIDAD") {
        document.getElementById('display_moral').style.display = 'none';
        document.getElementById('display_fisica').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'none';
        document.getElementById('display_sub').style.display = 'none';
        document.getElementById('display_autoridad').style.display = 'block';
        document.getElementById('nombre').required = false;
        document.getElementById('apellidoPaterno').required = false;
        document.getElementById('sexo').required = false;
        document.getElementById('razonSocial').required = false;
        document.getElementById('nombre_aut').required = true;
        document.getElementById('autoridad').required = false;
        document.getElementById('cedulaAbogado').required = false;
        document.getElementById('file').required = false;
        document.getElementById('abogado').required = false;

    } else if (value == "SUB") {
        document.getElementById('display_moral').style.display = 'none';
        document.getElementById('display_fisica').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'none';
        document.getElementById('display_sub').style.display = 'block';
        document.getElementById('display_autoridad').style.display = 'none';
        document.getElementById('nombre').required = false;
        document.getElementById('apellidoPaterno').required = false;
        document.getElementById('sexo').required = false;
        document.getElementById('razonSocial').required = false;
        document.getElementById('nombre_aut').required = false;
        document.getElementById('autoridad').required = true;
        document.getElementById('cedulaAbogado').required = false;
        document.getElementById('file').required = false;
        document.getElementById('abogado').required = false;
    } else if (value == "SI") {
        document.getElementById('display_moral').style.display = 'none';
        document.getElementById('display_autoridad').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'block';
        document.getElementById('nombre').required = false;
        document.getElementById('apellidoPaterno').required = false;
        document.getElementById('sexo').required = false;
        document.getElementById('razonSocial').required = false;
        document.getElementById('nombre_aut').required = false;
        document.getElementById('autoridad').required = false;
        document.getElementById('cedulaAbogado').required = true;
        document.getElementById('file').required = true;

    } else if (value == "NO") {
        document.getElementById('display_moral').style.display = 'none';
        document.getElementById('display_autoridad').style.display = 'none';
        document.getElementById('display_abogado').style.display = 'none';
        document.getElementById('nombre').required = false;
        document.getElementById('apellidoPaterno').required = false;
        document.getElementById('sexo').required = false;
        document.getElementById('razonSocial').required = false;
        document.getElementById('nombre_aut').required = false;
        document.getElementById('autoridad').required = false;
        document.getElementById('cedulaAbogado').required = false;
        document.getElementById('file').required = false;

    }
}

function mostrar_datos_modal(value) {
    if (value == "FISICA") {
        document.getElementById('display_fisicaTercera').style.display = 'block';
        document.getElementById('display_moralTercera').style.display = 'none';
        document.getElementById('nombreTercera').required = true;
        document.getElementById('apellidoPaternoTercera').required = true;
        document.getElementById('razonSocialTercera').required = false;
    } else if (value == "MORAL") {
        document.getElementById('display_fisicaTercera').style.display = 'none';
        document.getElementById('display_moralTercera').style.display = 'block';
        document.getElementById('nombreTercera').required = false;
        document.getElementById('apellidoPaternoTercera').required = false;
        document.getElementById('razonSocialTercera').required = true;
    } else {

    }
}

function mostrar_datos_inicio(value) {
    if (value == "NULIDAD" || value == "GENERALIDAD") {
        document.getElementById('display_nuevo').style.display = 'block';
        document.getElementById('display_archivos').style.display = 'block';
        document.getElementById('display_obs').style.display = 'block';
        document.getElementById('display_amparo').style.display = 'none';
        document.getElementById('display_rag').style.display = 'none';
        document.getElementById('hojas_traslado').disabled = false;
        document.getElementById('actor').required = true;
        document.getElementById('demandado').required = true;
        document.getElementById('expediente').required = false;
        document.getElementById('presunto_resp').required = false;
        document.getElementById('autoridad_inv').required = false;
        document.getElementById('autoridad_sust').required = false;
        document.getElementById('tipo_falta').required = false;
        document.getElementById('id_juicio').required = true;
        $('.select2-multiple').select2({
        })

    } else if (value == "RAG") {
        document.getElementById('display_nuevo').style.display = 'none';
        document.getElementById('display_archivos').style.display = 'block';
        document.getElementById('display_amparo').style.display = 'none';
        document.getElementById('display_rag').style.display = 'block';
        document.getElementById('display_obs').style.display = 'block';
        document.getElementById('hojas_traslado').disabled = false;
        document.getElementById('actor').required = false;
        document.getElementById('demandado').required = false;
        document.getElementById('expediente').required = false;
        document.getElementById('presunto_resp').required = true;
        document.getElementById('autoridad_inv').required = true;
        document.getElementById('autoridad_sust').required = true;
        document.getElementById('tipo_falta').required = true;
        document.getElementById('id_juicio').required = true;
        $('.select2-multiple').select2({
        })

    } else if (value != "") {
        document.getElementById('display_amparo').style.display = 'block';
        document.getElementById('display_archivos').style.display = 'none';
        document.getElementById('display_nuevo').style.display = 'none';
        document.getElementById('display_rag').style.display = 'none';
        document.getElementById('display_obs').style.display = 'none';
        document.getElementById('hojas_traslado').disabled = true;
        document.getElementById('actor').required = false;
        document.getElementById('demandado').required = false;
        document.getElementById('expediente').required = true;
        document.getElementById('presunto_resp').required = false;
        document.getElementById('autoridad_inv').required = false;
        document.getElementById('autoridad_sust').required = false;
        document.getElementById('tipo_falta').required = false;
        document.getElementById('id_juicio').required = false;

    }

}

function mostrar_datos_inicio_edit(value) {
    if (value == "NULIDAD" || value == "GENERALIDAD") {
        document.getElementById('display_nuevo').style.display = 'block';
        document.getElementById('display_archivos').style.display = 'block';
        document.getElementById('display_obs').style.display = 'block';

        document.getElementById('display_rag').style.display = 'none';
        document.getElementById('hojas_traslado').disabled = false;
        document.getElementById('actor_aux').required = true;
        document.getElementById('demandados_aux').required = true;
        document.getElementById('presunto_resp_aux').required = false;
        document.getElementById('autoridad_inv_aux').required = false;
        document.getElementById('autoridad_sust_aux').required = false;
        document.getElementById('tipo_falta').required = false;
        document.getElementById('id_juicio').required = true;
        $('.select2-multiple').select2({
        })

    } else if (value == "RAG") {
        document.getElementById('display_nuevo').style.display = 'none';
        document.getElementById('display_archivos').style.display = 'block';
        document.getElementById('display_rag').style.display = 'block';
        document.getElementById('display_obs').style.display = 'block';
        document.getElementById('hojas_traslado').disabled = false;
        document.getElementById('actor_aux').required = false;
        document.getElementById('demandados_aux').required = false;
        document.getElementById('presunto_resp_aux').required = true;
        document.getElementById('autoridad_inv_aux').required = true;
        document.getElementById('autoridad_sust_aux').required = true;
        document.getElementById('tipo_falta').required = true;
        document.getElementById('id_juicio').required = true;
        $('.select2-multiple').select2({
        })

    }

}

function changeescaneo(value) {
    if (value == "RAG" || value == "NULIDAD") {
        document.getElementById('escanesc').innerHTML = "Escrito de demanda";

    } else if (value == "AMPARO" || value == "PROMOCION") {
        document.getElementById('escanesc').innerHTML = "Escaneo escrito";
    }
}


//FUNCION PARA INACTIVAR REGISTROS// AUX ES LA RUTA QUE RECIBE
function inactivar(id, aux) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Se inactivará el registro, y ya no se podra utilizar en expedientes nuevos!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, inactivar!'
    }).then((result) => {
        if (result.isConfirmed) {

            var route = ruta_global + "/" + aux + "/" + id + "";
            var token = $("#token").val();
            $.ajax({

                url: route,
                headers: { 'X-CSRF-TOKEN': token },
                type: 'post',
                method: 'DELETE',
                dataType: 'json',
                success: function () {
                    Swal.fire(
                        'Inactivado!',
                        'El registro se ha inactivado.',
                        'success'
                    )
                }
            });

               setTimeout(function(){location.reload()},1000);

            //location.reload();
        }
    })
}

//MODAL PARA GUARDAR LOS DATOS DE UN ACTOR NUEVO EN LA VISTA DE NUEVOS INGRESOS
function modal_actor(tipo) {

    if (tipo == "actor") {
        ruta = "/actoresCrear";
        dataString = $('#formulario').serialize(); // carga todos 
    } else {
        ruta = "/terceras_personasCrear";
        dataString = $('#formulario_tercera').serialize(); // carga todos 
    }
    $.ajax({
        type: "POST",
        method: 'post',
        url: ruta,
        data: dataString,
        success: function (data) {
            var x = $('#' + tipo + '');
            if (data.tipo_persona == "FISICA") {
                option = new Option(data.nombre + " " + data.apellido_paterno + " " + data.apellido_materno, data.id, true, true);
            } else {
                option = new Option(data.razon_social, data.id, true, true);
            }
            x.append(option).trigger('change');
            x.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });

            if (tipo == "actor") {
                // $("#actor").val(data.id);
                $("#modal .close").click();
                $('.modal.in').modal('hide');
            } else {
                //$("#tercero").val(data.id);
                $("#modalTercera .close").click();
                $('.modalTercera.in').modal('hide');

            }


        }
    });


}

//MODAL PARA GUARDAR LOS DATOS DE UN DEMANDADO NUEVO EN LA VISTA DE NUEVOS INGRESOS
function modal_demandado() {

    var dataString = $('#formulario_demandado').serialize(); // carga todos 
    $.ajax({
        type: "POST",
        method: 'post',
        url: "/demandadosCrear",
        data: dataString,
        success: function (data) {
            var x = $('#demandado');
            option = new Option(data.nombre, data.id, true, true);
            x.append(option).trigger('change');
            x.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
            $("#modal_demandado .close").click();
            $('.modal_demandado.in').modal('hide');


        }
    });


}


//MODAL PARA GUARDAR LOS DATOS DE UN ABOGADO NUEVO EN LA VISTA DE NUEVOS INGRESOS
function modal_abogado() {
    var dataString = $('#formulario_abogado').serialize(); // carga todos 
    $.ajax({
        type: "POST",
        method: 'post',
        url: "/abogadosCrear",
        data: dataString,
        success: function (data) {

            var x = $('#abogado');
            option = new Option(data.nombre + " " + data.apellido_paterno + " " + data.apellido_materno, data.id, true, true);
            x.append(option).trigger('change');
            x.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
            $("#modal_abogado .close").click();
            $('.modal_abogado.in').modal('hide');


        }
    });
}

//Funcion para traer los datos de un expediente
function traerExpediente(value, sr) {

    if (sr == "cr" && value != null) {
        document.getElementById('display_info').style.display = 'block';
        document.getElementById('display_archivos').style.display = 'block';
    }
    $('.select2-multiple').val(null).trigger('change');
    if (value != null) {
        var route = ruta_global + "/traer_expediente/" + value;
        var token = $("#token").val();
        $.ajax({
            type: "get",
            headers: { 'X-CSRF-TOKEN': token },
            method: 'get',
            url: route,
            data: value,
            success: function (data) {
                //FOR EACH PARA AGREGAR LOS ACTORES AL EXPEDIENTE SELECCIONADO
                data.actores.forEach(function (actor, index) {
                    var x = $('#actor_aux');
                    if (actor.tipo == "FISICA") {
                        option = new Option(actor.nombre + " " + actor.apellido_paterno + " " + actor.apellido_materno, actor.id, true, true);
                    } else if (actor.tipo == "MORAL") {
                        option = new Option(actor.razon_social, actor.id, true, true);
                    } else {
                        option = new Option(actor.nombre, actor.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: actor
                        }
                    });
                });//END FOREACH ACTORES

                //FOR EACH PARA AGREGAR LOS DEMANDADOS AL EXPEDIENTE SELECCIONADO
                data.demandados.forEach(demandado => {
                    var x = $('#demandados_aux');
                    if (demandado.tipo == "FISICA") {
                        option = new Option(demandado.nombre + " " + demandado.apellido_paterno + " " + demandado.apellido_materno, demandado.id, true, true);
                    } else if (demandado.tipo == "MORAL") {
                        option = new Option(demandado.razon_social, demandado.id, true, true);
                    } else {
                        option = new Option(demandado.nombre, demandado.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: demandado
                        }
                    });
                });//END FOREACH DEMANDADOS

                //FOR EACH PARA AGREGAR LOS ABOGADOS AL EXPEDIENTE SELECCIONADO
                data.abogados.forEach(abogado => {
                    var x = $('#abogados_aux');
                    // option = new Option(abogado.nombre + " " + abogado.apellido_paterno + " " + abogado.apellido_materno, abogado.id, true, true);
                    if (abogado.tipo == "FISICA") {
                        option = new Option(abogado.nombre + " " + abogado.apellido_paterno + " " + abogado.apellido_materno, abogado.id, true, true);
                    } else if (abogado.tipo == "MORAL") {
                        option = new Option(abogado.razon_social, abogado.id, true, true);
                    } else {
                        option = new Option(abogado.nombre, abogado.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: abogado
                        }
                    });
                });//END FOREACH ABOGADOS

                //FOR EACH PARA AGREGAR LOS Juicios AL EXPEDIENTE SELECCIONADO
                data.juicios.forEach(juicio => {
                    var x = $('#id_juicio_aux');
                    option = new Option(juicio.tipo, juicio.id, true, true);
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: juicio
                        }
                    });
                });//END FOREACH ABOGADOS 

                //FOR EACH PARA AGREGAR LOS TERCEROS AL EXPEDIENTE SELECCIONADO
                data.terceras.forEach(tercera => {
                    var x = $('#terceros_aux');
                    if (tercera.tipo == "FISICA") {
                        option = new Option(tercera.nombre + " " + tercera.apellido_paterno + " " + tercera.apellido_materno, tercera.id, true, true);
                    } else if (tercera.tipo == "MORAL") {
                        option = new Option(tercera.razon_social, tercera.id, true, true);
                    } else {
                        option = new Option(tercera.nombre, tercera.id, true, true);
                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: tercera
                        }
                    });
                });//END FOREACH TERCEROS

                //FOR EACH PARA AGREGAR AUTORIDAD INVESTIGADORA AL EXPEDIENTE SELECCIONADO
                data.autoridad_inv.forEach(autoridad_inv => {
                    var x = $('#autoridad_inv_aux');
                    if (autoridad_inv.tipo == "FISICA") {
                        option = new Option(autoridad_inv.nombre + " " + autoridad_inv.apellido_paterno + " " + autoridad_inv.apellido_materno, autoridad_inv.id, true, true);
                    } else if (autoridad_inv.tipo == "MORAL") {
                        option = new Option(autoridad_inv.razon_social, autoridad_inv.id, true, true);
                    } else {
                        option = new Option(autoridad_inv.nombre, autoridad_inv.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: autoridad_inv
                        }
                    });
                });//END FOREACH AUTORIDAD INVESTIGADORA

                //FOR EACH PARA AGREGAR AUTORIDAD SUSTANCIADORA AL EXPEDIENTE SELECCIONADO
                data.autoridad_sust.forEach(autoridad_sust => {
                    var x = $('#autoridad_sust_aux');
                    if (autoridad_sust.tipo == "FISICA") {
                        option = new Option(autoridad_sust.nombre + " " + autoridad_sust.apellido_paterno + " " + autoridad_sust.apellido_materno, autoridad_sust.id, true, true);
                    } else if (autoridad_sust.tipo == "MORAL") {
                        option = new Option(autoridad_sust.razon_social, autoridad_sust.id, true, true);
                    } else {
                        option = new Option(autoridad_sust.nombre, autoridad_sust.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: autoridad_sust
                        }
                    });
                });//END FOREACH AUTORIDAD INVESTIGADORA

                //FOR EACH PARA AGREGAR Presunto responsable AL EXPEDIENTE SELECCIONADO
                data.presunto_resp.forEach(presunto_resp => {
                    var x = $('#presunto_resp_aux');
                    if (presunto_resp.tipo == "FISICA") {
                        option = new Option(presunto_resp.nombre + " " + presunto_resp.apellido_paterno + " " + presunto_resp.apellido_materno, presunto_resp.id, true, true);
                    } else if (presunto_resp.tipo == "MORAL") {
                        option = new Option(presunto_resp.razon_social, presunto_resp.id, true, true);
                    } else {
                        option = new Option(presunto_resp.nombre, presunto_resp.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: presunto_resp
                        }
                    });
                });//END FOREACH PRESUNTO RESPONSABLE

                //FOR EACH PARA AGREGAR DENUNCIANTE AL EXPEDIENTE SELECCIONADO
                data.denunciante.forEach(denunciante => {
                    var x = $('#denunciante_aux');
                    if (denunciante.tipo == "FISICA") {
                        option = new Option(denunciante.nombre + " " + denunciante.apellido_paterno + " " + denunciante.apellido_materno, denunciante.id, true, true);
                    } else if (denunciante.tipo == "MORAL") {
                        option = new Option(denunciante.razon_social, denunciante.id, true, true);
                    } else {
                        option = new Option(denunciante.nombre, denunciante.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: denunciante
                        }
                    });
                });//END FOREACH DENUNCIANTE RESPONSABLE

                //FOR EACH PARA AGREGAR PARTICULAR AL EXPEDIENTE SELECCIONADO
                data.particular_vinc.forEach(particular_vinc => {
                    var x = $('#particular_aux');
                    if (particular_vinc.tipo == "FISICA") {
                        option = new Option(particular_vinc.nombre + " " + particular_vinc.apellido_paterno + " " + particular_vinc.apellido_materno, particular_vinc.id, true, true);
                    } else if (particular_vinc.tipo == "MORAL") {
                        option = new Option(particular_vinc.razon_social, particular_vinc.id, true, true);
                    } else {
                        option = new Option(particular_vinc.nombre, particular_vinc.id, true, true);

                    }
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: particular_vinc
                        }
                    });
                });//END FOREACH PARTICULAR RESPONSABLE


                if (sr == "detalle" || sr == "cr") {
                    //FOR EACH PARA AGREGAR LOS DATOS AL EXPEDIENTE SELECCIONADOtipo_juicio


                    data.datos.forEach(dato => {
                        fecha = document.getElementById('fecha_aux');
                        option = document.createElement("option");
                        option.value = dato.id;
                        option.text = dato.fecha;
                        fecha.add(option, fecha[0]);
                        $("#fecha_aux").val(dato.id);

                        tipojuicio = document.getElementById('tipo_juicio');
                        option = document.createElement("option");
                        option.text = dato.tipo_juicio;
                        option.value = dato.id;
                        tipojuicio.add(option, tipojuicio[0]);
                        $("#tipo_juicio").val(dato.id);


                        update = document.getElementById('ultima_ac');
                        option = document.createElement("option");
                        option.text = dato.updated_at;
                        option.value = dato.id;
                        update.add(option, update[0]);
                        $("#ultima_ac").val(dato.id);

                        create = document.getElementById('fecha_captura');
                        option = document.createElement("option");
                        option.text = dato.created_at;
                        option.value = dato.id;
                        create.add(option, create[0]);
                        $("#fecha_captura").val(dato.id);

                        user = document.getElementById('modificado');
                        option = document.createElement("option");
                        option.text = dato.captura;
                        option.value = dato.id;
                        user.add(option, user[0]);
                        $("#modificado").val(dato.id);

                        num_exp = document.getElementById('num_expediente');
                        option = document.createElement("option");
                        option.text = dato.num_expediente;
                        option.value = dato.id;
                        num_exp.add(option, num_exp[0]);
                        $("#num_expediente").val(dato.id);

                        tipo = document.getElementById('tipo_aux');
                        option = document.createElement("option");
                        option.text = dato.tipo;
                        option.value = dato.id;
                        tipo.add(option, tipo[0]);
                        $("#tipo_aux").val(dato.id);

                        observaciones = document.getElementById('observaciones_aux');
                        option = document.createElement("option");
                        option.text = dato.observaciones;
                        option.value = dato.id;
                        observaciones.add(option, observaciones[0]);
                        $("#observaciones_aux").val(dato.id);




                    });//END FOREACH TERCEROS


                    //SI ES RAG LE AGREGA EL TIPO DE FALTA
                    if (tipo[0].innerHTML == "RAG") {
                        tipo_falta = document.getElementById('tipo_falta');
                        option = document.createElement("option");
                        option.text = data.tipo_falta['tipo_falta'];
                        option.value = data.tipo_falta['tipo_falta'];
                        tipo_falta.add(option, tipo_falta[0]);
                        $("#tipo_falta").val(data.tipo_falta['tipo_falta']);

                    }

                }


            }
        });


    } else {
        document.getElementById('display_info').style.display = 'block';
        document.getElementById('display_archivos').style.display = 'block';
    }
}


//FUNCION PARA AGREGAR EL NUMERO DE ANEXOS
function anexos_hojas(value) {
    document.getElementById("anexos_div").innerHTML = "";
    if (value > 0) {
        for (index = 1; index <= value; index++) {
            //aquí instanciamos al componente padre
            var padre = document.getElementById("anexos_div");
            //aquí agregamos el componente de tipo input
            var div = document.createElement("div");
            div.setAttribute("id", 'div' + index);
            div.classList.add('col-lg-4');


            var div2 = document.createElement("div");
            div2.setAttribute("id", 'card' + index);
            div2.classList.add('card-box');

            input = document.createElement("INPUT");
            input.setAttribute("id", 'input' + index);
            input.setAttribute("class", 'dropify');
            input.setAttribute("name", 'input' + index);
            input.setAttribute('type', 'file');
            input.setAttribute('required', 'true');
            input.setAttribute('accept', '.pdf');
            input.setAttribute('data-max-file-size', '3M');
            //AGREGA EL INPUT 2 CON EL TIPO
            select = document.createElement("select");
            select.setAttribute("id", 'select' + index);
            select.setAttribute("class", 'form-control mt-2 mb-2');
            select.setAttribute("data-toggle", 'select2');
            select.setAttribute("name", 'select' + index);
            select.setAttribute('required', 'true');
            select.setAttribute('data-placeholder', 'Seleccione una opción ...');

            //AGREGA EL INPUT 2 CON EL TIPO
            select = document.createElement("select");
            select.setAttribute("id", 'select' + index);
            select.setAttribute("class", 'form-control mt-2 mb-2');
            select.setAttribute("data-toggle", 'select2');
            select.setAttribute("name", 'select' + index);
            select.setAttribute('required', 'true');
            select.setAttribute('data-placeholder', 'Seleccione una opción ...');
            //AGREGA EL INPUT 2 CON LA FORMA
            select2 = document.createElement("select");
            select2.setAttribute("id", 'select2' + index);
            select2.setAttribute("class", 'form-control mt-2 mb-2');
            select2.setAttribute("data-toggle", 'select2');
            select2.setAttribute("name", 'select2' + index);
            select2.setAttribute('required', 'true');

            label = document.createElement("Label");
            label.setAttribute('for', 'userName');
            label.innerHTML = "Hojas del anexo";

            span = document.createElement('span');
            span.setAttribute('class', 'text-danger')
            span.innerHTML = "*";


            input2 = document.createElement("input");
            input2.setAttribute("id", 'input2' + index);
            input2.setAttribute("class", 'form-control mt-2 mb-2');
            input2.setAttribute("name", 'input2' + index);
            input2.setAttribute('required', 'true');
            input2.setAttribute('type', 'number');
            input2.setAttribute('min', '1');
            input2.setAttribute('max', '99');
            input2.setAttribute('placeholder', 'Hojas del anexo (numérico)');
            input2.setAttribute('onmousewheel', 'this.blur();');

            // AGREGA UN ETIQUETA H4 CON EL NUMERO DE HOJAS
            h4 = document.createElement("h4");
            h4.setAttribute("id", 'h4' + index);
            h4.innerHTML = "Anexo n°" + index;
            //AGREGA TODOS LOS DIV Y INPUT
            padre.appendChild(div);
            div.appendChild(div2);
            div2.appendChild(h4);
            div2.appendChild(select);
            div2.appendChild(select2);
            div2.appendChild(label);
            label.appendChild(span);
            div2.appendChild(input2);
            div2.appendChild(input);
            $('.dropify').dropify();

            select_aux1 = document.getElementById('select' + index);
            opciones = ['SELECCIONE UNA OPCIÓN', 'ACTA DE NACIMIENTO', 'CURP', 'IFE', 'PASAPORTE MEXICANO', 'CÉDULA PROFESIONAL', 'TITULO PROFESIONAL', 'CARTILLA DEL SERVICIO MILITAR', 'INAPAM', 'CREDENCIAL IMSS', 'CREDENCIAL ISSSTE', 'LICENCIA DE CONDUCIR', 'CARTA DE NATURALIZACIÓN']
            opciones.forEach(element => {
                option = document.createElement("option");
                option.text = element;
                if (element == "SELECCIONE UNA OPCIÓN") {
                    option.value = "";
                } else {
                    option.value = element;
                }
                select_aux1.add(option, select_aux1[0]);
            });//END FOR EACH

            select_aux2 = document.getElementById('select2' + index);
            opciones = ['SELECCIONE UNA OPCIÓN', 'ORIGINAL', 'COPIA CERTIFICADA', 'COPIA SIMPLE']
            opciones.forEach(element => {
                option = document.createElement("option");
                option.text = element;
                if (element == "SELECCIONE UNA OPCIÓN") {
                    option.value = "";
                } else {
                    option.value = element;
                }
                select_aux2.add(option, select_aux2[0]);
            });//END FOR EACH



        }


    }

}

function valida_contra() {
    aux1 = document.getElementById('password').value;
    aux2 = document.getElementById('password_confirmation').value;
    if (aux1 != aux2) {
        document.getElementById("error_pass").innerHTML = "Las contraseñas no coinciden.";
        document.getElementById("error_pass").value = "1";
        document.getElementById('submit3').disabled = true;
    } else {
        document.getElementById("error_pass").innerHTML = "";
        document.getElementById("error_pass").value = "0";
        document.getElementById('submit3').disabled = false;
    }
}

function valida_contrafirma() {
    aux1 = document.getElementById('passfirma').value;
    aux2 = document.getElementById('passfirma_confirmation').value;
    if (aux1 != aux2) {
        document.getElementById("error_passfirma").innerHTML = "Las contraseñas no coinciden.";
        document.getElementById("error_passfirma").value = "1";
        document.getElementById('submit3').disabled = true;
    } else {
        document.getElementById("error_passfirma").innerHTML = "";
        document.getElementById("error_passfirma").value = "0";
        document.getElementById('submit3').disabled = false;
    }
}

function valida_email(sr) {
    var dataString = $('#formulario').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_email").innerHTML =
                        "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_email").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_email").innerHTML = "";
                    document.getElementById("error_email").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_email").innerHTML = "";
                document.getElementById("error_email").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

function valida_nombreAutoridad(sr) {
    //var aux=false;
    var dataString = $('#formulario_demandado').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_nombreAutoridad",
        data: dataString,
        success: function (data) {
            if (data.autoridad) {
                if (sr != data.autoridad.nombre) {

                    document.getElementById("error_nombre").innerHTML =
                        "El nombre de la autoridad que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_nombre").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_nombre").innerHTML = "";
                    document.getElementById("error_nombre").value = "0";
                    document.getElementById('submit').disabled = false;

                }

            } else {
                document.getElementById("error_nombre").innerHTML = "";
                document.getElementById("error_nombre").value = "0";
                document.getElementById('submit').disabled = false;

            }

        }
    });

}

//FUNCION PARA VALIDAR QUE NO EXISTAN MAS DE 1 FIRMA POR USUARIO
function validaFirma() {
    //var aux=false;
    var dataString = $('#formulario_firma').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/validaFirma",
        data: dataString,
        success: function (data) {
            if (data.usuario) {

                document.getElementById("error_usuario").innerHTML =
                    "El usuario que intenta registrar, ya tiene su firma electronica.";
                document.getElementById("error_usuario").value = "1";
                document.getElementById('submit').disabled = true;

            } else {
                document.getElementById("error_usuario").innerHTML = "";
                document.getElementById("error_usuario").value = "0";
                document.getElementById('submit').disabled = false;

            }

        }
    });

}

//FUNCION PARA VALIDAR LAS SALAS Y LOS MAGISTRADOS
function validaSalaMagistrado(cr) {
    var dataString = $('#formsalamagistrado').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/validaSala/" + cr,
        data: dataString,
        success: function (data) {
            if (data.valida) {
                document.getElementById("error_sala").innerHTML =
                    data.mensaje;
                document.getElementById("error_sala").value = "1";
                document.getElementById('submit').disabled = true;

            } else {
                document.getElementById("error_sala").innerHTML = "";
                document.getElementById("error_sala").value = "0";
                document.getElementById('submit').disabled = false;

            }

        }
    });

}

//MODAL PARA ASIGNAR EL EXPEDIENTE A UN INFERIOR
function modal_asigna_expediente(id) {
    var dataString = $('#emailAbogado').serialize(); // carga todos    
    $.ajax({
        type: "POST",
        method: 'post',
        url: "/asignarExpediente/" + id,
        data: dataString,
        success: function (data) {

            let d = document.getElementById('modal' + id)
            d.close;
            d.style.display = "none"




        }
    });
}



function valida_email_abogado(sr) {
    var dataString = $('#emailAbogado').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email_abogado",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_email").innerHTML = "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_email").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_email").innerHTML = "";
                    document.getElementById("error_email").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_email").innerHTML = "";
                document.getElementById("error_email").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

function valida_email_abogado_mod(sr) {
    var dataString = $('#emailAbogado').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email_abogado",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_emailmod").innerHTML = "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_emailmod").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_emailmod").innerHTML = "";
                    document.getElementById("error_emailmod").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_emailmod").innerHTML = "";
                document.getElementById("error_emailmod").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

function valida_email_terceras(sr) {
    var dataString = $('#email').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email_terceras",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_email").innerHTML = "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_email").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_email").innerHTML = "";
                    document.getElementById("error_email").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_email").innerHTML = "";
                document.getElementById("error_email").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

function valida_email_tercerasmod(sr) {
    var dataString = $('#emailTercera').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email_tercerasmod",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_emailmod").innerHTML = "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_emailmod").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_emailmod").innerHTML = "";
                    document.getElementById("error_emailmod").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_emailmod").innerHTML = "";
                document.getElementById("error_emailmod").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

function valida_cedula_abogado(sr) {
    var dataString = $('#cedulaAbogado').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_cedula_abogado",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.num_cedula) {

                    document.getElementById("error_num_cedula").innerHTML =
                        "Este número de Cedula ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_num_cedula").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_num_cedula").innerHTML = "";
                    document.getElementById("error_num_cedula").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_num_cedula").innerHTML = "";
                document.getElementById("error_num_cedula").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

//FUNCION PARA VALIDAR EXPEDIENTES//
function validaExpediente(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Una vez validado el expediente, no se podrán modificar sus datos, solo podrá acceder un Administrador!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Validar!'
    }).then((result) => {
        if (result.isConfirmed) {
            var route = ruta_global + "/validarExpediente/" + id;
            var token = $("#token").val();
            $.ajax({

                url: route,
                headers: { 'X-CSRF-TOKEN': token },
                type: 'post',
                method: 'post',
                dataType: 'json',
                success: function () {
                    Swal.fire(
                        'Validado!',
                        'El registro se ha validado.',
                        'success'
                    )
                }
            });

            //   setTimeout(function(){location.reload()},1000);

            location.reload();
        }
    })
}

//FUNCION PARA VALIDAR EXPEDIENTES//
function validaExpedienteAuxiliar(id) {
    Swal.fire({
        title: 'Estás seguro?',
        text: "Una vez validado el expediente, no se podrán modificar sus datos, solo podrá acceder un Administrador!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Validar!'
    }).then(function () {
        var route = ruta_global + "/validarExpediente/" + id;
        var token = $("#token").val();
        $.ajax({

            url: route,
            headers: { 'X-CSRF-TOKEN': token },
            type: 'post',
            method: 'post',
            dataType: 'json',
            success: function () {
                Swal.fire(
                    'Validado!',
                    'El registro se ha validado.',
                    'success'
                )
            }
        });

        //   setTimeout(function(){location.reload()},1000);

        location.reload();
    });

}

//OCULTAR Y MOSTRAR EL INPUT DE PROMOCIONES EN LOS ACUERDOS
function cambia_display_acuerdo(value) {
    if (value == "SI") {
        document.getElementById('display_promocion').style.display = 'block';
        document.getElementById('promocion').required = true;
        $("#promocion").select2({
            width: '100%'
        });

    } else {
        document.getElementById('display_promocion').style.display = 'none';
        document.getElementById('promocion').required = false;
    }
}

//VALIDAR ACUERDOS
function valida_acuerdo() {

    if (document.getElementById('tipoAcuerdo').value == "") {
        document.getElementById("error_tipo_acuerdo").innerHTML = "Seleccione un tipo de acuerdo.";
        return false;

    } else if (document.getElementById('tipoAcuerdo').value != "") {
        document.getElementById("error_tipo_acuerdo").innerHTML = "";

    } else if (document.getElementById('radioInline').value == "SI") {
        if (document.getElementById('promocion').value == "") {
            document.getElementById("error_promocion").innerHTML = "Seleccione una promocion.";
            return false;
        }
    } else if (document.getElementById('radioInline').value == "NO") {
        document.getElementById("error_promocion").innerHTML = "";
    }
    else if (document.getElementById('tiempo_contestacion').value < 0 || document.getElementById('tiempo_contestacion').value > 99) {
        document.getElementById("error_dias").innerHTML = "El número de dias no puede ser menor de 0 o mayor de 99.";
        return false;

    } else {
        document.getElementById("error_tipo_acuerdo").innerHTML = "";
        document.getElementById("error_promocion").innerHTML = "";
        document.getElementById("error_acuerdo").innerHTML = "";
        return true;

    }


}

function valida_sexo(sr) {

    var us = document.getElementById("sexo").value;

    if (us == "Seleccione una opción") {

        document.getElementById("error_sexo").innerHTML = "Ah olvidado seleccionar el sexo del nuevo abogad@."
        document.getElementById("error_sexo").value = "1";
        document.getElementById('submit').disabled = true;

    } else {
        document.getElementById("error_sexo").innerHTML = "";
        document.getElementById("error_sexo").value = "0";
        document.getElementById('submit').disabled = false;
    }




}




function validar_sala(sr) {
    var dataString = $('#user').serialize(); // carga todos 
    var us = document.getElementById("user").value;
    $.ajax({
        type: "get",
        method: 'get',
        url: "/validar_sala",
        data: dataString,
        success: function (data) {
            if (data.ida) {
                if (us == data.ida.id_user) {
                    document.getElementById("error_sala_asg").innerHTML = "Este usuario ya se encuentra asignado en la sala número " + data.ida.num_sala + "."
                    document.getElementById("error_sala_asg").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_sala_asg").innerHTML = "";
                    document.getElementById("error_sala_asg").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_sala_asg").innerHTML = "";
                document.getElementById("error_sala_asg").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}
//FUNCION PARA TRAER EL HISTORIAL DE UN EXPEDIENTE
function traerHistorialExpediente(id) {

    var route = ruta_global + "/traerHistorialExpediente/" + id;
    var token = $("#token").val();
    $.ajax({
        type: "get",
        headers: { 'X-CSRF-TOKEN': token },
        method: 'get',
        url: route,
        success: function (data) {


            $('#datatable-buttons').DataTable().clear().destroy();

            //FOR EACH PARA AGREGAR LAS PROMOCIONES AL EXPEDIENTE SELECCIONADO
            data.amparos.forEach(amparo => {

                var tabla = document.getElementById("datatable-buttons");
                var row = tabla.insertRow(1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                cell1.innerHTML = amparo.tipo;
                cell2.innerHTML = amparo.folio;
                cell3.innerHTML = amparo.estado;
                cell4.innerHTML = amparo.created_at;
                cell5.innerHTML = amparo.captura;
                cell6.innerHTML = '<a href= "{{URL::action(AmparosController@show,' + amparo.id + ')}}" class="btn waves-effect waves-light btn-info" role="button"><i class="mdi mdi-eye"></i></a>';

            });//END FOREACH PROMOCIONES
            //FOR EACH PARA AGREGAR LAS PROMOCIONES AL EXPEDIENTE SELECCIONADO
            data.expediente.forEach(exp => {

                var tabla = document.getElementById("datatable-buttons");
                var row = tabla.insertRow(1);
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                cell1.innerHTML = "Escrito inicial";
                cell2.innerHTML = exp.num_expediente;
                cell3.innerHTML = exp.estado;
                cell4.innerHTML = exp.created_at;
                cell5.innerHTML = exp.captura;
                cell6.innerHTML = '<a href= "{{URL::action(AmparosController@show,' + exp.id + ')}}" class="btn waves-effect waves-light btn-info" role="button"><i class="mdi mdi-eye"></i></a>';

            });//END FOREACH PROMOCIONES
            //MOSTRAR = $('#datatable-buttons').DataTable();


            $('#datatable-buttons').DataTable({
                paging: true,
                search: true,
                scrollY: 300,
            });
        }
    });

}
//limpia modales
function limpia() {
    document.getElementById("nombre").value = "";
    document.getElementById("apellidoPaterno").value = "";
    document.getElementById("apellidoMaterno").value = "";
    document.getElementById("sexo").value = "";
    document.getElementById("email").value = "";
    document.getElementById("error_emailactor").innerHTML = "";

    document.getElementById("nombre_demandado").value = "";

    document.getElementById("nombreTercera").value = "";
    document.getElementById("apellidoPaternoTercera").value = "";
    document.getElementById("apellidoMaternoTercera").value = "";
    document.getElementById("sexotercera").value = "";
    document.getElementById("emailTercera").value = "";
    document.getElementById("error_emailmod").innerHTML = "";

}

function valida_magistrado() {
    var dataString = $('#sala').serialize(); // carga todos
    var funcions = document.getElementById("funcion").value;
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_magistrado",
        data: dataString,
        success: function (data) {
            if (data.salas) {
                if (funcions == data.salas.funcion) {
                    document.getElementById("error_sala").innerHTML =
                        "Ya se encuentra registrado un Magistrado en esta sala.";
                    document.getElementById("error_sala").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_sala").innerHTML = "";
                    document.getElementById("error_sala").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_sala").innerHTML = "";
                document.getElementById("error_sala").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }

    });

}

function iniciamodal() {
    $("#modal").modal();
}

function caracteres(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.@1234567890-_ ";
    especiales = "8-37-39-46";
  
    tecla_especial = false
    for(var i in especiales){
      if(key == especiales[i]){
        tecla_especial = true;
        break;
      }
    }
  
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
      return false;
    }
  
    if (key == 32) { 
          return false; 
          } 
  }

  function llenar_firmante() {

    x = document.getElementById('firmantes');
    y = x.options[x.selectedIndex].text;
    z = x.options[x.selectedIndex].value;
    var rows = document.getElementById("detalles").rows.length;    
    if (rows <= 1) {
        var tabla = document.getElementById("detalles");
        var row = tabla.insertRow(rows);
        row.style.backgroundColor = "white";
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = '<input type="button" class="btn waves-effect btn-secondary" value="Eliminar"  onClick="eliminarFilaLista(this.parentNode.parentNode.rowIndex);recorre_tabla();">';
        cell2.innerHTML = rows;
        cell3.innerHTML = '<select class="form-control" style="width: 100%" name="tipoIngreso" id="' + z + '"  data-toggle="select2"> <option value="' + z + '" selected>' + y + '</option></select>';
        //recorre_tabla();
    } else {
        var comprueba = document.getElementById(z);
        if (comprueba == null) {
            var tabla = document.getElementById("detalles");
            var row = tabla.insertRow(rows);
            row.style.backgroundColor = "white";
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.innerHTML = '<input type="button" class="btn waves-effect btn-secondary" value="Eliminar"  onClick="eliminarFilaLista(this.parentNode.parentNode.rowIndex);recorre_tabla();">';
            cell2.innerHTML = rows;
            cell3.innerHTML = '<select class="form-control" style="width: 100%" name="tipoIngreso" id="' + z + '"  data-toggle="select2"> <option value="' + z + '" selected>' + y + '</option></select>';
           // recorre_tabla();
        } else {
            Swal.fire(
                'Error!',
                'El usuario ingresado ya se ha insertado en las firmas.',
                'warning'
            )

        }

    }




}

function eliminarFilaLista(value) {
    document.getElementById("detalles").deleteRow(value);
}

function recorre_tabla() {
    var table = document.getElementById('detalles');
    var arreglo = [];
    for (var r = 1, n = table.rows.length-1; r <= n; r++) {
        for (var c = 2, m = table.rows[r].cells.length; c < m; c++) {
            var input = table.rows[r].cells[c].innerHTML;
            limite = "4",
            separador = "id=",
            arregloDeSubCadenas = input.split(separador, limite);
            separador2 = '"',
            arregloDeSubCadenas2 = arregloDeSubCadenas[1].split(separador2, limite);
            arreglo.push(arregloDeSubCadenas2[1]);              

        }

    }
   
    document.getElementById("array").value=arreglo;
}

function caracteres(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.@1234567890-_ ";
    especiales = "8-37-39-46";
  
    tecla_especial = false
    for(var i in especiales){
      if(key == especiales[i]){
        tecla_especial = true;
        break;
      }
    }
  
    if(letras.indexOf(tecla)==-1 && !tecla_especial){
      return false;
    }
  
    if (key == 32) { 
          return false; 
          } 
  }

function modal_loading(){

  $("#modal-loading").modal();

}

function traerMagistradoSala(value){
     
    var route = ruta_global + "/traerMagistradoSala/" + value;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
          if(data.sala.sexo == "FEMENINO"){
                nombre="MAGISTRADA "+data.sala.name+" "+data.sala.apellido_p+" "+data.sala.apellido_m;
          }else{
                nombre=data.sala.funcion+" "+data.sala.name+" "+data.sala.apellido_p+" "+data.sala.apellido_m;
          }
       
      document.getElementById('ponente').value=nombre;
        
         
          
      }});

    
}


///////////////traer juicios/////////////////////7
function traerJuicios(){
    var juicio = document.getElementById('tipo_juicio').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var sala = document.getElementById('sala').value;
    var juicioest = document.getElementById('juicioest');
    var route = ruta_global + "/traerJuiciosEstadisticas/" +juicio+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
         let juiciocount = data.juicios.length;
         juicioest.value = juiciocount;
          
      }});

    
}

function traerJuiciosfirmados(){
    var juicio = document.getElementById('tipo_juicio').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var sala = document.getElementById('sala').value;
    var firmados = document.getElementById('estado_firmado');
    var route = ruta_global + "/traerJuiciosFirmados/"+juicio+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let firmadoscount = data.juicios.length;
         firmados.value = firmadoscount;
        
          
      }});

    
}

function traerJuiciosPendientes(){
    var juicio = document.getElementById('tipo_juicio').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var sala = document.getElementById('sala').value;
    var pendientes = document.getElementById('estado_pendiente');
    var route = ruta_global + "/traerJuiciosPendientes/"+juicio+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let pendientescount = data.juicios.length;
       pendientes.value = pendientescount;
          
      }});

    
}

function traerJuiciosRevocadas(){
    var documento = document.getElementById('tipo_juicio').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var sala = document.getElementById('sala').value;
    var revocadas = document.getElementById('estado_revocadas');
    var route = ruta_global + "/traerJuiciosRevocadas/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let revocadasCount = data.juicios.length;
       revocadas.value = revocadasCount;
       
      }});

    
}
///////////////////////////////////////////////////


///////////////traer documentos/////////////////////7
function traerDocumentos(){
    var documento = document.getElementById('tipoDocumento').value;
    var fecha_inicio = document.getElementById('fecha_inicio_doc').value;
    var fecha_fin = document.getElementById('fecha_fin_doc').value;
    var sala = document.getElementById('sala_doc').value;
    var documentostot = document.getElementById('documentostot');
    var route = ruta_global + "/traerDocumentosEstadisticas/" +documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
         let documentoCount = data.documentos.length;
         documentostot.value = documentoCount;
         
      }});

    
}

function traerDocumentosfirmados(){
    var documento = document.getElementById('tipoDocumento').value;
    var fecha_inicio = document.getElementById('fecha_inicio_doc').value;
    var fecha_fin = document.getElementById('fecha_fin_doc').value;
    var sala = document.getElementById('sala_doc').value;
    var firmados = document.getElementById('estado_firmado_doc');
    var route = ruta_global + "/traerDocumentosFirmados/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let firmadosCount = data.documentos.length;
         firmados.value = firmadosCount;
        
          
      }});

    
}

function traerDocumentosPendientes(){
    var documento = document.getElementById('tipoDocumento').value;
    var fecha_inicio = document.getElementById('fecha_inicio_doc').value;
    var fecha_fin = document.getElementById('fecha_fin_doc').value;
    var sala = document.getElementById('sala_doc').value;
    var pendientes = document.getElementById('estado_pendiente_doc');
    var route = ruta_global + "/traerDocumentosPendientes/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let pendientesCount = data.documentos.length;
       pendientes.value = pendientesCount;
     
      }});

    
}

function traerDocumentosRevocadas(){
    var documento = document.getElementById('tipoDocumento').value;
    var fecha_inicio = document.getElementById('fecha_inicio_doc').value;
    var fecha_fin = document.getElementById('fecha_fin_doc').value;
    var sala = document.getElementById('sala_doc').value;
    var revocadas = document.getElementById('estado_revocadas_doc');
    var route = ruta_global + "/traerDocumentosRevocadas/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let revocadasCount = data.documentos.length;
       revocadas.value = revocadasCount;
     
      }});

    
}
///////////////////////////////////////////////////
///////////////traer expedientes/////////////////////7
function traerExpedientes(){
    var documento = document.getElementById('tipoExpediente').value;
    var fecha_inicio = document.getElementById('fecha_inicio_exp').value;
    var fecha_fin = document.getElementById('fecha_fin_exp').value;
    var sala = document.getElementById('sala_exp').value;
    var tot_exp = document.getElementById('tot_exp');
    var route = ruta_global + "/traerExpedientesEstadisticas/" +documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
         let expedientesCount = data.expedientes.length;
         tot_exp.value = expedientesCount;
         
      }});

    
}

function traerExpedientesfirmados(){
    var documento = document.getElementById('tipoExpediente').value;
    var fecha_inicio = document.getElementById('fecha_inicio_exp').value;
    var fecha_fin = document.getElementById('fecha_fin_exp').value;
    var sala = document.getElementById('sala_exp').value;
    var firmados = document.getElementById('estado_firmado_exp');
    var route = ruta_global + "/traerExpedientesFirmados/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let firmadosCount = data.expedientes.length;
         firmados.value = firmadosCount;
        
          
      }});

    
}

function traerExpedientesPendientes(){
    var documento = document.getElementById('tipoExpediente').value;
    var fecha_inicio = document.getElementById('fecha_inicio_exp').value;
    var fecha_fin = document.getElementById('fecha_fin_exp').value;
    var sala = document.getElementById('sala_exp').value;
    var pendientes = document.getElementById('estado_pendiente_exp');
    var route = ruta_global + "/traerExpedientesPendientes/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let pendientesCount = data.expedientes.length;
       pendientes.value = pendientesCount;
    
      }});

    
}

function traerExpedientesRevocadas(){
    var documento = document.getElementById('tipoExpediente').value;
    var fecha_inicio = document.getElementById('fecha_inicio_exp').value;
    var fecha_fin = document.getElementById('fecha_fin_exp').value;
    var sala = document.getElementById('sala_exp').value;
    var revocadas = document.getElementById('estado_revocadas_exp');
    var route = ruta_global + "/traerExpedientesRevocadas/"+documento+"/"+fecha_inicio+"/"+fecha_fin+"/"+sala;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let revocadasCount = data.expedientes.length;
       revocadas.value = revocadasCount;
       
      }});

    
}
 ///////////////traer Salas/////////////////////7
 function traerSalas(){
    var sala = document.getElementById('sala_salas').value;
    var fecha_inicio = document.getElementById('fecha_inicio_sala').value;
    var fecha_fin = document.getElementById('fecha_fin_sala').value;
    var tot_sala = document.getElementById('tot_sala');
    var route = ruta_global + "/traerSalasEstadisticas/"+sala+"/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
         let  salasCount = data.salas.length;
         tot_sala.value = salasCount;
      }});

    
}

function traerSalasPendientes(){
    var sala = document.getElementById('sala_salas').value;
    var fecha_inicio = document.getElementById('fecha_inicio_sala').value;
    var fecha_fin = document.getElementById('fecha_fin_sala').value;
    var pendientes = document.getElementById('estado_pendiente_sala');
    var route = ruta_global + "/traerSalasPendientes/"+sala+"/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let pendientesCount = data.salas.length;
       pendientes.value = pendientesCount;
   
      }});

    
}

function traerSalasfirmados(){
    var sala = document.getElementById('sala_salas').value;
    var fecha_inicio = document.getElementById('fecha_inicio_sala').value;
    var fecha_fin = document.getElementById('fecha_fin_sala').value;
    var firmados = document.getElementById('estado_firmado_sala');
    var route = ruta_global + "/traerSalasFirmados/"+sala+"/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let firmadosCount = data.salas.length;
         firmados.value = firmadosCount;
       
          
      }});

    
}

function traerSalasRevocadas(){
    var sala = document.getElementById('sala_salas').value;
    var fecha_inicio = document.getElementById('fecha_inicio_sala').value;
    var fecha_fin = document.getElementById('fecha_fin_sala').value;
    var revocadas = document.getElementById('estado_revocadas_sala');
    var route = ruta_global + "/traerSalasRevocadas/"+sala+"/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
       let revocadasCount = data.salas.length;
       revocadas.value = revocadasCount;
      
      }});

    
}

function llenarPastelSalas(){
    var num_firmados_sala =  parseInt(document.getElementById('estado_firmado_sala').value);
    var num_pendientes_sala =  parseInt(document.getElementById('estado_pendiente_sala').value);
    var num_revocadas_sala =  parseInt(document.getElementById('estado_revocadas_sala').value);
data={series:[num_firmados_sala,num_pendientes_sala,num_revocadas_sala]};
var sum=function(e,t){return e+t};
setInterval(function(){ new Chartist.Pie("#pastelSalas",data,{labelInterpolationFnc:function(e){
    var dat = Math.round(e/data.series.reduce(sum)*100)+"%";
    //console.log(num_firmados_sala,num_pendientes_sala,num_revocadas_sala); 
    return dat; 
}}); }, 1000);

}
///////////////////////////////////////////////////
function traerAsignacionFirma(value){
    var route = ruta_global + "/traerAsignacionFirma/" + value;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
        document.getElementById('display_revocar').style.display = 'block';

        //AGREGA TODAS LOS DATOS DEL DOCUMENTO
        var x = $('#num_exp');
        option = new Option(data.asignacion.num_expediente, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });
        var x = $('#tipo_doc');
        option = new Option(data.asignacion.tipo_documento, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#tipo_exp');
        option = new Option(data.asignacion.tipo_expediente, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#tipo_juicio');
        option = new Option(data.asignacion.tipo_juicio, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#propietario');
        option = new Option(data.asignacion.name+" "+data.asignacion.apellido_p+" "+data.asignacion.apellido_m, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#captura');
        option = new Option(data.asignacion.captura, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#created');
        option = new Option(data.asignacion.created_at, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#updated');
        option = new Option(data.asignacion.updated_at, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#ponente');
        option = new Option(data.asignacion.ponente, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#proyectista');
        option = new Option(data.asignacion.proyectista, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#folio');
        option = new Option(data.asignacion.num_asignacion, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#clave_alfa');
        option = new Option(data.asignacion.clave_alfanumerica, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

        var x = $('#estado');
        option = new Option(data.asignacion.estado, data.asignacion.id, true, true);
        x.append(option).trigger('change');
        x.trigger({
            type: 'select2:select',
            params: {
                data: data
            }
        });

         document.getElementById('doc').href='../public/DOCUMENTOSPARAFIRMA/'+data.asignacion.docx;

        

        $('#datatable').DataTable().clear().destroy();

        //FOR EACH PARA AGREGAR LAS PROMOCIONES AL EXPEDIENTE SELECCIONADO
        data.asignaciones.forEach(asignacion => {

            var tabla = document.getElementById("datatable");
            var row = tabla.insertRow(1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = '<td>'+asignacion.name+" "+asignacion.apellido_p+" "+ asignacion.apellido_m+'</td>';
            cell2.innerHTML =  '<td>'+asignacion.funcion+'</td>';
            cell3.innerHTML =  '<td><span class="badge badge-danger">'+asignacion.estado+'</span></td>';
            cell4.innerHTML =  '<td>'+asignacion.created_at+'</td>';          

        });//END FOREACH PROMOCIONES
        
         
          
      }});

}

function validaPassword(form){
    var dataString = $('#formulario_pass').serialize(); // carga todos 
      var token = $("#token").val();
  $.ajax({
      type: "GET",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: '/passwordvalida',
      data: dataString,
      success: function (data) {
          if(data.resp == 1){
            document.getElementById("error_pass").innerHTML = "";  
            formulario = document.formulario;
            formulario.submit();
           // document.getElementById("wizard-validation-form").submit();
          }else{
          document.getElementById("error_pass").innerHTML = "La contraseña no coincide.";
          }
         
          
      }});
    
}

function valida_envio_firma(){
    $("#modal_pass").modal();
    return false;

}


function tipo_documento(tipo){
    if(tipo == "ACUERDO"){
        document.getElementById('display_sentencia').style.display = 'none';
        document.getElementById('display_acuerdo').style.display = 'block';
    
        document.getElementById('sala').required = false;
        document.getElementById('proyectista').required = false;
        document.getElementById('ponente').required = false;
        document.getElementById('tipoAcuerdo').required = true;
        document.getElementById('actores').required = true;      

    }else if(tipo == "SENTENCIA"){
        document.getElementById('display_sentencia').style.display = 'block';
        document.getElementById('display_acuerdo').style.display = 'none';
    
        document.getElementById('sala').required = true;
        document.getElementById('proyectista').required = true;
        document.getElementById('ponente').required = true;
        document.getElementById('tipoAcuerdo').required = false;
        document.getElementById('actores').required = false;      

    }

}

function tabla_historial(){
    var dataString = $('#formulario_pass').serialize(); // carga todos 
    var token = $("#token").val();
$.ajax({
    type: "GET",
    headers: { 'X-CSRF-TOKEN': token },
    method: 'get',
    url: '/passwordvalida',
    data: dataString,
    success: function (data) {
        if(data.resp == 1){
          document.getElementById("error_pass").innerHTML = "";  
          formulario = document.formulario;
          formulario.submit();
         // document.getElementById("wizard-validation-form").submit();
        }else{
        document.getElementById("error_pass").innerHTML = "La contraseña no coincide.";
        }
       
        
    }});

}
