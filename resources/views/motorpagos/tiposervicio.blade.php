@extends('layout.app')


@section('content')
<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Motor de pagos <small>Configuración de Trámite</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Motor de pagos</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración de Trámite</a>
        </li>
    </ul>
</div>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Importante:</strong> Para esta configuración debe existir un tipo de referencia y límite de referencia para llevar acabo el alta.
</div>
<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <strong>Info: </strong>Esta configuración te permite dar de alta un trámite al sistema, editar o eliminar su registro. Así como también asignar el tipo de referencia y tipo de límite.
</div>
<div class="row">
  <div hidden="true">
  <a href="javascript:;" class="btn green" id="blockui_sample_3_1" >Block</a>
  <a href="javascript:;" class="btn default" id="blockui_sample_3_1_1" >Unblock</a></div>
  <div id="blockui_sample_3_1_element">
        <!-- BEGIN SAMPLE TABLE PORTLET-->
        <div class="portlet box blue"id="table_1">
            <div class="portlet-title" >
                <div class="caption" id="headerTabla">
                  <div id="borraheader">  <i class="fa fa-cogs">&nbsp; </i>Tipos Tramite</div>
                  </div>
                  <div class="tools" hidden="true">
              </div>             
            </div>
            <div class="portlet-body" id="table_2">
            <div class="row"> 
              <div class="col-md-1">
                <div class="form-group">               
                   <button class="btn green" data-toggle="modal" href="#static2">Agregar</button>
                </div> 
              </div>
             <div class="col-md-2"> 
              <div class="form-group">                                
                   <button class="btn green" data-toggle="modal" href="#static3">Actualizar por Entidad</button>
                </div> 
              </div>  
              <div class='col-md-9 text-right'><div class='form-group'> 
                     
                  <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> 
                </div>
              </div> 
            	                
            </div>

                <span class="help-block">&nbsp;</span>
                    <table class="table table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th>&nbsp;Entidad&nbsp;</th>
                        <th>Servicio</th>
                        <th>Origen URL</th>
                        <th>Descripcion gpm</th>
                        <th>Tipo Referencia</th>
                        <th>Limite Referencia</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>                   
                          <tr> <td>Cargando...</td> </tr>         
                    </tbody>
                    </table>
               
            </div>
        </div>
      </div>
        <!-- END SAMPLE TABLE PORTLET-->
</div>
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h3 class="form-section">Tipo Tramite</h3>
            </div>
            <div class="modal-body">
              <div class="tabbable-line boxless tabbable-reversed">
						<!--<form class="horizontal-form">-->
							<input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">
											<div class="form-body">
												
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Descripcion</label>
															<input type="text" name="descripcion"class="form-control"id="descripcion" placeholder="Escribe una Descripcion..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Origen URL</label>
															<input type="text" name="origen"class="form-control"id="origen" placeholder="Escribe la url..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpo Trans</label>
															<input type="text" name="gpo" class="form-control"  id="gpo" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpm</label>
															<input type="text" name="gpm"class="form-control"id="gpm" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<div class="row">
													
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Gpm Descripcion</label>
															<input type="text" name="gpmdescripcion"class="form-control"id="gpmdescripcion" row="2" placeholder="Escribe..." autocomplete="off" >
														</div>
													</div>
													<!--/span-->
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Tipo Referencia</label>
																<select id="tiporeferencia" class="select2me form-control">
                                  									<option value="limpia">-------</option>
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">Limite Referencia</label>

																<select id="limitereferencia" class="select2me form-control">
                                  									<option value="limpia">-------</option>
																</select>
																<span class="help-block">
																Seleccione una Opcion </span>
														</div>
													</div>
													<!--/span-->
												</div>
												<!--/row-->
											</div>
											<div class="form-actions left">
												<!--<button type="button" class="btn default">Cancel</button>-->
												<button type="submit" class="btn blue" onclick="savetramite()"><i class="fa fa-check"></i> Guardar</button>
											</div>
										<!--</form>-->
									</div>
								</div>
								<div class="modal-footer">
         				<button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
            	</div>
            </div>            
        </div>
    </div>
</div>

<div id="static3" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar_modal()"></button>
                <h4 class="form-section">Actualizar Registros</h4>
            </div>
            <div class="modal-body">
              
              <div class="portlet-body form">
              <!--<input hidden="true" type="text" name="idupdate" id="idupdate" class="idupdate">-->
                      
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="col-md-2 control-label" >Entidad</label>                       
                              <div class="col-md-9">                                             
                                <select id="optionEntidad" class="select2me form-control" onchange="changeEntidadFind()">
                                    <option value="limpia">-------</option>
                                </select>
                                <span class="help-block">
                                Seleccione una Opcion </span>
                              </div>
                            </div>
                          </div>
                        </div>                      
                    </div>
                    <div class="row">
                          <div class="col-md-12">
                             <div class="col-md-12">
                              <div class='form-group'>
                                <label class="col-md-2 control-label" >Buscar</label> 
                               <div class="col-md-6">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Escribe...">
                                </div>               
                              </div>               
                              </div>               
                              <br>
                              <div  id="demo">              
                              <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
                                <thead>
                                  <tr>            
                                   <th>Selecciona los Servicios</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                  <td>No Found</td>
                                  <td></td>
                                </tr>         
                                </tbody>
                              </table>
                            </div> 
                          </div>
                        </div>
                    <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Tipo Referencia</label>
                                <select id="tiporeferencia2" class="select2me form-control">
                                  <option value="limpia">-------</option>
                                </select>
                                <span class="help-block">
                                Seleccione una Opcion </span>
                            </div>
                          </div>
                          <!--/span-->
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Limite Referencia</label>

                                <select id="limitereferencia2" class="select2me form-control">
                                  <option value="limpia">-------</option>
                                </select>
                                <span class="help-block">
                                Seleccione una Opcion </span>
                            </div>
                          </div>
                          <!--/span-->
                        </div>

                      <div class="form-actions left">
                        <!--<button type="button" class="btn default">Cancel</button>-->
                        <button type="submit" class="btn blue" onclick="updateServiciosArray()"><i class="fa fa-check"></i> Guardar</button>
                      </div>                                    
                </div>
                <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar_modal()">Cerrar</button>
              </div>
            </div>            
        </div>
    </div>
