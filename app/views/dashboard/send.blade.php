@extends('dashboard.sidebar') @section('ckeditor')
<!-- CKEDITOR JavaScript Loading -->
{{HTML::script('ckeditor/ckeditor.js')}} @stop @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Compose New Mail</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">Mail Content</div>
            <!-- Form Starts -->
            {{ Form::open(array('url' => 'sendMail')) }}
            <div class="row">
                <div class="col-lg-6">{{ Form::text('subject', NULL,
                    array('class' => 'form-control top-buffer',
                    'placeholder' => 'Subject') ) }}</div>
                <div class="checkbox">
                    {{ '<label>' }} {{ Form::checkbox('ccAdmin',
                        'admin-placement@iiitd.ac.in', NULL,
                        array('class' => 'checkbox-inline top-buffer',
                        'placeholder' => 'Subject') ) }}{{ 'cc Admin</label>'
                    }}
                </div>
                <div class="checkbox">
                    {{ '<label>' }} {{ Form::checkbox('ccAdmin',
                        'scp@iiitd.ac.in', NULL, array('class' =>
                        'checkbox-inline top-buffer', 'placeholder' =>
                        'Subject') ) }}{{ 'cc SCP</label>' }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    {{ Form::textarea('editor', NULL, array( 'id' =>
                    'content', 'class' => 'form-control top-buffer') )
                    }}
                    <script type="text/javascript">CKEDITOR.replace( 'content' ); </script>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 top-buffer">{{ Form::submit('Send',
                    array('class' => 'btn btn-primary ')) }}</div>
            </div>
            {{ Form::close() }}
            <!--  -->
        </div>
    </div>
</div>
@stop
