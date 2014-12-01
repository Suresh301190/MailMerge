@extends('dashboard.template') @section('template-header') {{ 'Manage
Templates' }} @stop @section('template-form')
<div id="template-form">
    {{ Form::open(array('url' => 'sendMail')) }}
    <div class="row">
        <div class="col-lg-8">{{ Form::text('subject', NULL,
            array('class' => 'form-control top-buffer', 'placeholder' =>
            'Subject') ) }}</div>
        <div class="checkbox col-lg-4">
            {{ '<label>' }} {{ Form::checkbox('ccAdmin',
                'admin-placement@iiitd.ac.in', NULL, array('class' =>
                'checkbox-inline top-buffer', 'placeholder' =>
                'Subject') ) }}{{ 'cc Admin</label>' }} {{ '<label>' }}
                {{ Form::checkbox('ccAdmin', 'scp@iiitd.ac.in', NULL,
                array('class' => 'checkbox-inline top-buffer',
                'placeholder' => 'Subject') ) }}{{ 'cc SCP</label>' }}
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{ Form::textarea('editor', $content, array( 'id' =>
            'content', 'class' => 'form-control top-buffer') ) }}
            <script type="text/javascript">CKEDITOR.replace( 'content' ); </script>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 top-buffer">{{ Form::submit('Send',
            array('class' => 'btn btn-primary ')) }}</div>
    </div>
    {{ Form::close() }}
</div>
@stop

@section('isModify')
{{ Form::radio('template-modify', '0', true, array('class' => 'hidden')) }}
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
