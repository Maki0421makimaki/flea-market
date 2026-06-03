@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
            <div class="container">
                <!-- 左　画像 -->
                <div class="image-area">
                    <div class="image-content">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
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
                        @php
    $liked = $product->likes->where('user_id', auth()->id())->count();
                        @endphp
                        <div class="like-container">
                            <div>
                                @if($liked)
                                    <form action="/product/{{ $product->id }}/unlike" method="post">
                                        @csrf
                                        <button class="like-btn">
                                            <img src="{{ asset('images/ハートロゴ_ピンク.png') }}">
                                        </button>
                                    </form>
                                @else
                                    <form action="/product/{{ $product->id }}/like" method="post">
                                        @csrf
                                        <button class="like-btn">
                                            <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}">
                                        <button>
                                    </form>
                                @endif
                                </div>
                            <div class="like-count">
                                {{ $product->likes->count() }}
                            </div>
                        </div>
                        <div class="comment-container">
                            <button class="comment-btn">
                                <img src="{{ asset('images/ふきだしロゴ.png') }}">
                            </button>
                            <div class="comment-count">
                                {{ $product->comments->count() }}
                            </div>
                        </div>
                    </div>

                    <a href="/purchase/{{ $product->id }}" class="purchase-submit__btn">購入手続きへ</a>

                    <div class="product-description">
                        <h2>商品説明</h2>
                        <p>{{ $product->description }}</p>
                    </div>

                    <div class="product-info">
                        <h2>商品の情報</h2>
                        <div class="product-category">
                            <div class="product-category__title">カテゴリー</div>
                            <div class="product-category__name">
                                @foreach ($product->categories as $category)
                                    {{ $category->name }}
                                @endforeach
                            </div>
                        </div>
                        <div class="product-status">
                            <div class="product-status__title">商品の状態</div>
                            <div class="product-status__name">{{ $product->productStatus->name }}</div>
                        </div>
                    </div>

                    <div class="product-comment">
                        <h2 class="comment-count">コメント({{ $product->comments->count() }})</h2>
                        @foreach ($product->comments as $comment)
                            <div class="user-info">
                                <div class="user-icon">
                                    <img src="{{ asset('storage/profile/' . $comment->user->profile->image) }}" alt="ユーザー画像">
                                </div>
                                <div class="user-name">
                                    {{ $comment->user->profile->name }}
                                </div>
                            </div>
                            <p class="comment-area">
                                {{ $comment->comment }}
                            </p>
                        @endforeach

                        <label class="comment-label">商品へのコメント</label>
                        <form action="/product/{{ $product->id }}/comment" method="post">
                            @csrf
                            <textarea name="comment" id="comment" rows="8"></textarea>
                            <p class="comment__error-message">
                                @if ($errors->has('comment'))
                                    @foreach($errors->get('comment') as $message)
                                        {{ $message }}
                                    @endforeach
                                @endif
                            </p>

                            <button class="product-comment__submit">コメントを送信する</button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
