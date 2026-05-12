@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="item-form">
    <div class="item-form__heading"><h1>商品の出品</h1></div>

    <form class="form" action="/？？？？" method="post" enctype="multipart/form-data">
        @csrf
        <div class="item-form__image-uploader">
            <div class="image-uploader__header">
                <span class="image-uploader__title">商品画像</span>
            </div>

            <div class="image-uploader__body">
                <label class="image-uploader__button" for="image-upload-input">画像を選択する</label>
                <input class="image-uploader__input" type="file" id="image-upload-input" name="image-upload-input">
            </div>
        </div>

        <div class="item-form__detail">
            <div class="detail-title"><h2>商品の詳細</h2></div>
            <hr>
            <div class="detail-category">
                <span class="detail-category__title">カテゴリー</span>
                @foreach ($categories as $category)
                    <label>
                        <input class="category__item" type="checkbox" name="categories[]" value="{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            
            <div>
                <span class="item-form__detail-status">商品の状態</span>
                <select class="detail-status__input" name="product-status" required>
                    <option value="select" selected disabled>選択してください</option>
                    <option value="excellent">良好</option>
                    <option value="good">目立った傷や汚れなし</option>
                    <option value="fair">やや傷や汚れあり</option>
                    <option value="poor">状態が悪い</option>
                </select>
            </div>
            

        </div>

        <div class="item-form__description">
            <div class="item-form__description-title"><h2>商品名と説明</h2></div>
            <hr>

            <div class="form__group">
                <div class="form__group-title">
                    <label for="product-name">商品名</label>
                </div>
                <div class="form__group-content">
                    <input type="text" id="product-name" name="product-name">
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <label for="brand-name">ブランド名</label>
                </div>
                <div class="form__group-content">
                    <input type="text" id="brand-name" name="brand-name">
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <label for="description">商品の説明</label>
                </div>
                <div class="form__group-content">
                    <input type="text" id="description" name="description">
                </div>
            </div>

            <div class="form__group">
                <div class="form__group-title">
                    <label for="price">販売価格</label>
                </div>
                <div class="form__group-content input-yen">
                    <input type="text" id="price" name="price">
                </div>
            </div>
        </div>

        
        <div class="form-btn">
            <button class="form-btn__submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection