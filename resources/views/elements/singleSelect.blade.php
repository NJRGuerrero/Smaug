@if(isset($first) && $first)
    <option value="">{{$first}}</option>
@endif

@if(isset($new) && $new)
    <option value="*">{{$new}}</option>
@endif

@if(isset($all) && $all)
    <option value="0">{{$all}}</option>
@endif

@foreach($results as $result)
    @php
    if(isset($value)){
        if(!$value){
            $val = $result->{$text};
        } else {
            $val = $result->{$value};
        }
    } else {
        $val = $result->id;
    }
	
	if(is_array($text)){
		if(isset($textRelation)){
			$txt = $result->{$textRelation}->{$text[0]}.': '.$result->{$textRelation}->{$text[1]};
		} else {
			$txt = $result->{$text[0]}.': '.$result->{$text[1]};
		}
	} else {
		if(isset($textRelation)){
			$txt = $result->{$textRelation}->{$text};
		} else {
			$txt = $result->{$text};
		}
	}
	
	$sel = '';
	if(isset($selected) && $selected == $val){
		$sel = 'selected';
	}
    @endphp
    
    <option value="{{$val}}" {{$sel}}>{{$txt}}</option>
@endforeach