@extends('layout.app')

@section('content')

<h3 class="page-title">
Configuración <small> Menu principal</small>
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
            <a href="#">Menu principal</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            
            <div class="col-sm-4">
                <br />
                <div class="form-body">
                    <div class="form-group">
                        <label>Menu Principal</label>
                        <a href="javascript:;" class="btn btn-icon-only red" id="deletePrincipal">
                            <i class="fa fa-times"></i>
                        </a> 
                        <select size="6" class="form-control" id="principal" onchange="changesPrincipal();">
                        
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nuevo valor</label>
                        <a href="javascript:;" onclick="addPrincipalLevel()" class="btn btn-icon-only green">
                            <i class="fa fa-plus"></i>
                        </a> 
                        <div class="input-icon input-icon-lg right">
                            <i class="fa  fa-bookmark-o"></i>
                            <input type="text" id="principal_title" class="form-control input-lg" placeholder="Título">
                        </div>
                        <div class="input-icon input-icon-lg right">
                            <i class="fa fa-anchor"></i>
                            <input type="text" id="principal_route" class="form-control input-lg" placeholder="Ruta">
                        </div>
                    </div>
                   
                </div>
                    
            </div>
            <div class="col-sm-4">
                <br />
                <div class="form-body">
                    <div class="form-group">
                        <label>Menu Secundario</label>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-times"></i>
                        </a> 
                        <select size="6" class="form-control" id="second" onchange="changesSecond();">
                        
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nuevo valor</label>
                        <a href="javascript:;" onclick="addSecondLevel()" class="btn btn-icon-only green">
                            <i class="fa fa-plus"></i>
                        </a> 
                        <div class="input-icon input-icon-lg right">
                            <i class="fa  fa-bookmark-o"></i>
                            <input type="text" id="second_title" class="form-control input-lg" placeholder="Título">
                        </div>
                        <div class="input-icon input-icon-lg right">
                            <i class="fa fa-anchor"></i>
                            <input type="text" id="second_route" class="form-control input-lg" placeholder="Ruta">
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="col-sm-4">
                <br />
                <div class="form-body">
                    <div class="form-group">
                        <label>Menu Auxiliar</label>
                        <a href="javascript:;" class="btn btn-icon-only red">
                            <i class="fa fa-times"></i>
                        </a> 
                        <select size="6" class="form-control" id="third">
                        
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nuevo valor</label>
                        <a href="javascript:;" onclick="addThirdLevel()" class="btn btn-icon-only green">
                            <i class="fa fa-plus"></i>
                        </a> 
                        <div class="input-icon input-icon-lg right">
                            <i class="fa  fa-bookmark-o"></i>
                            <input type="text" id="third_title" class="form-control input-lg" placeholder="Título">
                        </div>
                        <div class="input-icon input-icon-lg right">
                            <i class="fa fa-anchor"></i>
                            <input type="text" id="third_route" class="form-control input-lg" placeholder="Ruta">
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

    </div>

</div>


<!-- we added the form here to post the data to the controller and saves the info in DB -->
<!-- levels in menu -->
<form action=" {{ url('/adminmenu/saveMenu') }}" method="POST">
@csrf
<input type="hidden" id="first_level" name="first_level" value="{{ $first_level }}" >
<input type="hidden" id="second_level" name="second_level" value="{{ $second_level }}" >
<input type="hidden" id="third_level" name="third_level" value="{{ $third_level }}" >

<div class="row">
    <div class="col-md-12">
        <button class="btn blue" type="submit">
            Guardar
        </button>
    </div>
</div>
</form>
@endsection



@section('scripts')

