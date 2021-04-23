function Login() {
    if(document.querySelector('[id="USER"]').value=="" || document.querySelector('[id="PASSWORD"]').value==""){
        Swal.fire({
          title: 'Datos incompletos!',
          text: 'Llena todos los datos del formulario',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
    }
    else{
      var archivos = new FormData();
      archivos.append('USER',document.querySelector('[id="USER"]').value);
      archivos.append('PASSWORD',document.querySelector('[id="PASSWORD"]').value);
      var ruta = "PHP/Login.php";
      $.ajax({
        url: ruta,
        type: "POST",
        data: archivos,
        contentType: false,
        processData: false,
        success: function(datos)
        {  
          if(datos=="incorrecto"){
            Swal.fire({
              title: 'Datos incorrecto!',
              text: 'Intenta de nuevo',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          }
          else{
            location.href='home.html';
          }
        }
      });
    }
  }
  function abrirNuevoTab(url) {
    // Abrir nuevo tab
    var win = window.open(url, '_blank');
    // Cambiar el foco al nuevo tab (punto opcional)
    win.focus();
  }
  function Home() { 
    var ruta = "PHP/Home.php";
    $.ajax({
      url: ruta,
      success: function(datos)
      {  
        if(datos=="login"){
          Swal.fire(
            'Sesión caducada!',
            'Vuelve a iniciar sesión',
            'info'
  
          ).then((result) => {
              location.href='index.html';
          })
        }
        else{
          $("#contenido").html(datos.split("@LABEL@")[0]);
          $("#inicio").fadeIn(1000);
          $('#etiq_name').text(datos.split("@LABEL@")[1]);
          Seleccion_menu(1);
        }
      }
    });
  }
  function Seleccion_menu(NUMERO){
    for (let index = 1; index <= 6; index++) {
      var element = document.getElementById("menu"+index);
      element.classList.remove("active");
    }
    var element = document.getElementById("menu"+NUMERO);
    element.classList.add("active");
  }
  function Oficialia_nuevo_ingreso_load(){
    var ruta = "PHP/Oficialia/Nuevo_ingreso_load.php";
    $.ajax({
      url: ruta,
      success: function(datos)
      {  
        if(datos=="login"){
          Swal.fire(
            'Sesión caducada!',
            'Vuelve a iniciar sesión',
            'info'
  
          ).then((result) => {
              location.href='index.html';
          })
        }
        else{
          $("#contenido").html(datos.split("@LABEL@")[0]);
          $("#inicio").fadeIn(1000);
          $('#etiq_name').text(datos.split("@LABEL@")[1]);
          Seleccion_menu(2);
          $('.select2-multiple').select2();
        }
      }
    });
  }
  function Configuracion_catalogos_load(){
    var ruta = "PHP/Configuracion/Catalogos_load.php";
    $.ajax({
      url: ruta,
      success: function(datos)
      {  
        if(datos=="login"){
          Swal.fire(
            'Sesión caducada!',
            'Vuelve a iniciar sesión',
            'info'
  
          ).then((result) => {
              location.href='index.html';
          })
        }
        else{
          $("#contenido").html(datos.split("@LABEL@")[0]);
          $("#inicio").fadeIn(1000);
          $('#etiq_name').text(datos.split("@LABEL@")[1]);
          Seleccion_menu(6);
        }
      }
    });
  }
  function Cargar_listas(){
    if (document.querySelector('[id="lista"]').value=="Seleccione..."){
        $("#resultado").html('');
    }
    else{
        var ruta = "PHP/Configuracion/Listas_encontradas.php";
        var archivos = new FormData();    
        archivos.append('lista',document.querySelector('[id="lista"]').value);
        $.ajax({
            url: ruta,
            type:'POST', 
            contentType:false, 
            data:archivos, 
            processData:false, 
            cache:false,
            beforeSend: function () {
                    
                },
            success: function(datos)
            {   
                $("#resultado").html(datos);
                $("#datos_encontrados").show("slide");     
            }
        });
    }
  }
  function Acciones_listas(ACCION){
    var ruta = "PHP/Configuracion/Acciones_listas.php";
    if (ACCION=="3") {
        Swal.fire({
          title: 'Estas segur@?',
          text: "Esta acción no se puede revertir!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Borrar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            var archivos = new FormData();    
            archivos.append('lista_resultado',document.querySelector('[id="lista_resultado"]').value);
            archivos.append('lista',document.querySelector('[id="lista"]').value);
            archivos.append('accion',ACCION);
  
            $.ajax({
                url: ruta,
                type:'POST', 
                contentType:false, 
                data:archivos, 
                processData:false, 
                cache:false,
                beforeSend: function () {
                        
                    },
                success: function(datos)
                {   
                    Cargar_listas();
                }
            });
          }
        })
            
    }
    else if (ACCION=="1") {
        Swal.fire({
          title: 'Nombre',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Subir',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true
        }).then((result) => {
          if (result.value) {
            var archivos = new FormData();
            archivos.append('lista',document.querySelector('[id="lista"]').value);
            archivos.append('accion',ACCION);
            archivos.append('NOMBRE',result.value);
  
            $.ajax({
                url: ruta,
                type:'POST', 
                contentType:false, 
                data:archivos, 
                processData:false, 
                cache:false,
                beforeSend: function () {
                        
                    },
                success: function(datos)
                {   
  
                    if (datos=="nombre") {
                        Swal.fire(
                          'Error de nombre!',
                          'Ya se encuetra registrado un elemento con el mismo nombre',
                          'info'
  
                        ).then((result) => {
                            
                        })
                    }
                    else{
                        Cargar_listas(); 
                    }
                    
                }
            });
          }
        })
    }
    else if (ACCION=="2") {
        Swal.fire({
          title: 'Nombre',
          input: 'text',
          inputValue: document.querySelector('[id="lista_resultado"]').value,
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Subir',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true
        }).then((result) => {
          if (result.value) {
            var archivos = new FormData();
            archivos.append('lista',document.querySelector('[id="lista"]').value);
            archivos.append('lista_resultado',document.querySelector('[id="lista_resultado"]').value);
            archivos.append('accion',ACCION);
            archivos.append('NOMBRE',result.value);
  
            $.ajax({
                url: ruta,
                type:'POST', 
                contentType:false, 
                data:archivos, 
                processData:false, 
                cache:false,
                beforeSend: function () {
                        
                    },
                success: function(datos)
                {   
                    if (datos=="nombre") {
                        Swal.fire(
                          'Error de nombre!',
                          'Ya se encuetra registrado un elemento con el mismo nombre',
                          'info'
  
                        ).then((result) => {
                            
                        })
                    }
                    else{
                        Cargar_listas(); 
                    }
                    
                }
            });
          }
        })
    } 
  }
  function Nueva_opcion(TIPO){
    var lista = "";
    if(TIPO == "1"){
      lista = "Actor";
    }
    else if(TIPO == "2"){
      lista = "Demandado";
    }
    else if(TIPO == "3"){
      lista = "Abogado";
    }
    else{
      lista = "Tercero Interesado";
    }
    var ruta = "PHP/Configuracion/Acciones_listas.php";
    var archivos = new FormData();
            archivos.append('lista',lista);
            archivos.append('accion',"1");
            archivos.append('NOMBRE',document.querySelector('[id="nuevo'+TIPO+'"]').value);
  
            $.ajax({
                url: ruta,
                type:'POST', 
                contentType:false, 
                data:archivos, 
                processData:false, 
                cache:false,
                beforeSend: function () {
                        
                    },
                success: function(datos)
                {   
  
                    if (datos=="nombre") {
                        Swal.fire(
                          'Error de nombre!',
                          'Ya se encuetra registrado un elemento con el mismo nombre',
                          'info'
  
                        ).then((result) => {
                            
                        })
                    }
                    else{
                      $('#opcion'+TIPO).prepend("<option>"+document.querySelector('[id="nuevo'+TIPO+'"]').value+"</option>");
                      var selectedItems = $("#opcion"+TIPO).val();
                      selectedItems.push(document.querySelector('[id="nuevo'+TIPO+'"]').value);
                      $('#opcion'+TIPO).val(selectedItems);
                      document.querySelector('[id="nuevo'+TIPO+'"]').value = "";  
                    }
                }
            });
  
  }
  function Nuevo_ingreso_seleccion(){  
      if(document.querySelector('[id="tipo_ingreso"]').value!="Seleccione..."){
        var archivos = new FormData();
        archivos.append('TIPO',document.querySelector('[id="tipo_ingreso"]').value);
        var ruta = "PHP/Oficialia/Nuevo_ingreso_seleccion.php";
        $.ajax({
          url: ruta,
          type: "POST",
          data: archivos,
          contentType: false,
          processData: false,
          success: function(datos)
          {  
            $("#resultado_seleccion").html(datos);
            $("#resultado_seleccion_datos").fadeIn(1000);
            $('.select2-multiple').select2();
            $('.dropify').dropify();
          }
        });
      }
      else{
        $("#resultado_seleccion").html("");
      }
  }
  function Subir_expediente(){
    var actor = "",demandado="",abogado="",tercero="";
    for (let index = 0; index < $('#opcion1').val().length; index++) {
      actor = actor + $('#opcion1').val()[index];
      if(index!=$('#opcion1').val().length - 1){
        actor = actor + "@SEP@";
      }
    }
    for (let index = 0; index < $('#opcion2').val().length; index++) {
      demandado = demandado + $('#opcion2').val()[index];
      if(index!=$('#opcion2').val().length - 1){
        demandado = demandado + "@SEP@";
      }
    }
    for (let index = 0; index < $('#opcion3').val().length; index++) {
      abogado = abogado + $('#opcion3').val()[index];
      if(index!=$('#opcion3').val().length - 1){
        abogado = abogado + "@SEP@";
      }
    }
    for (let index = 0; index < $('#opcion4').val().length; index++) {
      tercero = tercero + $('#opcion4').val()[index];
      if(index!=$('#opcion4').val().length - 1){
        tercero = tercero + "@SEP@";
      }
    }
    var archivos = document.getElementById("archivo1");
    var archivo1 = archivos.files;
    archivos = document.getElementById("archivo2");
    var archivo2 = archivos.files;
    if(actor=="" || demandado=="" || abogado=="" || tercero=="" || 
        document.querySelector('[id="hojas_escrito"]').value=="" || 
        document.querySelector('[id="hojas_anexos"]').value=="" || 
        document.querySelector('[id="hojas_traslados"]').value==""){
          Swal.fire({
            title: 'Error!',
            text: 'Favor de llenar todos los datos',
            icon: 'info',
            confirmButtonText: 'Aceptar'
          });
    } 
    else if(archivo1.length == 0){
      Swal.fire({
        title: 'Error!',
        text: 'Falta archivo escaneo de escrito',
        icon: 'info',
        confirmButtonText: 'Aceptar'
      });
    }
    else if(archivo2.length == 0){
      Swal.fire({
        title: 'Error!',
        text: 'Falta archivo escaneo de anexos',
        icon: 'info',
        confirmButtonText: 'Aceptar'
      });
    }
    else{
      var archivos = new FormData();
        archivos.append('ACTOR',actor);
        archivos.append('DEMANDATO',demandado);
        archivos.append('ABOGADO',abogado);
        archivos.append('TERCERO',tercero);
        archivos.append('TIPO',document.querySelector('[id="tipo_ingreso"]').value);
        archivos.append('HOJAS_ESCRITO',document.querySelector('[id="hojas_escrito"]').value);
        archivos.append('HOJAS_ANEXOS',document.querySelector('[id="hojas_anexos"]').value);
        archivos.append('HOJAS_TRASLADOS',document.querySelector('[id="hojas_traslados"]').value);
        archivos.append('archivo1',archivo1[0]);
        archivos.append('archivo2',archivo2[0]);
        var ruta = "PHP/Oficialia/Subir_expediente.php";
        $.ajax({
          url: ruta,
          type: "POST",
          data: archivos,
          contentType: false,
          processData: false,
          async:false,
          success: function(datos)
          {  
            Swal.fire({
              title: 'Correcto',
              icon: 'success',
              html:
                'Puede descargar su acuse en el siguiente ' +
                '<a href="//sweetalert2.github.io">Enlace</a>',
              showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              Buscar_expedientes('2');
            })
          }
        });
    }
  }
  function Subir_expediente2(){
   
    var archivos = document.getElementById("archivo1");
    var archivo1 = archivos.files;
    archivos = document.getElementById("archivo2");
    var archivo2 = archivos.files;
    if(document.querySelector('[id="hojas_escrito"]').value=="" || 
        document.querySelector('[id="hojas_anexos"]').value==""){
          Swal.fire({
            title: 'Error!',
            text: 'Favor de llenar todos los datos',
            icon: 'info',
            confirmButtonText: 'Aceptar'
          });
    } 
    else if(archivo1.length == 0){
      Swal.fire({
        title: 'Error!',
        text: 'Falta archivo escaneo de escrito',
        icon: 'info',
        confirmButtonText: 'Aceptar'
      });
    }
    else if(archivo2.length == 0){
      Swal.fire({
        title: 'Error!',
        text: 'Falta archivo escaneo de anexos',
        icon: 'info',
        confirmButtonText: 'Aceptar'
      });
    }
    else{
      var archivos = new FormData();
        archivos.append('ACTOR',document.querySelector('[id="opcion1"]').value);
        archivos.append('DEMANDATO',document.querySelector('[id="opcion2"]').value);
        archivos.append('ABOGADO',document.querySelector('[id="opcion3"]').value);
        archivos.append('TERCERO',document.querySelector('[id="opcion4"]').value);
        archivos.append('TIPO',document.querySelector('[id="tipo_ingreso"]').value);
        archivos.append('EXPEDIENTE',document.querySelector('[id="expediente"]').value);
        archivos.append('HOJAS_ESCRITO',document.querySelector('[id="hojas_escrito"]').value);
        archivos.append('HOJAS_ANEXOS',document.querySelector('[id="hojas_anexos"]').value);
        archivos.append('archivo1',archivo1[0]);
        archivos.append('archivo2',archivo2[0]);
        var ruta = "PHP/Oficialia/Subir_expediente2.php";
        $.ajax({
          url: ruta,
          type: "POST",
          data: archivos,
          contentType: false,
          processData: false,
          async:false,
          success: function(datos)
          {  
            Swal.fire({
              title: 'Correcto',
              icon: 'success',
              html:
                'Puede descargar su acuse en el siguiente ' +
                '<a href="//sweetalert2.github.io">Enlace</a>',
              showCloseButton: false,
              showCancelButton: false,
              focusConfirm: false,
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              Buscar_expedientes('2');
            })
          }
        });
    }
  }
  function Seleccionar_expediente(){
    var ruta = "PHP/Oficialia/Seleccionar_expediente.php";
    $.ajax({
        url: ruta,
        beforeSend: function () {
  
            },
        success: function(datos)
        {
            $("#modal_content").html(datos);
            $("#modal_temp").modal();
        }
    });
  }
  function Buscar_expedientes(TIPO){
    if(TIPO=="1"){
      if (document.querySelector('[id="busqueda"]').value==""){
        Swal.fire({
          title: 'Datos incompletos!',
          text: 'Ingresa datos para la busqueda',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
      }
      else{
          var ruta = "PHP/Oficialia/Buscar_expedientes.php";
          var archivos = new FormData();
          archivos.append('busqueda',document.querySelector('[id="busqueda"]').value);
          archivos.append('TIPO',TIPO);
          $.ajax({
              url: ruta,
              type:'POST',
              contentType:false,
              data:archivos,
              processData:false,
              cache:false,
              beforeSend: function () {
  
                  },
              success: function(datos)
              {
                  if(datos=="no_datos"){
                      Swal.fire({
                        title: 'Sin datos!',
                        text: 'No se encontro ninguna coincidencia',
                        icon: 'info',
                        confirmButtonText: 'Aceptar'
                      });
                      $("#resultado_seleccion").html("");
                  }
                  else{
                      $("#resultado_seleccion").html(datos);
                      $("#datos_encontrados").show("slide");
                  }
  
              }
          });
      }
    }
    else{
      var ruta = "PHP/Oficialia/Buscar_expedientes.php";
          var archivos = new FormData();
          archivos.append('busqueda',document.querySelector('[id="busqueda2"]').value);
          archivos.append('TIPO',TIPO);
          $.ajax({
              url: ruta,
              type:'POST',
              contentType:false,
              data:archivos,
              processData:false,
              cache:false,
              beforeSend: function () {
  
                  },
              success: function(datos)
              {
                  if(datos=="no_datos"){
                      $("#resultado_seleccion").html("");
                  }
                  else{
                      $("#resultado_seleccion").html(datos);
                      $("#datos_encontrados").show("slide");
                  }
  
              }
          });
    }
    
  }
  function Buscar_expedientes2(){
    if (document.querySelector('[id="busqueda"]').value==""){
        Swal.fire({
          title: 'Datos incompletos!',
          text: 'Ingresa datos para la busqueda',
          icon: 'error',
          confirmButtonText: 'Aceptar'
        });
    }
    else{
        var ruta = "PHP/Oficialia/Buscar_expedientes2.php";
        var archivos = new FormData();
        archivos.append('busqueda',document.querySelector('[id="busqueda"]').value);
        $.ajax({
            url: ruta,
            type:'POST',
            contentType:false,
            data:archivos,
            processData:false,
            cache:false,
            beforeSend: function () {
  
                },
            success: function(datos)
            {
                if(datos=="no_datos"){
                    Swal.fire({
                      title: 'Sin datos!',
                      text: 'No se encontro ninguna coincidencia',
                      icon: 'info',
                      confirmButtonText: 'Aceptar'
                    });
                    $("#datos_encontrados").hide("slide");
                }
                else{
                    $("#resultado_modal").html(datos);
                    $("#datos_encontrados").show("slide");
                }
  
            }
        });
    }
  }
  function Seleccionar_expediente_confirmacion(ID_EXPEDIENTE){
    $("#modal_temp").modal('hide');
    var ruta = "PHP/Oficialia/Seleccionar_expediente_confirmacion.php";
        var archivos = new FormData();
        archivos.append('ID_EXPEDIENTE',ID_EXPEDIENTE);
        $.ajax({
            url: ruta,
            type:'POST',
            contentType:false,
            data:archivos,
            processData:false,
            cache:false,
            success: function(datos)
            {
              
              $("#Resultados_expediente").html(datos);
              $('.select2-multiple').select2();
              $('.dropify').dropify();
            }
        });
  }
  function Consultar_expediente_load(){
    var ruta = "PHP/Oficialia/Consultar_expediente_load.php";
    $.ajax({
      url: ruta,
      success: function(datos)
      {  
        if(datos=="login"){
          Swal.fire(
            'Sesión caducada!',
            'Vuelve a iniciar sesión',
            'info'
  
          ).then((result) => {
              location.href='index.html';
          })
        }
        else{
          $("#contenido").html(datos);
          $("#inicio").fadeIn(1000);
          Seleccion_menu(2);
          Buscar_expedientes('2');
          
        }
      }
    });
  }
  