</div>
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
            <button type="button" data-dismiss="modal" class="btn green" onclick="deleteTipoServicio()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!------------------      ---------------     MODAL CALCULO CONSEPTOS----------------        ----------------->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiaCalculoConcepto()"></button>
          <input type="text" id="id_calculoConcepto" name="id_calculoConcepto" hidden="true">
          <h4 class="modal-title">Actualizar: <label id="encabezado"></label></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Nombre de Consepto</label>                                             
                <input type="text" class="form-control" name="calculoConsepto" id="calculoConsepto" placeholder="Ingrese el Consepto">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Tramite</label>                                                           
                <input type="text" id="calculoTramite" class="form-control"name="calculoTramite" disabled="true">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Sujeto Aplicable</label>                                             
                <select id="calculoSujetoAplicable" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Partida Presupuestal</label>                                                           
                <select id="calculoPartida" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
          </div>
        </div>
        <!-----------------------------   METODO  ------------------------->
        <div class="row">
          <div class="col-md-12">            
          <div class="col-md-12">            
            <div class="form-group">
              <div class="form-group form-md-radios">
              <label >Metodo</label>
              <div class="md-radio-inline">
                <div class="md-radio">
                  <input type="radio" id="radio1" name="radio1" class="md-radiobtn" value="Fijo" onclick="changeMetodo()" checked>
                    <label for="radio1">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    Fijo </label>
                </div> | &nbsp;
                <div class="md-radio">
                  <input type="radio" id="radio2" name="radio1" class="md-radiobtn" value="Variable" onclick="changeMetodo()" >
                    <label for="radio2">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    Variable </label>
                </div>        
                </div>        
              </div>
            </div>           
          </div>
          </div>
        </div> 
        <div class="row">
          <!--------------------------------- FIJO ------------------------------------------------------>
          <div id="changeFijo">
            <div class="col-md-12">
            <div class="col-md-8"> 
              <div class="form-group">
                <label >Total</label>                                             
                <input type="text" class="valida-decimal form-control" name="calculoTotal" id="calculoTotal" placeholder="Ingrese el Total">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Moneda (Total)</label>                                                           
                <select id="calculoMonedaTotal" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
          </div>
          </div>
          <!------------------------------- VARIABLE ----------------------------------->
          <div id="changeVariable">
            <div class="col-md-12">
              <div class="col-md-3"> 
                <div class="form-group">
                  <span class='help-block'>&nbsp;</span>
                  <div class='md-checkbox'>
                    <input type='checkbox' id='checkbox30' class='md-check' onclick=''>   
                    <label for='checkbox30'>    
                      <span></span>  
                      <span class='check'></span> 
                      <span class='box'></span>  Tiene Maximo </label> 
                  </div>
                </div>
              </div>
            <div class="col-md-5"> 
              <div class="form-group">
                <label >Precio Maximo</label>                                             
                <input type="text" class="valida-decimal form-control" name="calculoPrecioMaximo" id="calculoPrecioMaximo" placeholder="Ingrese el Precio Maximo">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Moneda (Precio Maximo)</label>                                                           
                <select id="calculoMonedaMaximo" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
          </div>
          <!------------------------------- MINIMO ------------------------------->
          <div class="col-md-12">           
            <div class="col-md-8"> 
              <div class="form-group">
                <label >Precio Minimo</label>                                             
                <input type="text" class="valida-decimal form-control" name="calculoPrecioMinimo" id="calculoPrecioMinimo" placeholder="Ingrese el Precio Minimo">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Moneda (Precio Minimo)</label>                                                           
                <select id="calculoMonedaMinimo" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
          </div>
          <!------------------------------------ Formula---------------------------------->
          <div class="col-md-12">           
            <div class="col-md-8"> 
              <div class="form-group">
                <label >Formula</label>                                             
                <textarea class="valida-formula form-control" rows="3" name="calculoFormula" id="calculoFormula" placeholder="Ingrese la Formula"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label >Moneda (Formula)</label>                                                           
                <select id="calculoMonedaFormula" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12">             
            <div class="form-group">
              <div class="form-group form-md-radios">
              <label >Tiene Lote</label>
              <div class="md-radio-inline">
                <div class="md-radio">
                  <input type="radio" id="radio3" name="radio2" class="md-radiobtn" value="1" onclick="" >
                    <label for="radio3">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    Si </label>
                </div> | &nbsp;
                <div class="md-radio">
                  <input type="radio" id="radio4" name="radio2" class="md-radiobtn" value="0" onclick="" checked>
                    <label for="radio4">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    No </label>
                </div>        
              </div>
              </div>
              </div>
            </div>           
          </div>
          <div class="col-md-12">
            <div class="col-md-12">
              <div class="form-group">
                <label>Cantidad</label>
                <input type="text" name="calculoCantidad" id="calculoCantidad" class="valida-decimal form-control" placeholder="Ingrese Cantidad">
              </div>
            </div>
          </div>
        </div>        
        <div class="row">
          <div class="col-md-12">            
          <div class="col-md-12">            
            <div class="form-group">
              <div class="form-group form-md-radios">
              <label >Aplica Redondeo al Millar</label>
              <div class="md-radio-inline">
                <div class="md-radio">
                  <input type="radio" id="radio5" name="radio3" class="md-radiobtn" value="1" onclick="" >
                    <label for="radio5">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    Si </label>
                </div> | &nbsp;
                <div class="md-radio">
                    <input type="radio" id="radio6" name="radio3" class="md-radiobtn" value="0" onclick="" checked>
                    <label for="radio6">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    No </label>
                </div>        
              </div>
            </div>           
            </div>           
            </div>           
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="calculoVerifica()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal" onclick="limpiaCalculoConcepto()">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>
<!----------------------------------------- Subsidio MODAL ----------------------------------------------->
<div class="modal fade bs-modal-lg" id="modalSubsidio" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close"data-dismiss="modal" aria-hidden="true" onclick="limpiarSubsidio()"></button>
        <h4 class="modal-title">Actualizacion de Registro</h4>
        <input hidden="true" type="text" name="idsubsidio" id="idsubsidio">
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label >Tramite</label>                                                           
                <input type="text" id="subsidioTramite" class="form-control"name="subsidioTramite" disabled="true">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Moneda</label>
                <select id="subsidioMoneda" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>                                            
              </div>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Aplicar cuando el Total se Menor o Igual</label>                                             
                <input type="text" class="valida-decimal form-control" name="subsidioTotal" id="subsidioTotal" placeholder="Cuando el Total se Menor o Igual">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label >Total Despues de Aplicar Subsidio</label>                                                       
                <input type="text" class="valida-decimal form-control" name="subsidioTotalDesp" id="subsidioTotalDesp" placeholder="Total Despues de Aplicar Subsidio">
             </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label >Partida Presupuestal</label>                                                           
                <select id="subsidioPartida" class="select2me form-control" >
                  <option value="limpia">-------</option>
                </select>               
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Descripción</label>                                             
                <input type="text" class="form-control" name="subsidioDescripcion" id="subsidioDescripcion" placeholder="Ingrese la Descripción">                
              </div>
            </div>            
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
                <label >No Decreto/Oficio</label>                                             
                <input type="text" class="form-control" name="subsidioDecreto" id="subsidioDecreto" placeholder="Ingrese No Decreto/Oficio">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <span class='help-block'>&nbsp;</span>
                  <div class='md-checkbox'>
                    <input type='checkbox' id='checkbox40' class='md-check' onclick=''>   
                    <label for='checkbox40'>    
                      <span></span>  
                      <span class='check'></span> 
                      <span class='box'></span>  Requiere Formato </label> 
                  </div>
              </div>
            </div>            
          </div>
        </div>
         <div class="row">
                    <div class="col-md-12"> 
                        <div class=' date-picker input-daterange' data-date-format='yyyy-mm-dd'>
                            <div class="form-group">    
                                <div class='col-md-6'>
                                    <div class="form-group">
                                        <label >Fecha Inicio </label>
                                        <input type='text' class='form-control' name='from' id='fechainicio' autocomplete='off'> 
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class="form-group">
                                        <label>Fecha Fin </label>
                                        <input type='text' class='form-control' name='to'id='fechafin' autocomplete='off'>
                                </div>                                
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group">
              </div>
            </div>
            <div class="col-md-6"> 
              <div class="form-group">
                <label >Tipo de Persona</label>
                <select id="subsidioTipoPersona" class="select2me form-control" >
                  <option value="limpia">---------</option>
                  <option value="FISICA">FISICA</option>
                  <option value="MORAL">MORAL</option>
                  <option value="TODOS">TODOS</option>
                </select>                                            
              </div>
            </div>
            
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-12">             
            <div class="form-group">
              <button type="submit" class="btn blue" onclick="subsidioVerifica()"><i class="fa fa-check"></i> Guardar</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarSubsidio()">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<input hidden="true" type="text" name="idtramite" id="idtramite">

