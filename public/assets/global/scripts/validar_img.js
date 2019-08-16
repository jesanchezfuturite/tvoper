$("#file").change(function () {
    if(validarExtension(this)) {
      if(validarPeso(this)) {
       
      }
      else{
        document.getElementById("file").value = "";
      }    
    }else{
        document.getElementById("file").value = "";
    }
    }); 
  function validarExtension(datos) {
  var extensionesValidas = ".png, .gif, .jpeg, .jpg";
  var ruta = datos.value;
  var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
  var extensionValida = extensionesValidas.indexOf(extension);

  if(extensionValida < 0) {
           Command: toastr.warning("La extension no es valida Su fichero tiene de extension  ."+ extension+"", "Notifications") 
            return false;
        } else {
            return true;
        }
    }
    function validarPeso(datos) {

     var pesoPermitido = 1024;

        if (datos.files && datos.files[0]) {

      var pesoFichero = datos.files[0].size/1024;

      if(pesoFichero > pesoPermitido) {
          $('#texto').text();
          Command: toastr.warning("El peso maximo permitido del fichero es: " + pesoPermitido + " KBs Su fichero tiene: "+ pesoFichero +" KBs", "Notifications")
          return false;
      } else {
          return true;
      }
      }
    }