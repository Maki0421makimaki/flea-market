@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')

    <body>
        <form action="{{ route('purchase.buy', ['item_id' => $product->id]) }}" method="POST">
            @csrf
            <div class="all-contents">
                <div class="left-contents">
                    <div class="product-area">
                        <div class="img-content">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                        </div>
                        <div class="product-info">
                            <h1 class="product-name">{{ $product->name }}</h1>
                            <div class="product-price">￥{{ $product->price }}</div>
                        </div>
                    </div>
                    <hr>
                    <div class="product-payment">
                        <h2 class="product-payment">支払い方法</h2>
                        <div class="product-payment__input">
                            <select class="product-payment__input-item" name="payment_method" required>
                                <option value="" selected disabled>選択してください</option>
                                <option value="konbini">コンビニ払い</option>
                                <option value="card">カード支払い</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="delivery-info">
                        <div class="delivery-info__header">
                            <h2 class="delivery-title">配送先</h2>
                            <a href="/purchase/address/{{ $product->id }}">変更する</a>
                        </div>
                        <div class="delivery-info__body">
                            <p class="delivery-postcode">〒{{ $profile->post_code }}</p>
                            <p class="delivery-address">{{ $profile->address }}{{ $profile?->building }}</p>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="right-contents">
                    <div class="check-area">
                        <div class="product-price-check">
                            <span>商品代金</span>
                            <div class="product-price-check__item">¥{{ $product->price }}</div>
                        </div>
                        <div class="product-payment-check">
                            <span>支払い方法</span>
                            <div class="product-payment-check__item">{{ $profile->address }}</div>
                        </div>
                        <div class="form-btn">
                            <button class="form-btn__submit" type="submit">購入する</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>

@endsection