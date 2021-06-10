@extends('layout.app')
@section('content')
<link href="assets/global/css/table-scroll.css" rel="stylesheet" type="text/css"/>
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
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="true" aria-hidden="true">
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
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="true">
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
<div class="modal fade" id="config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="true" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Menu</h4>
            </div>
            <div class="modal-body">
                    <input hidden="true" type="text"  id="users_select">
                    <div class="row">
                        <label class="col-md-2 control-label">Nivel Principal:</label>
                        <div class="col-md-6">
                            <select id="principal_level" class="select2me form-control" onchange="changePrincipal_level()">
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
                    <hr>
                    <h4>Menu Auxiliar</h4>
                    <div class="row">                        
                        <div class="col-md-4">
                            Disponibles:
                            <select size="6"  id="thirdy_level" class="form-control">
                        
                            </select>
                        </div>
                        <div class="col-md-3">
                    
                            <div class="btn-toolbar">
                                <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10 center-block">
                                    <button type="button" class="btn red" id="deleteThird"> << </button>
                                    <button type="button" class="btn green" id="addThird"> >> </button>
                                </div>
                            </div>
                
                        </div>
            
                        <div class="col-md-4">
                            Agregadas:
                            <select size="6"  id="thirdy_level_added" class="form-control">
                        
                            </select>
                        </div>
                    </div>
                     <span class="help-block">&nbsp; </span>
                    
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
                    </div>                
            </div>
        </div>
    </div>
</div>
<!-- modal-dialog -->
<div id="ModaldeletePartida" class="modal fade " tabindex="-1"role="dialog" data-backdrop="static" data-keyboard="true">
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
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaUsuario()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="Modalparttidas" class="modal fade " tabindex="-1"  data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarPartidas()"></button>
                <h4 class="modal-title">Agregar Partidas</h4> 
                <input hidden="true" type="text" name="idUserPartidas" id="idUserPartidas">
            </div>
            <div class="modal-body">  
               <div class="col-md-12">
                    <div class='form-group'>
                        <label for="search"class="col-md-2">Buscar:</label>
                        <div class="col-md-8">                        
                            <input type="text" name="search" id="search" class="form-control " placeholder="Escribe...">
                        </div>

                    </div>
                </div>                               
               <div class="row">
                    <div class="col-md-12">
                        <div  id="demo">              
                            <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
                                <thead>
                                  <tr>            
                                   <th>Selecciona</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>No Found</td>
                                  <td></td>
                                </tr>         
                                </tbody>
                            </table>
                        </div> 
                    </div>
                    <input type="hidden" id="selectedChecks" value="[]">
                    <div class="col-md-12 text-right" >
                        <button type="button"class="btn green" onclick="savePartidas()">Agregar</button>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-md-12">
                        <div  id="demo2">              
                            <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table3">
                                <thead>
                                    <tr>            
                                        <th>Agregados</th>
                                    </tr>
                                </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" id="selectedChecksAdded" value="[]">
                </div> 
                <div class="col-md-12 text-right" >
                    <button type="button"class="btn red" onclick="deletedPartidas()">Quitar</button>
                    <button type="button" data-dismiss="modal" class="btn default " onclick="limpiarPartidas()">Cancelar</button>
            
                </div>
            </div>
        </div>
    </div>
</div>

