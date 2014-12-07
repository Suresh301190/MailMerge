@extends('dashboard.rightbar')

@section('page-header')
{{ 'Compose New Mail' }}
@stop

@section('template-header')
{{ 'Manage Templates' }}
@stop

@section('template-form')
<div id="template-form">
    {{ Form::open(array('url' => 'sendMail', 'files' => 'true')) }}
    <div class="row col-lg-12">
        <div class="col-lg-6">
            <div class="row">
                {{ Form::text('subject', NULL, array(
                'class' => 'form-control top-buffer',
                'placeholder' => 'Subject') ) }}
            </div>
            <div class="row top-buffer">
                <label class="checkbox-inline">
                    <input name="ccAdmin" type="checkbox" value="{{{ 'admin-placement@iiitd.ac.in' }}}">
                    CC Admin</label>
                <label class="checkbox-inline">
                    <input name="ccSCP" type="checkbox" value="{{{ 'admin-placement@iiitd.ac.in' }}}">
                    CC SCP</label>
            </div>
            <div class="row top-buffer">
                @foreach(Template::getReplaceArray() as $v)
                    <label class="checkbox-inline">
                        <input name="contains[]" type="checkbox" value="{{{ $v }}}" checked>Contains {{ $v }} ?
                    </label>
                @endforeach
            </div>
        </div>
        <div class="col-lg-6">
            @if(isset($success) && $success)
                <div class="alert alert-success alert-dismissable top-buffer">
                    <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">x</button>
                    {{ $message }}
                </div>
            @elseif(isset($success) && !$success)
                <div class="alert alert-danger alert-dismissable top-buffer">
                    <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">x</button>
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            {{ Form::textarea('editor', $content, array(
            'id' => 'content',
            'class' => 'form-control top-buffer' ,
            'name' =>  'content') ) }}
            <script type="text/javascript">CKEDITOR.replace( 'content', {height: 350} ); </script>
        </div>
    </div>
    <div class="row">
        <label class="help-block col-lg-3">Select Attachments</label>
    </div>
    <div class="row">
        <div class="form-group col-lg-12">
            @foreach($attachmentList as $k => $v )
                <div class="col-lg-3">
                    <label class="checkbox-inline">
                        <input name="{{{ $k }}}" type="checkbox" value="{{{ $v }}}">
                        {{ $v }}</label>
                </div>
            @endforeach
        </div>
        <div class="form-group col-lg-12">
            @for($i = 0; $i < 2; $i++ )
                <div class="row">
                    @for($j = 0; $j < 2; $j++)
                        <div class="col-lg-4 <?php if($j == 1) echo 'col-lg-offset-1' ?> " style="margin-bottom: 5px">
                            {{ Form::file('attachments[]', array('class' => 'btn btn-outline btn-sm btn-success')) }}
                        </div>
                    @endfor
                </div>
            @endfor
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 top-buffer">
            {{ Form::submit('Send', array('class' => 'btn btn-primary ')) }}
        </div>
        <!-- Add the Send Mail Checkboxes -->
        <div class="col-lg-8">
            @foreach(Group::getStatesArray() as $status)
                <div class="col-lg-4 form-group top-buffer">
                    <label class="help-block">{{ $status }}</label>
                    <div class="checkbox">
                        <label>
                            <input name="{{{ $status }}}[]" type="checkbox" value="all">
                            all</label>
                    </div>
                    @foreach($groupsByStatus[$status] as $group)
                        <div class="checkbox">
                            <label>
                            <input name="{{{ $status }}}[]" type="checkbox" value="{{{ $group }}}">
                            {{ $group }}</label>
                        </div>
                @endforeach
                </div>
            @endforeach
        </div>
    </div>
    {{ Form::close() }}
</div>

@if(isset($data))
{{-- Helper::arrayPrettyPrint($data, 0) --}}
@endif

@stop

@section('isModify')
{{ Form::radio('template-modify', '0', true, array('class' => 'hidden')) }}
@stop
