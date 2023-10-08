

<!-- jQuery -->
<script type="text/javascript" src="{{asset('jquery/jquery-3.3.1.js')}}" ></script>
<script type="text/javascript" src="{{asset('jquery/jquery_ui/jquery-ui.min.js')}}" ></script>
<!-- Datatables -->
<script type="text/javascript" src="{{asset('plugins/datatables/media/js/jquery.dataTables-1.10.19.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/datatables/media/js/dataTables.bootstrap.js')}}" ></script>
<!-- Theme Javascript -->
<script type="text/javascript" src="{{asset('js/utility/utility.js')}}" ></script>
<script type="text/javascript" src="{{asset('js/main.js')}}" ></script>
<!-- Widget Javascript -->
<script type="text/javascript" src="{{asset('js/demo/widgets.js')}}" ></script>
<!-- Plugins -->
<script type="text/javascript" src="{{asset('plugins/canvasbg/canvasbg.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/select2/select2.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/maxlength/bootstrap-maxlength.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/sweetalert/sweetalert.min.js')}}" ></script>
<script type="text/javascript" src="{{asset('plugins/pnotify/pnotify.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/validation/additional-methods.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/tabledragger/table-dragger.js')}}"></script>
 
<!-- Custom Javascript -->
<script type="text/javascript">
    //Destruye un DataTable
    function destroyDataTable(id){
        var table = $('#'+id).DataTable();
        table.destroy();
    }

    //Construye un DataTable
    function buildDataTable(id){
        $('#'+id).dataTable({
            "language": {
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "emptyTable": "Sin Registros",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Sin resultados para mostrar",
                "infoFiltered": " - filtrado de _MAX_ registros",
                "search": "Palabra clave:",
                "zeroRecords": "No se encontraron coincidencias",
                "lengthMenu": "Mostrar _MENU_ registros"
            }
        });
    }

    $(".select2-single").select2({width: '100%'}).attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');

    jQuery(document).ready(function() {
        "use strict";
        
        // Init Theme Core      
        Core.init();

        // Init CanvasBG and pass target starting location
        /* CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2,
                y: window.innerHeight / 3.3
            },
        });*/
    });

	//Muestra el sweetalert de Espera
	function showWait(){
	    swal({
	        html: '<section id="content" class="table-layout animated fadeIn">'+
                    '<div class="tab-block tray tray-center">'+
                        '<div style="background:#ffffff; padding:5% 0 5% 15%;">'+
                            '<center>'+
                                '<div class="spinner" align="center">'+
                                    '<div class="spinner-circle spinner-circle-outer"></div>'+
                                    '<div class="spinner-circle-off spinner-circle-inner"></div>'+
                                    '<div class="spinner-circle spinner-circle-single-1"></div>'+
                                    '<div class="spinner-circle spinner-circle-single-2"></div>'+
                                    '<div class="blink"><center>Procesando...</center></div>'+
                                '</div>'+
                            '</center>'+
                        '</div>'+
                    '</div>'+
                '</section>',
	        showConfirmButton: false,
	        allowOutsideClick: false
	    });
	}
	
	function notifyUser(title, text, type){
   		// Create new Notification
     	new PNotify({
       		title: title,
       		text: text,
       		shadow: true,
       		opacity: 1,
       		addclass: "stack_bar_bottom",
       		type: type,
       		stack: {
           		"dir1": "up",
           		"dir2": "right",
           		"spacing1": 0,
       			"spacing2": 0
    			},
       		width: "70%",
       		delay: 1400
     	});
	}
    
    function clearErrors(){
        var inputs = $(".state-error");
        for(var i = 0; i < inputs.length; i++){
            if(inputs[i].localName == "em"){
                inputs[i].remove();
            } else {
                var input = inputs[i];
                var classes = input.className;
                var newClasses =  classes.replace("state-error", "");
                input.className = newClasses;
            }
        }
    }
  </script>