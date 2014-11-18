@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    {{ Form::open(array('url' => '', 'method' => 'put')) }}
    {{ Form::close() }}
</div>
@stop