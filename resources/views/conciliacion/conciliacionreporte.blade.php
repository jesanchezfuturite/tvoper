@extends('layout.app')

@section('content')
<h3 class="page-title">Conciliación <small> Conciliacion Reporte</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a >Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a >Conciliacion Reporte</a>
        </li>
    </ul>
</div>

<div class="row">
     <div class="portlet box blue">
        <div class="portlet-title" >
          <div class="caption">
            <i class="fa fa-cogs"> </i> Filtros
          </div>
          <div class="tools">                
           <!--<a href="#portlet-perfil"  class="config" data-original-title="" title="Crear Nuevo"></a>
           --> 
          </div>           
        </div>
 
      <div class="portlet-body">
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label col-md-1">Año </label>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <select class="select2me form-control" id="itemYear" onchange="changeMonthYear()">
                            <option value="0"> --------</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Mes </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="select2me form-control" id="itemMonth" onchange="changeMonthYear()">
                        <option value="0"> --------</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Dia </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="select2me form-control" id="itemDay">
                        <option value="0"> --------</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">Archivo </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <select class="select2me form-control" id="itemfilename">
                        <option value="0"> --------</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button class="btn blue" id="busqueda" type="submit" onclick="searhFiles()">
                        Buscar
                    </button>
                </div>
            </div>    
        </div>
      </div>    
    </div>
</div>
<div class="row" >
    <div class="portlet box blue">
        <div class="portlet-title" >
          <div class="caption">
              <div id="borraheader">  <i class="fa fa-cogs"> </i> Reporte Conciliacion</div>
          </div>
          <div class="tools">                
           <!--<a href="#portlet-perfil"  class="config" data-original-title="" title="Crear Nuevo"></a>
           --> 
            <a href="#portlet-perfil" data-toggle="modal" class="tooltips" data-original-title="" title="Editar Registro"><i class='fa fa-pencil' style="color:#d7eaf8 !important;"></i></a>
          </div>           
        </div>
  <div class="portlet-body" id="addtables">
    <div id="removetable">
          <table class="table table-hover" id="sample_2">
            <thead>
              <tr>
              <th>Referencia</th>
              <th>Fecha pago</th>
              <th>Archivo</th>
              <th>Fecha Corte</th>
              <th>Procesado</th>
              <th>En Corte</th>
            </tr>
          </thead>
          <tbody>                   
                         
          </tbody>
        </table>  
      </div>             
    </div>
</div>
</div>
<input type="jsonCode" name="jsonCode" id="jsonCode" hidden="true">
@endsection

@section('scripts')

<script>
    jQuery(document).ready(function() {   
        findYear();
        findMonth();
        findFileName();
    }); 

    function findYear(){
        $.ajax({
           method: "get",            
           url: "{{ url('/get-year') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          $("#itemYear option").remove();
          $("#itemYear").append("<option value='0'>-------</option>");
            $.each(response, function(i, item) {                
               $("#itemYear").append("<option value='"+item.year+"'>"+item.year+"</option>");  
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function findMonth(){
        $.ajax({
           method: "get",            
           url: "{{ url('/get-month') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          $("#itemMonth option").remove();
          $("#itemMonth").append("<option value='0'>-------</option>");
            $.each(response, function(i, item) {                
               $("#itemMonth").append("<option value='"+item.month+"'>"+item.month+"</option>");  
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function findFileName(){
        $.ajax({
           method: "get",            
           url: "{{ url('/get-filename') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
          $("#itemfilename option").remove();
          $("#itemfilename").append("<option value='0'>-------</option>");
            $.each(response, function(i, item) {                
               $("#itemfilename").append("<option value='"+i+"'>"+i+"</option>");  
            });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function searhFiles(){
        var itemYear =$("#itemYear").val();
        var itemDay =$("#itemDay").val();
        var itemMonth =$("#itemMonth").val();
        var itemfilename =$("#itemfilename").val();
        if(itemYear=="0")
        {
            Command: toastr.warning("Campo Año, requerido!", "Notifications") 
        }else if(itemMonth=="0"){
            Command: toastr.warning("Campo Mes, requerido!", "Notifications") 
        }else if(itemDay=="0"){
            Command: toastr.warning("Campo Dia, requerido!", "Notifications") 
        }else if(itemfilename=="0"){
            Command: toastr.warning("Campo Archivo, requerido!", "Notifications") 
        }else{
            findFiles(itemYear,itemMonth,itemDay,itemfilename);
        }
    }
    function findFiles(itemYear,itemMonth,itemDay,itemfilename){
        
        $.ajax({
           method: "POST",            
           url: "{{ url('/get-dataconciliacion') }}",
           data: {day: itemDay,month:itemMonth,year:itemYear,filename:itemfilename,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {  
            console.log(response);
            $.each(response, function(i, item) {                
                $('#sample_2 tbody').append("<tr>"
                  +"<td>"+item.referencia+"</td>"
                  +"<td>"+item.day+"-"+item.month+"-"+item.year+"</td>"
                  +"<td>"+item.filename+"</td>"
                  +"<td>"+item.fecha_ejecucion+"</td>"
                  +"<td>"+item.status+"</td>"
                  +"<td>"+item.fecha_corte+"</td>"
                  +"</tr>"
                ); 
            });
        })
        .fail(function( msg ) {
            console.log(msg);
         Command: toastr.warning("No Success", "Notifications")  });
    }
    function changeMonthYear(){
        var itemYear =$("#itemYear").val();
        var itemMonth =$("#itemMonth").val();
        if(itemYear=="0" || itemMonth=="0")
        {
            $("#itemDay").val("0").change();
        }else{
            $.ajax({
               method: "get",            
               url: "{{ url('/get-days') }}" +"/"+itemMonth+"/"+itemYear,
               data: {_token:'{{ csrf_token() }}'}  })
            .done(function (response) {  
              $("#itemDay option").remove();
              $("#itemDay").append("<option value='0'>-------</option>");
                $.each(response, function(i, item) {                
                   $("#itemDay").append("<option value='"+item.day+"'>"+item.day+"</option>");  
                });
                $("#itemDay").val("0").change();
            })
            .fail(function( msg ) {
             Command: toastr.warning("No Success", "Notifications")  });
        }

    }
    function addtables(){
        $("#addtables div").remove();
        $("#addtables").append("<div id='removetable'><table class='table table-hover' id='sample_2'> <thead><tr>"
            +"<th>Referencia</th>"
            +"<th>Fecha pago</th>"
            +"<th>Archivo</th>"
            +"<th>Fecha Corte</th>"
            +"<th>Procesado</th>"
            +"<th>En Corte</th>"
            +"</tr></thead> <tbody></tbody> </table></div>");
    }

</script>
@endsection
