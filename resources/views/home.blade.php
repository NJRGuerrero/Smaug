@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ul class="nav nav-tabs tabs-border">
                <li class="active"><a href="#div_main" data-toggle="tab">General</a></li>
                <li><a href="#div_accounts" onClick="searchAccounts()">Mis Cuentas</a></li>
                <li><a href="#div_movements" data-toggle="tab">Planeación de movimientos</a></li>
                <li><a href="#div_transactions" data-toggle="tab">Confirmar Transacciones</a></li>
                <li><a href="#div_reports" data-toggle="tab">Reportes</a></li>
            </ul>
            <div class="panel tab-content">
                <div role="tabpanel" class="tab-pane active" id="div_main">
                    <div class="panel-heading">General</div>

                    <div class="panel-body">
                        <h6>General</h6>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="div_accounts">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-success pull-right btn-sm" onClick="newAccount()">
                            <i class="fas fa-plus-square"></i>
                            Nueva Cuenta
                        </button>
                    </div>
                    <br>
                    <div class="panel-body">
                        <div id="div_accounts_table"></div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="div_movements">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-success pull-right btn-sm" onClick="openModal('mdl_movements')">
                            <i class="fas fa-plus-square"></i>
                            Nuevo Movimiento
                        </button>
                    </div>
                    <br>
                    <div class="panel-body">
                        <table id="tbl_movements" class="table text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Detalle</th>
                                    <th>Notas</th>
                                    <th>Estatus</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody id="tbdy_movements">
                                <tr>
                                    <td>1</td>
                                    <td>Pago de Nomina</td>
                                    <td><i class="fas fa-arrow-circle-down text-success"></i></td>
                                    <td>$8,500.00 MXN</td>
                                    <td>
                                        <button class="btn-xinfo fas fa-question-circle text-info">
                                            <span class="info-text">
                                                <ul class="ul-simple text-left">
                                                    <li><strong>Periodo:</strong> Quincenal</li>
                                                    <li><strong>Inicia:</strong> 2018/08/30</li>
                                                    <li><strong>Eventos:</strong> Indefinido</li>
                                                </ul>
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        Ajustar al monto real cada quincena
                                    </td>
                                    <td>
                                        <div class="chkDiv chkOnOff">
                                            <input type="checkbox" checked>
                                            <label class="chkIcon"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Plan Telcel</td>
                                    <td><i class="fas fa-arrow-circle-up text-danger"></i></td>
                                    <td>$349.00 MXN</td>
                                    <td>
                                        <button class="btn-xinfo fas fa-question-circle text-info">
                                            <span class="info-text">
                                                <ul class="ul-simple text-left">
                                                    <li><strong>Periodo:</strong> Mensual</li>
                                                    <li><strong>Inicia:</strong> 2019/11/30</li>
                                                    <li><strong>Eventos:</strong> 15</li>
                                                </ul>
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        Considerar Marzo 2020 para subir de plan
                                    </td>
                                    <td>
                                        <div class="chkDiv chkOnOff">
                                            <input type="checkbox" checked>
                                            <label class="chkIcon"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Ahorro</td>
                                    <td><i class="fas fa-exchange-alt text-primary"></i></td>
                                    <td>$2,500.00 MXN</td>
                                    <td>
                                        <button class="btn-xinfo fas fa-question-circle text-info">
                                            <span class="info-text">
                                                <ul class="ul-simple text-left">
                                                    <li><strong>Periodo:</strong> Quincenal</li>
                                                    <li><strong>Inicia:</strong> 2019/11/30</li>
                                                    <li><strong>Eventos:</strong> Indefinido</li>
                                                    <li><strong>Cuenta origen:</strong> Nomina Banamex</li>
                                                    <li><strong>Cuenta destino:</strong> Ahorro HSBC</li>
                                                </ul>
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        QUITAR APLICACIONES LIGADAS A ESTA CUENTA
                                    </td>
                                    <td>
                                        <div class="chkDiv chkOnOff">
                                            <input type="checkbox">
                                            <label class="chkIcon"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Pago Titulo</td>
                                    <td><i class="fas fa-arrow-circle-up text-danger"></i></td>
                                    <td>$10,000.00 MXN</td>
                                    <td>
                                        <button class="btn-xinfo fas fa-question-circle text-info">
                                            <span class="info-text">
                                                <ul class="ul-simple text-left">
                                                    <li><strong>Pago único</strong></li>
                                                    <li><strong>Fecha:</strong> 2019/10/15</li>
                                                </ul>
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        Monto aproximado
                                    </td>
                                    <td>
                                        <div class="chkDiv chkOnOff">
                                            <input type="checkbox" checked>
                                            <label class="chkIcon"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="div_transactions">
                    <div class="panel-heading">
                        <button type="button" class="btn btn-success pull-right btn-sm" onClick="openModal('mdl_transactions')">
                            <i class="fas fa-plus-square"></i>
                            Nueva Transacción
                        </button>
                    </div>
                    <br>
                    <div class="panel-body">
                        <table id="tbl_transaction" class="table text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Movimiento</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Fecha</th>
                                    <th>Ejecutar</th>
                                </tr>
                            </thead>
                            <tbody id="tbdy_transactions">
                                <tr>
                                    <td>1</td>
                                    <td>
                                        Pago de Nomina
                                        <button class="btn-xinfo fas fa-question-circle text-info">
                                            <span class="info-text">
                                                <ul class="ul-simple text-left">
                                                    <li><strong>Periodo: </strong> Quincenal</li>
                                                    <li><strong>Próximo movimiento: </strong> $7,500.00</li>
                                                    <li><strong>Notas: </strong> Ajustar al monto real cada quincena</li>
                                                </ul>
                                            </span>
                                        </button>
                                    </td>
                                    <td><i class="fas fa-arrow-circle-down text-success with-info"><span class="info-float info-mr">Ingreso</span></i></td>
                                    <td>$8,500.00 MXN</td>
                                    <td>2019/07/31</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Plan Telcel</td>
                                    <td><i class="fas fa-arrow-circle-up text-danger with-info"><span class="info-float info-mr">Pago</span></i></td>
                                    <td>$349.00 MXN</td>
                                    <td>2019/08/01</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Ahorro</td>
                                    <td><i class="fas fa-exchange-alt text-primary with-info"><span class="info-float info-mr">Transferencia</span></i></td>
                                    <td>$2,500.00 MXN</td>
                                    <td>2019/08/01</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Pago Titulo</td>
                                    <td><i class="fas fa-arrow-circle-up text-danger with-info"><span class="info-float info-mr">Pago</span></i></td>
                                    <td>$10,000.00 MXN</td>
                                    <td>2019/10/24</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs" onClick="openModal('mdl_account')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="div_reports">
                    <div class="panel-heading">Reportes</div>

                    <div class="panel-body">
                        <h6>Reportes</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODALES -->
