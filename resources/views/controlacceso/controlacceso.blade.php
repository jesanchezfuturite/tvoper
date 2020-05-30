@extends('layout.app')


@section('content')
<h3 class="page-title">Control <small>Control Acceso</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Control</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Control Acceso</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="portlet box blue"  id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Registros Usuarios
            </div>
        </div>
        <div class="portlet-body"> 
            <div class="row">          
            <div class="form-group"> 
             <div class="col-md-6">           
                <button class="btn green" href='#portlet-config' data-toggle='modal' >Nuevo Usario</button>
            </div>
            </div>
            <div class="form-group">
             <div class="col-md-6 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            </div>
        </div>
        </div>       
                  
        <div class="portlet-body" id="Removetable"> 
            <span class="help-block">&nbsp; </span> 
            <table class="table table-hover" id="sample_2">
                <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Correo Electrónico
                    </th>    
                    <th>
                        Dependencia
                    </th>                 
                    <th>
                        &nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                    <td><span class="help-block">No Found</span></td>
                    <td></td>                         
                    <td></td>                                 
                    <td></td>                                 
                </tbody>
            </table>
          
            
        </div>
    </div>
</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Registro Usuarios</h4>
            </div>
            <div class="modal-body">
                    <input hidden="true" type="text"  id="idupdate">
                    <input hidden="true" type="text"  id="idupdate_user_id">

                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Nombre(s):</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Nombres..." id="name">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Apellido Paterno:</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Apellido Paterno" id="ape_paterno">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Apellido Materno:</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Apellido Materno..." id="ape_materno">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Dependecia:</label>
                            <div class="col-md-8">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Ingresa Dependencia..." id="dependencia">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Correo Electrónico:</label>
                            <div class="col-md-8">
                                <input type="email" autocomplete="off" class="form-control" placeholder="Ingresa Correo Electrónico" id="email">
                                 <span id="emailOK" class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Contraseña</label>
                            <div class="col-md-8">
                                <div class="input-icon right">
                                <i  id="pass1"class="fa fa-eye-slash" onclick="onechange1()"  style="cursor:pointer;color: black;"></i>
                                <input type="text" name="password"id="password" autocomplete="new-password" class="form-control" placeholder="Ingresa la Contraseña" value="">
                            </div>
                            </div>
                        </div>
                    </div>
                     <span class="help-block">&nbsp; </span>
                    <div class="row">                    
                        <div class="form-group">
                            <label class="col-md-3 control-label">Confirma Contraseña</label>
                            <div class="col-md-8" >
                            <div class="input-icon right">
                                <i  id="pass2"class="fa fa-eye-slash" onclick="onechange2()"  style="cursor:pointer;color: black;"></i>
                                <input type="text" name="confirmpassword" id="confirmpassword"autocomplete="new-password" class="form-control" placeholder="Confirma la Contraseña" value="" >
                            </div>
                        </div>
                        </div>
                    </div>
                     <span class="help-block">&nbsp; </span>
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="form-group">
                                <button type="submit" class="btn blue" onclick="saveUpdateUser()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                
            </div>
        </div>
    </div>
</div>