<script type="text/javascript">

    $( document ).ready(function() {
        var elements = $.parseJSON($("#first_level").val());

        //clean the principal level
        $('#principal').empty();

        $.each(elements,function(i, item){

           $('#principal').append($('<option>', { 
                value: item.id,
                text : item.title 
            })); 

        });

    });

    $("#deletePrincipal").click(function(){
        /* check if it has child levels */

        // get the id
        var id = $("#principal").val();
        var second = $.parseJSON($("#second_level").val());
        // check in second level in fathers field
        var childs = 0;
        $.each(second, function(i,item){
            if(item.id_father == id)
            {
                childs = 1; // here I save the position in the array who has the element without childs
            }
        });
        // if true returns an alert and exit
        if(childs == 1)
        {
            alert("No es posible eliminar el elemento principal del menu porque no esta vacío");
        }else{
            // else delete the node
            var first = $.parseJSON($("#first_level").val());

            $.each(first,function (i,item){
                if(item.id == id)
                {
                    delete first[i];
                } 
            });

            var filtered = first.filter(function (el) {
                return el != null;
            });
            // update the hidden field
            $("#first_level").val(JSON.stringify(filtered));
            /* delete all elements in the list*/
            $('#principal').empty();
            /*refresh select box data*/
            $.each(filtered, function (i, item) {
                console.log(item);   
                $('#principal').append($('<option>', { 
                    value: item.id,
                    text : item.title 
                }));
            }); 
        }
        
    });
    
    function addPrincipalLevel()
    {

        var title = $("#principal_title").val();
        var route = $("#principal_route").val();

        /* validate the info in both fields */
        if(title == "")
        {
            alert("El título en el nivel principal es obligatorio");
            return false;
        }

        if(route == "")
        {
            alert("La ruta en el nivel principal es obligatorio");
            return false;
        }

        /* read the first level menu */
        var jsonObj = $.parseJSON($("#first_level").val());

        /* add the new node in menu */
        item = {}
        item ["title"] = title;
        item ["route"] = route;
        item ["id"] = uniqId();

        jsonObj.push(item);

        /* add the new element to the field */
        $("#first_level").val(JSON.stringify(jsonObj));
        
        /* delete all elements in the list*/
        $('#principal').empty();
        /*refresh select box data*/
        $.each(jsonObj, function (i, item) {
            $('#principal').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

        /* reset fields */
        $("#principal_title").val("");
        $("#principal_route").val("");

    }

    function addSecondLevel()
    {
        /*before send you should select an item in principal level*/

        var principal = $( "#principal" ).val();
        var title = $("#second_title").val();
        var route = $("#second_route").val();


        if(principal === null || principal === undefined)
        {
            alert("Debes seleccionar un menu principal antes de agregar un secundario");
            return false;
        }

        /* validate the info in both fields */
        if(title == "")
        {
            alert("El título en el nivel secundario es obligatorio");
            return false;
        }

        if(route == "")
        {
            alert("La ruta en el nivel secundario es obligatorio");
            return false;
        }

        /* read the values in the second level and filter just with the id primary */
        var jsonObj = {}; 
        jsonObj = $.parseJSON($("#second_level").val());
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

        i = {}
        i ["title"] = title;
        i ["route"] = route;
        i ["id"] = uniqId();
        i ["id_father"] = principal;

        objSecond.push(i);
        jsonObj.push(i);

        /* add the new element to the field */
        $("#second_level").val(JSON.stringify(jsonObj));

        /* delete all elements in the list*/
        $('#second').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#second').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

        /* reset fields */
        $("#second_title").val("");
        $("#second_route").val("");


    }


    function addThirdLevel()
    {
        /*before send you should select an item in second level*/

        var second = $( "#second" ).val();
        var title = $("#third_title").val();
        var route = $("#third_route").val();


        if(second === null || second === undefined)
        {
            alert("Debes seleccionar un menu secundario antes de agregar un auxiliar");
            return false;
        }

        /* validate the info in both fields */
        if(title == "")
        {
            alert("El título en el nivel auxiliar es obligatorio");
            return false;
        }

        if(route == "")
        {
            alert("La ruta en el nivel auxiliar es obligatorio");
            return false;
        }

        /* read the values in the second level and filter just with the id primary */
        var jsonObj = {}; 
        jsonObj = $.parseJSON($("#third_level").val());
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

        i = {}
        i ["title"] = title;
        i ["route"] = route;
        i ["id"] = uniqId();
        i ["id_father"] = second;

        objSecond.push(i);
        jsonObj.push(i);

        /* add the new element to the field */
        $("#third_level").val(JSON.stringify(jsonObj));

        /* delete all elements in the list*/
        $('#third').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#third').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

        /* reset fields */
        $("#third_title").val("");
        $("#third_route").val("");


    }

    /* this generates an id for a new element in menu */
    function uniqId() 
    {
        return Math.round(new Date().getTime() + (Math.random() * 100));
    }

    /* the following function refresh the second select when the principal changes */
    function changesPrincipal()
    {
        var principal = $( "#principal" ).val();

        /* read the values in the second level and filter just with the id primary */
        var jsonObj = $.parseJSON($("#second_level").val());
        
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
        $('#second').empty();
        $('#third').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#second').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

    }

    /* the following function refresh the second select when the principal changes */
    function changesSecond()
    {
        var principal = $( "#second" ).val();

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
        $('#third').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#third').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

    }
</script>
@endsection
