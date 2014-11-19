@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Mailing Lists</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Add Email</div>
            <!-- Form Starts -->
            {{ Form::open(array('url' => 'AddToMailingList')) }}
            <div class="row">
                <div class="col-lg-4">
                    <p class="help-block">Select the list</p>
                    {{ Form::select('mlist', $mlists, 'No Group to
                    Delete', array('class' => 'form-control')) }}
                </div>
                <div class="col-lg-4">
                    <p class="help-block">Select the group</p>
                    {{ Form::select('gname', $groups, 'No Group to
                    Delete', array('class' => 'form-control')) }}
                </div>
            </div>
            <div class="row">
                <br>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group input-group">
                        <span class="input-group-addon">@</span> {{
                        Form::text('email', NULL, array('class' =>
                        'form-control', 'placeholder' => 'E-Mail' ) ) }}
                    </div>
                </div>
                <div class="col-lg-4">{{ Form::submit('Add Mail',
                    array('class' => 'btn btn-default')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Delete Email</div>
            <!-- Form Starts -->
            {{ Form::open(array('url' => 'getMailsToDelete')) }}
            <div class="row">
                <br>
            </div>
            <div class="row">
                <div class="col-lg-4">{{ Form::select('mlist', $mlists,
                    'No Group to Delete', array('class' =>
                    'form-control')) }}</div>
                <div class="col-lg-4">{{ Form::select('gname', $groups,
                    'No Group to Delete', array('class' =>
                    'form-control')) }}</div>
                <div class="col-lg-4">{{ Form::submit('Get list',
                    array('class' => 'btn btn-default')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>

    @yield('showMails')

    <!-- To Display if group was added -->
    @if(isset($data['added']) and $data['added'])
    <div class="alert alert-success col-lg-9">E-Mail {{ $data['email']
        }} was added Successfully to Group {{ $data['gname'] }}</div>
    @elseif(isset($data['added']) and ! $data['added'])
    <div class="alert alert-danger col-lg-9">@if(! $data['empty'])
        E-Mail {{ $data['email'] }} Already Exists @else Invalid Group
        Name @endif</div>
    @endif

    <!-- To Display if Emails were was added -->
    @if(isset($data['deleted']) and $data['deleted'])
    <div class="alert alert-success col-lg-9">E-Mails deleted
        Successfully</div>
    @elseif(isset($data['deleted']) and ! $data['deleted'])
    <div class="alert alert-danger col-lg-9">No E-Mails were
        Selected/Exists</div>
    @endif
</div>
@stop
