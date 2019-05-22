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
                        <a href="javascript:;" class="btn btn-icon-only red">
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
                        <select size="6" class="form-control" id="second">
                        
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
                        <a href="javascript:;" id="addprincipal" onclick="()" class="btn btn-icon-only green">
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
        </div>

    </div>

</div>

<!-- we added the form here to post the data to the controller and saves the info in DB -->
<!-- levels in menu -->
<input type="hidden" id="first_level" name="first_level" value="[]" >
<input type="hidden" id="second_level" name="second_level" value="[]" >
<input type="hidden" id="third_level" name="third_level" value="[]" >
<input type="hidden" id="final_menu" name="final_menu" value="[]" >

<script type="text/javascript">
    
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
        var hasSecond = false, objSecond = [];
        $.each(jsonObj, function (i,item){

            if(i === principal)
            {
                hasSecond = true;
                objSecond = item;
            }

        });

        /* add the new node in menu */
        item = {}
        item ["title"] = title;
        item ["route"] = route;
        item ["id"] = uniqId();

        objSecond.push(item);

        jsonObj [principal]= objSecond;

        /* add the new element to the field */
        console.log(typeof(jsonObj));
        console.log(JSON.stringify(jsonObj));
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
        var hasSecond = false, objSecond = [];
        $.each(jsonObj, function (i,item){

            if(i === principal)
            {
                hasSecond = true;
                objSecond = item;
            }

        });

        /* delete all elements in the list*/
        $('#second').empty();
        /*refresh select box data*/
        $.each(objSecond, function (i, item) {
            $('#second').append($('<option>', { 
                value: item.id,
                text : item.title 
            }));
        });

    }
</script>
@endsection
