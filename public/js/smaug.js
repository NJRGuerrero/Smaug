function openModal(modalId){
    closeModal();
    $("#"+modalId).fadeIn();
    $("#"+modalId).addClass("active");
}

function closeModal(){
    $(".modal.active").fadeOut().removeClass("active");
}

$(".modal .close").click(function(){
   closeModal();
});

$(".field input, .field textarea, .field select").change(function(){
    if(this.value != ""){
        $(this.nextElementSibling).addClass("active");
    } else {
        $(this.nextElementSibling).removeClass("active");
    }
});

$(".chkDiv input[type=checkbox]").change(function(){
    var parent = this.parentElement;
    
    for(var i = 0; i < parent.children.length; i++){
        var child = parent.children[i];
        if(child.className == "chkText"){
            if(this.checked){
                $(child).html(this.dataset.checked);
            } else {
                $(child).html(this.dataset.unchecked);
            }
        }
    }
});

$("select, input").trigger("change");

function validateMultiple(multiple){
    if(multiple){
        $("#slt_movement_period").prop("disabled", false);
        $("#num_movement_repetitions").prop("disabled", false);
        $("#lbl_movement_startDate").html("Fecha de inicio");
    } else {
        $("#slt_movement_period").prop("disabled", true);
        $("#num_movement_repetitions").prop("disabled", true);
        $("#lbl_movement_startDate").html("Fecha");
    }

}

    
function StringToDate(stringDate){
    var dateArray = stringDate.split("-");
    var year = dateArray[0];
    var month = parseInt(dateArray[1], 10) - 1;
    var date = dateArray[2];
    var parsedDate = new Date(year, month, date);
    
    return parsedDate;
}

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
}

Date.prototype.addMonths = function(months) {
    var date = new Date(this.valueOf());
    var newDate = new Date(date.setMonth(date.getMonth()+months));
    return newDate;
}

Date.prototype.addYears = function(years) {
    var date = new Date(this.valueOf());
    var newDate = new Date(date.setYear(date.getFullYear()+years));
    return newDate;
}

Date.prototype.toInputString = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(),
          (mm>9 ? '' : '0') + mm,
          (dd>9 ? '' : '0') + dd
         ].join('-');
};


function calcFinalDate(startDate){
    if(!$("#chk_movement_multiple").prop("checked")){
        return;
    }
    
    var startDate = $("#dte_movement_startDate").val();
    startDate = StringToDate(startDate);
    
    var period = $("#slt_movement_period").val();
    period = period.split("-");
    var add = period[0];
    var unit = period[1];
    
    var repetitions = $("#num_movement_repetitions").val();
    var addTime = add * repetitions;
    
    try {
        switch(unit){
            case "d":
                var endDate = startDate.addDays(addTime);
                break;
            case "m":
                var endDate = startDate.addMonths(addTime);
                break;
            case "y":
                var endDate = startDate.addYears(addTime);
                break;
            default:
                var endDate = false;
                break;
        }
        
        if(endDate){
            $("#dte_movement_endDate").val(endDate.toInputString());
        }        
    } catch (e){
        
    }
}

function testFunction(form){
    if(validateForm(form)){
        alert("Yay!");
    } else {
        alert("Nay\n:(")
    }
}

function validateForm(form){
    $(".invalid-warning").removeClass("invalid-active");
    var valid = true;
    for(var i = 0; i < form.length; i++){
        if (!form[i].checkValidity()) {
            valid = false;
            $(".invalid-warning").addClass("invalid-active");
        }
    }
    
    return valid;
}


/* Descomentar cuando se resuelva lo del autofill
$(".input").change(function(){
    if(this.value != "" ){
        $(this.nextElementSibling).addClass("active");
    } else {
        $(this.nextElementSibling).removeClass("active");
    }
});

$( document ).ready(function() {
    setTimeout(function(){
        $(".input").trigger("change");
    }, 1000 );
});
*/
// In your Javascript (external .js resource or <script> tag)
function initializeControls(){
    $('.table').DataTable().destroy();
    initSingleSelect();
    initMultiSelect();
    initPanelMenu();
    initDataTables();
}

function initPanelMenu(){
    $('.panel-menu > li').click(function(e){
        
        var li = $(this);
        li.siblings().removeClass('active');
        li.addClass('active');
        
        var panels = $(e.target.parentElement).siblings('.panel-tab');
        panels.removeClass('active');
        
        var target = li.data('target');
        $("#"+target).addClass('active');
        
        
    });
}

function initSingleSelect(width = '155px'){
    $('.select-single').select2({
        width: width
    });
}

