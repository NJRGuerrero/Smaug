function searchAccounts(){

    $.ajax({
        url : 'account/search',
        dataType: 'JSON',
        type: 'GET',
        success : function(data) {
            $('#div_accounts_table').html(data.accountsTable);
            buildDataTable('tbl_accounts');
            $('.nav-tabs a[href="#div_accounts"]').tab('show');
        }
    });
}

function newAccount(){
    $.ajax({
        url : 'account/new',
        dataType: 'JSON',
        type: 'GET',
        success : function(data) {
            $('#frm_account')[0].reset();
            $('#frm_account').attr('onSubmit', 'saveAccount(this);return false;');
            $('#hid_account_id, #txta_account_notes').val('');
            
            $('#slt_account_type').html(data.accountTypesSlt).trigger('change', true);
            $('#slt_account_currency').html(data.currenciesSlt).trigger('change', true);
            
            clearValidations();
            $('#mdl_account').modal();
        }
    });
}

function saveAccount(form){
    if(validateForm(form)){
        var data = new FormData(form);
        $.ajax({
            url : 'account/save',
            dataType : 'JSON',
            type : 'POST',
            data : data,
            cache : false,
            contentType : false,
            processData : false,
            success : function(data) {console.log(data);
                if (data.result) {
                    notifyUser('success', '¡Movimiento correcto!', 'Medidor registrado');
                    $('#mdl_meter').modal('hide');
                    meterSearch();
                } else {
                    notifyUser('warning', '<strong>¡Atención!</strong> El movimiento no se realizó.', data.message);
                    backValidation(form, data.validations);
                }
            }
        });
    }
}