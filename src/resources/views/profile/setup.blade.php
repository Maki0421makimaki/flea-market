@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/setup.css') }}">
@endsection

@section('content')
<div class="profile-form">
    <div class="profile-form__heading">
        <h1>プロフィール設定</h1>
    </div>
    <form class="form" action="/mypage" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form__group">
            <div class="form__group--image">
                <div class="image-display"></div>
                <div class="image-upload">
                    <label class="image-upload__label" for="user_image">画像を選択する</label>
                    <input type="file" id="user_image" class="image-upload__input" name="user_image">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group--title">
                <label for="username">ユーザー名</label>
            </div>
            <div class="form__group--content">
                <input type="text" id="name" name="name">
            </div>
        </div>

        <div class="form__group">
            <div class="form__group--title">
                <label for="postcode">郵便番号</label>
            </div>
            <div class="form__group--content">
                <input type="text" id="post_code" name="post_code">
            </div>
        </div>

        <div class="form__group">
            <div class="form__group--title">
                <label for="address">住所</label>
            </div>
            <div class="form__group--content">
                <input type="text" id="address" name="address">
            </div>
        </div>

        <div class="form__group">
            <div class="form__group--title">
                <label for="building">建物名</label>
            </div>
            <div class="form__group--content">
                <input type="text" id="building" name="building">
            </div>
        </div>


        <div class="button-area">
            <div class="form-btn">
                <button class="form-btn__submit" type="submit">更新する</button>
            </div>
        </div>
    </form>
</div>

@endsection

