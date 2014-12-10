@extends('dashboard.sidebar')
@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Mail Statistics</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    {{ Helper::dump($mailByStatus) }}
</div>
 @stop