@extends('layout.app')
@section('content')
<h3 class="page-title">Servicios Generales <small>Retenciones al Millar</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Servicios Generales </a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Retenciones al Millar</a>
        </li>
    </ul>
</div>

<div class="row">
     <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>Retenciones al Millar
            </div>
        </div>
        <div class="portlet-body" id="divRemove">
            <h4>Selecciona los datos a Consultar:</h4>            
            <div class="row">           
                <div class="col-md-12">
                    <div class="form-group"> 
                        <div class="col-md-3">
                            <label for="estpagada"class="control-label">Partida:</label>
                            <select id="partida" class="select2me form-control" onchange="changepartidas()">
                                <option value="limpia">Selecionar</option>            
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                    <div class="col-md-4"> 
                        <span class="help-block">Selecciona una Opcion. </span>
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input type="radio" id="radio6" name="radio2" class="md-radiobtn" value="undia" onclick="radiobuttons()" checked>
                                    <label for="radio6">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                         Pagados </label>
                                </div>|
                                <div class="md-radio">
                                    <input type="radio" id="radio7" name="radio2" class="md-radiobtn" value="tresdias" onclick="radiobuttons()">
                                    <label for="radio7">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                        Sin Pagar</label>
                                </div>
                        </div>                                                                 
                    </div>                   
                </div>
                <div class="form-group">
                    <div class='col-md-4'> 
                        <div class='form-group'>   
                            <label for='fecha'>Seleccionar Rango de Fechas. </label>
                            <div class='input-group input-large date-picker input-daterange' data-date-format='yyyy-mm-dd'><span class='input-group-addon'>De</span><input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'><span class='input-group-addon'>A</span><input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                            </div>
                        </div>
                    </div>
                </div>
                </div> 
             </div><br>
                 
               
                    
                    <div class='col-md-3'><span class='help-block'>&nbsp;</span>
                        <button class='btn green' id='Buscar' onclick='consultaRangoFechasOper()'>Buscar</button><span class='help-block'>&nbsp;</span></div>
               
            </div>
        </div>
    </div>
</div>
<!-- modal-dialog -->
<div id="static" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>¿Continuar?</p>
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default" >Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="continuarsecondary()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<input type="text" name="link" id="link" hidden="true">
@endsection
@section('scripts')
<script type="text/javascript">


</script>
@endsection