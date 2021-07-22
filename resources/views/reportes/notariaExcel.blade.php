<!DOCTYPE html>
<html>
<head>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Número Notaría</th>
        <th>Entidad Federativa</th>
        <th>Ciudad</th>
        <th>Calle</th>
        <th>Número Exterior</th>
        <th>Número Interior</th>
        <th>Código Postal</th>
        <th>Colonia</th>
        <th>Número de Teléfono</th>
        <th>Correo Electrónico</th>
    </tr>
    </thead>
    <tbody>
   @foreach ($notaria as $not)
        <tr>
           <td >{{ $not->notary_number }}</td>
           <td >{{ $not->estado }}</td>
           <td >{{ $not->municipio }}</td>
           <td >{{ $not->street }}</td>
           <td >{{ $not->number }}</td>
           <td >{{ $not->numero_int }}</td>
           <td >{{ $not->zip }}</td>
           <td >{{ $not->district }}</td>
           <td >{{ $not->phone }}</td>
           <td >{{ $not->email }}</td>
     
         
        </tr>
    @endforeach
    </tbody>
   </table>
 </body>