@extends('layout.app')
@section('content')

<link href="assets/global/css/checkbox.css" rel="stylesheet" type="text/css"/>
<h3 class="page-title">Portal <small>Asignar Tramite</small></h3>
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
            <a href="#">Asignar Tramite</a>
        </li>
    </ul>
</div>
<div class="row">  
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Entidad
            </div>
            
        </div>
        <div class="portlet-body">
        <div class="form-body">
        <div class="row">
            <div class="col-md-3">   
                <div class="form-group">
                    <label>Entidades Registradas (Selecciona para ver los Tramites)</label>         
                </div>
            </div> 
            <div class="col-md-3">   
                <div class="form-group">    
                    <select class="select2me form-control" name="OptionEntidad" id="OptionEntidad" onchange="changeEntidad()">
                        <option value="limpia">------</option>
                    </select>       
                </div> 
            </div>
            <div id="editentidad" class="col-md-1 col-ms-12" hidden="true">
                <div class="form-group" >
                  <button type="button" class="btn green tooltips" onclick="editEntidad()"  data-container="body" data-placement="top" data-original-title="Editar Nombre Entidad" data-toggle='modal' href='#modEntidad'><i class='fa fa-pencil'></i></button>  
                </div>
            </div> 
          </div>            
            </div>
        </div>
    </div>
    
</div>

<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue" id="Addtable">
        <div class="portlet-title" id="TitleBanco">
            <div class="caption" id="RemoveTitle">
                <i class="fa fa-cogs"></i>Registros Entidad Tramite 
            </div>
             <div class="tools">                
                <a href="#static2" data-toggle="modal" class="config" data-original-title="" title="Agregar Nuevo">
                </a>
            </div>
        </div>
        <div class="portlet-body">
        <!--  <div class="row">
            <div class="form-group">
             <div class="col-md-12 text-right">                
                <button class="btn blue" onclick="GuardarExcel()"><i class="fa fa-file-excel-o"></i> Descargar CSV</button>
              </div>
            
            <span class="help-block">&nbsp; </span>
          </div></div>-->
        	<div id="table_sample"> 
                <table class="table table-hover" id="sample_2">
                <thead>
	                <tr>
	                    <th>
	                        Nombre
	                    </th>                    
	                    <th>
	                        &nbsp;
	                    </th>
	                </tr>
                </thead>
                	<tbody>              
                        <tr>                           
                            <td>                              
                              <span class="help-block">No Found</span>                          
                            </td>
                            <td class="text-right">
                            </td>
                        </tr>                              
                	</tbody>
                </table>
           </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->   
</div>
<div class="modal fade" id="portlet-config" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Limpiar()"></button>
                <h4 class="modal-title">Editar Tramite Entidad</h4>
            </div>
            <div class="modal-body">
                 <div class="form-body">
                      <input type="text" name="idtramiteEntidad" id="idtramiteEntidad" hidden="true">                   
                     <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        <label class="control-label">Tipo Tramite</label>
                                            <select id="itemsTipoServicio" class="select2me form-control">
                                                 <option id="limpia" value="limpia">-------</option>
                                               
                                            </select>
                                        <span class="help-block">
                                    Seleccione una Opcion </span>
                                 </div>
                             </div>
                        </div>
                    </div>
                  <div class="row">
                <div class="col-md-12">            
                    <div class="form-group">
                        <button type="submit" class="btn blue" onclick="savetramiteEntidad()"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                </div>
              </div>
                 
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                 <input hidden="true" type="text" name="idregistro" id="idregistro" class="idregistro">
            </div>
            <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn default">Cancelar</button>
            <button type="button" data-dismiss="modal" class="btn green" onclick="eliminaTramiteEntidad()">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<div id="static2" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarr()"></button>
                <h4 class="modal-title">Registro Tramite Entidad</h4>
            </div>
            <div class="modal-body">  
               <div class="col-md-12"><div class='form-group'><label for="search">Buscar:</label></div></div>
                 <div class="col-md-8"><div class='form-group'><input type="text" name="search" id="search" class="form-control" placeholder="Escribe..."></div></div>
                <div class="col-md-4"><div class='form-group'> <div class='md-checkbox'><input type='checkbox' id='checkbox30' class='md-check' onclick='MostrarTodos()'>   <label for='checkbox30'>    <span></span>  <span class='check'></span> <span class='box'></span>Mostrar Todos</label> </div><span class='help-block'>Muestra Todo los Registros</span> 
              </div></div>
                
               <div  id="demo">              
                 <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar" id="table2">
                    <thead>
                      <tr>            
                        <th>Selecciona</th>
                      </tr>
                    </thead>
                    <tbody>  
                        
                    </tbody>
                  </table>
               </div>
               <div class="col-md-12">            
                  <div class="form-group">
                    <button type="submit" class="btn blue" onclick="obtenerTodocheck()"><i class="fa fa-check"></i> Guardar</button>
                    </div>
                </div> 
                <br>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarr()">Cerrar</button>
            </div>
            
        </div>
    </div>
    <!-- added jesv-->
    <input type="hidden" id="selectedChecks" value="[]">
</div>
<div id="modEntidad" class="modal fade " tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiarentidad()"></button>
                <h4 class="modal-title">Editar Nombre Entidad</h4>
            </div>
            <div class="modal-body">
                <br>
                <br>

                <div class="row">
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="upEntidad">Entidad:</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="upEntidad"name="upEntidad" autocomplete="off"placeholder="Entidad...">
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="form-group">
                    <div class="col-md-12">                    
                            <button type="submit" class="btn blue" onclick="updateEntidad()"><i class="fa fa-check"></i> Guardar</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn default" onclick="limpiarentidad()">Cerrar</button>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('scripts')

<script type="text/javascript">
	jQuery(document).ready(function() {
		
    });
</script>

@endsection