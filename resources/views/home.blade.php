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

                    <div class="container">
                        <div class="form-outline">
                            <input type="search" id="operations-search" class="form-control" placeholder="Введите описание..." aria-label="Search" />
                        </div>
                    </div>

                    <table class="table" id="operations-table">
                        <thead>
                            <tr>
                                <th scope="col" style="cursor: pointer" data-type="string">Дата</th>
                                <th scope="col">Описание</th>
                                <th scope="col">Тип</th>
                                <th scope="col">Значение</th>
                            </tr>
                        </thead>
                        <tbody id="operations-table-body-body">
                        @foreach($operations as $operation)
                            <tr id="operations-list">
                                <td>{{ $operation->date }}</td>
                                <td id="description-search">{{ $operation->description }}</td>
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
                    $('#operations-table-body').empty();
                    $.each(result, function (key, value) {
                        $('#operations-table-body').append(`<tr id="operations-list"><td>${value.date}</td><td>${value.type}</td><td>${value.value}</td></tr>`)
                    });
                }
            });
        }, 10000)
    });
    $(document).ready(function(){
        $("#operations-search").on("keyup", function() {
            const value = $(this).val().toLowerCase();
            $("#description-search").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            })
        });
    });
    $(function() {
        const tableHeaders = $("th");
        let sortOrder = 1;

        tableHeaders.on("click", function() {
            const rows = sortRows(this);
            rebuildTbody(rows);
            updateClassName(this);
            sortOrder *= -1;
        })

        function sortRows(tableHeaders) {
            const rows = $.makeArray($('tbody > tr'));
            const col = tableHeaders.cellIndex;
            const type = tableHeaders.dataset.type;
            rows.sort(function(a, b) {
                return compare(a, b, col, type) * sortOrder;
            });
            return rows;
        }

        function compare(a, b, col, type) {
            let _a = a.children[col].textContent;
            let _b = b.children[col].textContent;
            if (type === "number") {
                _a *= 1;
                _b *= 1;
            } else if (type === "string") {
                _a = _a.toLowerCase();
                _b = _b.toLowerCase();
            }

            if (_a < _b) {
                return -1;
            }
            if (_a > _b) {
                return 1;
            }
            return 0;
        }

        function rebuildTbody(rows) {
            const tbody = $("tbody");
            while (tbody.firstChild) {
                tbody.remove(tbody.firstChild);
            }
            let j;
            for (j=0; j<rows.length; j++) {
                tbody.append(rows[j]);
            }
        }

        function updateClassName(tableHeaders) {
            let k;
            for (k=0; k < tableHeaders.length; k++) {
                tableHeaders[k].className = "";
            }
            tableHeaders.className = sortOrder === 1 ? "asc" : "desc";
        }
    });
</script>
@endsection
