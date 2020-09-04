@extends('layout.app')

@section('content')
<h3 class="page-title">Portal <small>Solicitudes</small></h3>
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
            <a href="#">Solicitudes</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="portlet box blue">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-bank"></i>Agregar Solicitud
            </div>
        </div>
        <div class="portlet-body">
	        <div class="form-body">
		        <div class="row">
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">
		                    <label >Trámites</label>
		                  </div>
		            </div>
		            <div class="col-md-3 col-ms-12">
		                <div class="form-group">           
						    <select class="select2me form-control" name="tramitesSelect" id="tramitesSelect" onchange="updateTablaSolicitudes()">
						       <option value="limpia">------
						        </option>
						    </select>
							<i class="fa fa-spin fa-spinner" id="spin-animate"></i>    
		                </div>
		            </div>
		            <div class="col-md-2 col-ms-12">
		                <div class="form-group" id="addButton">
		                    
		                </div>
		            </div>
	            </div> 
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet box blue">
        <div class="portlet-title">
            
            <div class="caption" id="headerTabla">
              	<div id="borraheader"> 
              	 	<i class="fa fa-cogs"></i>&nbsp;Solicitudes &nbsp;
            	</div>
            </div>
            <div class="tools" id="toolsSolicitudes">                
                <a href="#add-solicitud-modal" data-toggle="modal" class="config" data-original-title="" title="Agregar Solicitud">
                </a>
               	<a id="Remov" href="javascript:;" data-original-title="" title="Desactivar Banco" onclick="desactivaSolicitud()">
               		<i class='fa fa-remove' style="color:white !important;"></i>
                </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
               <table id="example" class="table table-hover hidden" cellspacing="0" width="100%" >
				    <thead>
				        <tr>
				            <th></th>
				            <th>Name</th>
				            <th>Position</th>
				            <th>Office</th>
				            <th>Salary</th>
				        </tr>
				    </thead>
				</table>
            </div>
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->

</div>

<div class="modal fade" id="add-solicitud-modal" tabindex="-1" data-backdrop="static" role="dialog" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()"></button>
                <h4 class="modal-title">Agregar</h4>
            </div>
            <div class="modal-body">
	             <form action="#" class="form-horizontal">    
	                <div class="form-body">
	                    <input hidden="true" type="text"  id="idupdate">
	                    <input hidden="true" type="text"  id="estatus">
	                    <div class="row">
	                        <div class="col-md-12">                        
	                           <div class="form-group">
	                                <label class="col-md-3 control-label ">Titulo</label>
	                                <div class="col-md-8">
	                                    <input id="titulo" class="valida-num form-control" autocomplete="off" placeholder="Ingresar Titulo">
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-12">
	                        	<div class="form-group">
		                            <label class="col-md-3 control-label">Trámite</label>
		                            <div class="col-md-8">
		                                <select class="select2me form-control" name="tramitesSelectModal" id="tramitesSelectModal">
								    	</select>   
		                            </div>
		                        </div>
	                        </div>
	                    </div>         
                        <div class="form-group">
                        	<div class="col-md-10"> 
                                <button type="submit" class="btn blue" onclick="verificaInsert()">
                                	<i class="fa fa-check"></i> 
                                	Guardar
                                </button>
                            </div>
                        </div>
	                    <div class="modal-footer">
	                        <button type="button" data-dismiss="modal" class="btn default" onclick="limpiar()">Cerrar</button>
	                    </div>                        
	                </div>
	             </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- modal-dialog -->
@endsection