function initMultiSelect(placeholder = 'Selecciona'){
    $(".select-multiple").select2({
        placeholder: placeholder,
        allowClear: true,
        width: '100%'
    });
}

function initDataTables(){
    $('.table').DataTable({
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
            "lengthMenu": "Mostrar _MENU_ registros"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        "aaSorting": [],
        columnDefs: [ { orderable: false, targets: 'not-sort' } ],
        paging: true,
        searching: true,
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip({container:'body', trigger: 'hover'});
        }
    });
}

function openModule(url){
    $.ajax({
        url : url,
        type : 'GET',
        success : function(data) {
            $("#div_main_content").html(data.html);
        }
    });
}

//Construye un DataTable
function buildDataTable(id, page = true, search = true){
    $('#'+id).DataTable({
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
            "lengthMenu": "Mostrar _MENU_ registros"
        },
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
        "aaSorting": [],
        columnDefs: [ { orderable: false, targets: 'not-sort' } ],
        paging: page,
        searching: search,
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip({container:'body', trigger: 'hover'});
        },
        /*fixedHeader: {
            headerOffset: $('#top_contain').outerHeight()
        },
        scrollY: 250,
        scrollX: 500,
        scrollCollapse: true,
        fixedColumns: {
            leftColumns: 2
        },*/
    });
}

//Destruye un DataTable
function destroyDataTable(id){
    var table = $('#'+id).DataTable();
    table.destroy();
}

function openModal(id){
    $("#"+id).fadeIn();
}

function closeModal(id){
    $("#"+id).fadeOut();
}

function fetchModal(url, ...args){
    
    $.ajax({
        url : url,
        type : 'GET',
        data: args,
        dataType: 'JSON',
        success : function(data) {
            var modal = $(data.content);
            $("body").append(modal);
            modal.fadeIn();
        }
    });
}

function removeModal(btn){
    var modal = $(btn.parentElement.parentElement.parentElement.parentElement).fadeOut();
    setTimeout(
        function(){
            modal.remove();
        }, 1000
    );
}

function minimizeModal(btn){
    var width = $('.modal.minimized').width();
    var modal = $(btn.parentElement.parentElement.parentElement.parentElement).addClass('minimized');
    modal.css('margin-left',width+'px');
}

function maximizeModal(btn){
    var modal = $(btn.parentElement.parentElement.parentElement.parentElement).removeClass('minimized');
}

function detailTable(){
    return 'Datos opcionales';
}

function showFlashCard(){
    $('#flash_title').html('COORDINADORA Y DISEÑO EN SOLUCIONES DE COMERCIO EXTERIOR SA DE CV');
    
    var content = 'Nombre Corto: <strong>COORDINADORA</strong><br>RFC: <strong>CDS041216MS3</strong><br>Estatus: <strong>Activo</strong>';
    $('#flash_content').html(content);
    $('#flash_card').css('left', '-5px');
}

function closeFlashCard(){
    $('#flash_card').css('left', '-100%');
}

function showSwiftSearch(){
    $('#swift_search_title').html('BUSQUEDA DE CLIENTES');
    
    $('#swift_search').css('right', '0px');
}

function closeSwiftSearch(){
    $('#swift_search').css('right', '-100%');
}

function asignCustomer(id){
    $("#slt_cutomer_test").val(id).trigger('change');
    closeSwiftSearch();
}

function validateForm(form, url){
    $(".invalid-warning").remove();
    var valid = true;
    for(var i = 0; i < form.length; i++){
        var input = form[i];
        input.value = input.value.trim();
        if (!form[i].checkValidity()) {
            valid = false;
            
            var warning = '<label class="invalid-warning">' + form[i].validationMessage + '</label>';
            var input = $(form[i]).after(warning);
        }
    }
    
    if(valid){
        
        var data = new FormData(form);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            dataType: 'JSON',
            type: 'POST',
            data: data,
            cache : false, 
            contentType : false,
            processData : false,
            success:function(data){
                if(data.result){
                    notifyUser("¡Movimiento correcto!", "Solicitud enviada correctamente", "success");
                } else {
                    if(typeof data.message == 'object'){
                        
                        $.each(data.message, function(name, value){
                            var warning = '<label class="invalid-warning custom">' + value + '</label>';
                            for(var i = 0; i < form.length; i++){
                                if (form[i].name == name) {
                                    var input = $(form[i]).after(warning);
                                }
                            }
                        });
                        
                    } else {
                        alert('caragio!');
                    }
                }
            }
        });
    }
}

initializeControls();
