@extends('layouts.master')

@section('heading')
@stop

@push('scripts')
    <script>
        $('#myTabs a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        })
    </script>
@endpush

@section('content')
    <div class="row">
        @include('partials.clientheader')
    </div>
    </div>
    </div>
@stop