<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted">
                 <input hidden="true" type="text" name="iddeleted_user_id" id="iddeleted_user_id">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaUsuario()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Menu</h4>
            </div>
            <div class="modal-body">
                    <input hidden="true" type="text"  id="iduser_menu">
                    <div class="row">
                        <label class="col-md-2 control-label">Nivel Principal:</label>
                        <div class="col-md-6">
                            <select id="principal_level" class="form-control">
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                          <label >Disponibles:</label>  
                        <select size="6" id="secondary_level" class="form-control" onchange="changesSecond()">
                        
                        </select>
                        </div>
                        <div class="col-md-3 center-block">
                            <span class="help-block">&nbsp;</span>
                            <div class="btn-toolbar center-block" >
                                <div class="btn-group btn-group-lg  margin-bottom-10 center-block">
                                    <button type="button" class="btn red" id="deleteSecond"> << </button>
                                    <button type="button" class="btn green" id="addSecond"> >> </button>
                                </div>
                            </div>                
                        </div>
                        <div class="col-md-4">
                            Agregadas:
                            <select size="6"  id="secondary_level_added" class="form-control">
                        
                            </select>
                        </div>
                    </div>
                    <div class="row">

                    </div>
                     <span class="help-block">&nbsp; </span>
                    <div class="row">
                        <div class="col-md-12">            
                            <div class="form-group">
                                <button type="submit" class="btn blue" onclick="saveUpdateUser()"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                
            </div>
        </div>
    </div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {  
        document.getElementById('password').type='password';   
        document.getElementById('confirmpassword').type='password';  
        userCargartabla();
    });
    function userDeleted(id_,user_id_)
    {
        document.getElementById('iddeleted').value=id_;
        document.getElementById('iddeleted_user_id').value=user_id_;
    }
    function eliminaUsuario()
    {   
        var id_=$("#iddeleted").val();
        var user_id_=$("#iddeleted_user_id").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/deleted-user') }}",
           data: {id:id_,user_id:user_id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {           
            var Resp=$.parseJSON(response);        
            $.each(Resp, function(i, item) {                
                if(item.code=='0')
                {
                    Command: toastr.success("Success", "Notifications")
                    userCargartabla();
                }else{
                     Command: toastr.warning(item.message, "Notifications")
                }
            });        
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function saveUpdateUser()
    {
        var id_=$("#idupdate").val();
        if(id_.length==0){
            insertUser();
        }else{
            updateUser();
        }
    }
    function updateUser()
    {   
        var id_=$("#idupdate").val();
        var user_id_=$("#idupdate_user_id").val();
        var nombre_=$("#name").val();
        var apellido_pat_=$("#ape_paterno").val();
        var apellido_mat_=$("#ape_materno").val();
        var dependencia_=$("#dependencia").val();
        var password_=$("#password").val();
        var confirmpassword_=$("#confirmpassword").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/update-user') }}",
           data: {id:id_,user_id:user_id_,nombre:nombre_,apellido_pat:apellido_pat_,apellido_mat:apellido_mat_,dependencia:dependencia_,password:password_,confirmpassword:confirmpassword_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {           
            var Resp=$.parseJSON(response);
        
            $.each(Resp, function(i, item) {                
                if(item.code=='0')
                {
                    Command: toastr.success("Success", "Notifications")
                    userCargartabla();
                }else{
                     Command: toastr.warning(item.message, "Notifications")
                }
            });        
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function userUpdate(id_,user_id_)
    {   
        document.getElementById('idupdate').value=id_;
        document.getElementById('idupdate_user_id').value=user_id_;
        $.ajax({
           method: "post",           
           url: "{{ url('/find-user') }}",
           data: {id:id_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {           
            var Resp=$.parseJSON(response);
        
            $.each(Resp, function(i, item) {                
                document.getElementById('name').value=item.nombre;
                document.getElementById('ape_paterno').value=item.ape_pat;
                document.getElementById('ape_materno').value=item.ape_mat;
                document.getElementById('dependencia').value=item.dependencia;
                document.getElementById('email').value=item.email;
                document.getElementById('password').value=item.password;
                document.getElementById('confirmpassword').value=item.password;
            });  
            $('#email').prop("disabled", true);      
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
     function addTable()
    {
        $('#Addtable').append(
            "<div class='portlet-body' id='Removetable'> <table class='table table-hover' id='sample_2'><thead><tr> <th>Nombre</th><th>Correo Electrónico</th><th>Dependecia</th><th> &nbsp; </th> </tr> </thead> <tbody><tr><td><p>Cargando...<p></td></tr></tbody> </table> </div>"
        );
    }
    function onechange2()
    {
        var nombre=$("#pass2").attr("class");
        if(nombre=="fa fa-eye-slash")
        {
            $("#pass2").removeClass("fa-eye-slash").addClass("fa-eye");
            $('#confirmpassword').attr('type', 'text');
        }else{
            $("#pass2").removeClass("fa-eye").addClass("fa-eye-slash");
            $('#confirmpassword').attr('type', 'password');
        }
    }
    function onechange1()
    {
        var nombre=$("#pass1").attr("class");
        if(nombre=="fa fa-eye-slash")
        {
            $("#pass1").removeClass("fa-eye-slash").addClass("fa-eye");
            $('#password').attr('type', 'text');
        }else{
            $("#pass1").removeClass("fa-eye").addClass("fa-eye-slash");
            $('#password').attr('type', 'password');
        }
    }
    function insertUser()
    {   var nombre_=$("#name").val();
        var apellido_pat_=$("#ape_paterno").val();
        var apellido_mat_=$("#ape_materno").val();
        var dependencia_=$("#dependencia").val();
        var email_=$("#email").val();
        var password_=$("#password").val();
        var confirmpassword_=$("#confirmpassword").val();
        $.ajax({
           method: "post",           
           url: "{{ url('/insert-user') }}",
           data: {nombre:nombre_,apellido_pat:apellido_pat_,apellido_mat:apellido_mat_,dependencia:dependencia_,email:email_,password:password_,confirmpassword:confirmpassword_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {           
            var Resp=$.parseJSON(response);
        
            $.each(Resp, function(i, item) {                
                if(item.code=='0')
                {
                    Command: toastr.success("Success", "Notifications")
                     limpiar();
                     userCargartabla();
                }else{
                     Command: toastr.warning(item.message, "Notifications")
                }
            });        
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }
    function userCargartabla()
    {
        $.ajax({
           method: "get",           
           url: "{{ url('/user-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
        document.getElementById('jsonCode').value=response;            
          var Resp=$.parseJSON(response);
           $("#Removetable").remove();
         addTable();
         $('#sample_2 tbody tr').remove();
        $.each(Resp, function(i, item) {                
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.nombre+" "+item.ape_pat +" "+item.ape_mat +"</td>"
                +"<td>"+item.emial+"</td>"
                +"<td>"+item.dependencia+"</td>"
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only green' data-toggle='modal' href='#config' onclick='userDeleted("+item.id+")'><i class='fa fa-cogs'></i></a><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='' title='Editar' onclick='userUpdate("+item.id+","+item.user_id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick='userDeleted("+item.id+","+item.user_id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged.init();
        })
        .fail(function( msg ) {
         console.log("Error al Cargar Tabla Partidas");  });
    }

    function limpiar()
    {
        document.getElementById('idupdate').value='';
        document.getElementById('idupdate_user_id').value='';
        document.getElementById('name').value='';
        document.getElementById('ape_paterno').value='';
        document.getElementById('ape_materno').value='';
        document.getElementById('dependencia').value='';
        document.getElementById('email').value='';
        document.getElementById('password').value='';
        document.getElementById('confirmpassword').value='';
        valido = document.getElementById('emailOK');
        valido.innerText = "";
        $('#email').prop("disabled", false);
        var nombre=$("#pass1").attr("class");
        if(nombre=="fa fa-eye")
        {
            $("#pass1").removeClass("fa-eye").addClass("fa-eye-slash");
            $('#password').attr('type', 'password');
        }
        var nombre2=$("#pass2").attr("class");
        if(nombre2=="fa fa-eye")
        {
            $("#pass2").removeClass("fa-eye").addClass("fa-eye-slash");
            $('#confirmpassword').attr('type', 'password');
        }
        
    }

    document.getElementById('email').addEventListener('input', function() {
        campo = event.target;
        valido = document.getElementById('emailOK');
        
        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        //Se muestra un texto a modo de ejemplo, luego va a ser un icono
        if (emailRegex.test(campo.value)) {
            valido.innerText = "Válido";
            document.getElementById("emailOK").style.color = "green";
        } else {
            valido.innerText = "Incorrecto";
            document.getElementById("emailOK").style.color = "red";
        }
    });
    function GuardarExcel()
    {
        var JSONData=$("#jsonCode").val();
        JSONToCSVConvertor(JSONData, "USERS", true)
    }
    
    function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
        var f = new Date();
        fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;    
        var CSV = '';    
        //CSV += ReportTitle + '\r\n\n';
        if (ShowLabel) {
            var row = ""; 
            for (var index in arrData[0]) { 
                row += index + ',';
            }
            row = row.slice(0, -1);
            CSV += row + '\r\n';
        } 
        for (var i = 0; i < arrData.length; i++) {
            var row = "";
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }
            row.slice(0, row.length - 1); 
            CSV += row + '\r\n';
        }
        if (CSV == '') {        
            alert("Invalid data");
            return;
        }
        var fileName = fecha;
        fileName += ReportTitle.replace(/ /g,"_");
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
        var link = document.createElement("a");    
        link.href = uri;
        link.style = "visibility:hidden";
        link.download = fileName + ".csv";
        Command: toastr.success("Success", "Notifications")
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection