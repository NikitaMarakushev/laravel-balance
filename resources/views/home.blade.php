@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>

                <div class="card-body">
                    <p>Примечение: баланс обновляется раз в сутки</p>
                    <h2>Баланс пользователя {{ $current_user }}: {{ $user_balance }}</h2>

                    <table class="table">
                        <h2>Пять последних операций</h2>
                        <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            <th scope="col">Тип</th>
                            <th scope="col">Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($operations as $operation)
                            <tr>
                                <td>{{ $operation->date }}</td>
                                <td>{{ $operation->type }}</td>
                                <td>{{ $operation->value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $operations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
