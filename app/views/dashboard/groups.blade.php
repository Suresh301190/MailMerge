@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Groups</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Add Group</div>
            <!-- -->
            {{ Form::open(array('url' => 'addNewGroup')) }} {{
            Form::label('glabel', 'Group Name'); }} {{
            Form::text('gname') }} {{ Form::submit('Add Group') }} {{
            Form::close() }}
            <!--  -->
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">Delete Group</div>
            <!-- -->
            {{ Form::open(array('url' => 'deleteGroup')) }} {{
            Form::label('glabel', 'Group Name'); }} {{
            Form::text('gname') }} {{ Form::submit('Delete Group') }} {{
            Form::close() }}
            <!--  -->
        </div>
    </div>
    
    <!-- To Display if group was added -->
    @if(isset($added) and $added)
    <div class="alert alert-success">Group {{ $gname }} Added
        Successfully</div>
    @elseif(isset($added) and ! $added)
    <div class="alert alert-success">Group {{ $gname }} Already Exists</div>
    @endif
    
    <!-- To Display if group was deleted -->
    @if(isset($deleted) and $deleted)
    <div class="alert alert-success">Group {{ $gname }} Deleted
        Successfully</div>
    @elseif(isset($deleted) and ! $deleted)
    <div class="alert alert-success">Group {{ $gname }} Doesn't Exists</div>
    @endif
</div>
@stop
