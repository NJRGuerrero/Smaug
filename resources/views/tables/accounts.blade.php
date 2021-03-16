<table class="table table-stripped table-dataTable" id="tbl_meters">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Balance</th>
            <th>Notas</th>
            <th>Estatus</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
      @php $i = 0; @endphp
      @foreach($accounts as $account)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $account->name }}</td>
            <td>{{ $account->accountType->name }}</td>
            <td>{{ $account->currency->symbol.number_format($account->balance, 2, '.', ',').' '.$account->currency->code }}</td>
            <td>{{ $account->notes }}</td>
            <td class="text-center" data-sort="{{($account->isActive ? 'Habilitado' : 'Deshabilitado')}}">
                <div class="chkDiv chkOnOff" data-toggle="tooltip" title="{{($account->isActive ? 'Habilitado' : 'Deshabilitado')}}">
                    <input type="checkbox" {{($account->isActive ? 'checked' : '')}}
                            onChange="{{($account->isActive ? 'accountDisable('.$account->id.')' : 'accountEnable('.$account->id.')')}}" >
                    <label class="chkIcon"></label>
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-primary btn-xs" onClick="editAccount({{$account->id}})" data-toggle="tooltip" title="Editar">
                    <i class="fas fa-pen"></i>
                </button>
            </td>
        </tr>
      @endforeach
    </tbody>
</table>