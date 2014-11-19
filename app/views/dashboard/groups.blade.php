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
                    array('class' => 'form-control', 'placeholder' =>
                    'Enter Group name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::text('hr_name', NULL,
                    array('class' => 'form-control', 'placeholder' =>
                    'Enter HR name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::text('company', NULL,
                    array('class' => 'form-control', 'placeholder' =>
                    'Enter Company name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::submit('Add Group',
                    array('class' => 'btn btn-default')) }}</div>
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
                <div class="col-lg-3">{{ Form::select('gname', $groups,
                    'No Group to Delete', array('class' =>
                    'form-control')) }}</div>
                <div class="col-lg-3">{{ Form::submit('Delete Group',
                    array('class' => 'btn btn-default')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Update Group</div>
            <!-- Form starts update group name -->
            {{ Form::open(array('url' => 'updateGroup')) }}
            <div class="row">
                <div class="col-lg-3">{{ Form::text('toUpdate', NULL,
                    array('class' => 'form-control', 'placeholder' =>
                    'Enter Group name' ) ) }}</div>
                <div class="col-lg-3">{{ Form::select('gname', $groups,
                    'No Group to Delete', array('class' =>
                    'form-control')) }}</div>
                <div class="col-lg-3">{{ Form::submit('Update Group',
                    array('class' => 'btn btn-default')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    <!-- --  {{ Helper::arrayPrettyPrint($groups, 0) }} <!-- -->

    <!-- To Display if group was added -->
    @if(isset($data['added']) and $data['added'])
    <div class="alert alert-success">Group {{ $data['gname'] }} Added
        Successfully</div>
    @elseif(isset($data['added']) and ! $data['added'])
    <div class="alert alert-success">Group {{ $data['gname'] }} Already
        Exists</div>
    @endif

    <!-- To Display if group was deleted -->
    @if(isset($data['deleted']) and $data['deleted'])
    <div class="alert alert-success">Group {{ $data['gname'] }} Deleted
        Successfully</div>
    @elseif(isset($data['deleted']) and ! $data['deleted'])
    <div class="alert alert-success">Group {{ $data['gname'] }} Doesn't
        Exists</div>
    @endif

    <!-- To Display if group was Updated -->
    @if(isset($data['updated']) and $data['updated'])
    <div class="alert alert-success">Group {{ $data['gname'] }} Updated
        to {{ $data['toUpdate'] }}</div>
    @endif
    
    <!-- To Display Error Messages -->
    @if(isset($validator))
        @foreach ($validator->messages->all() as $message)
            {{ '<p>$message</p>' }}
        @endforeach
    @endif
</div>
@stop
