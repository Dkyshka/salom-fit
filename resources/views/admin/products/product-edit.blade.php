@extends('admin.layouts.app')

@section('title')
    просмотр продукта
@endsection

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Просмотр продукта</h1>
                    </div>

                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="card">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item active">
                                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Основное</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">

                                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                                        @if($errors->has('error'))<div class="alert alert-danger"> {{ $errors->first('error') }}</div>@endif
                                        <form class="form-horizontal" action="{{ route('products_update', [$product->id]) }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="chat_id"><u>Закрытый канал</u></label>
                                                    <select class="custom-select rounded-0 js-select" name="chat_id" id="chat_id">
                                                        <option>Нечего не выбрано</option>
                                                        @foreach($chats as $chat)
                                                            <option value="{{ $chat->id }}" {{ $chat->id == $product->chat_id ? 'selected' : '' }}>
                                                                {{ $chat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-form-label">Имя</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}">
                                                    @if($errors->has('name'))<span class="text-danger"> {{ $errors->first('name') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label for="description"><u>Описание</u></label>
                                                    <textarea id="description" class="form-control summernote" name="description">{{ $product->description ?? ''}}</textarea>
                                                    @if($errors->has('description'))<span class="text-danger"> {{ $errors->first('description') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="price" class="col-sm-2 col-form-label">Цена</label>
                                                <div class="col-sm-12">
                                                    <input type="number" name="price" class="form-control" id="price" value="{{ $product->price }}">
                                                    @if($errors->has('price'))<span class="text-danger"> {{ $errors->first('price') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="video" class="col-sm-2 col-form-label">Видео</label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="video" class="form-control" id="video">
                                                    @if($errors->has('video'))<span class="text-danger"> {{ $errors->first('video') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="picture" class="col-sm-2 col-form-label">Изображение</label>
                                                <div class="col-sm-12">
                                                    <input type="file" name="picture" class="form-control" id="picture">
                                                    @if($errors->has('picture'))<span class="text-danger"> {{ $errors->first('picture') }}</span>@endif
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                                    <a href="{{ route('products_admin') }}" type="submit" class="btn btn-primary">Отменить</a>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </section>

    </div>
@endsection
