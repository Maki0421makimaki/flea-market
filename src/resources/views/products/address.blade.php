@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

    <body>
        <div class="all-contents">
            <div class="address-change">
                <div class="address-change__heading">
                    <h1>住所の変更</h1>
                </div>
                <form class="form" action="/？？？？" method="post">
                    @csrf
                    <div class="form__group">
                        <div class="form__group--title">
                            <label for="postcode">郵便番号</label>
                        </div>
                        <div class="form__group--content">
                            <input type="text" id="postcode" name="postcode">
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
        </div>
    </body>

@endsection