@section('scripts')
	<script src="assets/global/dataTable/dataTables.min.js"></script>
	<script src="assets/global/dataTable/jszip.min.js"></script>
	<script src="assets/global/dataTable/vfs_fonts.js"></script>
	<script>

		function getTramites(){
	        $.ajax({
		        method: "get",            
		        url: "{{ url('/solicitud-tramites') }}",
		        data: {_token:'{{ csrf_token() }}'}  })
	        .done((response) => {  
	        	let tramites = JSON.parse(response);
	        	tramites.forEach(tramite => {
					let option = new Option(tramite.tramite, tramite.id_tramite);
					$("#tramitesSelect").append(option);
					$("#tramitesSelectModal").append(option);
	        	});
	        })
	        .fail(function( msg ) {
	         	Command: toastr.warning("No Success", "Notifications") 
	        }).always( () =>{
	        	$("#spin-animate").hide();
	        } );
		}

		function updateTablaSolicitudes(){
			if( $("#tramitesSelect").val() != "limpia" ){
		        $.ajax({
			        method: "get",            
			        url: "{{ url('/solicitud-all') }}",
			        data: {
			        	_token:'{{ csrf_token() }}', id_tramite: $("#tramitesSelect").val()
			    	}  
			    })
		        .done((response) => {  
		        	console.log( response );
		        	$("#example").removeClass("hidden");
		        })
		        .fail(function( msg ) {
		         	Command: toastr.warning("No Success", "Notifications") 
		        });
	    	}

		}

		function format ( d ) {
		    // `d` is the original data object for the row
		    return '<table  class="table table-hover" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		        '<tr>'+
		            '<td>Full name:</td>'+
		            '<td>'+d.name+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extension number:</td>'+
		            '<td>'+d.extn+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extra info:</td>'+
		            '<td>And any further details here (images etc)...</td>'+
		        '</tr>'+
		    '</table>';
		}

    jQuery(document).ready(function() {
    	getTramites();
		var table = $('#example').DataTable( {
        	data : [
    {
      "name": "Tiger Nixon",
      "position": "System Architect",
      "salary": "$320,800",
      "start_date": "2011/04/25",
      "office": "Edinburgh",
      "extn": "5421"
    },
    {
      "name": "Garrett Winters",
      "position": "Accountant",
      "salary": "$170,750",
      "start_date": "2011/07/25",
      "office": "Tokyo",
      "extn": "8422"
    },
    {
      "name": "Ashton Cox",
      "position": "Junior Technical Author",
      "salary": "$86,000",
      "start_date": "2009/01/12",
      "office": "San Francisco",
      "extn": "1562"
    },
    {
      "name": "Cedric Kelly",
      "position": "Senior Javascript Developer",
      "salary": "$433,060",
      "start_date": "2012/03/29",
      "office": "Edinburgh",
      "extn": "6224"
    },
    {
      "name": "Airi Satou",
      "position": "Accountant",
      "salary": "$162,700",
      "start_date": "2008/11/28",
      "office": "Tokyo",
      "extn": "5407"
    },
    {
      "name": "Brielle Williamson",
      "position": "Integration Specialist",
      "salary": "$372,000",
      "start_date": "2012/12/02",
      "office": "New York",
      "extn": "4804"
    },
    {
      "name": "Herrod Chandler",
      "position": "Sales Assistant",
      "salary": "$137,500",
      "start_date": "2012/08/06",
      "office": "San Francisco",
      "extn": "9608"
    },
    {
      "name": "Rhona Davidson",
      "position": "Integration Specialist",
      "salary": "$327,900",
      "start_date": "2010/10/14",
      "office": "Tokyo",
      "extn": "6200"
    },
    {
      "name": "Colleen Hurst",
      "position": "Javascript Developer",
      "salary": "$205,500",
      "start_date": "2009/09/15",
      "office": "San Francisco",
      "extn": "2360"
    },
    {
      "name": "Sonya Frost",
      "position": "Software Engineer",
      "salary": "$103,600",
      "start_date": "2008/12/13",
      "office": "Edinburgh",
      "extn": "1667"
    },
    {
      "name": "Jena Gaines",
      "position": "Office Manager",
      "salary": "$90,560",
      "start_date": "2008/12/19",
      "office": "London",
      "extn": "3814"
    },
    {
      "name": "Quinn Flynn",
      "position": "Support Lead",
      "salary": "$342,000",
      "start_date": "2013/03/03",
      "office": "Edinburgh",
      "extn": "9497"
    },
    {
      "name": "Charde Marshall",
      "position": "Regional Director",
      "salary": "$470,600",
      "start_date": "2008/10/16",
      "office": "San Francisco",
      "extn": "6741"
    },
    {
      "name": "Haley Kennedy",
      "position": "Senior Marketing Designer",
      "salary": "$313,500",
      "start_date": "2012/12/18",
      "office": "London",
      "extn": "3597"
    },
    {
      "name": "Tatyana Fitzpatrick",
      "position": "Regional Director",
      "salary": "$385,750",
      "start_date": "2010/03/17",
      "office": "London",
      "extn": "1965"
    },
    {
      "name": "Michael Silva",
      "position": "Marketing Designer",
      "salary": "$198,500",
      "start_date": "2012/11/27",
      "office": "London",
      "extn": "1581"
    },
    {
      "name": "Paul Byrd",
      "position": "Chief Financial Officer (CFO)",
      "salary": "$725,000",
      "start_date": "2010/06/09",
      "office": "New York",
      "extn": "3059"
    },
    {
      "name": "Gloria Little",
      "position": "Systems Administrator",
      "salary": "$237,500",
      "start_date": "2009/04/10",
      "office": "New York",
      "extn": "1721"
    },
    {
      "name": "Bradley Greer",
      "position": "Software Engineer",
      "salary": "$132,000",
      "start_date": "2012/10/13",
      "office": "London",
      "extn": "2558"
    },
    {
      "name": "Dai Rios",
      "position": "Personnel Lead",
      "salary": "$217,500",
      "start_date": "2012/09/26",
      "office": "Edinburgh",
      "extn": "2290"
    },
    {
      "name": "Jenette Caldwell",
      "position": "Development Lead",
      "salary": "$345,000",
      "start_date": "2011/09/03",
      "office": "New York",
      "extn": "1937"
    },
    {
      "name": "Yuri Berry",
      "position": "Chief Marketing Officer (CMO)",
      "salary": "$675,000",
      "start_date": "2009/06/25",
      "office": "New York",
      "extn": "6154"
    },
    {
      "name": "Caesar Vance",
      "position": "Pre-Sales Support",
      "salary": "$106,450",
      "start_date": "2011/12/12",
      "office": "New York",
      "extn": "8330"
    },
    {
      "name": "Doris Wilder",
      "position": "Sales Assistant",
      "salary": "$85,600",
      "start_date": "2010/09/20",
      "office": "Sidney",
      "extn": "3023"
    },
    {
      "name": "Angelica Ramos",
      "position": "Chief Executive Officer (CEO)",
      "salary": "$1,200,000",
      "start_date": "2009/10/09",
      "office": "London",
      "extn": "5797"
    },
    {
      "name": "Gavin Joyce",
      "position": "Developer",
      "salary": "$92,575",
      "start_date": "2010/12/22",
      "office": "Edinburgh",
      "extn": "8822"
    },
    {
      "name": "Jennifer Chang",
      "position": "Regional Director",
      "salary": "$357,650",
      "start_date": "2010/11/14",
      "office": "Singapore",
      "extn": "9239"
    },
    {
      "name": "Brenden Wagner",
      "position": "Software Engineer",
      "salary": "$206,850",
      "start_date": "2011/06/07",
      "office": "San Francisco",
      "extn": "1314"
    },
    {
      "name": "Fiona Green",
      "position": "Chief Operating Officer (COO)",
      "salary": "$850,000",
      "start_date": "2010/03/11",
      "office": "San Francisco",
      "extn": "2947"
    },
    {
      "name": "Shou Itou",
      "position": "Regional Marketing",
      "salary": "$163,000",
      "start_date": "2011/08/14",
      "office": "Tokyo",
      "extn": "8899"
    },
    {
      "name": "Michelle House",
      "position": "Integration Specialist",
      "salary": "$95,400",
      "start_date": "2011/06/02",
      "office": "Sidney",
      "extn": "2769"
    },
    {
      "name": "Suki Burks",
      "position": "Developer",
      "salary": "$114,500",
      "start_date": "2009/10/22",
      "office": "London",
      "extn": "6832"
    },
    {
      "name": "Prescott Bartlett",
      "position": "Technical Author",
      "salary": "$145,000",
      "start_date": "2011/05/07",
      "office": "London",
      "extn": "3606"
    },
    {
      "name": "Gavin Cortez",
      "position": "Team Leader",
      "salary": "$235,500",
      "start_date": "2008/10/26",
      "office": "San Francisco",
      "extn": "2860"
    },
    {
      "name": "Martena Mccray",
      "position": "Post-Sales support",
      "salary": "$324,050",
      "start_date": "2011/03/09",
      "office": "Edinburgh",
      "extn": "8240"
    },
    {
      "name": "Unity Butler",
      "position": "Marketing Designer",
      "salary": "$85,675",
      "start_date": "2009/12/09",
      "office": "San Francisco",
      "extn": "5384"
    },
    {
      "name": "Howard Hatfield",
      "position": "Office Manager",
      "salary": "$164,500",
      "start_date": "2008/12/16",
      "office": "San Francisco",
      "extn": "7031"
    },
    {
      "name": "Hope Fuentes",
      "position": "Secretary",
      "salary": "$109,850",
      "start_date": "2010/02/12",
      "office": "San Francisco",
      "extn": "6318"
    },
    {
      "name": "Vivian Harrell",
      "position": "Financial Controller",
      "salary": "$452,500",
      "start_date": "2009/02/14",
      "office": "San Francisco",
      "extn": "9422"
    },
    {
      "name": "Timothy Mooney",
      "position": "Office Manager",
      "salary": "$136,200",
      "start_date": "2008/12/11",
      "office": "London",
      "extn": "7580"
    },
    {
      "name": "Jackson Bradshaw",
      "position": "Director",
      "salary": "$645,750",
      "start_date": "2008/09/26",
      "office": "New York",
      "extn": "1042"
    },
    {
      "name": "Olivia Liang",
      "position": "Support Engineer",
      "salary": "$234,500",
      "start_date": "2011/02/03",
      "office": "Singapore",
      "extn": "2120"
    },
    {
      "name": "Bruno Nash",
      "position": "Software Engineer",
      "salary": "$163,500",
      "start_date": "2011/05/03",
      "office": "London",
      "extn": "6222"
    },
    {
      "name": "Sakura Yamamoto",
      "position": "Support Engineer",
      "salary": "$139,575",
      "start_date": "2009/08/19",
      "office": "Tokyo",
      "extn": "9383"
    },
    {
      "name": "Thor Walton",
      "position": "Developer",
      "salary": "$98,540",
      "start_date": "2013/08/11",
      "office": "New York",
      "extn": "8327"
    },
    {
      "name": "Finn Camacho",
      "position": "Support Engineer",
      "salary": "$87,500",
      "start_date": "2009/07/07",
      "office": "San Francisco",
      "extn": "2927"
    },
    {
      "name": "Serge Baldwin",
      "position": "Data Coordinator",
      "salary": "$138,575",
      "start_date": "2012/04/09",
      "office": "Singapore",
      "extn": "8352"
    },
    {
      "name": "Zenaida Frank",
      "position": "Software Engineer",
      "salary": "$125,250",
      "start_date": "2010/01/04",
      "office": "New York",
      "extn": "7439"
    },
    {
      "name": "Zorita Serrano",
      "position": "Software Engineer",
      "salary": "$115,000",
      "start_date": "2012/06/01",
      "office": "San Francisco",
      "extn": "4389"
    },
    {
      "name": "Jennifer Acosta",
      "position": "Junior Javascript Developer",
      "salary": "$75,650",
      "start_date": "2013/02/01",
      "office": "Edinburgh",
      "extn": "3431"
    },
    {
      "name": "Cara Stevens",
      "position": "Sales Assistant",
      "salary": "$145,600",
      "start_date": "2011/12/06",
      "office": "New York",
      "extn": "3990"
    },
    {
      "name": "Hermione Butler",
      "position": "Regional Director",
      "salary": "$356,250",
      "start_date": "2011/03/21",
      "office": "London",
      "extn": "1016"
    },
    {
      "name": "Lael Greer",
      "position": "Systems Administrator",
      "salary": "$103,500",
      "start_date": "2009/02/27",
      "office": "London",
      "extn": "6733"
    },
    {
      "name": "Jonas Alexander",
      "position": "Developer",
      "salary": "$86,500",
      "start_date": "2010/07/14",
      "office": "San Francisco",
      "extn": "8196"
    },
    {
      "name": "Shad Decker",
      "position": "Regional Director",
      "salary": "$183,000",
      "start_date": "2008/11/13",
      "office": "Edinburgh",
      "extn": "6373"
    },
    {
      "name": "Michael Bruce",
      "position": "Javascript Developer",
      "salary": "$183,000",
      "start_date": "2011/06/27",
      "office": "Singapore",
      "extn": "5384"
    },
    {
      "name": "Donna Snider",
      "position": "Customer Support",
      "salary": "$112,000",
      "start_date": "2011/01/25",
      "office": "New York",
      "extn": "4226"
    }
  ],
    	    "columns": [
	            {
	                "class":          'fa fa-plus',
	                "orderable":      false,
	                "data":           null,
	                "defaultContent": ''
	            },
	            { "data": "name" },
	            { "data": "position" },
	            { "data": "office" },
	            { "data": "salary" }
        	],
        	"order": [[1, 'asc']]
    	});

			    // Add event listener for opening and closing details
	    $('#example tbody').on('click', 'td.fa-plus', function () {
	        var tr = $(this).parents('tr');
	        var row = table.row( tr );
	 
	        if ( row.child.isShown() ) {
	            // This row is already open - close it
	            row.child.hide();
	            tr.removeClass('shown');
	        }
	        else {
	            // Open this row
	            row.child( format(row.data()) ).show();
	            tr.addClass('shown');
	        }
	    } );

    });

	</script>
@endsection
