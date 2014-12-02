@extends('dashboard.rightbar') @section('page-header') {{ 'Compose New
Mail' }} @stop @section('template-header') {{ 'Manage Templates' }}
@stop @section('template-form')
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
            'content', 'class' => 'form-control top-buffer' , 'name' =>
            'content') ) }}
            <script type="text/javascript">CKEDITOR.replace( 'content', {height: 350} ); </script>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 top-buffer">{{ Form::submit('Send',
            array('class' => 'btn btn-primary ')) }}</div>
        @foreach(Group::getStatesArray() as $status)
            {{ '<div class="col-lg-3 form-group">' }}
            @foreach($groupsByStatus[$status] as $group)
                {{ '<div class="checkbox"><label>' }}
                <input type="checkbox" value="{{{ $group }}}">{{ $group }}
                {{ '</label></div>' }}
            @endforeach
            {{ '</div>' }}
        @endforeach
    </div>
    <!-- Add the Send Mail Checkboxes -->
    <div class="row">
    </div>
    {{ Form::close() }}
</div>
@stop @section('isModify')
{{ Form::radio('template-modify', '0', true, array('class' => 'hidden')) }}
@stop
@section('invite')
{{Form::radio('TID', 'invite', true, array('class' => 'hidden')) }}
@stop
@section('follow')
{{ Form::radio('TID', 'follow', true, array('class'=> 'hidden')) }}
@stop
@section('confirm')
{{ Form::radio('TID','confirm', true, array('class' => 'hidden')) }}
@stop @section('custom')
{{ Form::radio('TID', 'custom1', true, array('class' => 'hidden')) }}
@stop
@section('custom2')
{{ Form::radio('TID', 'custom2', true,array('class' => 'hidden')) }}
@stop
