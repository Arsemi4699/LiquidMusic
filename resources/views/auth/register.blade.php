@extends('layouts.startApp')

@section('content')
    <div class="middler" dir="rtl">
        <div class="login__form">
            <div class="login__form__name">{{ __('ثبت نام') }}</div>

            <div class="">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="">
                        <label for="name" class="login__form__label">{{ __('نام مستعار') }}</label>

                        <div class="">
                            <input dir="ltr" id="name" type="text"
                                class="login__form__input @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="email" class="login__form__label">{{ __('پست الکترونیکی') }}</label>

                        <div class="">
                            <input dir="ltr" id="email" type="email"
                                class="login__form__input @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password" class="login__form__label">{{ __('رمزعبور') }}</label>

                        <div class="">
                            <input dir="ltr" id="password" type="password"
                                class="login__form__input @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="">
                        <label for="password-confirm" class="login__form__label">{{ __('تایید رمزعبور') }}</label>

                        <div class="">
                            <input dir="ltr" id="password-confirm" type="password" class="login__form__input"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="">
                        <div class="login__form__label">{{ __('ثبت نام به عنوان:') }}</div>
                        <div class="">
                            <input type="radio" name="role" value=1 id="listener" class="login__form__radio" checked>
                            <label for="listener" class="login__form__label">{{ __('شنونده') }}</label>
                        </div>
                        <div class="">
                            <input type="radio" name="role" value=3 class="login__form__radio" id="artist">
                            <label for="artist" class="login__form__label">{{ __('هنرمند') }}</label>
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <input type="checkbox" id="rulls" class="login__form__radio" required>
                            <label for="rulls" class="login__form__label">پذیرش
                                <a target="_blank" href="{{ route('policy') }}">قوانین
                                    سرویس</a>
                                </label>
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <button type="submit" class="login__form__btn">
                                {{ __('ثبت نام') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <a class="login__form__label__sm text-decoration-none" href="{{ route('login') }}">
                        {{ __('قبلا ثبت نام کردی؟') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
