@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Manage Attachments</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Update attachment</div>
            <!-- Form starts add group-->
            {{ Form::open( array( 'url' => 'saveAttachments', 'files' => 'true' )) }}
            <div class="row">
                <div class="col-lg-3">
                {{ Form::select('type', $attachmentList,
                    NULL, array('class' => 'form-control col-lg-4 top-buffer')) }}
                </div>
                <div class="col-lg-4">
                    {{ Form::file('file', array('class' => 'btn btn-outline btn-success top-buffer')) }}
                </div>
                <div class="col-lg-3 col-lg-offset-1">{{ Form::submit('Update',
                    array('class' => 'btn btn-default top-buffer')) }}</div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

</div>
@stop