<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
<input type="hidden" id="first_level" name="first_level" value="{{ $first_level }}" >
<input type="hidden" id="second_level" name="second_level" value="{{ $second_level }}" >
<input type="hidden" id="third_level" name="third_level" value="{{ $third_level }}" >
<input type="hidden" id="saved_tools" name="saved_tools" value="0" >
@endsection
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {  
        document.getElementById('password').type='password';   
        document.getElementById('confirmpassword').type='password';  
        userCargartabla();
        level_principal();
    });
    function savePartidas()
    {
      var checkeds=$("#selectedChecks").val();
       var user_id=$("#idUserPartidas").val();      
        if (checkeds.length < 3) {
          Command: toastr.warning("Partidas Sin Seleccionar, Requerido!", "Notifications")
        }else{            
                $.ajax({
                method: "POST",            
                url: "{{ url()->route('insert-partidas-user') }}",
                data: {id_user:user_id,checkedsAll:checkeds,_token:'{{ csrf_token() }}'}  })
                .done(function (response) {
            if(response==0){
              Command: toastr.warning("Ninguno Fue Agregado!", "Notifications")
            }else{ 
             
              Command: toastr.success(" "+response+" Registrados!", "Notifications")}
                FindPartidasTable();        
                FindPartidasTableUser();
                document.getElementById('selectedChecks').value="[]";
            })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function deletedPartidas()
    {
      var checkeds=$("#selectedChecksAdded").val();
       var user_id=$("#idUserPartidas").val();      
        if (checkeds.length < 3) {
          Command: toastr.warning("Partidas Sin Seleccionar, Requerido!", "Notifications")
        }else{            
                $.ajax({
                method: "POST",            
                url: "{{ url()->route('delete-partidas-user') }}",
                data: {id_user:user_id,checkedsAll:checkeds,_token:'{{ csrf_token() }}'}  })
                .done(function (response) {
            if(response==0){
              Command: toastr.warning("Ninguno Fue Agregado!", "Notifications")
            }else{ 
             
              Command: toastr.success(" "+response+" Eliminados!", "Notifications")}
                FindPartidasTable();        
                FindPartidasTableUser();
                document.getElementById('selectedChecksAdded').value="[]";
            })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
        }
    }
    function FindPartidas(user_id)
    {
        document.getElementById('idUserPartidas').value=user_id;
        FindPartidasTable();        
        FindPartidasTableUser();
    }
    function FindPartidasTable()
    {
         var user_id=$("#idUserPartidas").val();
      $.ajax({
        method: "POST",            
        url: "{{ url()->route('find-partidas-where') }}",
        data: {id_user:user_id,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table2").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox'onclick='addRemoveElement("+item.id+");'></td>"
                +"<td  width='10%'>"+item.id+"</td>"
                +"<td  width='90%'>"+item.nombre+"</td>"
                +"</tr>"
            );  
        });
        sortTable();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
     function FindPartidasTableUser()
    {
        var user_id=$("#idUserPartidas").val();
      $.ajax({
        method: "POST",            
        url: "{{ url()->route('find-partidas-user') }}",
        data: {id_user:user_id,_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table3 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table3").append("<tr>"
                +"<td class='text-center'><input id='ch_add_"+item.id+"' type='checkbox'onclick='addRemoveChecks("+item.id+");'></td>"
                +"<td  width='10%'>"+item.id+"</td>"
                +"<td  width='90%'>"+item.nombre+"</td>"
                +"</tr>"
            );  
        });
        sortTable2();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function addRemoveElement(element)
    {
      var eleStatus = $("#ch_"+element).prop("checked");
      var checkedElements = $.parseJSON($("#selectedChecks").val());
      if(eleStatus == true)
      {
        checkedElements.push(element);
        $("#selectedChecks").val(JSON.stringify(checkedElements));
      }else{
        $.each(checkedElements,function(i,value){
            if(element == value){
              delete checkedElements[i];
            }
        });
        var filtered = checkedElements.filter(function (el) {
          return el != null;
        });
        $("#selectedChecks").val(JSON.stringify(filtered));      
      }
    }
     function addRemoveChecks(element)
    {
      var eleStatus = $("#ch_add_"+element).prop("checked");
      var checkedElements = $.parseJSON($("#selectedChecksAdded").val());
      if(eleStatus == true)
      {
        checkedElements.push(element);
        $("#selectedChecksAdded").val(JSON.stringify(checkedElements));
      }else{
        $.each(checkedElements,function(i,value){
            if(element == value){
              delete checkedElements[i];
            }
        });
        var filtered = checkedElements.filter(function (el) {
          return el != null;
        });
        $("#selectedChecksAdded").val(JSON.stringify(filtered));      
      }
    }
    function limpiarPartidas()
    {
        document.getElementById('selectedChecks').value="[]";
        document.getElementById('selectedChecksAdded').value="[]";
        document.getElementById('search').value="";
    }
    /******************************/

    $("#addSecond").click( function(){
        var selected = $("#secondary_level").val();
        var first = $("#principal_level").val();
        var user = $("#users_select").val();
        if(selected == 0 || selected == null)
        {
            Command: toastr.warning("Por favor selecciona una herramienta!!", "Notifications")
            return false;
        }
        var second = $.parseJSON($("#second_level").val());
        var newsaved=[];
        var aux = {};
        $.each(second, function (i, item){
            
            if(item.id == selected)
            {   
                aux = item;
            }
        });
        var existe='false';
        var saved = $.parseJSON($("#saved_tools").val());
        $.each(saved, function (i, item){
            
            if(item.id == selected)
            {   
                existe='true';
            }
            newsaved.push(item);
        });
        if(existe=='true')
        {
            Command: toastr.warning("Ya Existe!!", "Notifications")
            return false;
        }else{
            newsaved.push(aux);
            document.getElementById('saved_tools').value=JSON.stringify(newsaved); 
        }
       var listAdded=[];
        $.each(newsaved, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });
       // console.log(JSON.stringify(newsaved));
        $('#secondary_level_added').empty();
        $.each(listAdded,function(i, item){

           $('#secondary_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 

        });
        $.ajax({
            method: "POST",
            url: "{{ url()->route('update-menu-user') }}",
            data: { tools: JSON.stringify(newsaved), id: user, _token: '{{ csrf_token() }}' }
        })
        .done(function (response) {
              Command: toastr.success("Success", "Notifications")
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });


    }); 
    $("#deleteSecond").click( function (){

        var user = $("#users_select").val();
        var first = $("#principal_level").val();
        var added = $("#secondary_level_added").val();
        if(added == 0 || added == null)
        {
             Command: toastr.warning("Debes seleccionar una herramienta para eliminarla del perfil !", "Notifications")
            return false;   
        }
        var saved = $.parseJSON($("#saved_tools").val());
        /* deletes in select */
        $.each(saved, function (i, item){
            
            if(item.id == added)
            {   
                delete saved[i];
            }

        });
        var filtered = saved.filter(function (el) {
            return el != null;
        });
        var listAdded=[];
        $.each(filtered, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });
        document.getElementById('saved_tools').value=JSON.stringify(filtered);
        $('#secondary_level_added').empty();
        //console.log(JSON.stringify(filtered));
        /*refresh select box data*/
        $.each(listAdded, function (i, item) { 
            $('#secondary_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });
        /* update DB */
        // loads the menu that users has saved in DB
        $.ajax({
            method: "POST",
            url: "{{ url()->route('update-menu-user') }}",
            data: { tools: JSON.stringify(filtered), id: user, _token: '{{ csrf_token() }}' }
        })
        .done(function (response) {
              Command: toastr.success("Success", "Notifications")
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });

    });
      function changesSecond()
    {
        var principal = $( "#secondary_level" ).val();

        /* read the values in the second level and filter just with the id primary */
        var jsonObj = $.parseJSON($("#third_level").val());
        
        var objSecond = [];
        $.each(jsonObj, function (i,item){

            if(item.id_father === principal)
            {
                /* add the new node in menu */
                i = {}
                i ["title"] = item.title;
                i ["route"] = item.route;
                i ["id"] = item.id;
                i ["id_father"] = item.id_father;

                objSecond.push(i);
            }

        });


        /* delete all elements in the list*/
        $('#thirdy_level').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#thirdy_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });
        changesSecond_added();

    }
    function changesSecond_added(){

        var user = $("#users_select").val();

        if(user == 0)
        {
            Command: toastr.warning("Debes seleccionar un usuario para agregar una herramienta", "Notifications")
            return false;   
        }
        var first = $("#secondary_level").val();
        /* reads the second level and loads the childs in multiple selector */
        //var second = $.parseJSON($("#second_level").val());
        var third=$.parseJSON($("#third_level").val());
        /* reads the saved_tools hidden field */
        var saved = $.parseJSON($("#saved_tools").val());        
        var objList = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        objList.push(i);
        $.each(third, function (i, item){            
            if(item.id_father == first)
            {   
                  i = {};
                    i ["title"] = item.title;
                    i ["id"] = item.id;
                    objList.push(i);                
            }
        });
        /* fill the list */
        $('#thirdy_level').empty();
        $.each(objList,function(i, item){
           $('#thirdy_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 
        });

        var listAdded = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        listAdded.push(i);
        /* we update the values in secondary_level_added with the values saved in */
        $.each(saved, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });

        /* fill the list added */
        $('#thirdy_level_added').empty();
        $.each(listAdded,function(i, item){
           $('#thirdy_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 
        });
    };

    $("#addThird").click( function(){
        var first = $("#secondary_level").val();
        var selected = $("#thirdy_level").val();
        var user = $("#users_select").val();
        if(user == 0)
        {
            Command: toastr.warning("Debes seleccionar un usuario para agregar una herramienta", "Notifications")
            return false;   
        }
        if(selected == 0 || selected == null)
        {
            Command: toastr.warning("Por favor selecciona una herramienta.", "Notifications")
            return false;
        }
        /* remove element from secondary and update the multi select */
        var third = $.parseJSON($("#third_level").val());
        var newsaved = [];
        var aux = {};
        $.each(third, function (i, item){            
            if(item.id == selected)
            { aux = item;}

        });
        var existe='false';
        var saved = $.parseJSON($("#saved_tools").val());
        $.each(saved, function (i, item){
            
            if(item.id == selected)
            {   
                existe='true';
            }
            newsaved.push(item);
        });
        if(existe=='true')
        {
            Command: toastr.warning("Ya Existe!!", "Notifications")
            return false;
        }else{
            newsaved.push(aux);
            document.getElementById('saved_tools').value=JSON.stringify(newsaved); 
        }
       var listAdded=[];
        $.each(newsaved, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });
        $("#thirdy_level_added").empty();
        $.each(listAdded, function (i, item) { 
            $('#thirdy_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });
        /* save with ajax in DB */
        $.ajax({
            method: "POST",
            url: "{{ url()->route('update-menu-user') }}",
            data: { tools: JSON.stringify(newsaved), id: user, _token: '{{ csrf_token() }}' }
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });


    });

     $("#deleteThird").click( function (){

        var user = $("#users_select").val();
        var first = $("#secondary_level").val();
        var added = $("#thirdy_level_added").val();

        if(added == 0 || added == null)
        {
            Command: toastr.warning("Debes seleccionar una herramienta para eliminarla del perfil !", "Notifications")
            return false;   
        }

        var saved = $.parseJSON($("#saved_tools").val());
        /* deletes in select */

        $.each(saved, function (i, item){
            
            if(item.id == added)
            {   
                delete saved[i];
            }

        });

        var filtered = saved.filter(function (el) {
            return el != null;
        });
        var listAdded=[];
        $.each(filtered, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });
        document.getElementById('saved_tools').value=JSON.stringify(filtered);
        $('#thirdy_level_added').empty();
        //console.log(JSON.stringify(filtered));
        /*refresh select box data*/
        $.each(listAdded, function (i, item) { 
            $('#thirdy_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });
        /* update DB */
        // loads the menu that users has saved in DB
        $.ajax({
            method: "POST",
            url: "{{ url()->route('update-menu-user') }}",
            data: { tools: JSON.stringify(filtered), id: user, _token: '{{ csrf_token() }}' }
        })
        .done(function (response) {
              Command: toastr.success("Success", "Notifications")
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });

    });

    function changePrincipal_level()
    {
        var user = $("#users_select").val();
        var first = $("#principal_level").val();
        var second = $.parseJSON($("#second_level").val());
        var saved = $.parseJSON($("#saved_tools").val());
        //console.log(saved);
        var objList = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        $.each(second, function (i, item){
            if(item.id_father == first)
            {   
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                objList.push(i);                
            }
        });
        /* fill the list */
        $('#secondary_level').empty();
        $.each(objList,function(i, item){
           $('#secondary_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 
        });
        var listAdded = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        listAdded.push(i);
        /* we update the values in secondary_level_added with the values saved in */
        $.each(saved, function (i,item){
            if(item.id_father == first)
            {
                i = {};
                i ["title"] = item.title;
                i ["id"] = item.id;
                listAdded.push(i);
            }
        });
        /* fill the list added */
        $('#secondary_level_added').empty();
        $.each(listAdded,function(i, item){
           $('#secondary_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 
        });
        $('#thirdy_level_added').empty();
        $('#thirdy_level').empty();
    }
    function level_principal()
    {
        var elements = $.parseJSON($("#first_level").val());
        //clean the principal level
        $('#principal_level').empty();

        $('#principal_level').append($('<option>', { 
                value: 0,
                text : '-----' 
            }));
        $.each(elements,function(i, item){
           $('#principal_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 
        }); 
    }
    function userMenu(id_)
    {
        document.getElementById('users_select').value=id_;
        var user = $("#users_select").val();

        if(user.length == 0)
        {
           
            return false;   
        }

        // loads the menu that users has saved in DB
        $.ajax({
            method: "POST",
            url: "{{ url()->route('load-menu-user') }}",
            data: { id: user, _token: '{{ csrf_token() }}' }
        })
        .done( function ( values ) {
            /* here we loads the tools in the profile */
            if(values == ""){
                
            }
            
            $("#saved_tools").val(values);
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });     
    }
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
           url: "{{ url()->route('deleted-user') }}",
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
           url: "{{ url()->route('update-user') }}",
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
           url: "{{ url()->route('find-user') }}",
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
           url: "{{ url()->route('insert-user') }}",
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
           url: "{{ url()->route('user-find-all') }}",
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
                + "<td class='text-center' width='20%'><a class='btn btn-icon-only green' data-toggle='modal' href='#config' data-original-title='Menu' title='Menu' onclick='userMenu("+item.id+")'><i class='fa fa-cogs'></i></a><a class='btn btn-icon-only yellow' data-toggle='modal' href='#Modalparttidas' data-original-title='Partidas' title='Partidas' onclick='FindPartidas("+item.user_id+")'><i class='fa fa-plus'></i></a><a class='btn btn-icon-only blue' href='#portlet-config' data-toggle='modal' data-original-title='Editar' title='Editar' onclick='userUpdate("+item.id+","+item.user_id+")'><i class='fa fa-pencil'></i></a><a class='btn btn-icon-only red' data-toggle='modal' href='#static' data-original-title='Eliminar' title='Eliminar' onclick='userDeleted("+item.id+","+item.user_id+")'><i class='fa fa-minus'></i></a></td>"
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
        $("#principal_level").val("0").change();
        
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
    function sortTable() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("table2");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[1];
                y = rows[i + 1].getElementsByTagName("TD")[1];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
    function sortTable2() {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("table2");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[1];
                y = rows[i + 1].getElementsByTagName("TD")[1];
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
    $("#search").keyup(function(){
        _this = this;
        $.each($("#table2 tbody tr"), function() {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
        $(this).hide();
        else
        $(this).show();
        });
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