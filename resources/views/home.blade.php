@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Пять последних операций (данные обновляются каждые 10 секунд)') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <h3>Баланс пользователя {{ $current_user }}: {{ $user_balance }}</h3>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            <th scope="col">Тип</th>
                            <th scope="col">Значение</th>
                        </tr>
                        </thead>
                        <tbody id="operations-table">
                        @foreach($operations as $operation)
                            <tr id="operations-list">
                                <td>{{ $operation->date }}</td>
                                <td>{{ $operation->type }}</td>
                                <td>{{ $operation->value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
    window.$(() => {
        setInterval(function () {
            $.ajax({
                url: "{{ url('/operations_last') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#operations-table').empty();
                    $.each(result, function (key, value) {
                        $('#operations-table').append(`<tr id="operations-list"><td>${value.date}</td><td>${value.type}</td><td>${value.value}</td></tr>`)
                    });
                }
            });
        }, 10000)
    });
</script>
@endsection
