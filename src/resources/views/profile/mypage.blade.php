 @extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="main">
            <div class="user-info">
                <div class="user-info-profile">
                    <div class="user-icon">
                        <img src="{{ asset('storage/profile/' . $image) }}" alt="ユーザー画像">
                    </div>
                    <div class="user-name">
                        {{ $name }}
                    </div>
                </div>
                <div class="profile-edit">
                    <a href="/mypage/profile" class="profile-edit__link">プロフィールを編集</a>
                </div>
            </div>
            <div class="menu-tab">
                <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
                    class="tab-sell-list {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
                <a href="{{ route('mypage.index', ['page' => "buy"]) }}"
                    class="tab-purchased-list {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
            </div>
            <hr>
            <div class="product-list">
                @foreach ($products as $item)
                    <div class="product-content">
                        @if ($page === 'buy')
                            <a href="/item/{{ $item->product->id }}" class="product-link">
                                <div class="product-card">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="商品画像">
                                    <div class="product-info">
                                        <p>{{ $item->product->name }}</p>
                                    </div>
                                </div>
                            </a>
                        @else
                            <a href="/item/{{ $item->id }}" class="product-link">
                                <div class="product-card">
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
                                    <div class="product-info">
                                        <p>{{ $item->name }}</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection