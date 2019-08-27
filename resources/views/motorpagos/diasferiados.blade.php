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
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">Día feriado</label>
            <div class="col-md-3">
                <input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha">
                <span class="help-block">
                 </span>
                <button class="btn blue" onclick="guardar()" type="submit">
                    Agregar
                </button>
            </div>
        </div>
    </div>
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
                        <th>
                            <i class="fa fa-calendar"></i> Fecha
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( $saved_days as $sd)
                        <tr>
                            <td hidden>{{$sd["anio"]}}-{{$sd["mes"]}}-{{$sd["dia"]}}</td>
                            <td class="highlight">
                                <div class="success"></div>
                                <a href="javascript:;"> 
                                     &nbsp; {{$sd["anio"]}} - {{$sd["mes"]}} - {{$sd["dia"]}}  
                                </a>
                            </td>
                            <td>
                                <a  class="btn default btn-xs black" data-toggle="modal" href="#static">
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
                 <input hidden="true" type="text" name="idvalor" id="idvalor" class="idvalor">
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
    });   
	function guardar() {
	  
		var date = $("#datetime1").datepicker("getDate");
		 var anioj = date.getFullYear();
         var mesj = date.getMonth()+1;
		 var diaj = date.getDate();
		  $.ajax({
            method: "POST",
            url: "{{ url('/dias-feriados-insert') }}",
            data: { anio: anioj, mes: mesj, dia: diaj, _token: '{{ csrf_token() }}' }
        })
          .done(function(response){ 
           //alert(data);
            var Resp=$.parseJSON(response);
            var item = '';
            $("#table tbody tr").remove();
            /*agrega tabla*/
                $.each(Resp, function(i, item) {                
                 $('#table tbody').append("<tr>"  
                 +"<td hidden>"+ item.anio +"-"+ item.mes +"-"+ item.dia + "</td>"                 
                 + "<td class='highlight'><div class='success'></div><a href='javascript:;'> &nbsp;" + item.anio +" - "+ item.mes +" - "+ item.dia + "</a></td>"                 
                 + "<td><a  class='btn default btn-xs black' data-toggle='modal' href='#static'><i class='fa fa-trash-o' ></i> Borrar </a></td>"                  
                 + "</tr>");
                 
                });
            Command: toastr.success("Success!", "Notifications")
           })
        .fail(function( msg ) {
            Command: toastr.warning("Failed to Add", "Notifications")
        });
			toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000"
            }
	}
	$('#table').on('click', 'tr td a', function (evt) {

       var row = $(this).parent().parent();
       var celdas = row.children();
	   var com = new RegExp('\"','g'); 
	   var valor=$(celdas[0]).html();
        document.getElementById('idvalor').value =valor;
    });

	function deleted()
	{
        var fecha = $("#idvalor").val();
        var fecha2= new Date(fecha+" 12:00:00"); 
		var date = fecha2;
		 var anioj = date.getFullYear();
         var mesj = date.getMonth()+1;
		 var diaj = date.getDate();
        
		$.ajax({
           method: "POST",
           url: "{{ url('/dias-feriados-eliminar') }}",
           data: { anio: anioj, mes: mesj, dia: diaj, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
             var Resp=$.parseJSON(response);
            var item = '';
            $("#table tbody tr").remove();
            /*agrega tabla*/
                $.each(Resp, function(i, item) {                
                 $('#table tbody').append("<tr>"  
                 +"<td hidden>"+ item.anio +"-"+ item.mes +"-"+ item.dia + "</td>"                 
                 + "<td class='highlight'><div class='success'></div><a href='javascript:;'> &nbsp;" + item.anio +" - "+ item.mes +" - "+ item.dia + "</a></td>"                 
                 + "<td><a  class='btn default btn-xs black'  data-toggle='modal' href='#static'><i class='fa fa-trash-o'></i> Borrar </a></td>"                  
                 + "</tr>");
                
                });
         Command: toastr.success("Success", "Notifications") })
        .fail(function( msg ) {
         Command: toastr.warning("No deleted", "Notifications")  });
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
         "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "4000",
         "extendedTimeOut": "1000"
        }
    }
    

</script>
@endsection
