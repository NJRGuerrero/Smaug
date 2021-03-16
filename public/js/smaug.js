/* Start components */

// Datatable
function buildDataTable(id){
    try{
        var table = $('#'+id).DataTable();
        table.destroy();
    } catch(e){}
    
	var groups = $('#'+id).find('[data-group]').length;
	var groupIndexes = new Array(groups);
	for(var i = 0; i < groups; i++){
		groupIndexes[i] = i;
	}
	
	$("#"+id).DataTable({
		"language": {
			"paginate": {
				"first": "Primera",
				"last": "Última",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"emptyTable": "Sin Registros",
			"info": "Mostrando _END_ de _TOTAL_ registros",
			"infoEmpty": "Sin resultados para mostrar",
			"infoFiltered": " - filtrado de _MAX_ registros",
			"search": "Palabra clave:",
			"zeroRecords": "No se encontraron coincidencias",
			"lengthMenu": "Mostrar _MENU_ registros",
            'searchPlaceholder': "Sensible a mayusculas"
		},
        "search": {
            "caseInsensitive": false
        },
		"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
		"aaSorting": [],
		columnDefs: [
			{orderable: false, targets: 'not-sort'},
			{visible: false, targets: 'hidden' }
			
		],
        rowGroup: (groups > 0 ? {
            dataSrc:  groupIndexes
        } : false),
		paging: ($(this).data('paging') == 'false' ? false : true),
		searching: ($(this).data('search') == 'false' ? false : true),
		drawCallback: function() {
			
			/*var groupBy = $(this).data('groupby');
			if(groupBy != undefined && groupBy != false){
				var api = this.api();
				var rows = api.rows( {page:'current'} ).nodes();
				var columns = api.columns();
				
				var last=null;
				
				api.column(groupBy, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
						$(rows).eq( i ).before(
							'<tr class="group"><td colspan="'+(columns[0].length - 1)+'">'+group+'</td></tr>'
						);
						
						last = group;
					}
				} );
			}*/
    
            $('[data-toggle="tooltip"]').tooltip({container:'body', trigger: 'hover'});
		}
	});
}

// Single Select
function buildSingleSelect(id){
    
    var placeholder = $('#'+id).data('placeholder');
    if(placeholder == undefined){
        placeholder = 'Selecciona una opción';
    }
    
    $('#'+id).select2({
        width: ($(this).data('width') == undefined ? '100%' : $(this).data('width')),
		"language": {
			"noResults": function(){
				return "Sin opciones disponibles";
			},
		},
        placeholder: placeholder,
    });
}

// Multiple Select
function buildMultipleSelect(id){
	
    $('#'+id).select2({
		maximumSelectionLength: $(this).data('maxselection'),
        placeholder: '',
        allowClear: true,
        width: '100%'
    });
}

/* End Components */


/* Start Validation */

function validateForm(form){
    clearValidations();
    
    var valid = true;
    
    for(var i = 0; i < form.length; i++){
        var input = form[i];
        if(input.type == 'text' || input.type == 'mail' || input.type == 'password' || input.type == 'textarea' || input.type == 'url'){
            input.value = input.value.trim();
        }
        
        var customMessage = undefined;
        if(input.type == 'file' && input.accept != ''){
            var fileTypes = input.accept.split(',');
            
            for(var j = 0; j < input.files.length; j++){
                
                var fileName = input.files[j].name;
                var arrName = fileName.split('.');
                var ext = arrName.slice(-1);

                if(!fileTypes.includes('.'+ext)){
                    customMessage = 'Documento incorrecto. Se acepta: '+fileTypes.join(', ');
                }
            }
        }

        if (!input.checkValidity() || customMessage != undefined) {
            valid = false;

            var message = (customMessage == undefined ? input.validationMessage : customMessage);
            
            var warning = '<i class="invalid-warning">' + message + '</i>';
            $(input).parent().append(warning);
            $(input).addClass('invalid-input');
        
            var parentTab = $(input).closest('.panel-tab');
            if(parentTab.length > 0){
                var menuTab = $('.panel-menu li[data-target="' + parentTab[0].id + '"]')[0];
                $(menuTab).addClass('invalid-content');
            }
            
            triggerValidation(input.id);
        }
    }
    
    if(!valid){
        notifyUser('danger', 'Error al validar los datos', 'Favor de completar correctamente todos los campos');
    } 

    return valid;
}

function triggerValidation(elementId){
	$('#'+elementId).on('change', function() {
		if(!$(this).prop('required')){
			return;
		}
		
		if(this.type == 'text' || this.type == 'mail' || this.type == 'password' || this.type == 'textarea' || this.type == 'url'){
			this.value = this.value.trim();
		}
        
        var customMessage = undefined;
        if(this.type == 'file' && this.accept != ''){
            var fileTypes = this.accept.split(',');
            
            for(var j = 0; j < this.files.length; j++){
                
                var fileName = this.files[j].name;
                var arrName = fileName.split('.');
                var ext = arrName.slice(-1);

                if(!fileTypes.includes('.'+ext)){
                    customMessage = 'Documento incorrecto. Se acepta: '+fileTypes.join(', ');
                }
            }
        }
		
		if (!this.checkValidity() || customMessage != undefined) {
            var message = (customMessage == undefined ? this.validationMessage : customMessage);

			var warning = '<i class="invalid-warning">' + message + '</i>';
			$(this).parent().children('.invalid-warning').remove();
			
			var input = $(this).parent().append(warning);
			$(this).addClass('invalid-input');
			
			var parentTab = $(this).closest('.panel-tab');
			if(parentTab.length > 0){
				var menuTab = $('.panel-menu li[data-target="' + parentTab[0].id + '"]')[0];
				$(menuTab).addClass('invalid-content');
			}
		} else {
			$(this).removeClass('invalid-input');
			$(this).parent().children('.invalid-warning').remove();
			
			var parentTab = $(this).closest('.panel-tab');
			if(parentTab.length > 0){
				var menuTab = $('.panel-menu li[data-target="' + parentTab[0].id + '"]')[0];
				var invalidChildren = $(parentTab[0]).find('.invalid-input');
				if(invalidChildren.length == 0){
					$(menuTab).removeClass('invalid-content');
				}
			}
		}
	});
}

function backValidation(form, data){

    for(var i = 0; i < data.length; i++){

        var name = data[i][0];
        var message = data[i][1];

        var warning = '<i class="invalid-warning">' + message + '</i>';
        
        for(var j = 0; j < form.length; j++){
            if (form[j].name == name) {
                $(form[j]).addClass('invalid-input').parent().append(warning);
                triggerValidation(form[j].id);
                break;
            }
        }
    }
}

function clearValidations(){
    $('.invalid-warning').remove();
    $('.invalid-input').removeClass('invalid-input');
    $('.invalid-content').removeClass('invalid-content');
}

/* End Validation */

/* Notifications */

function showWait(){
    $('#processing').fadeIn();
}

function closeWait(){
    $('#processing').fadeOut();
}

var Timer = function(callback, delay) {
    var timerId;
    var start
    var remaining = delay;

    this.pause = function() {
        clearTimeout(timerId);
        remaining -= Date.now() - start;
    };

    this.resume = function(newDelay = false) {
        start = Date.now();
        window.clearTimeout(timerId);
        if(newDelay){
            timerId = window.setTimeout(callback, newDelay);
        } else {
            timerId = window.setTimeout(callback, remaining);
        }
    };

    this.resume();
};
    
function notifyUser(type, title, content, id = false){
    if(id && $('#notify'+id).length > 0 ){
        return;
    }
    
    $('#notification').addClass(type+' notification');
    $('#notification_title').html(title);
    $('#notification_content').html(content);
    
    var newNotification = $('#notification').clone().appendTo('#notification_area');
    $('#notification_area').addClass('active');
    if(id){
        $(newNotification).attr('id', 'notify'+id);
    }
    
    var closeTimer = new Timer(function() {
        closeNotification(newNotification);
    }, 4000 );

    $(newNotification).mouseover(function(){
        closeTimer.pause();
    });

    $(newNotification).mouseleave(function(){
        closeTimer.resume(1500);
    });
    
    $('#notification_title').html('');
    $('#notification_content').html('');
    $('#notification').removeClass();
}

function closeNotification(notification){
    $(notification).fadeOut(500);
    setTimeout(function(){
        $(notification).remove();
        if($('#notification_area').html() == ''){
            $('#notification_area').removeClass();
        }
    }, 1000 );
}

/* End notification */

/* Ajax global */

    
$( document ).ajaxStart(function() {
    $('[data-toggle="tooltip"]').tooltip('destroy');
    showWait();
});

$( document ).ajaxSuccess (function( event, request, settings ) {
    // Pending
});

$( document ).ajaxError(function( event, request, settings ) {
    notifyUser('danger', '¡Algo salió mal!', 'Favor de intentar nuevamente');
    console.log(event);
    console.log(request);
    console.log(settings);
    if(request.status == 401){
        location.reload();
    }
});

$( document ).ajaxStop(function() {
    setTimeout(function(){ closeWait(); }, 750);
    $('[data-toggle="tooltip"]').tooltip({
        container:'body', trigger: 'hover'
    });
});

/* On load triggers */

$( document ).ready(function() {
	$(".field input, .field textarea, .field select").change(function(){
		var parent = $(this).parent('.field')[0];
		var label = $(parent).children('label').last()[0];
		if(this.value != ""){
			$(label).addClass("active");
		} else {
			$(label).removeClass("active");
		}
	});
    
    $('.table-dataTable').each(function(){
        buildDataTable(this.id);
    });
    
    $('.select-single').each(function(){
        buildSingleSelect(this.id);
    });
    
    $('.select-single').each(function(){
        buildMultipleSelect(this.id);
    });

    $('.fileDiv').each(function(){
        
        var fileInput = $(this).children('input[type=file]').first();

        var textQty = (fileInput.multiple ? 'archivos' : 'archivo');
        
        var text = (fileInput.data('placeholder') == undefined ? 'Seleccionar ' + textQty : fileInput.data('placeholder'));
        var placeholder = '<span class="file-input-placeholder" data-text="'+text+'">'+text+'</span>';
        $(this).append(placeholder);

        var cleanFileInput = '<span class="file-input-clean" data-toggle="tooltip" title="Quitar '+textQty+'">x</span>';
        $(this).append(cleanFileInput);

        $(fileInput).on('change', function(){
            var p = $(this).next();
            var fileQty = this.files.length;
            var bolTooltip = false;

            if(fileQty == 0){
                p.text(p.data('text'));
                $(this).removeClass('with-file');
            } else if(fileQty == 1){
                p.text(this.files[0].name);
                $(this).addClass('with-file');
            } else {
                p.text(fileQty + ' archivos elegidos');
                $(this).addClass('with-file');
                bolTooltip = true;
            }
            /*
            if(bolTooltip){

                var names = [];
                for(var i = 0; i < fileQty; i++){
                    names.push(this.files[i].name);
                }

                $(this).data('toggle', 'tooltip');
                $(this).data('html', 'true');
                $(this).data('title', names.join('<br>'));
                $(this).tooltip({container:'body', trigger: 'hover'});
                $(this).tooltip('enable');
            } else {
                try{
                    $(this).tooltip('disable');
                } catch(e){}
            }*/
        });
    });
    
    $('.file-input-clean').on('click', function(){
        var inputFile = $(this).prev().prev();
        $(inputFile).val('').trigger('change');
    });

    $('[data-toggle="tooltip"]').tooltip({container:'body', trigger: 'hover'});
});
//New Line