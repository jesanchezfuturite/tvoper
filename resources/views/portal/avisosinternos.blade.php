@extends('layout.app')

@section('content')

<h3 class="page-title">Portal <small>Avisos Internos</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Portal</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Avisos Internos</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            
            <div class="caption" id="headerTabla">
              	<div id="borraheader"> 
              	 	<i class="fa fa-cogs"></i>&nbsp; &nbsp;Avisos &nbsp;
            	</div>
            </div>
            <div class="tools" id="toolsSolicitudes">                
                <a href="#portlet-notifications" data-toggle="modal" class="config" data-original-title="" title="Crear Nuevo">
                </a>
            </div>
        </div>
         <div class="portlet-body" id="addtables">
          <span class="help-block">&nbsp;</span>
    		<div id="removetable">
          		<table class="table table-hover" id="sample_2">
            		<thead>
              			<tr>
                    <th>Nombre</th>
              			<th>Subtitulo</th>
              			<th>Mensaje</th>
            			   <th>&nbsp;</th>
            			</tr>
          			</thead>
          			<tbody>                   
                   
          			</tbody>
        		</table>  
      		</div>             
    	</div>
    </div>
</div>
<!----------------------------------------- Informacion de la Solicitud-------------------------------------------->
<div class="modal fade" id="portlet-notifications" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog" style="width: 70%;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
        <h4 class="modal-title">Configuración Avisos Internos</h4>
      </div>
      <div class="modal-body">
        <input type="text" name="id_notifications" id="id_notifications" hidden="true">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">             
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre"class="form-control"placeholder="Escribe el Nombre..." id="nombre"> 
              </div>
            </div>
            <div class="col-md-6">             
              <div class="form-group">
                <label>Subtitulo</label>
                <input type="text" name="titulo"class="form-control"placeholder="Escribe el Subtitulo..." id="titulo"> 
              </div>
            </div>
          </div>        
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12">             
              <div class="form-group">
                <label>Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Escribe..." id="description"></textarea>
              </div>
            </div>
          </div>        
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="saveUpdate()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()" >Cerrar</button>
      </div>   
    </div>
  </div>
</div>
<!----------------------------------------- deleted config costo-------------------------------------------->
<div id="portlet-deleted" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
             ¿Eliminar Registro?
                </p>
                 <input hidden="true" type="text" name="iddeleted" id="iddeleted" class="iddeleted">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleted()">Confirmar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
	<script type="text/javascript">
	jQuery(document).ready(function() {
    findNotifications();
    });
  function addtable()
  {
    $("#addtables div").remove();
    $("#addtables").append("<table class='table table-hover' id='sample_2'> <thead><tr><th>Nombre</th> <th>Subtitulo</th> <th>Mensaje</th><th>&nbsp;</th></tr> </thead> <tbody></tbody> </table>");
  }
  function findNotifications()
  {

    $.ajax({
      method: "get",
      url: "{{ url()->('find-avisos') }}",
      data: { _token: '{{ csrf_token() }}' }
      })
      .done(function (response) {
         //document.getElementById('jsonCode').value=JSON.stringify(response);
         //console.log(response);
          var Resp=$.parseJSON(response);
        addtable();
        $.each(Resp, function(i, item) {
            $('#sample_2 tbody').append("<tr>"
                +"<td>"+item.name+"</td>"
                +"<td>"+item.title+"</td>"
                +"<td>"+item.description+"</td>"
                + "<td class='text-center' width='20%'>"+
                      "<a class='btn btn-icon-only blue' href='#portlet-notifications' data-toggle='modal'data-original-title=''title='Editar' onclick='notificationUpdate("+JSON.stringify(item)+")'><i class='fa fa-pencil'></i></a>"
                      +"<a class='btn btn-icon-only red' data-toggle='modal' href='#portlet-deleted' onclick='notificationDelete("+item.id+")'><i class='fa fa-minus'></i></a></td>"
                +"</tr>"
                );
            });
        TableManaged2.init2();
    })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
   function saveUpdate()
  {
    var id_=$("#id_notifications").val();
    var name_=$("#nombre").val();
    var title_=$("#titulo").val(); 
    var description_=$("#description").val();

    if(name_.length==0)
    {
      Command: toastr.warning("Campo un Nombre, Requerido!", "Notifications")
      return;
    }else if(title_.length==0)
    {
      Command: toastr.warning("Campo Subtitulo, Requerido!", "Notifications")
      return;
    }else if(description_.length==0)
    {
      Command: toastr.warning("Campo Mensaje, Requerido!", "Notifications")
      return;
    }else{   
      if(id_.length==0)
      {
        insertNotifications();
      }else{
         updateCostoNotifications();
      }
    }
  }
  function insertNotifications()
  {
     var name_=$("#nombre").val();
    var title_=$("#titulo").val(); 
    var description_=$("#description").val();
      $.ajax({
           method: "POST",
           url: "{{ url()->('create-avisos') }}",
           data: {name:name_,title:title_,description:description_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
          }else{
            Command: toastr.warning(response.Message, "Notifications")
          }
             findNotifications();
             limpiar();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function notificationUpdate(response)
  {
    console.log(response);
    var Resp=response;
     document.getElementById('id_notifications').value=Resp.id;
      document.getElementById('nombre').value=Resp.name;
      document.getElementById('titulo').value=Resp.title;
      document.getElementById('description').value=Resp.description;
  }
  function updateCostoNotifications()
  {
    var id_=$("#id_notifications").val();
    var name_=$("#nombre").val();
    var title_=$("#titulo").val(); 
    var description_=$("#description").val();
      $.ajax({
           method: "POST",
           url: "{{ url()->('update-avisos') }}",
           data: {id:id_,name:name_,title:title_,description:description_,_token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
          }else{
            Command: toastr.warning(response.Message, "Notifications")
          }
             findNotifications();
             limpiar();

        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function notificationDelete(id_)
  {
     document.getElementById('iddeleted').value=id_;
  }
  function deleted()
  {
    var id_=$("#iddeleted").val();
    $.ajax({
           method: "POST",
           url: "{{ url()->('delete-avisos') }}",
           data: {id:id_, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {

         if(response.Code =="200"){
            Command: toastr.success(response.Message, "Notifications")
            }else{
              Command: toastr.warning(response.Message, "Notifications")
            }
            limpiar();
            findNotifications();
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function limpiar()
  {
    document.getElementById('iddeleted').value='';
    document.getElementById('id_notifications').value='';
    document.getElementById('nombre').value='';
    document.getElementById('titulo').value='';
    document.getElementById('description').value='';

  }

</script>
@endsection
