@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    <!-- 左　画像 -->
    <div class="image-area">
        <div class="image-content">
            <img src="{{ asset($product->image) }}" alt="商品画像">
        </div>
    </div>
    <!-- 右　商品詳細 -->
    <div class="product-detail">
        <div class="product-meta">
            <div class="product-name">{{ $product->name }}</div>
            <div class="brand-name">{{ $product->brand_name }}</div>
        </div>

        <div class="product-price">¥<span style="font-size: 1.3em">{{ $product->price }}</span>（税込）</div>

        <div class="reaction-area">
            <div class="like-container">
                <button class="like-btn">
                    <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}">
                </button>
                <div class="like-count">0</div>
            </div>
            <div class="comment-container">
                <button class="comment-btn">
                    <img src="{{ asset('images/ふきだしロゴ.png') }}">
                </button>
                <div class="comment-count">0</div>
            </div>
        </div>

        <a href="/purchase/{item_id}" class="purchase-submit__btn">購入手続きへ</a>

        <div class="product-description">
            <h2>商品説明</h2>
            <p>{{ $product->description }}</p>
        </div>

        <div class="product-info">
            <h2>商品の情報</h2>
            <div class="product-category">
                <div class="product-category__title">カテゴリー</div>
                <div class="product-category__name">{{ $category->name }}</div>
            </div>
            <div class="product-status">
                <div class="product-status__title">商品の状態</div>
                <div class="product-status__name">{{ $product_status-name }}</div>
            </div>
        </div>

        <div class="product-comment">
            <h2 class="comment-count">コメント({{ }})</h2>
            <div class="user-info">
                <div class="user-icon"> </div>
                <div class="user-name"> </div>
            </div>
            <p class="comment-area">こちらにコメントが入ります</p>

            <label class="comment-label">商品へのコメント</label>
            <textarea name="comment" id="comment" rows="8"></textarea>

            <button class="product-comment__submit">コメントを送信する</button>
        </div>
    </div>
</div>
@endsection
