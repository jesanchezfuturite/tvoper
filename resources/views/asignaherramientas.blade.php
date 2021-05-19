@extends('layout.app')

@section('content')

<h3 class="page-title">
Configuración <small> Asignación de Herramientas</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Asignación Herramientas</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet-body">
            <div class="row">
                <h4>Listado de usuarios</h4>
                
                <div class="form-group">
                    
                    <select id="users_select" class="select2me form-control users_select">
                        <option value="0"> ----- </option>
                        @foreach($users as $user)
                            <option value='{{$user->email}}' data-iduser='{{$user->id}}'>{{$user->name}} - ({{$user->email}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">                
                <div class="form-group">
                    <div class="col-md-6">
                        <h4>Estatus</h4>
                    <select class="select2me form-control col-md-6" placeholder="Estatus"  multiple name="itemsEstatus" id="itemsEstatus">
                         @foreach(json_decode(json_encode($status)) as $estatus)
                            <option value='{{$estatus->id}}'>{{$estatus->descripcion}}</option>
                        @endforeach
                    </select>   
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <span class="help-block">&nbsp;</span>
                        <input type="button" name="saveEstatus"class="btn green" value="Guardar" onclick="saveEstatus()"> 
                    </div>
                </div>
            </div>

            <hr>
            <h4>Nivel principal</h4>
            <div class="row">
                <div class=" col-md-3">
                    <select id="principal_level" class="select2me form-control" onchange="changePrincipal_level()">
                        
                    </select>
                </div>
                <div class="col-md-3">
                    Disponibles:
                    <select size="6" id="secondary_level" class="form-control" onchange="changesSecond()">
                        
                    </select>
                </div>
                <div class="col-md-3">
                    
                    <div class="btn-toolbar">
                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10 center-block">
                            <button type="button" class="btn red" id="deleteSecond"> << </button>
                            <button type="button" class="btn green" id="addSecond"> >> </button>
                        </div>
                    </div>
                
                </div>
                <div class="col-md-3">
                    Agregadas:
                    <select size="6"  id="secondary_level_added" class="form-control">
                        
                    </select>
                </div>
            </div>
            
            <hr>
            <h4>Menu Auxiliar</h4>
            <div class="row">
                <div class="col-md-3"> &nbsp;</div>
                <div class="col-md-3">
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
            
                <div class="col-md-3">
                    Agregadas:
                    <select size="6"  id="thirdy_level_added" class="form-control">
                        
                    </select>
                </div>
            </div>
    
        </div>
    </div>
</div>   
<input type="hidden" id="first_level" name="first_level" value="{{ $first_level }}" >
<input type="hidden" id="second_level" name="second_level" value="{{ $second_level }}" >
<input type="hidden" id="third_level" name="third_level" value="{{ $third_level }}" >
<input type="hidden" id="saved_tools" name="saved_tools" value="0" >

<!--<div class="row">
    <div class="col-md-12">
        <button class="btn blue" type="submit">
            Guardar
        </button>
    </div>
</div>-->
@endsection

@section('scripts')
<script type="text/javascript">
    /**
    This method fills the first level in the menu hierarchy
    */
    $( document ).ready(function() {
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
       
    });

    /* 
        It's used when the user selects a principal element in menu
        Loads the second level in each selection
        Loads the tools in the profile selected 
        Validates if which tools has assigned the profile to show in the correct selectbox
    */

    function changePrincipal_level()
    {

        var user = $("#users_select").val();
        var first = $("#principal_level").val();
        var second = $.parseJSON($("#second_level").val());
        var saved = $.parseJSON($("#saved_tools").val());
        if(user == 0)
        {    Command: toastr.warning("Por favor selecciona un Usuario!!", "Notifications")         
    //$("#principal_level").val("0").change();
            
            return false;   
        }
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

    /* 
        This function has been actived when: clicks in green button
        validate than we have a user selected and secondary field selected  
        if all goes well:
            using ajax we will go to the Controller and save the hidden field saved_tools
            with the response updates the select box
        else
            throws Alert exceptions !
    */ 
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
        /* save with ajax in DB */
        $.ajax({
            method: "POST",
            url: "{{ url('/asignaherramientas/saveuserprofile') }}",
            data: { tools: JSON.stringify(newsaved), username: user, _token: '{{ csrf_token() }}' }
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });


    });

    /*
        This function allows to load the initial configuration with the profile selected
        we check with the value selected in users_select if the user is active
        And with the response we load the saved_tools hidden field
    */

    $("#users_select").change(function (){

        var user = $("#users_select").val();
        $("#principal_level").val("0").change();
        if(user == 0)
        {             
            return false;   
        }
        findEstatusUsers();
        // loads the menu that users has saved in DB
        $.ajax({
            method: "POST",
            url: "{{ url('/asignaherramientas/loaduserprofile') }}",
            data: { username: user, _token: '{{ csrf_token() }}' }
        })
        .done( function ( values ) {
            /* here we loads the tools in the profile */
            if(values == ""){
                alert("Error de configuración inicial el usuario tiene vacío el campo menu en la tabla oper_administrator");
            }
            
            $("#saved_tools").val(values);
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });        



    });

    /* 
        delete a menu element added to the profile 
        Validate the selection
        read the tools_saved hidden field and deletes the node selected
        updates the DB
        reloads the secondary and the assigned
    */

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
            url: "{{ url('/asignaherramientas/deleteelementuserprofile') }}",
            data: { username: user, id: added, _token: '{{ csrf_token() }}' }
        })
        .done( function ( values ) {
            /* update the secondary */
            if(values == 0){
                alert("Error al desasignar la herramienta por favor verifica en la Base de Datos !!!");
                return false;
            }

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
            url: "{{ url('/asignaherramientas/saveuserprofile') }}",
            data: { tools: JSON.stringify(newsaved), username: user, _token: '{{ csrf_token() }}' }
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
            url: "{{ url('/asignaherramientas/deleteelementuserprofile') }}",
            data: { username: user, id: added, _token: '{{ csrf_token() }}' }
        })
        .done( function ( values ) {
            /* update the secondary */
            if(values == 0){
                alert("Error al desasignar la herramienta por favor verifica en la Base de Datos !!!");
                return false;
            }

        });
    });
    function saveEstatus()
    {
      var id_user=$("#users_select").val();
      var option = document.querySelector("#users_select").selectedOptions[0].getAttribute("data-iduser");
      var status=$("#itemsEstatus").val();
      if(id_user==0)
      {
         Command: toastr.warning("Usuario sin seleccionar", "Notifications")
        return;
      }
      if(status==null)
      {
        Command: toastr.warning("Estatus sin seleccionar", "Notifications")
        return;
      }

     $.ajax({
           method: "POST", 
           url: "{{ url('/asignaherramientas/saveuserstatus') }}",
           data:{ id_usuario:option, estatus:status,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               return;
             }else{
                Command: toastr.warning(response.Message, "Notifications")
             }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
    function findEstatusUsers()
    {
      var id_user=$("#users_select").val();
       var option = document.querySelector("#users_select").selectedOptions[0].getAttribute("data-iduser"); 
      if(id_user==0)
      {
        $("#itemsEstatus").val(response).trigger('change');
        return;
      }     
     $.ajax({
           method: "POST", 
           url: "{{ url('asignaherramientas/loadstatususer') }}",
           data:{ id_usuario:option,_token:'{{ csrf_token() }}'} })
        .done(function (response) {
             $("#itemsEstatus").val(response).trigger('change');
           if(response.Code=="200")
             {
               Command: toastr.success(response.Message, "Notifications")
               return;
             }else{
                Command: toastr.warning(response.Message, "Notifications")
             }
        })
        .fail(function( msg ) {
         Command: toastr.warning("Error", "Notifications");
        });
    }
</script>
@endsection
