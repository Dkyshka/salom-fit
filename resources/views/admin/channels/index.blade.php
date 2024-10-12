@extends('admin.layouts.app')

@section('title')
    Чаты
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Чаты</h1>
                    </div>

                </div>
            </div>
        </div>

        @if(session('success'))
            <span id="events" data-message="{{ session('success') }}" data-action="success"></span>
        @endif

        @if(session('error'))
            <span id="events" data-message="{{ session('error') }}" data-action="error"></span>
        @endif

    <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Имя</th>
                                        <th>Chat ID</th>
                                    </thead>
                                    <tbody>
                                    @foreach($channels as $item)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ ($channels->currentPage() - 1) * $channels->perPage() + $loop->iteration }}</td> <!-- Порядковый номер с учётом пагинации -->
                                            <td style="vertical-align: middle;">{{ $item->name }}</td>
                                            <td>{{ $item?->chat_id }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix d-flex justify-content-end">
                                {{ $channels->appends(request()->input())->links('pagination::bootstrap-5') }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
