@extends('layout.app')


@section('content')

<style>

.loader {
    border: 8px solid #f3f3f3;
    border-radius: 50% !important;
    border-top: 8px solid #3498db;
    width: 60px;
    height: 60px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    margin: auto;
    position: relative;
    right: 0;
    top: 156px;
    display:none;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<h3 class="page-title">Portal <small>Reporte usuarios</small></h3>
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
            <a href="#">Reporte usuarios</a>
        </li>
    </ul>
</div>
<div class="row">
  <div id="filtros">
    <div class='col-md-4'>
      <span class='help-block'>&nbsp;</span> 
      <div class='form-group'>   
        <label for='status'>Estatus </label>
        <select class="select2me form-control" name="status" id="status" onchange="">
          <option value="null">----------</option>
          <option value="0">Inactivo</option>
          <option value="1">Activo</option>  
        </select> 
      </div>
    </div>
    <div class='col-md-3'>
      <span class='help-block'>&nbsp; </span>
      <div class='form-group'>
        <label for='role'>Role</label>
        <select class="select2me form-control" name="role" id="role" onchange="">
            <option value="0">------</option>
              @foreach($roles as $r)              
                <option value="{{$r->id}}">{{$r->description}}</option>
              @endforeach     
        </select> 
      </div>
    </div>
    <div class='col-md-3'>
      <span class='help-block'>&nbsp;</span>
      <div class='form-group'> 
        <label> Notaria</label> 
        <input type='text' placeholder='Ingrese número de notaria' autocomplete='off' name='notaria' id='notaria' class='form-control'>
      </div>
    </div>
    <div class='col-md-1'>
      <span class='help-block'>&nbsp; </span>
      <span class='help-block'>&nbsp; </span>
      <div class='form-group'>
        <button class='btn blue' id='BuscarTramites' onclick='consultaUsuarios()'>Buscar</button>
      </div>
    </div>
  </div>
</div>
<div class="row">     
  <div class='col-md-2'>
      <span class='help-block'>&nbsp; </span>
      <span class='help-block'>&nbsp; </span>
      <div class='form-group'>
          <button class='btn green' id="usuarios"  >Reporte Usuarios</button>
      </div>
    </div>
  <div class='col-md-2'>
      <span class='help-block'>&nbsp; </span>
      <span class='help-block'>&nbsp; </span>
      <div class='form-group'>
        <button class='btn green' id='subnotaria'  >Reporte Notaria</button>
      </div>
  </div>
</div>
<form id="form_notaria" action="{{url()->route('export-notaria')}}" method="post">
  {{ csrf_field() }}
    <input type="hidden" value="" id="ids_notaria" name="ids_notaria">          
</form>  
<form id="form_users" action="{{url()->route('export')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="" id="ids_array" name="ids">
</form>    

<div class="row">
  <div class="portlet box">
    <div class="portlet-body" id="addtables">
      <span class="help-block">&nbsp;</span>
      <div id="removetable">
        
        <table class="table table-hover" id="sample_2">
          <div class="loader"></div>
          <thead>
            <tr>
            <th></th>
            <th></th>    
            <th>Tipo Rol</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Nombre</th>        
            <th>RFC</th>
            <th>Curp</th>
            <th>Estatus</th>
            <th>Notaria</th>                
            </tr>
          </thead>
          <tbody> </tbody>
        </table>  
      </div>             
    </div>
  </div>
</div>


@endsection

@section('scripts')
	<script type="text/javascript">
   jQuery(document).ready(function() {
      var table =$('#sample_2').DataTable();
        
    $(".dataTables_empty").text("");

      $('#usuarios').click(function() {
        event.preventDefault();     
        $("#form_users").submit();
    
      }); 

      $('#subnotaria').click(function() {   
        event.preventDefault();     
        $("#form_notaria").submit();    
      }); 
       $(document).ajaxStart(function () {        
          $( ".loader" ).show();
       })
      .ajaxStop(function () {
        $( ".loader" ).hide();
      }); 
   
   })


  function consultaUsuarios()
  {     
  
    var notaria = $("#notaria").val();
    var status = $("#status").val();
    var role = $("#role").val();
    $.ajax({
      method: "POST",
      url: "{{ url()->route('find-usuarios') }}",
      data: { notaria:notaria, status:status, role:role, _token: '{{ csrf_token() }}' }
      })
      .done(function (response) {         
          var Resp=$.parseJSON(response);
          createTable(Resp);  

      
    })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }

  function createTable( dataS){
      var table = $('#sample_2').DataTable();
      table.destroy();    

      $('#sample_2').DataTable( {
               "data": dataS,
                "columns": [
                  {"data": "id_usuario", "visible": false},
                  {"data": "id_notary_offices", "visible": false},
                  {"data": "role"},
                  {"data":"username"},
                  {"data":"email"},                 
                  {"data":null,
                  "render": function ( data, type, row ) {
                    return row.name + ' ' + row.fathers_surname+' '+row.mothers_surname;
                    }
                  },
                  {"data": "rfc"},
                  {"data":"curp"},
                  {"data":null,
                  "render": function ( data, type, row ) {
                    return row.status==1 ? '<span class="label label-sm label-success">Activo</span>' : '<span class="label label-sm label-danger">Inactivo</span>';
                    }
                  },
                  {"data":"notary_number"},
                  
                  
                 
              ]
        });

      array=[];
      array_notaria=[];

      var table = $('#sample_2').DataTable();
      table.column(0).data().sort().each(function(value, index) {
        array.push(value);
      });
      table.column(1).data().sort().each(function(value, index) {
        array_notaria.push(value);
      });
      
      var ids = JSON.stringify(array);
      $("#ids_array").val(ids);
      
      let ids_not = Array.from(new Set(array_notaria));
      
      var ids_notaria= JSON.stringify(ids_not);
      $("#ids_notaria").val(ids_notaria);
     
  }
  

</script>
@endsection
