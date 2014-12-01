@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    @if($added) {{ 'Welcome New User' }}
    @endif
    {{-- var_dump( Auth::user() ) --}}
</div>
@stop
