@extends('dashboard.lists') @section('showMails') @if(isset($toDelete))
<div class="row">
    <div class="panel panel-default col-lg-9">
        <div class="panel-heading">Delete Email</div>
        <!-- Form Starts -->
        {{ Form::open(array('url' => 'deleteMails')) }}
        <div class="row">
            <br>
        </div>
        <div class="row">
            <div class="hidden">{{ Form::select('mlist', $mlists, 'No
                Group to Delete', array('class' => 'form-control')) }}</div>
            <div class="hidden">{{ Form::select('gname', $groups, 'No
                Group to Delete', array('class' => 'form-control')) }}</div>
            <div class="col-lg-3">{{ Form::submit('Delete Mails',
                array('class' => 'btn btn-danger')) }}</div>
            <div class="col-lg-9">
            <?php $i = 0; ?>
                @foreach ($toDelete as $k => $v)
                    @if($i %3 == 0)
                        {{ '<div class="row">
                    ' }} @endif {{ '<label>' }} {{ Form::checkbox($k,
                        $v, NULL, array( 'class' => 'checkbox-inline' ))
                        }} {{ $v }} {{ '</label>' }}
                    <?php $i = $i + 1; ?>
                    @if($i %3 == 0)
                        {{ '</div>
                ' }} @endif @endforeach @if($i % 3 != 0) {{ '
            </div>
            ' }} @endif
        </div>
    </div>
</div>

@endif @stop