<div class="modal" id="mdl_account">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="cursor:pointer !important;" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- SUBTITULO -->
                <div class="mb40">
                    <center>
                        <span class="h4 text-golden">EDICIÓN DE CUENTA</span>
                    </center>
                </div>
            </div>
            <div class="modal-body justify-content-center small admin-form theme-primary">
                <div class="panel-body panel" style="background:#fcfcfc !important;">
                    <form id="frm_account" novalidate>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="section row">
                            <div class="col-sm-3">
                                <label class="field">
                                    <input id="txt_account_name" type="text" name="name" required>
                                    <label for="txt_account_name">Nombre</label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_account_type" name="accountTypeId" required>
                                        <option></option>
                                        <option>Nomina</option>
                                        <option>Ahorro</option>
                                        <option>Efectivo</option>
                                        <option>Inversión</option>
                                        <option>Crédito</option>
                                        <option>Otro</option>
                                    </select>
                                    <label>Tipo de cuenta</label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_account_currency" name="currencyId" required>
                                        <option></option>
                                        <option value="1">Peso Mexicano (MXN)</option>
                                        <option value="2">Dolar Americano (USD)</option>
                                        <option value="3">Euro (EUR)</option>
                                    </select>
                                    <label>Moneda</label>
                                </label>
                            </div>
                            <div class="col-sm-3 test" class="" >
                                <label class="field">
                                    <input id="num_account_balance" type="number" name="balance" value="" required>
                                    <label for="num_account_balance">Saldo</label>
                                </label>
                            </div>
                        </div>
                        <div class="section row">                                    
                            <div class="col-sm-12">
                                <label class="field">
                                    <textarea id="txta_account_notes" name="notes" required style="resize:none"></textarea>
                                    <label for="txta_account_notes">Notas</label>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success pull-right btn-sm">
                            <i class="fas fa-check"></i>
                            Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdl_movements">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="cursor:pointer !important;" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- SUBTITULO -->
                <div class="mb40">
                    <center>
                        <span class="h4 text-golden">EDICIÓN DE MOVIMIENTO</span>
                    </center>
                </div>
            </div>
            <div class="modal-body justify-content-center small admin-form theme-primary">
                <div class="panel-body panel" style="background:#fcfcfc !important;">
                    <form id="frm_account">
                        <div class="section-divider text-golden">
                            <span>General</span>
                        </div>
                        <div class="section row">
                            <div class="col-sm-12">
                                <label class="field">
                                    <input id="txt_movement_name" type="text" name="name" required>
                                    <label for="txt_movement_name">Nombre</label>
                                    <label class="invalid-warning">Favor de ingresar un nombre</label>
                                </label>
                            </div>
                        </div>
                        <div class="section row">
                            <div class="col-sm-3">
                                <label class="field">
                                    <input id="num_movement_amount" type="number" name="amount" min="1" step="any" required>
                                    <label for="num_movement_amount">Monto</label>
                                    <label class="invalid-warning">Favor de ingresar un monto mayor a 0</label>
                                </label>
                                <label class="field">
                                    <select id="slt_movement_currency" required>
                                        <option></option>
                                        <option>MXN</option>
                                        <option>USD</option>
                                        <option>EUR</option>
                                    </select>
                                    <label>Moneda</label>
                                    <label class="invalid-warning">Favor de elegir una moneda</label>
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <label class="field">
                                    <textarea id="txta_movement_notes" class="no-resize" name="notes" rows="4"></textarea>
                                    <label for="txta_movement_notes">Notas</label>
                                </label>
                            </div>
                        </div>
                        <div class="section-divider text-golden">
                            <span>Detalles de Movimiento</span>
                        </div>
                        <div class="section row">
                            <div class="col-sm-6 text-center">
                                <label class="field" style="width: unset;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="rad_movement_entry" onchange="$('#slt_movement_originAccount').prop('disabled', true);$('#slt_movement_targetAccount').prop('disabled', false);">
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_movement_entry">
                                        <i class="fas fa-arrow-circle-down text-success"></i> Ingreso
                                    </label>
                                </label>
                                <label class="field" style="width: unset;margin-left: 25px;margin-right: 25px;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="rad_movement_exit" onchange="$('#slt_movement_originAccount').prop('disabled', false);$('#slt_movement_targetAccount').prop('disabled', true);">
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_movement_exit">
                                        <i class="fas fa-arrow-circle-up text-danger"></i> Gasto
                                    </label>
                                </label>
                                <label class="field" style="width: unset;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="rad_movement_transfer" onchange="$('#slt_movement_originAccount, #slt_movement_targetAccount').prop('disabled', false);" checked>
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_movement_transfer">
                                        <i class="fas fa-exchange-alt text-primary"></i> Transferencia
                                    </label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_movement_originAccount" name="originAccount">
                                        <option></option>
                                        <option>Banamex Nomina</option>
                                        <option>HSBC Ahorro</option>
                                        <option>Banamex Inversión</option>
                                        <option>Cartera efectivo</option>
                                    </select>
                                    <label for="slt_movement_originAccount">Cuenta de Origen</label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_movement_targetAccount" name="targetAccount">
                                        <option></option>
                                        <option>Banamex Nomina</option>
                                        <option>HSBC Ahorro</option>
                                        <option>Banamex Inversión</option>
                                        <option>Cartera efectivo</option>
                                    </select>
                                    <label for="slt_movement_targetAccount">Cuenta Destino</label>
                                </label>
                            </div>
                        </div>
                        <div class="section-divider text-golden">
                            <span>Fechas</span>
                        </div>
                        <div class="section row">
                            <div class="col-sm-3">
                                <label class="field">
                                    <input id="dte_movement_startDate" type="date" name="startDate" onChange="calcFinalDate()">
                                    <label for="dte_movement_startDate" id="lbl_movement_startDate">Fecha</label>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <label class="field">
                                    <label>Evento multiple</label>
                                    <div class="chkDiv chkGoodBad">
                                        <input type="checkbox" onChange="validateMultiple(this.checked);" id="chk_movement_multiple" name="multiple">
                                        <label class="chkIcon"></label>
                                    </div>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <label class="field">
                                    <select id="slt_movement_period" name="period" onChange="calcFinalDate()">
                                        <option value="1-d">Diario</option>
                                        <option value="7-d">Semanal</option>
                                        <option value="15-d">Quincenal</option>
                                        <option value="1-m">Mensual</option>
                                        <option value="2-m">Bimestral</option>
                                        <option value="3-m">Trimestral</option>
                                        <option value="4-m">Cuatrimestral</option>
                                        <option value="6-m">Semenstral</option>
                                        <option value="1-y">Anual</option>
                                    </select>
                                    <label>Periodo</label>
                                </label>
                            </div>
                            <div class="col-sm-2">
                                <label class="field">
                                    <input id="num_movement_repetitions" type="number" name="repetitions" onChange="calcFinalDate()">
                                    <label for="num_movement_repetitions"># Eventos</label>
                                </label>
                            </div>
                            <div class="col-sm-3 test" class="" >
                                <label class="field">
                                    <input id="dte_movement_endDate" type="date" disabled>
                                    <label for="dte_movement_endDate">Fecha final</label>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success pull-right btn-sm">
                            <i class="fas fa-check"></i>
                            Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="mdl_transactions">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="cursor:pointer !important;" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <!-- SUBTITULO -->
                <div class="mb40">
                    <center>
                        <span class="h4 text-golden">TRANSACCIÓN NO PLANEADA</span>
                    </center>
                </div>
            </div>
            <div class="modal-body justify-content-center small admin-form theme-primary">
                <div class="panel-body panel" style="background:#fcfcfc !important;">
                    <form id="frm_account" novalidate onSubmit="testFunction(this);return false;">
                        <div class="section-divider text-golden">
                            <span>General</span>
                        </div>
                        <div class="section row">
                            <div class="col-sm-12">
                                <label class="field">
                                    <input id="txt_transaction_name" type="text" name="name" required>
                                    <label for="txt_transaction_name">Nombre</label>
                                    <label class="invalid-warning">Favor de ingresar un nombre</label>
                                </label>
                            </div>
                        </div>
                        <div class="section row">
                            <div class="col-sm-3">
                                <label class="field">
                                    <input id="num_transaction_amount" type="number" name="amount" min="1" step="any" required>
                                    <label for="num_transaction_amount">Monto</label>
                                    <label class="invalid-warning">Favor de ingresar un monto mayor a 0</label>
                                </label>
                                <label class="field">
                                    <select id="slttransaction_currency" required>
                                        <option></option>
                                        <option>MXN</option>
                                        <option>USD</option>
                                        <option>EUR</option>
                                    </select>
                                    <label>Moneda</label>
                                    <label class="invalid-warning">Favor de elegir una moneda</label>
                                </label>
                            </div>
                            <div class="col-sm-9">
                                <label class="field">
                                    <textarea id="txta_transaction_notes" class="no-resize" name="notes" rows="4"></textarea>
                                    <label for="txta_transaction_notes">Notas</label>
                                </label>
                            </div>
                        </div>
                        <div class="section-divider text-golden">
                            <span>Detalles de Movimiento</span>
                        </div>
                        <div class="section row">
                            <div class="col-sm-6 text-center">
                                <label class="field" style="width: unset;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="rad_transaction_entry" onchange="$('#slt_transaction_originAccount').val('').trigger('change').prop('disabled', true);$('#slt_transaction_targetAccount').prop('disabled', false);">
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_transaction_entry">
                                        <i class="fas fa-arrow-circle-down text-success"></i> Ingreso
                                    </label>
                                </label>
                                <label class="field" style="width: unset;margin-left: 25px;margin-right: 25px;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="radtransaction_exit" onchange="$('#slt_transaction_originAccount').prop('disabled', false);$('#slt_transaction_targetAccount').val('').trigger('change').prop('disabled', true);">
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_transaction_exit">
                                        <i class="fas fa-arrow-circle-up text-danger"></i> Gasto
                                    </label>
                                </label>
                                <label class="field" style="width: unset;">
                                    <div class="radDiv">
                                        <input type="radio" name="type" id="radtransaction_transfer" onchange="$('#slt_transaction_originAccount, #slt_transaction_targetAccount').prop('disabled', false);" checked>
                                        <label class="chkIcon active"></label>
                                    </div>
                                    <br>
                                    <label for="rad_transaction_transfer">
                                        <i class="fas fa-exchange-alt text-primary"></i> Transferencia
                                    </label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_transaction_originAccount" name="originAccount" required>
                                        <option></option>
                                        <option>Banamex Nomina</option>
                                        <option>HSBC Ahorro</option>
                                        <option>Banamex Inversión</option>
                                        <option>Cartera efectivo</option>
                                    </select>
                                    <label for="slt_transaction_originAccount">Cuenta de Origen</label>
                                    <label class="invalid-warning">Favor de seleccionar una opción</label>
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="field">
                                    <select id="slt_transaction_targetAccount" name="targetAccount" required>
                                        <option></option>
                                        <option>Banamex Nomina</option>
                                        <option>HSBC Ahorro</option>
                                        <option>Banamex Inversión</option>
                                        <option>Cartera efectivo</option>
                                    </select>
                                    <label for="slt_transaction_targetAccount">Cuenta Destino</label>
                                    <label class="invalid-warning">Favor de seleccionar una opción</label>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success pull-right btn-sm">
                            <i class="fas fa-check"></i>
                            Guardar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
