@extends('dashboard.sidebar')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $groupCount['invite'] }}</div>
                                        <div>To Invite</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $groupCount['follow'] }}</div>
                                        <div>To Follow</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $groupCount['confirm'] }}</div>
                                        <div>To Confirm</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">{{ $groupCount['confirmed'] }}</div>
                                        <div>Confirmed</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 pull-right">
                <div class="col-lg-11 pull-right">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bell fa-fw"></i> Notifications
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                @foreach($notifications as $mail)
                                    <!-- Sending status -->
                                    @if($mail['type'] == 0)
                                        <a class="list-group-item">
                                            <i class="fa fa-upload fa-fw"></i>{{ $mail['message'] }}
                                            <span class="pull-right text-muted small">
                                                <em>{{ $mail['time'] }}</em>
                                            </span>
                                        </a>
                                    @elseif($mail['type'] == 1)
                                        <a class="list-group-item">
                                            <i class="fa fa-envelope fa-fw"></i>{{ $mail['message'] }}
                                            <span class="pull-right text-muted small">
                                                <em>{{ $mail['time'] }}</em>
                                            </span>
                                        </a>
                                    @elseif($mail['type'] == 2)
                                        <a class="list-group-item">
                                            <i class="fa fa-warning fa-fw"></i>{{ $mail['message'] }}
                                            <span class="pull-right text-muted small">
                                                <em>{{ $mail['time'] }}</em>
                                            </span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            <!-- /.list-group -->
                            <a href="{{{ URL::to('mail-info') }}}" class="btn btn-default btn-block">View All Alerts</a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{ '<pre>' }}
            {{-- var_dump('') --}}
            {{ '</pre>' }}
        </div>
    </div>
@stop
