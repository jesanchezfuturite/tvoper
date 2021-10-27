<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table>
    <thead>
       <tr>
          <th>Fecha</th> 
          <th>Operacion</th> 
          <th>Referencia</th> 
          <th>Banco</th>
          <th>Importe</th>
          <th>Respuesta</th>  
      </tr>
    </thead>
    <tbody>
   @foreach ($data as $row)
        <tr>
           <td >{{ $row->fecha }}</td>
           <td >{{ $row->operacion }}</td>
           <td >{{ $row->referencia }}</td>
           <td >{{ $row->banco }}</td>
           <td >{{ $row->importe }}</td>
           <td >{{ $row->respuesta }}</td>
        </tr>
    @endforeach
    </tbody>
   </table>
 </body>