@endsection

@section('scripts')

<script type="text/javascript">
	jQuery(document).ready(function() {
        findLimiteReferencia();
        findTipoReferencia();
        FindEntidad();
        ActualizaTabla();
        currenciesFind();
        calculoSujetoFind();
        UIBlockUI.init();  
        ComponentsPickers.init();       
       //TableAdvanced.init();       
    });
  function currenciesFind()
  {
    $.ajax({
           method: "get",            
           url: "{{ url('/currencies-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
    .done(function (responseinfo) {     
      var Resp=$.parseJSON(responseinfo);
      var item="";
      //--------------------SUBSIDIO-------------//
      $("#subsidioMoneda option").remove();
      $("#subsidioMoneda").append("<option value='limpia'>-------</option>");

      //---------------CALCULO CONCEPTO------------//
      $("#calculoMonedaTotal option").remove();
      $("#calculoMonedaTotal").append("<option value='limpia'>-------</option>");

      $("#calculoMonedaMinimo option").remove();
      $("#calculoMonedaMinimo").append("<option value='limpia'>-------</option>");

      $("#calculoMonedaMaximo option").remove();
      $("#calculoMonedaMaximo").append("<option value='limpia'>-------</option>");

      $("#calculoMonedaFormula option").remove();
      $("#calculoMonedaFormula").append("<option value='limpia'>-------</option>");

        $.each(Resp, function(i, item) {                
            $("#subsidioMoneda").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
            $("#calculoMonedaTotal").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
            $("#calculoMonedaMinimo").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
            $("#calculoMonedaMaximo").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
            $("#calculoMonedaFormula").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
        });
      })
    .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  
    });
  }
  
  function calculoSujetoFind()
  {
    $.ajax({
      method: "get",            
      url: "{{ url('/applicable-subject-find-all') }}",
      data: {_token:'{{ csrf_token() }}'}  })
    .done(function (responseinfo) {     
      var Resp=$.parseJSON(responseinfo);
      var item="";
      $("#calculoSujetoAplicable option").remove();
      $("#calculoSujetoAplicable").append("<option value='limpia'>-------</option>");
        $.each(Resp, function(i, item) {                
          $("#calculoSujetoAplicable").append("<option value='"+item.id+"'>"+item.nombre+"</option>");  
        });
      })
      .fail(function( msg ) {
       Command: toastr.warning("No Success", "Notifications")  
      });
  }
  function updateServiciosArray()
  {
    var tiporeferencia=$("#tiporeferencia2").val();
    var limitereferencia=$("#limitereferencia2").val();
    let valoresCheck = [];
    $("input[type=checkbox]:checked").each(function(){
       valoresCheck.push(this.value);
    });
   if(valoresCheck.length == 0)
   {
     Command: toastr.warning("Ningun Servicio Seleccionado", "Notifications")
   }else if(limitereferencia=="limpia"){
    Command: toastr.warning("Limite Referencia Requerido", "Notifications")
   }else if(tiporeferencia=="limpia"){
    Command: toastr.warning("Tipo Referencia Requerido!", "Notifications")
   }else{
    ActualizarServicios();

   }
  }
  function ActualizarServicios()
  {
    var tiporeferencia_=$("#tiporeferencia2").val();
    var limitereferencia_=$("#limitereferencia2").val();
    let valoresCheck = [];
    $("input[type=checkbox]:checked").each(function(){
       valoresCheck.push(this.value);
    });
    $.ajax({
           method: "POST",            
           url: "{{ url('/tipo-servicio-update-array') }}",
           data: {tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_,id:valoresCheck, _token:'{{ csrf_token() }}'}  })
        .done(function (response) {     
        if(response=="true")
        {   
        $("#tiporeferencia2").val("limpia").change();
        $("#limitereferencia2").val("limpia").change();
        $('input:checkbox').removeAttr('checked');
         
          Command: toastr.success("Success", "Notifications")
             ActualizaTabla();

        } 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function FindEntidad()
    {
         $.ajax({
           method: "get",            
           url: "{{ url('/entidad-find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#optionEntidad option").remove();
          $("#optionEntidad").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#optionEntidad").append("<option value='"+item.id+"'>"+item.nombre+"</option>"
            );  
        });
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
	function findLimiteReferencia()
	{
		$.ajax({
           method: "get",           
           url: "{{ url('/limite-referencia-fin-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#limitereferencia option").remove();
         $('#limitereferencia').append(
            "<option value='limpia'>------</option>"
        );
         $("#limitereferencia2 option").remove();
         $('#limitereferencia2').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#limitereferencia').append(
                "<option value='"+item.id+"'>"+item.descripcion+" "+item.periodicidad+" "+item.vencimiento+"</option>"
                );
                $('#limitereferencia2').append(
                "<option value='"+item.id+"'>"+item.descripcion+" "+item.periodicidad+" "+item.vencimiento+"</option>"
                );
            });
      	})
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
	}

	function findTipoReferencia()
	{
		$.ajax({
           method: "get",           
           url: "{{ url('/tipo-referencia-Find') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (response) {
          var Resp=$.parseJSON(response);
           $("#tiporeferencia option").remove();
         $('#tiporeferencia').append(
            "<option value='limpia'>------</option>"
        );
          $("#tiporeferencia2 option").remove();
         $('#tiporeferencia2').append(
            "<option value='limpia'>------</option>"
        );
        $.each(Resp, function(i, item) {                
            $('#tiporeferencia').append(
                "<option value='"+item.id+"'>"+item.fecha_condensada+"</option>"
                );           
         $('#tiporeferencia2').append(
                "<option value='"+item.id+"'>"+item.fecha_condensada+"</option>"
                );
            });

      	})
        .fail(function( msg ) {
         console.log("Error al Cargar select Option Limite Referencia");  });
    
	}
  function OperacionTramite(id_)
  {
    document.getElementById('idupdate').value=id_;
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-Find-where') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
            
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {  
        document.getElementById('descripcion').value=item.descripcion;
        document.getElementById('origen').value=item.origen;
        document.getElementById('gpo').value=item.gpm;
        document.getElementById('gpm').value=item.gpo;
        document.getElementById('gpmdescripcion').value=item.descripcion_gpm;          
        $("#limitereferencia").val(item.limitereferencia).change();
        $("#tiporeferencia").val(item.tiporeferencia).change();
       console.log(item.tiporeferencia +" "+item.limitereferencia);
       
        });
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function savetramite()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia=$("#limitereferencia").val();
    var tiporeferencia=$("#tiporeferencia").val();
    var id=$("#idupdate").val();
    if(desc.length<1)
    {
        Command: toastr.warning("Descripcion Requerido!", "Notifications")
        document.getElementById('descripcion').focus();
    }/*else if(origen.length<=0)
    {
        Command: toastr.warning("Origen URL Requerido!", "Notifications")
        document.getElementById('origen').focus();
    }else if(gpo.length<=0)
    {
        Command: toastr.warning("gpo Requerido!", "Notifications")
        document.getElementById('gpo').focus();
    }else if(gpm.length<=0)
    {
        Command: toastr.warning("gpm Requerido!", "Notifications")
        document.getElementById('gpm').focus();
    }else if(gpmdescripcion.length<=0)
    {
        Command: toastr.warning("GPM Descripcion Requerido!", "Notifications")
    $("#tiporeferencia").val("limpia").change();
        document.getElementById('gpmdescripcion').focus();
    }*/else if(limitereferencia=="limpia")
    {
        Command: toastr.warning("Limite Referencia Requerido!", "Notifications")
        document.getElementById('limitereferencia').focus();
    }else if(tiporeferencia=="limpia")
    {
        Command: toastr.warning("Tipo de Referencia Requerido!", "Notifications")
        document.getElementById('tiporeferencia').focus();
    }else
    {
        if(id=="")
        {
            insertTipoServicio();
        }else{
            updateTipoServicio();
        }

    }
  }
  function insertTipoServicio()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia_=$("#limitereferencia").val();
    var tiporeferencia_=$("#tiporeferencia").val();
    if(origen.length==0)
    {origen="url";}
    if(gpo.length==0)
    {gpo="1";}
    if(gpm.length==0)
    {gpm="1";}
    if(gpmdescripcion.length==0)
    {gpmdescripcion="1";}
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-insert') }}",
           data: { descripcion:desc,url:origen,gpoTrans:gpo,id_gpm:gpm,descripcion_gpm:gpmdescripcion,tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {            
            ActualizaTabla();
            Command: toastr.success("Success", "Notifications")
            limpiar();
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function updateTipoServicio()
  {
    var desc=$("#descripcion").val();
    var origen=$("#origen").val();
    var gpo=$("#gpo").val();
    var gpm=$("#gpm").val();
    var gpmdescripcion=$("#gpmdescripcion").val();
    var limitereferencia_=$("#limitereferencia").val();
    var tiporeferencia_=$("#tiporeferencia").val();
    var id_=$("#idupdate").val();
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-update') }}",
           data: { id:id_,descripcion:desc,url:origen,gpoTrans:gpo,id_gpm:gpm,descripcion_gpm:gpmdescripcion,tiporeferencia:tiporeferencia_,limitereferencia:limitereferencia_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {           
            ActualizaTabla(); 
            Command: toastr.success("Success", "Notifications")
            limpiar();
        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

    }
    function deletetramite(id_)
    {
        document.getElementById('idvalor').value=id_;
    }
    function deleteTipoServicio()
    {
        var id_=$("#idvalor").val();
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-delete') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
     
        if(response=="true")
        {          
            ActualizaTabla();  
            Command: toastr.success("Success", "Notifications")

        }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }

    function ActualizaTabla()
    {
   
    $.ajax({
           method: "GET",
           url: "{{ url('/tipo-servicio-find-all') }}",
           data: { _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
         var Resp=$.parseJSON(response);
         var orig="";
         var desc="";
         $("#table_2").remove();
         $("#table_1").append("<div class='portlet-body' id='table_2'><div class='row'> <div class='col-md-1'> <div class='form-group'> <button class='btn green' data-toggle='modal' href='#static2'>Agregar</button> </div>     </div> <div class='col-md-2'><div class='form-group'> <button class='btn green' data-toggle='modal' href='#static3'>Actulizar por Entidad</button> </div></div> <div class='col-md-9 text-right'><div class='form-group'> <button class='btn blue' onclick='GuardarExcel()'><i class='fa fa-file-excel-o'></i> Descargar CSV</button> </div></div> </div>  <span class='help-block'>&nbsp;</span>   <table class='table table-hover' id='sample_2'>   <thead>   <tr> <th>&nbsp;Entidad&nbsp;</th>  <th>Servicio</th>    <th>Origen URL</th>  <th>Descripcion gpm</th>  <th>Tipo Referencia</th>  <th>Limite Referencia</th> <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th> </tr>  </thead><tbody> <tr> <td><p>Cargando...</p></td> </tr></tbody></table></div>");
         $("#sample_2 tbody tr").remove();
        $.each(Resp, function(i, item) {
           
            $("#sample_2 tbody").append("<tr>"
            +"<td>"+item.Entidad+"</td>"
            +"<td>"+item.Tipo_Descripcion+"</td>"
            +"<td>"+item.Origen_URL+"</td>"
            +"<td>"+item.descripcion_gpm+"</td>"
            +"<td>"+item.tiporeferencia+"</td>"
            +"<td>"+item.limitereferencia+"</td>"
            +"<td><a class='btn btn-icon-only blue' href='#static2' data-toggle='modal' data-original-title='Editar' title='Editar' onclick=\"OperacionTramite(\'"+item.id+"\')\"><i class='fa fa-pencil'></i></a>&nbsp;<a class='btn btn-icon-only green' href='#large' data-toggle='modal' data-original-title='' title='Calculo de Conseptos' onclick=\"CalculoConsepto(\'"+item.id+"\')\"><i class='fa fa-cogs'></i></a>&nbsp;<a class='btn btn-icon-only grey' href='#modalSubsidio' data-toggle='modal' data-original-title='' title='Subsidio' onclick=\"CalculoSubsidio(\'"+item.id+"\')\"><i class='fa fa-eye'></i></a></td>"
            +"</tr>");
            /*<a class='btn btn-icon-only red' data-toggle='modal' href='#static' onclick=\"deletetramite(\'"+item.id+"\')\"><i class='fa fa-minus'></i></a>*/
       
          });
            TableManaged.init();
           //TableAdvanced.init() 
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

  }
  function CalculoConsepto(id_)
  {
    document.getElementById('idtramite').value=id_;  
    changeMetodo();
    calculoPartidasFind(id_);
    
        $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-Find-where') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
        calculoConceptoFind(id_);
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {  
        document.getElementById('calculoTramite').value=item.descripcion;

        $("#encabezado").text(item.descripcion);       
        });
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
   

  } 
  function calculoPartidasFind(id_)
  {
     $.ajax({
           method: "post",            
           url: "{{ url('/partidas-where') }}",
           data: {id_tramite:id_,_token:'{{ csrf_token() }}'}  })
      .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#calculoPartida option").remove();
          $("#calculoPartida").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#calculoPartida").append("<option value='"+item.id_partida+"'>"+item.descripcion+"</option>"
            );  
        });
        })
      .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  
      });
  }
  function changeMetodo()
  {
    var radioValue1 = $("input[name='radio1']:checked"). val();
    if(radioValue1=='Fijo')
    {
      $("#changeFijo").css("display", "block");
      $("#changeVariable").css("display", "none");
    }else{
      $("#changeFijo").css("display", "none");
      $("#changeVariable").css("display", "block");
    }
   
  }
  function calculoConceptoFind(id_)
  {
    $.ajax({
           method: "POST",
           url: "{{ url('/calcula-find-where') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
            
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {

        document.getElementById('id_calculoConcepto').value=item.id;
        document.getElementById('calculoConsepto').value=item.nombreconcepto;
        $("#calculoSujetoAplicable").val(item.applicablesubject).change();
        $("#calculoPartida").val(item.id_partida).change();
        if(item.metodo=="Fijo")
          {
            $("#radio1").prop( "checked", true );
          }else{
            $("#radio2").prop( "checked", true );
          }        
        document.getElementById('calculoTotal').value=item.total;
        $("#calculoMonedaTotal").val(item.moneda_total).change();
        if(item.has_max==1) 
        {
          $("#checkbox30").prop("checked", true);
        }else{
          $("#checkbox30").prop("checked", false); 
        }
        document.getElementById('calculoPrecioMaximo').value=item.precio_max;
        $("#calculoMonedaMaximo").val(item.moneda_max).change();
        document.getElementById('calculoPrecioMinimo').value=item.precio_min;
        $("#calculoMonedaMinimo").val(item.moneda_min).change();    
        document.getElementById('calculoFormula').value=item.formula;
        $("#calculoMonedaFormula").val(item.moneda_formula).change();
        if(item.has_lot==1)
        {
          $("#radio3").prop( "checked", true );
        }else{
            $("#radio4").prop( "checked", true );
        }        
        document.getElementById('calculoCantidad').value=item.cantidad;
        if(item.redondeo_millar==1)
        {
          $("#radio5").prop( "checked", true );
        }else{
          $("#radio6").prop( "checked", true );
        }       
        });
        changeMetodo();
        
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function calculoVerifica()
  {
    var id_calculoConcepto=$("#id_calculoConcepto").val();
    var id_tramite_=$("#idtramite").val();
    var nombreconcepto_=$("#calculoConsepto").val();
    var applicablesubject_=$("#calculoSujetoAplicable").val();
    var id_partida_=$("#calculoPartida").val();    
    var total_=$("#calculoTotal").val();
    var moneda_total_=$("#calculoMonedaTotal").val();
    var precio_max_=$("#calculoPrecioMaximo").val();
    var moneda_max_=$("#calculoMonedaMaximo").val();
    var precio_min_=$("#calculoPrecioMinimo").val();
    var moneda_min_=$("#calculoMonedaMinimo").val();
    var formula_=$("#calculoFormula").val();
    var moneda_formula_=$("#calculoMonedaFormula").val();
    var cantidad_=$("#calculoCantidad").val();
    var metodo_ = $("input[name='radio1']:checked").val();
    if(nombreconcepto_.length==0)
    {
       Command: toastr.warning("Campo Nombre Concepto, Requerido!", "Notifications") 
    }else if(applicablesubject_=="limpia")
    {
      Command: toastr.warning("Campo Sujeto Aplicable, Requerido!", "Notifications") 
    }else if(id_partida_=="limpia")
    {
      Command: toastr.warning("Campo Partida Presupuestal, Requerido!", "Notifications") 
    }else if(cantidad_.length==0)
    {
      Command: toastr.warning("Campo Cantidad, Requerido!", "Notifications") 
    }else{
      console.log(metodo_);
      if(metodo_=='Fijo')
      {
        if(total_.length==0)
        {
          Command: toastr.warning("Campo Total, Requerido!", "Notifications") 
        }else if(moneda_total_=="limpia")
        {
          Command: toastr.warning("Campo Moneda Total, Requerido!", "Notifications") 
        }else{
          console.log(id_calculoConcepto);
          if(id_calculoConcepto.length==0)
          {
            calculoInsert();

          }else{
            calculoUpdate();
          } 
        }
      }else{      
        if(precio_max_.length==0)
        {
          Command: toastr.warning("Campo , Requerido!", "Notifications") 
        }else if(moneda_max_=="limpia")
        {
          Command: toastr.warning("Campo Moneda (Precio Maximo), Requerido!", "Notifications") 
        }else if(precio_min_.length==0)
        {
          Command: toastr.warning("Campo Precio Minimo, Requerido!", "Notifications") 
        }else if(moneda_min_=="limpia")
        {
          Command: toastr.warning("Campo Moneda (Precio Minimo), Requerido!", "Notifications") 
        }else if(formula_.length==0)
        {
          Command: toastr.warning("Campo Formula, Requerido!", "Notifications") 
        }else if(moneda_formula_=="limpia")
        {
          Command: toastr.warning("Campo Moneda (Formula), Requerido!", "Notifications") 
        }else{
          if(id_calculoConcepto.length==0)
          {
            if(validarFormula()){
              calculoInsert();
            }        
          }else{
            if(validarFormula()){
              calculoUpdate();
            } 
          }
        }       
      }      
    }

  }
  function calculoInsert()
  {
    var id_=$("#id_calculoConcepto").val();
    var id_tramite_=$("#idtramite").val();
    var nombreconcepto_=$("#calculoConsepto").val();
    var applicablesubject_=$("#calculoSujetoAplicable").val();
    var id_partida_=$("#calculoPartida").val();
    var metodo_ = $("input[name='radio1']:checked").val();
    var total_=$("#calculoTotal").val();
    var moneda_total_=$("#calculoMonedaTotal").val();    
    var check=$("#checkbox30").prop("checked");
    var has_max_=0;
    if(check==true)
    {
      has_max_=1;
    }else{
      has_max_=0;
    }
    var precio_max_=$("#calculoPrecioMaximo").val();
    var moneda_max_=$("#calculoMonedaMaximo").val();
    var precio_min_=$("#calculoPrecioMinimo").val();
    var moneda_min_=$("#calculoMonedaMinimo").val();
    var formula_=$("#calculoFormula").val();
    var moneda_formula_=$("#calculoMonedaFormula").val();
    var has_lot_ = $("input[name='radio2']:checked").val();
    var cantidad_=$("#calculoCantidad").val();   
    var redondeo_millar_ = $("input[name='radio3']:checked").val();
    if(metodo_=='Fijo')
    {
      has_max_=0;
      precio_max_='0.00';
      moneda_max_='1';
      precio_min_='0.00';
      moneda_min_='1';
      formula_=null;
      moneda_formula_='1';
    }else{
      total_='0.00';
      moneda_total_='1';
    }

    $.ajax({
           method: "POST",
           url: "{{ url('/calcula-insert') }}",
           data: { id_tramite:id_tramite_,nombreconcepto:nombreconcepto_,applicablesubject:applicablesubject_,id_partida:id_partida_,metodo:metodo_,total:total_,moneda_total:moneda_total_,has_max:has_max_,precio_max:precio_max_,moneda_max:moneda_max_,precio_min:precio_min_,moneda_min:moneda_min_,formula:formula_,moneda_formula:moneda_formula_,has_lot:has_lot_,cantidad:cantidad_,redondeo_millar:redondeo_millar_, _token: '{{ csrf_token() }}' }
    })
    .done(function (response) {
        if(response=="true")
          {
            Command: toastr.success("Success", "Notifications")
          }
    })
    .fail(function( msg ) {
      Command: toastr.warning("No Success", "Notifications")  
    });

  }
  function calculoUpdate()
  {
    var id_=$("#id_calculoConcepto").val();
    var id_tramite_=$("#idtramite").val();
    var nombreconcepto_=$("#calculoConsepto").val();
    var applicablesubject_=$("#calculoSujetoAplicable").val();
    var id_partida_=$("#calculoPartida").val();
    var metodo_ = $("input[name='radio1']:checked").val();
    var total_=$("#calculoTotal").val();
    var moneda_total_=$("#calculoMonedaTotal").val();    
    var check=$("#checkbox30").prop("checked");
    var has_max_=0;
    if(check==true)
    {
      has_max_=1;
    }else{
      has_max_=0;
    }
    var precio_max_=$("#calculoPrecioMaximo").val();
    var moneda_max_=$("#calculoMonedaMaximo").val();
    var precio_min_=$("#calculoPrecioMinimo").val();
    var moneda_min_=$("#calculoMonedaMinimo").val();
    var formula_=$("#calculoFormula").val();
    var moneda_formula_=$("#calculoMonedaFormula").val();
    var has_lot_ = $("input[name='radio2']:checked").val();
    var cantidad_=$("#calculoCantidad").val();   
    var redondeo_millar_ = $("input[name='radio3']:checked").val();
    if(metodo_=='Fijo')
    {
      has_max_=0;
      precio_max_='0.00';
      moneda_max_='1';
      precio_min_='0.00';
      moneda_min_='1';
      formula_=null;
      moneda_formula_='1';
    }else{
      total_='0.00';
      moneda_total_='1';
    }

    $.ajax({
           method: "POST",
           url: "{{ url('/calcula-update') }}",
           data: {id:id_,id_tramite:id_tramite_,nombreconcepto:nombreconcepto_,applicablesubject:applicablesubject_,id_partida:id_partida_,metodo:metodo_,total:total_,moneda_total:moneda_total_,has_max:has_max_,precio_max:precio_max_,moneda_max:moneda_max_,precio_min:precio_min_,moneda_min:moneda_min_,formula:formula_,moneda_formula:moneda_formula_,has_lot:has_lot_,cantidad:cantidad_,redondeo_millar:redondeo_millar_, _token: '{{ csrf_token() }}' }
    })
    .done(function (response) {
        if(response=="true")
          {
            Command: toastr.success("Success", "Notifications")
          }
    })
    .fail(function( msg ) {
      Command: toastr.warning("No Success", "Notifications")  
    });

  }
  function limpiaCalculoConcepto()
  {
    
    document.getElementById('id_calculoConcepto').value="";
    document.getElementById('calculoConsepto').value="";
    $("#calculoSujetoAplicable").val("limpia").change();
    $("#calculoPartida").val("limpia").change();
    $("#radio1").prop( "checked", true );
    document.getElementById('calculoTotal').value="";
    $("#calculoMonedaTotal").val("limpia").change();  
    $("#checkbox30").prop("checked", false);  
    document.getElementById('calculoPrecioMaximo').value="";
    $("#calculoMonedaMaximo").val("limpia").change();
    document.getElementById('calculoPrecioMinimo').value="";
    $("#calculoMonedaMinimo").val("limpia").change();    
    document.getElementById('calculoFormula').value="";
    $("#calculoMonedaFormula").val("limpia").change();
    $("#radio4").prop( "checked", true );
    document.getElementById('calculoCantidad').value="";
    $("#radio6").prop( "checked", true );


    
  }
  function CalculoSubsidio(id_)
  {
    document.getElementById('idtramite').value=id_;
    changeSubsidio();
  }
  function changeSubsidio()
  {
    var id_=$("#idtramite").val();
    partidasFind(id_);
    subsidioFindWhere();
    $.ajax({
           method: "POST",
           url: "{{ url('/tipo-servicio-Find-where') }}",
           data: { id:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
            
        var Resp=$.parseJSON(response);
        $.each(Resp, function(i, item) {  
        document.getElementById('subsidioTramite').value=item.descripcion;
         });
     })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function subsidioFindWhere()
  {
    var id_=$("#idtramite").val();
     $.ajax({
           method: "POST",
           url: "{{ url('/subsidio-find-where') }}",
           data: { id_tramite:id_, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) {             
        var Resp=$.parseJSON(response);
        //console.log(Resp);
        $.each(Resp, function(i, item) {  
          document.getElementById('idsubsidio').value=item.id;          
          document.getElementById('subsidioDecreto').value=item.decretoficio;
          document.getElementById('subsidioTotal').value=item.total;
          document.getElementById('subsidioDescripcion').value=item.descripcion;
          document.getElementById('subsidioTotalDesp').value=item.totaldespues;
          $("#subsidioMoneda").val(item.moneda).change();
          $("#subsidioPartida").val(item.id_partida).change();
          $("#subsidioTipoPersona").val(item.tipopersona).change();
          if(parseFloat(item.formato)==1)
            {
              $("#checkbox40").prop("checked", true);
            }
        });
      })
      .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });

  }
  function subsidioVerifica()
  {
    var id_subsidio=$("#idsubsidio").val();
    var moneda_=$("#subsidioMoneda").val();
    var total_=$("#subsidioTotal").val();
    var totalDespues_=$("#subsidioTotalDesp").val();
    var partida_=$("#subsidioPartida").val();
    var descripcion_=$("#subsidioDescripcion").val();
    var decreto_=$("#subsidioDecreto").val();
    var tipopersona_=$("#subsidioTipoPersona").val();
    if(moneda_=='limpia')
    {
      Command: toastr.warning("Campo Moneda, Requerido!", "Notifications")
    }else if(total_.length==0)
    {
      Command: toastr.warning("Campo Total sea Menor o Igual, Requerido!", "Notifications")
    }else if(totalDespues_.length==0)
    {
      Command: toastr.warning("Campo Total Despues de Aplicar Subsidio, Requerido!", "Notifications")
    }else if(partida_=='limpia')
    {
      Command: toastr.warning("Campo Partida Presupuestal, Requerido!", "Notifications")
    }else if(descripcion_.length==0)
    {
      Command: toastr.warning("Campo Descripcion, Requerido!", "Notifications")
    }else if(decreto_.length==0)
    {
      Command: toastr.warning("Campo Decreto/Oficio, Requerido!", "Notifications")
    }else if(tipopersona_=='limpia')
    {
      Command: toastr.warning("Campo Tipo Persona, Requerido!", "Notifications")
    }else if(id_subsidio.length==0)
    {
      subsidioInsert();
    }else{
      subsidioUpdate();
    }
  }
  function subsidioInsert()
  {
    var id_=$("#idtramite").val();
    var moneda_=$("#subsidioMoneda").val();
    var total_=$("#subsidioTotal").val();
    var totalDespues_=$("#subsidioTotalDesp").val();
    var partida_=$("#subsidioPartida").val();
    var descripcion_=$("#subsidioDescripcion").val();
    var decreto_=$("#subsidioDecreto").val();
    var formato_='0';
    var check=$("#checkbox40").prop("checked");    
    var fechafin=$("#fechafin").val();
    var fechainicio=$("#fechainicio").val();
    if(check==true)
    {
      formato_=1;
    }
    else{
      formato_=0;
    }
    var tipopersona_=$("#subsidioTipoPersona").val();
     $.ajax({
           method: "POST",
           url: "{{ url('/subsidio-insert') }}",
           data: { id_tramite:id_,total:total_,moneda:moneda_,descripcion:descripcion_,decretoficio:decreto_,formato:formato_,totaldespues:totalDespues_,id_partida:partida_,tipopersona:tipopersona_,fecha_inicio:fechainicio,fecha_fin:fechafin,_token: '{{ csrf_token() }}' }
       })
        .done(function (response) {             
       if(response=="true")
        {           
          Command: toastr.success("Success", "Notifications")
        }else{
         Command: toastr.warning("No Success", "Notifications")
        }
      })
      .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function subsidioUpdate()
  {
    var id_=$("#idsubsidio").val();
    var id_tramite_=$("#idtramite").val();    
    var moneda_=$("#subsidioMoneda").val();
    var total_=$("#subsidioTotal").val();
    var totalDespues_=$("#subsidioTotalDesp").val();
    var partida_=$("#subsidioPartida").val();
    var descripcion_=$("#subsidioDescripcion").val();
    var decreto_=$("#subsidioDecreto").val();
    var formato_='0';
    var check=$("#checkbox40").prop("checked");
    var fechafin=$("#fechafin").val();
    var fechainicio=$("#fechainicio").val();
    if(check==true)
    {
      formato_=1;
    }
    else{
      formato_=0;
    }
    var tipopersona_=$("#subsidioTipoPersona").val();
     $.ajax({
           method: "POST",
           url: "{{ url('/subsidio-update') }}",
           data: { id:id_,id_tramite:id_tramite_,total:total_,moneda:moneda_,descripcion:descripcion_,decretoficio:decreto_,formato:formato_,totaldespues:totalDespues_,id_partida:partida_,tipopersona:tipopersona_,fecha_inicio:fechainicio,fecha_fin:fechafin,_token: '{{ csrf_token() }}' }
       })
        .done(function (response) {             
       if(response=="true")
        {           
          Command: toastr.success("Success", "Notifications")
        }else{
         Command: toastr.warning("No Success", "Notifications")
        }
      })
      .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
  }
  function limpiarSubsidio()
  {
    document.getElementById('idtramite').value="";
    document.getElementById('idsubsidio').value="";
    document.getElementById('subsidioTramite').value="";
    document.getElementById('subsidioDecreto').value="";
    document.getElementById('subsidioTotal').value="";
    document.getElementById('subsidioDescripcion').value="";
    document.getElementById('subsidioTotalDesp').value="";
    document.getElementById('subsidioTipoPersona').value="";
    $("#subsidioMoneda").val("limpia").change();
    $("#subsidioPartida").val("limpia").change();
    $("#subsidioTipoPersona").val("limpia").change();
    $("#checkbox40").prop("checked", false);
    $('#fechafin').datepicker('setDate',null );
    $('#fechainicio').datepicker('setDate',null );

  }
  function partidasFind(id_)
  {
     $.ajax({
           method: "post",            
           url: "{{ url('/partidas-where') }}",
           data: {id_tramite:id_,_token:'{{ csrf_token() }}'}  })
      .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#subsidioPartida option").remove();
          $("#subsidioPartida").append("<option value='limpia'>-------</option>"
            );
        $.each(Resp, function(i, item) {                
               $("#subsidioPartida").append("<option value='"+item.id_partida+"'>"+item.descripcion+"</option>"
            );  
        });
        })
      .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  
      });
  }

  function changeEntidadFind()
  {
    var entidad=$("#optionEntidad").val();
    if(entidad=="limpia")
    {
      $("#table2 tbody tr").remove();
        $("#table2").append("<tr>"
          +"<td>No Found</td>"
          +"<td></td>"
          +"</tr>"
        ); 
    }else{
      FindserviciosTableAll();
    }

  }
  function FindserviciosTableAll()
    {
      var entidad=$("#optionEntidad").val();
      $.ajax({
       method: "POST",
           url: "{{ url('/tipo-servicio-find-where-id') }}",
           data: { id_entidad:entidad,_token: '{{ csrf_token() }}' }  })
        .done(function (responseinfo) {     
        var Resp=$.parseJSON(responseinfo);
          var item="";
          $("#table2 tbody tr").remove();
        $.each(Resp, function(i, item) {                
               $("#table2").append("<tr>"
                +"<td class='text-center'><input id='ch_"+item.id+"' type='checkbox' value='"+item.id+"'></td>"
                +"<td width='100%'>"+item.descripcion+"</td>"
                +"</tr>"
            );  
        });
      })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications")  });
    }
    $("#search").keyup(function(){
        _this = this;
        $.each($("#table2 tbody tr"), function() {
        if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
        $(this).hide();
        else
        $(this).show();
        });
    });
  function limpiar()
  {
    $("#tiporeferencia").val("limpia").change();
    $("#limitereferencia").val("limpia").change();
    document.getElementById('gpmdescripcion').value="";
    document.getElementById('gpm').value="";
    document.getElementById('gpo').value="";
    document.getElementById('origen').value="";
    document.getElementById('descripcion').value="";
    document.getElementById('idupdate').value="";

  }
  function limpiar_modal() {
    $("#tiporeferencia2").val("limpia").change();
    $("#limitereferencia2").val("limpia").change();
    $("#optionEntidad").val("limpia").change();
          $("#table2 tbody tr").remove();
        $("#table2").append("<tr>"
          +"<td>No Found</td>"
          +"<td></td>"
          +"</tr>"
        );
       document.getElementById('search').value="";

}

