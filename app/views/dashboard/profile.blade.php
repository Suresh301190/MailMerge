@extends('dashboard.sidebar') @section('content')
<div id="page-wrapper">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>Your ID:</th>
                <td>{{ Auth::user()->id }}</td>
            </tr>
            <tr>
                <th>Your Full Name:</th>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <th>Your Given Name:</th>
                <td>{{ Auth::user()->given_name }}</td>
            </tr>
            <tr>
                <th>Your Family Name:</th>
                <td>{{ Auth::user()->family_name }}</td>
            </tr>
            <tr>
                <th>Your Email Address:</th>
                <td>{{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <td>Your Email Address has
                    @if(Auth::user()->verified_email) been <strong>verified</strong>
                    @else <strong>not</strong> been verified @endif
                </td>
            </tr>
            @if(isset(Auth::user()->hd))
            <tr>
                <th>Your hosted domain:</th>
                <td>{{ Auth::user()->hd }}</td>
            </tr>
            @endif
            <tr>
                <th>Your Locale:</th>
                <td>{{ Auth::user()->locale }}</td>
            </tr>
        </table>
    </div>
</div>
@stop
