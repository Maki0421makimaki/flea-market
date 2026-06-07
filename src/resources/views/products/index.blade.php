@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="main">
            <div class="menu-tab">
                <a href="{{ route('items.index', [
                    'tab' => 'recommend',
                    'keyword' => request('keyword')
                ]) }}"
                    class="tab-recommend {{ $tab === 'recommend' ? 'active' : '' }}">おすすめ</a>
                <a href="{{ route('items.index', [
                    'tab' => 'mylist',
                    'keyword' => request('keyword')
                ]) }}"
                    class="tab-mylist {{ $tab === 'mylist' ? 'active' : '' }}">マイリスト</a>
            </div>
            <hr>
            <div class="product-list">
                @foreach ($products as $product)
                    <div class="product-content">
                        <a href="/item/{{ $product->id }}" class="product-link">
                            <div class="product-card">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                                <div class="product-info">
                                    <p>{{ $product->name}}</p>
                                </div>
                                @if ($product->purchase)
                                    <span>sold</span>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection