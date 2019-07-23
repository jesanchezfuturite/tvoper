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
            <h4>Listado de usuarios</h4>
            
            <div class="form-group">
                
                <select id="users_select" class="form-control">
                    <option value="0"> ----- </option>
                    @foreach($users as $user)
                        <option value='{{$user->email}}'>{{$user->name}} - ({{$user->email}})</option>
                    @endforeach
                </select>
            </div>
            
            <hr>
            <h4>Nivel principal</h4>
            <div class="row">
                <div class="col-md-3">
                    <select id="principal_level" class="form-control">
                        
                    </select>
                </div>
                <div class="col-md-3">
                    Disponibles:
                    <select size="6" id="secondary_level" class="form-control">
                        
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
            <!--
            <hr>
            <h4>Menu Auxiliar</h4>
            <div class="row">
                <div class="col-md-3"> &nbsp;</div>
                <div class="col-md-3">
                    Disponibles:
                    <select multiple id="secondary_level" class="form-control">
                        <option>Reporte 1</option>
                        <option>Reporte 2</option>
                        <option>Reporte 3</option>
                        <option>Reporte 4</option>
                        <option>Reporte 5</option>
                    </select>
                </div>
                <div class="col-md-3">
                    
                    <div class="btn-toolbar">
                        <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10 center-block">
                            <button type="button" class="btn red"> << </button>
                            <button type="button" class="btn green"> >> </button>
                        </div>
                    </div>
                
                </div>
                <div class="col-md-3">
                    Agregadas:
                    <select multiple id="secondary_level" class="form-control">
                        
                    </select>
                </div>
            </div>
        -->
        </div>
    </div>
</div>   
<input type="hidden" id="first_level" name="first_level" value="{{ $first_level }}" >
<input type="hidden" id="second_level" name="second_level" value="{{ $second_level }}" >
<input type="hidden" id="third_level" name="third_level" value="{{ $third_level }}" >
<input type="hidden" id="saved_tools" name="saved_tools" value="0" >

<div class="row">
    <div class="col-md-12">
        <button class="btn blue" type="submit">
            Guardar
        </button>
    </div>
</div>
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

    $("#principal_level").change( function (){

        var user = $("#users_select").val();

        if(user == 0)
        {
            alert("Debes seleccionar un usuario para agregar una herramienta");
            return false;   
        }


        var first = $("#principal_level").val();

        /* reads the second level and loads the childs in multiple selector */
        var second = $.parseJSON($("#second_level").val());

        /* reads the saved_tools hidden field */
        var saved = $.parseJSON($("#saved_tools").val());
        
        var objList = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        objList.push(i);

        $.each(second, function (i, item){
            
            if(item.id_father == first)
            {   
                if(saved.length == 0)
                {
                    i = {};
                    i ["title"] = item.title;
                    i ["id"] = item.id;
                    objList.push(i);
                }else{

                    $.each(saved, function (j,sv){

                        if(item.id != sv.id)
                        {
                            i = {};
                            i ["title"] = item.title;
                            i ["id"] = item.id;
                            objList.push(i);        
                        }
                    });
                }
                
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

    });

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

        var user = $("#users_select").val();

        if(user == 0)
        {
            alert("Debes seleccionar un usuario para agregar una herramienta");
            return false;   
        }


        if(selected == 0 || selected == null)
        {
            alert("Por favor selecciona una herramienta.");
            return false;
        }

        /* remove element from secondary and update the multi select */
        var second = $.parseJSON($("#second_level").val());
        var aux = {};
        $.each(second, function (i, item){
            
            if(item.id == selected)
            {   
                aux = item;
                delete second[i];
            }

        });

        var filtered = second.filter(function (el) {
            return el != null;
        });

        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        filtered.push(i);

        $('#secondary_level').empty();
        /*refresh select box data*/
        $.each(filtered, function (i, item) { 
            $('#secondary_level').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

        /* add the new element first reads the hidden field */
        var saved = $.parseJSON($("#saved_tools").val());

        /*push aux to saved*/
        saved.push(aux);

        $("#secondary_level_added").empty();

        $.each(saved, function (i, item) { 
            $('#secondary_level_added').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });
        /* save with ajax in DB */
        $.ajax({
            method: "POST",
            url: "{{ url('/asignaherramientas/saveuserprofile') }}",
            data: { tools: JSON.stringify(saved), username: user, _token: '{{ csrf_token() }}' }
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

        if(user == 0)
        {
            alert("Debes seleccionar un usuario para agregar una herramienta");
            return false;   
        }

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

        if(user == 0)
        {
            alert("Debes seleccionar un usuario para agregar una herramienta");
            return false;   
        }

        var added = $("#secondary_level_added").val();

        if(added == 0)
        {
            alert("Debes seleccionar una herramienta para eliminarla del perfil !");
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
        $('#secondary_level_added').empty();
        /*refresh select box data*/
        $.each(filtered, function (i, item) { 
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
        /* adding the second level array */
        var second = $.parseJSON($("#second_level").val());
        var objList = [];
        i = {};
        i ["title"] = '-----';
        i ["id"] = 0;
        objList.push(i);
        $.each(second, function (i, item){
            
            if(item.id_father == first)
            {
                if(filtered.length == 0)
                {
                    i = {};
                    i ["title"] = item.title;
                    i ["id"] = item.id;
                    objList.push(i);   
                }else{
                    $.each(filtered, function (j,sv){

                        if(item.id != sv.id)
                        {
                            i = {};
                            i ["title"] = item.title;
                            i ["id"] = item.id;
                            objList.push(i);        
                        }
                    });
                }
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


    });
    
</script>
@endsection
