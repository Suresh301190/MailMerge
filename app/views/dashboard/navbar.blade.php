@extends('dashboard.master')

@section('navigation')
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation"
    style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle"
            data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span> <span
                class="icon-bar"></span> <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{{URL::to('home')}}}">Mail Merge</a>
    </div>

    <ul class="nav navbar-top-links navbar-right">

        <!-- /.dropdown -->
        <li class="dropdown"><a class="dropdown-toggle"
            data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i>
                <i class="fa fa-caret-down"></i>
        </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{{ URL::to('profile') }}}"><i class="fa fa-user fa-fw"></i> User
                        Profile</a></li>
                <li><a href="{{{ URL::to('profile') }}}"><i class="fa fa-gear fa-fw"></i> Import/Export
                         Data</a></li>
                <li class="divider"></li>
                <li><a href="{{{ URL::to('login') }}}"><i
                        class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul> <!-- /.dropdown-user --></li>
        <!-- /.dropdown -->
    </ul>
    
    @yield('sidepane')

</nav>
<!-- Navigation Ends -->
@stop
