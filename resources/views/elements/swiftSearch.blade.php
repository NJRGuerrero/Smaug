<thead>
    <tr>
        <th>Agregar</th>
        @foreach($params->fields as $field)
        <th>{{$field->name}}</th>
        @endforeach
    </tr>
</thead>
<tbody>
@foreach($items as $item)
    <tr data-itemid="{{$item->id}}" data-itemtype="{{$itemType}}">
        <td>
            <button class="btn btn-icon btn-success" onClick="{{$func}}({{$item->id}}, this)"><span class="fas fa-plus"></span></button>
        </td>
        @foreach($params->fields as $field)
        <td>
            @if(!property_exists($field, 'relation'))
				@if(!is_null($item->{$field->field}))
					{{ $item->{$field->field} }}
				@endif
			@else
				@if(!is_null($item->{$field->relation}->{$field->field}))
					{{ $item->{$field->relation}->{$field->field} }}
				@endif	
            @endif
        </td>
        @endforeach
    </tr>
@endforeach
</tbody>