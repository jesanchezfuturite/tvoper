@extends('layout.app')

@section('content')
<h3 class="page-title">Motor de pagos <small>Bancos</small></h3>
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
            <a href="#">Bancos</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Banco
            </div>
            
        </div>
        <div class="portlet-body">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputEmail2">Nuevo Banco</label>
                    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Nuevo Banco">
                </div>
                <button class="btn btn-default">Agregar</button>
                
                <div class="form-group">
                    <label >&nbsp;&nbsp;Bancos Registrados (Selecciona para ver las cuentas)</label>
                    
                        <select class="form-control">
                            <option>------</option>
                            <option>Bancomer</option>
                            <option>HSBC</option>
                            <option>Banamex</option>
                            <option>Aqui se agregan las opciones del campo anterior</option>
                        </select>
            
                </div>
                
                
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
