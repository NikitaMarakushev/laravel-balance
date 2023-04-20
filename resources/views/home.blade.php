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

                    <table class="table" id="operations-table">
                        <thead>
                            <tr>
                                <th scope="col" style="cursor: pointer" data-type="string">Дата</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Тип</th>
                                <th scope="col">Значение</th>
                            </tr>
                        </thead>
                        <tbody id="operations-table-body">
                        @foreach($operations as $operation)
                            <tr id="operations-list">
                                <td>{{ $operation->date }}</td>
                                <td>{{ $operation->description }}</td>
                                <td>{{ $operation->type }}</td>
                                <td>{{ $operation->value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">{{ __('Изменение баланса') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('balance_change') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <select class="form-control" name="type">
                                <option value="increase">Увеличить</option>
                                <option value="decrease">Уменьшить</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" min="0w" required name="value">
                        </div>
                        <div class="input-group mb-3">
                            <label for="description"></label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Описание"></textarea>
                        </div>
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                        <button type="submit" class="btn btn-danger">
                            {{ __('Подтвердить операцию') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
    const refreshTimeout = 10000;
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
                    $('#operations-table-body').empty();
                    $.each(result, function (key, value) {
                        $('#operations-table-body').append(`<tr id="operations-list"><td>${value.date}</td><td>${value.description}</td><td>${value.type}</td><td>${value.value}</td></tr>`);
                    });
                }
            });
        }, refreshTimeout)
    });
</script>
@endsection
