@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Groups</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Add Group</div>
            <!-- -->
            <div class="row">
                {{ Form::open(array('url' => 'addNewGroup')) }}
                <div class="col-lg-4">{{ Form::text('gname', NULL,
                    array('class' => 'form-control', 'placeholder' =>
                    'Enter Group name' ) ) }}</div>
                <div class="col-lg-4">{{ Form::submit('Add Group',
                    array('class' => 'btn btn-default')) }}</div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Delete Group</div>
            <!-- -->
            {{ Form::open(array('url' => 'deleteGroup')) }}
            <div class="row">
                <div class="col-lg-4">{{ Form::select('gname',
                    Group::getAllGroups(), 'No Group to Delete',
                    array('class' => 'form-control')) }}</div>

                <div class="col-lg-3">{{ Form::submit('Delete Group',
                    array('class' => 'btn btn-default')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    <!--  {{ Helper::arrayPrettyPrint(Group::getAllGroups(), 0) }} -->

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
