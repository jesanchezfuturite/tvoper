@extends('layout.app')

@section('content')
<h3 class="page-title"> Conciliación <small>Carga de Archivo</small></h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Operación - Conciliación</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Carga de Archivos</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Carga de archivos para conciliación
                </div>
            </div>
            <div class="portlet-body form">
                <form action=" {{ url('/conciliacion-uploadfile') }}" method="POST" role="form" method="post" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-body">
                        <div class="form-group">
                            <label for="exampleInputFile1">Cargar Archivo</label>
                            <input multiple="multiple" type="file" id="files[]" name="files[]">
                            <p class="help-block">

                                @if($valid == 1)
                                    Archivo para conciliar
                                @elseif($valid == 0)
                                    Archivo incorrecto - por favor verifique lo que intenta subir
                                @else
                                    Archivo cargado correctamente
                                @endif
                                 
                            </p>
                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Procesar</button>
                        <button type="button" class="btn default">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption" id="headerTabla">
              <div id="borraheader">  Resultados de conciliación &nbsp;
                 @if($report == false)
                <span class="label label-sm label-danger">Sin resultados </span>
                @endif
            </div>
        </div>
            
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-hover" id="table">
                <thead>
                <tr>
                    <th>Banco</th>
                    <th colspan="4" align="center">Internet</th>
                    <th colspan="4" align="center">Medios de pagos</th>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <th>Total de tramites</th>
                    <th>Procesado</th>
                    <th>No Procesado</th>
                    <th>Monto</th>
                    <th>Total de tramites</th>
                    <th>Procesado</th>
                    <th>No Procesado</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>                   
                @if($report == false)
                <tr>
                <td>
                    <span class="help-block">No Found</span>
                </td>
                </tr>                    
                @else
                    @foreach($report as $r => $values )

                    <tr>
                    <td>{{$r}}</td>
                    <td>{{number_format($values["total_egob"])}}</td>
                    <td>{{number_format($values["total_egobp"])}}</td>
                    <td>{{number_format($values["total_egobnp"])}}</td>
                    <td>${{number_format($values["total_egobmonto"],2)}}</td>
                    <td>{{number_format($values["total_motor"])}}</td>
                    <td>{{number_format($values["total_motorp"])}}</td>
                    <td>{{number_format($values["total_motornp"])}}</td>
                    <td>${{number_format($values["total_motormonto"],2)}}</td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
@endsection

@section('scripts')

@endsection
