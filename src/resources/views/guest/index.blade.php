@extends('layouts.guest')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="main">
        <!-- タイトル -->
        <div class="menu-tab">
            <a class="menu-tab__item-recommend" href="/login">おすすめ</a>
            <a class="menu-tab__item-mylist" href="/login">マイリスト</a>
        </div>

        <hr>


        <!-- 商品一覧 あとで繰り返す -->
        <div class="product-list">
            @foreach ($products as $product)
                <a href="/item/{{ $product->item_id }}">
                    <div class="product-card">
                        <img src="" alt="">
                        <div class="product-info">
                            <p>{{ $product->name}}</p>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>

        <div class="product-list">
            @foreach ($products as $product)
                <a href="/products/detail/{{ $product->id }}">
                    <div class="product-card">
                        <img src="{{ asset('storage/' . $product->image) }}">
                        <div class="product-info">
                            <p>{{ $product->name }}</p>
                            <p>¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
