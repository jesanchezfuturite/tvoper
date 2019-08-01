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
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label col-md-3">Día feriado</label>
            <div class="col-md-3">
                <input id="datetime1" class="form-control form-control-inline input-medium date-picker" size="16" type="text" value="">
                <span class="help-block">
                Selecciona una fecha </span>
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
                    <table class="table table-striped table-bordered table-advance table-hover">
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
                            <td class="highlight">
                                <div class="success"></div>
                                <a href="javascript:;"> 
                                    {{$sd["anio"]}} -  {{$sd["mes"]}} - {{$sd["dia"]}}  
                                </a>
                            </td>
                            <td>
                                <a href="javascript:;" class="btn default btn-xs black">
                                <i class="fa fa-trash-o"></i> Borrar </a>
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
         var mesj = date.getMonth();
		 var diaj = date.getDate();
		  $.ajax({
            method: "POST",
            url: "{{ url('/dias-feriados-insert') }}",
            data: { anio: anioj, mes: mesj, dia: diaj, _token: '{{ csrf_token() }}' }
        })
        .fail(function( msg ) {
            console.log( "AJAX Failed to add in : " + msg );
        });
			//alert(formatted);
	}
	
	
</script>
@endsection
