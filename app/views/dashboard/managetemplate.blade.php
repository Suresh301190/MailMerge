@extends('dashboard.template') @section('template-header') {{ 'Manage
Templates' }} @stop @section('template-form')
<div id="template-form">
    {{ Form::open(array('url' => 'sendMail')) }}
    <div class="row">
        <div class="col-lg-4">{{ Form::select('TID', array('invite' =>
            'Select Invite Template', 'followUp' => 'Follow Up
            Template', 'confirm' => 'Select Confirmation Template',
            'custom1' => 'Select custom1 Template', 'custom2' => 'Select
            custom2 Template' ), NULL, array('class' => 'form-control
            top-buffer')) }}</div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{ Form::textarea('editor', $content, array( 'id' =>
            'content', 'class' => 'form-control top-buffer', 'height' => '600px') ) }}
            <script type="text/javascript">CKEDITOR.replace( 'content' ); </script>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 top-buffer">{{ Form::submit('Save',
            array('class' => 'btn btn-primary ')) }}</div>
    </div>
    {{ Form::close() }}
</div>
@stop

@section('isModify')
{{ Form::radio('template-modify', '1', true, array('class' => 'hidden')) }}
@stop

@section('invite')
{{ Form::radio('invite', 'invite', true, array('class' => 'hidden')) }}
@stop

@section('follow')
{{ Form::radio('follow', 'follow', true, array('class' => 'hidden')) }}
@stop

@section('confirm')
{{ Form::radio('confirm', 'confirm', true, array('class' => 'hidden')) }}
@stop

@section('custom')
{{ Form::radio('custom1', 'custom1', true, array('class' => 'hidden')) }}
@stop

@section('custom2')
{{ Form::radio('custom2', 'custom2', true, array('class' => 'hidden')) }}
@stop
