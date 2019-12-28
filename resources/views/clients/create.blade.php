@extends('layouts.master')

@section('heading')
    <h1>{{ __('Thêm khách hàng') }}</h1>
@stop

@section('content')

<!--    <div class="container-fluid">
        <?php $data = Session::get('data'); ?>
        {!! Form::open(['url' => '/clients/create/cvrapi']) !!}
            <div class="form-group">
                <div class="input-group">
                    {!! Form::text('vat', null, ['class' => 'form-control', 'placeholder' => 'Insert company VAT']) !!}
                    <div class="popoverOption input-group-addon"
                         rel="popover"
                         data-placement="left"
                         data-html="true"
                         data-original-title="<span>Only for DK, atm.</span>">?
                    </div>
                </div>
                {!! Form::submit('Get client info', ['class' => 'btn btn-primary clientvat']) !!}
            </div>

        {!!Form::close()!!}
    </div> -->

    {!! Form::open([
            'route' => 'clients.store',
            'files'=>true,
            'enctype' => 'multipart/form-data'
    ]) !!}
        @include('clients.form', ['submitButtonText' => __('Thêm khách hàng')])
    {!! Form::close() !!}

@stop
