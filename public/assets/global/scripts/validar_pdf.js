$("#fileSAT").change(function () {
    if(validarExtension(this)) {
        
    }else{
        document.getElementById("fileSAT").value = "";
    }
    });
$("#fileNotario").change(function () {
    if(validarExtension(this)) {
      
    }else{
        document.getElementById("fileNotario").value = "";
    }
    }); 
  function validarExtension(datos) {
  var extensionesValidas = ".pdf";
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
