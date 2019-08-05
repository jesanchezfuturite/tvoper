   
	function guardar() {
	  
		var date = $("#datetime1").datepicker("getDate");
		 var anioj = date.getFullYear();
         var mesj = date.getMonth()+1;
		 var diaj = date.getDate();
		  $.ajax({
            method: "POST",
            url: "{{ url('/dias-feriados-insert') }}",
            data: { anio: anioj, mes: mesj, dia: diaj, _token: '{{ csrf_token() }}' }
        })
          .done(function(response){ 
           //alert(data);
            var Resp=$.parseJSON(response);
            var item = '';
            $("#table tbody tr").remove();
            /*agrega tabla*/
                $.each(Resp, function(i, item) {                
                 $('#table tbody').append("<tr>"  
                 +"<td hidden>"+ item.anio +"-"+ item.mes +"-"+ item.dia + "</td>"                 
                 + "<td class='highlight'><div class='success'></div><a href='javascript:;'> &nbsp;" + item.anio +" - "+ item.mes +" - "+ item.dia + "</a></td>"                 
                 + "<td><a  class='btn default btn-xs black' data-toggle='modal' href='#static'><i class='fa fa-trash-o' ></i> Borrar </a></td>"                  
                 + "</tr>");
                 
                });
            Command: toastr.success("Success!", "Notifications")
           })
        .fail(function( msg ) {
            Command: toastr.warning("Failed to Add", "Notifications")
            console.log( "AJAX Failed to add in : " + msg );
        });
			toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "4000",
            "extendedTimeOut": "1000"
            }
	}
	$('#table').on('click', 'tr td a', function (evt) {

       var row = $(this).parent().parent();
       var celdas = row.children();
	   var com = new RegExp('\"','g'); 
	   var valor=$(celdas[0]).html();
        document.getElementById('idvalor').value =valor;

	   //var res=valor.replace(com,"");
	   //res=res.replace("<div class=success></div>","");
	   //res=res.replace("<a href=javascript:;>","");
	   //res=res.replace("</a>","");
	   //res=res.trim();
	   //res=res.replace(/ /g,"");
	   //var fecha= new Date(valor);   
		/*var r = confirm("ELIMINAR REGISTRO!");
		if (r == true) {
		deleted(fecha);
		} else {
		return;
		}  */     
    });

	function deleted()
	{
        var fecha = $("#idvalor").val();
        var fecha2= new Date(fecha+" 12:00:00"); 
		var date = fecha2;
		 var anioj = date.getFullYear();
         var mesj = date.getMonth()+1;
		 var diaj = date.getDate();
        
		$.ajax({
           method: "POST",
           url: "{{ url('/dias-feriados-eliminar') }}",
           data: { anio: anioj, mes: mesj, dia: diaj, _token: '{{ csrf_token() }}' }
       })
        .done(function (response) { 
             var Resp=$.parseJSON(response);
            var item = '';
            $("#table tbody tr").remove();
            /*agrega tabla*/
                $.each(Resp, function(i, item) {                
                 $('#table tbody').append("<tr>"  
                 +"<td hidden>"+ item.anio +"-"+ item.mes +"-"+ item.dia + "</td>"                 
                 + "<td class='highlight'><div class='success'></div><a href='javascript:;'> &nbsp;" + item.anio +" - "+ item.mes +" - "+ item.dia + "</a></td>"                 
                 + "<td><a  class='btn default btn-xs black'  data-toggle='modal' href='#static'><i class='fa fa-trash-o'></i> Borrar </a></td>"                  
                 + "</tr>");
                
                });
         Command: toastr.success("Success", "Notifications") })
        .fail(function( msg ) {
         Command: toastr.warning("No deleted", "Notifications")  });
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
         "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "4000",
         "extendedTimeOut": "1000"
        }
    }
    
