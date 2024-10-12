@extends('admin.layouts.app')

@section('title')
    Продукты
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Продукты</h1>
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

                            <div class="card-header">
                                <a href="{{ route('products_create') }}" class="btn btn-success btn-flat"><i class="fas fa-plus"></i> Добавить продукт</a>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>Имя</th>
                                        <th>Цена</th>
                                        <th style="text-align: right">Действие</th></tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td style="vertical-align: middle;">{{ $product->name }}</td>

                                            <td>
                                                <mark>
                                                    {{  number_format($product?->price, 0, '', ' ') }}
                                                </mark>
                                            </td>
                                            <td style="width: 5%; vertical-align: middle;">
                                                <a href="{{ route('products_edit', [$product->id]) }}" style="padding: 0 15px;"><i class="fas fa-pen"></i></a>
                                                <a href="{{ route('products_delete', [$product->id]) }}" onclick="return confirm('Вы уверены, что хотите удалить продукт {{ $product->name }}?');"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix d-flex justify-content-end">
                                {{ $products->appends(request()->input())->links() }}
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
