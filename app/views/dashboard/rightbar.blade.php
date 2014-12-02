@extends('dashboard.sidebar') @section('ckeditor')
<!-- CKEDITOR JavaScript Loading -->
{{HTML::script('ckeditor/ckeditor.js')}} @stop @section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">@yield('page-header')</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="panel panel-default col-lg-9">
            <div class="panel-heading">@yield('template-header')</div>
            <!-- Form Starts -->
            @yield('template-form')
            <!-- Form closed -->
        </div>
        <div class="col-lg-3 pull-right">
            <div class="row">
                {{ Form::open(array('url' => 'getContent', 'id' =>'invite')) }}
                @yield('isModify')
                {{ Form::radio('TID', 'invite', true, array('class' => 'hidden')) }}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Invite Template</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="Save"
                        class="btn btn-info btn-block btn-xs btn-outline"
                        form="invite">
                        <div class="panel-footer">
                            <span class="pull-left">Select</span> <span
                                class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="row">
                {{ Form::open(array('url' => 'getContent', 'id' => 'follow')) }}
                @yield('isModify')
                {{ Form::radio('TID', 'follow', true, array('class' => 'hidden')) }}
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Follow Up Template</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="Save"
                        class="btn btn-info btn-block btn-xs btn-outline"
                        form="follow">
                        <div class="panel-footer">
                            <span class="pull-left">Select</span> <span
                                class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="row">
                {{ Form::open(array('url' => 'getContent', 'id' => 'confirm')) }}
                @yield('isModify')
                {{ Form::radio('TID', 'confirm', true, array('class' => 'hidden')) }}
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Confirmation Template</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="Save"
                        class="btn btn-info btn-block btn-xs btn-outline"
                        form="confirm">
                        <div class="panel-footer">
                            <span class="pull-left">Select</span> <span
                                class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="row">
                {{ Form::open(array('url' => 'getContent', 'id' => 'custom1')) }}
                @yield('isModify')
                {{ Form::radio('TID', 'custom1', true, array('class' => 'hidden')) }}
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Custom Template1</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="Save"
                        class="btn btn-info btn-block btn-xs btn-outline"
                        form="custom1">
                        <div class="panel-footer">
                            <span class="pull-left">Select</span> <span
                                class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
            <div class="row">
                {{ Form::open(array('url' => 'getContent', 'id' => 'custom2')) }}
                @yield('isModify')
                {{ Form::radio('TID', 'custom2', true, array('class' => 'hidden')) }}
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Custom Template2</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" value="Save"
                        class="btn btn-info btn-block btn-xs btn-outline"
                        form="custom2">
                        <div class="panel-footer">
                            <span class="pull-left">Select</span> <span
                                class="pull-right"><i
                                class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        @yield('status')
    </div>
    @if(isset($groupsByStatus))
    <?php Helper::arrayPrettyPrint($groupsByStatus, 0) ?> @endif
</div>
@stop
