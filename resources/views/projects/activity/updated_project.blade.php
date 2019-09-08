@if(count($activity->changes['after']) == 1)
    {{$activity->userName()}} updated the {{key($activity->changes['after'])}} of the project
@else
    {{$activity->userName()}} updated the project
@endif
