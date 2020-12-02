@extends('layout.app')

@section('content')

<h3 class="page-title">Portal <small>Calculo</small></h3>
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
            <a href="#">Calculo</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
           
            <div class="caption" id="headerTabla">
              	<div id="borraheader"> 
              	 	<i class="fa fa-cogs"></i>&nbsp; &nbsp;Calculo &nbsp;
            	</div>
            </div>
            <div class="tools" id="toolsSolicitudes">                
                <a href="#" data-toggle="modal" class="config" data-original-title="" title="">
                </a>
            </div>
        </div>
         <div class="portlet-body form" >
         	<div class="form-body"> 
         		<span class="help-block">&nbsp;</span>
          		<div class="row">
          			<div class=" col-md-offset-3 col-md-9 ">
	          			<div class="form-group">						
							<label class="col-md-3 control-label">Fecha Escritura</label>

							<div class="col-md-4">
								<input id="fecha" class="form-control form-control-inline date-picker" size="16" type="text" value="" autocomplete="off" placeholder="Selecciona una fecha" required="true">
							</div>
						</div>	
		        	</div>
		        </div>
		        <span class="help-block">&nbsp;</span>
		     	<div class="row">
          			<div class=" col-md-offset-3 col-md-9 ">
	          			<div class="form-group">						
							<label class="col-md-3 control-label">Monto operación</label>
							
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Monto operación.." id="montoOperacion">
							</div>
						</div>	
		        	</div>
		        </div>
		        <span class="help-block">&nbsp;</span>		    
		     	<div class="row">
          			<div class=" col-md-offset-3 col-md-9 ">
	          			<div class="form-group">						
							<label class="col-md-3 control-label">Ganancia obtenida</label>
							
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Ganancia Obtenida..." id="gananciaObtenida">
							</div>
						</div>	
		        	</div>
		        </div>
		        <span class="help-block">&nbsp;</span>		    
		     	<div class="row">
          			<div class=" col-md-offset-3 col-md-9 ">
	          			<div class="form-group">						
							<label class="col-md-3 control-label">Pago provicional conforme al art 127 LISR</label>
							
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Pago Provicional..." id="pagoProvicional">
							</div>
						</div>	
		        	</div>
		        </div>
		        <span class="help-block">&nbsp;</span>		     
		     	<div class="row">
          			<div class=" col-md-offset-3 col-md-9 ">
	          			<div class="form-group">						
							<label class="col-md-3 control-label">Multa por correccion fiscal (g)</label>
							
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Multa por correccion..." id="multa">
							</div>
						</div>	
		        	</div>
		        </div>
		        <span class="help-block">&nbsp;</span>
		     </div>
		     <span class="help-block">&nbsp;</span>
		     <div class="form-actions">
				<div class="row">
					<div class="col-md-offset-5 col-md-7">
						<button type="button" class="btn blue">Calcular</button>
						<button type="button" class="btn  default" onclick="limpiar()">Limpiar</button>
					</div>
				</div>
			</div>
    	</div>
    </div>
</div>

@endsection

@section('scripts')
	<script type="text/javascript">
	jQuery(document).ready(function() {
 		ComponentsPickers.init();
    });

  function limpiar()
  {
    document.getElementById('fecha').value='';
    document.getElementById('montoOperacion').value='';
    document.getElementById('gananciaObtenida').value='';
    document.getElementById('pagoProvicional').value='';
    document.getElementById('multa').value='';


  }

</script>
@endsection
