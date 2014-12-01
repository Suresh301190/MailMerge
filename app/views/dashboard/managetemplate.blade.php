@extends('dashboard.template') @section('page-header') {{ 'Manage
Templates' }} @stop @section('template-header') {{ 'Manage Templates' }}
@stop @section('template-form')
<div id="template-form">
    {{ Form::open(array('url' => 'saveTemplate')) }}
    <div class="row">
        <div class="col-lg-6">{{ Form::select('TID', array('useage' =>
            'Select Template from the list to save the content',
            'invite' => ' Invite Template', 'follow' => 'Follow Up
            Template', 'confirm' => ' Confirmation Template', 'custom1'
            => ' custom1 Template', 'custom2' => ' custom2 Template' ),
            NULL, array('class' => 'form-control top-buffer')) }}</div>

        <!-- To Display Template status -->
        <div class="col-lg-6">
            @if(isset($success) && $success)
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">×</button>
                Template {{ $type }} Successfully Updated
            </div>
            @elseif(isset($success) && !$success)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">×</button>
                Select a Template to Save
            </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{ Form::textarea('editor', $content, array( 'id' =>
            'content', 'class' => 'form-control top-buffer', 'name' =>
            'content') ) }}
            <script type="text/javascript">CKEDITOR.replace( 'content', {height: 350} ); </script>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 top-buffer">{{ Form::submit('Save',
            array('class' => 'btn btn-primary ')) }}</div>
    </div>
    {{ Form::close() }}
</div>
@stop @section('isModify') {{ Form::radio('template-modify', '1', true,
array('class' => 'hidden')) }} @stop @section('invite') {{
Form::radio('TID', 'invite', true, array('class' => 'hidden')) }} @stop
@section('follow') {{ Form::radio('TID', 'follow', true, array('class'
=> 'hidden')) }} @stop @section('confirm') {{ Form::radio('TID',
'confirm', true, array('class' => 'hidden')) }} @stop
@section('custom1') {{ Form::radio('TID', 'custom1', true, array('class'
=> 'hidden')) }} @stop @section('custom2') {{ Form::radio('TID',
'custom2', true, array('class' => 'hidden')) }} @stop @section('status')
@stop