function validarFormula()
{
  var formula=$("#calculoFormula").val();
  var v=4;

  var response=false;
  //console.log(eval(formula));
  try{
    var res=eval(formula);
    if(res)
    {
    
   response=true;

    }
    //console.log(res);
  }catch(e){
    if (e instanceof SyntaxError) {
      
   response=false;

    }

  }
  /*console.log(res);
  */
  return response;
}

function GuardarExcel()
{
 var id_=$("#OptionEntidad").val();
  if(id_=="limpia"){
    Command: toastr.warning("Entidad No Seleccionada!", "Notifications")
  }else{
    document.getElementById("blockui_sample_3_1").click();
     $.ajax({
           method: "GET",            
           url: "{{ url('/tipo-servicio-find-all') }}",
           data: {_token:'{{ csrf_token() }}'}  })
        .done(function (responseTipoServicio) {
            //console.log(responseTipoServicio);
            if(responseTipoServicio=="[]")
            { 
              Command: toastr.warning("Sin Registros!", "Notifications")
              document.getElementById("blockui_sample_3_1_1").click();
            }else{
              //var Resp=$.parseJSON(responseTipoServicio);  
               var title="Tipo_Servicio";        
               JSONToCSVConvertor(responseTipoServicio, title, true);
            }
        })
        .fail(function( msg ) {
         Command: toastr.warning("No Success", "Notifications") 
         document.getElementById("blockui_sample_3_1_1").click(); }); 
  }
}
$('.valida-formula').on('input', function () { 
    this.value = this.value.replace(/[^0-9./*+()v-]/g,'');
});
$('.valida-decimal').on('input', function () { 
    this.value = this.value.replace(/[^0-9.]/g,'');
});
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
  var f = new Date();
  fecha =  f.getFullYear()+""+(f.getMonth() +1)+""+f.getDate()+"_";
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;    
    var CSV = '';    
    //CSV += ReportTitle + '\r\n\n';
    if (ShowLabel) {
        var row = ""; 
        for (var index in arrData[0]) { 
            row += index + ',';
        }
        row = row.slice(0, -1);
        CSV += row + '\r\n';
    } 
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }
        row.slice(0, row.length - 1); 
        CSV += row + '\r\n';
    }
    if (CSV == '') {        
        alert("Invalid data");
        return;
    }
    document.getElementById("blockui_sample_3_1_1").click();

    var fileName = fecha;
    fileName += ReportTitle.replace(/ /g,"_");
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    var link = document.createElement("a");    
    link.href = uri;
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
     Command: toastr.success("Success", "Notifications")
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script>
@endsection
