@extends('layout.app')

@section('content')

<h3 class="page-title">
Configuración <small> Menu principal</small>
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="index.html">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Configuración</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#">Menu principal</a>
        </li>
    </ul>
</div>


<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i> Nivel Principal
                </div>
            </div>
            <div class="portlet-body form col-sm-4">
                <form role="form">
                    <div class="form-body">
                        <div class="form-group">
                            <label>Menu Principal</label>
                            <a href="javascript:;" class="btn btn-icon-only red">
                                <i class="fa fa-times"></i>
                            </a> 
                            <select multiple class="form-control">
                            
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nuevo valor</label>
                            <a href="javascript:;" class="btn btn-icon-only green">
                                <i class="fa fa-plus"></i>
                            </a> 
                            <div class="input-icon input-icon-lg right">
                                <i class="fa fa-bell-o"></i>
                                <input type="text" class="form-control input-lg" placeholder="Left icon">
                            </div>
                        </div>
                       
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
