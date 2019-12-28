@extends('layouts.master')

@section('heading')
    <h1>{{ __('Import danh sách khách hàng') }}</h1>
@stop

@section('content')
    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;" action="{{ URL::to('clients/doImport') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

        <input type="file" name="import_file" />
        {{ csrf_field() }}
        <br/>

        <button class="btn btn-success">Import CSV hoặc Excel File</button>

    </form>

@stop