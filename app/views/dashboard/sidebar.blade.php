@extends('dashboard.navbar')
@section('sidepane')
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control"
                        placeholder="Search..."> <span
                        class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div> <!-- /input-group -->
            </li>
            <li><a class="active" href="{{{URL::to('home')}}}"><i
                    class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            <li><a href="{{{ URL::to('groups') }}}"><i
                    class="fa fa-wrench fa-fw"></i> Manage Groups</a></li>
            <li><a href="{{{ URL::to('lists') }}}"><i
                    class="fa fa-wrench fa-fw"></i> Manage Mailing Lists</a></li>
            <li><a href="{{{ URL::to('managetemplate') }}}"><i
                    class="fa fa-files-o fa-fw"></i> Manage Templates</a></li>
            <li><a href="{{{ URL::to('attach') }}}"><i
                    class="fa fa-files-o fa-fw"></i> Manage Attachments</a></li>
            <li><a href="{{{ URL::to('send') }}}"><i
                    class="fa fa-edit fa-fw"></i> Send Mails</a></li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
@stop
