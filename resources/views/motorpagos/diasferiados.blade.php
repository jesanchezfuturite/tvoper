@extends('layout.app')

@section('content')
<h3 class="page-title"> Configuración de motor de pagos <small>Días feriados</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración de motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Días Feriados</a>
        </li>
    </ul>
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info:</strong> Esta configuración te permite dar de alta un día feriado o inhábil para el cálculo de impuestos, o asignación de las fechas de vencimiento para una referencia.
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-1">Selecciona</label>
            <div class="col-md-3">
                <select class="select2me form-control" name="itemsTipo" id="itemsTipo" onchange="findDiasferiados()">
                  <option value="E">Estatal</option>
                  <option value="F">Federal</option>
                </select> 
            </div>
        </div>
    </div>
    <span class="help-block">&nbsp;</span>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-md-1">Día feriado</label>
            <div class="col-md-3">
                <input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha" data-date-format='yyyy-mm-dd'>
            </div>
            <div class="col-md-1">
                <button class="btn blue" onclick="guardar()" type="submit">
                    Agregar
                </button>
            </div>
        </div>
    </div>
    <span class="help-block">&nbsp;</span>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-bell-o"></i>Días guardados
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                  <table id="table" class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                    <tr>
                        <th> <i class="fa fa-calendar"></i> Fecha </th>
                        <th> Tipo </th>
                        <th> </th>
                      </tr>
                    </thead>
                  <tbody>
                        @foreach( $saved_days as $sd)
                        <tr>
                            <td hidden>{{$sd["Ano"]}}-{{$sd["Mes"]}}-{{$sd["Dia"]}}</td>
                            <td class="highlight">                              
                              <div class="success"></div>
                              <a href="javascript:;"> 
                                &nbsp; {{$sd["Ano"]}} - {{$sd["Mes"]}} - {{$sd["Dia"]}}  
                              </a>                     
                                
                            </td>
                            <td class="highlight">
                               @if ($sd["tipo"]=="E")
                              <a href="javascript:;" > 
                                    Estatal  
                                </a>
                               @else
                               <a href="javascript:;"> 
                                    Federal  
                                </a>
                               @endif
                            </td>
                            <td>
                                <a  class='btn default btn-xs black' data-toggle='modal' href='#static' onclick='deleteDias("{{$sd->Ano}}","{{$sd->Mes}}","{{$sd->Dia}}" )'>
                                <i class="fa fa-trash-o" ></i> Borrar </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
</div>
<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
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
                 <input hidden="true" type="text" name="deldia" id="deldia" class="deldia">
                 <input hidden="true" type="text" name="delmes" id="delmes" class="delmes">
                 <input hidden="true" type="text" name="delano" id="delano" class="delano">
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
<script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="assets/admin/pages/scripts/components-pickers.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {       
       ComponentsPickers.init();
       sortTable();
    });   
	function guardar() {
	  
    var itemsTipo = $("#itemsTipo").val();
		var date = $("#datetime1").val();
    if(date.length==0)
    {
      Command: toastr.warning("Campo fecha, Requerido!", "Notifications")
    return;
    }
		  $.ajax({
            method: "POST",
            url: "{{ url('/dias-feriados-insert') }}",
            data: { fecha:date,tipo:itemsTipo, _token: '{{ csrf_token() }}' }
        })
          .done(function(response){ 
            if(response.Code =="200"){
              Command: toastr.success(response.Message, "Notifications")
              document.getElementById("datetime1").value="";
              findDiasferiados();
            }else{
              Command: toastr.warning(response.Message, "Notifications")
            }
           })
        .fail(function( msg ) {
            Command: toastr.warning("Failed to Add", "Notifications")
        });
    
	}
  function findDiasferiados()
  {   
    var itemsTipo = $("#itemsTipo").val();
      $.ajax({
            method: "POST",
            url: "{{ url('/dias-feriados-find') }}",
            data: { tipo:itemsTipo, _token: '{{ csrf_token() }}' }
        })
        .done(function(response){ 
            var Resp=$.parseJSON(response);
            var tipo = '';
            $("#table tbody tr").remove();
              $.each(Resp, function(i, item) {  
                if(item.tipo=="E")
                {tipo="Estatal";
                }else{tipo="Federal";}              
                 $('#table tbody').append("<tr>"                
                 + "<td class='highlight'><div class='success'></div><a href='javascript:;'> &nbsp;" + item.Ano +" - "+ item.Mes +" - "+ item.Dia + "</a></td>" 
                 +"<td class='highlight'><a href='javascript:;'>"+tipo+"</a></td>"                
                 + "<td><a  class='btn default btn-xs black' data-toggle='modal' href='#static' onclick='deleteDias(\""+item.Ano+"\",\""+item.Mes+"\",\""+item.Dia+"\")'><i class='fa fa-trash-o'></i> Borrar </a></td>"                  
                 + "</tr>");
                 
                });
                sortTable();
           })
        .fail(function( msg ) {
            Command: toastr.warning("Failed to Add", "Notifications")
        });
  }
	function deleted()
	{
      var ano_ = $("#delano").val();
      var mes_ = $("#delmes").val();
      var dia_ = $("#deldia").val();
      var itemsTipo = $("#itemsTipo").val(); 
		$.ajax({
           method: "POST",
           url: "{{ url('/dias-feriados-eliminar') }}",
           data: { ano: ano_, mes: mes_, dia: dia_,tipo:itemsTipo, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
            if(response.Code =="200"){
              Command: toastr.success(response.Message, "Notifications")
              findDiasferiados();
            }else{
              Command: toastr.warning(response.Message, "Notifications")
            }
         })
  }
  function deleteDias(ano,mes,dia)
  {
    document.getElementById("deldia").value=dia;
    document.getElementById("delmes").value=mes;
    document.getElementById("delano").value=ano;
  }
  function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("table");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
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

</script>
@endsection
