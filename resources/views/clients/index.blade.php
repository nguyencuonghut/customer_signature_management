@extends('layouts.master')
@section('heading')
    <h1>{{ __('Tất cả khách hàng') }}</h1>
@stop

@section('content')

    <table class="table table-striped" id="clients-table">
        <thead>
        <tr>
            <th>{{ __('Tên') }}</th>
            <th>{{ __('Code') }}</th>
            <th>{{ __('Địa chỉ') }}</th>
            <th>{{ __('Chữ ký') }}</th>
            <th>{{ __('Sửa/Xóa') }}</th>
        </tr>
        </thead>
    </table>

@stop

@push('scripts')
<script>
    $(function () {
        $('#clients-table').DataTable({
            processing: true,
            serverSide: true,

            ajax: '{!! route('clients.data') !!}',
            columns: [

                {data: 'namelink', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'address', name: 'address'},
                { "data": "signature_path", "render": function (data, type, full, meta) {
                    return '<img width="250" src='+'/upload/'+data+'>';
                    }
                },
                {data: 'actions', name: 'actions', orderable: false, searchable: false},

            ],
        });
    });
</script>
@endpush
