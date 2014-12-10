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
            <!-- Form starts add group-->
            <div class="row">
                {{ Form::open(array('url' => 'addNewGroup')) }}
                <div class="col-lg-3">{{ Form::text('gname', NULL,
                    array('class' => 'form-control top-buffer',
                    'placeholder' => 'Enter Group name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::text('hr_name', NULL,
                    array('class' => 'form-control top-buffer',
                    'placeholder' => 'Enter HR name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::text('company', NULL,
                    array('class' => 'form-control top-buffer',
                    'placeholder' => 'Enter Company name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::submit('Add Group',
                    array('class' => 'btn btn-default top-buffer')) }}</div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Delete Group</div>
            <!-- Form starts delete group -->
            {{ Form::open(array('url' => 'deleteGroup')) }}
            <div class="row">
                <div class="col-lg-3">
                {{ Form::select('gname', $groups, 'No Group to Delete', array(
                'class' => 'form-control top-buffer')) }}</div>
                <div class="col-lg-3">
                {{ Form::submit('Delete Group', array(
                'class' => 'btn btn-danger top-buffer')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Update Group Details</div>
            <!-- Form starts update group details -->
                {{ Form::open(array('url' => 'updateGroup')) }}
                <div class="row">
                    <div class="col-lg-4">
                        {{ Form::text('ugname', NULL, array(
                        'class' => 'form-control top-buffer',
                        'placeholder' => 'Enter Group name' ) ) }}</div>
                    <div class="col-lg-4">
                        {{ Form::text('HR', NULL, array(
                        'class' => 'form-control top-buffer',
                        'placeholder' => 'Enter HR name' ) ) }}</div>
                    <div class="col-lg-4">
                        {{ Form::text('COMPANY', NULL, array(
                        'class' => 'form-control top-buffer',
                        'placeholder' => 'Enter Company name' ) ) }}</div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        {{ Form::select('gname', $groups, 'No Group to Delete', array(
                        'class' => 'form-control top-buffer')) }}</div>
                    <div class="col-lg-4">
                        {{ Form::submit('Update Group', array(
                        'class' => 'btn btn-warning top-buffer' )) }}</div>
                </div>
                {{ Form::close() }}
            <!-- Ends Update group details  -->
        </div>
    </div>

    <!-- To Display messages -->
    @if(isset($data['success']) and $data['success'])
        <div class="alert alert-success col-lg-9">{{ $data['message']  }}</div>
    @elseif(isset($data['success']) and ! $data['success'])
        <div class="alert alert-danger col-lg-9">{{ $data['message'] }}</div>
    @endif

</div>
@stop
