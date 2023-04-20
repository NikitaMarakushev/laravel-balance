@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Пять последних операций') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Дата</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Тип</th>
                            <th scope="col">Значение</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($operations as $operation)
                            <tr>
                                <td>{{ $operation->date }}</td>
                                <td>{{ $operation->description }}</td>
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
