@extends('layouts.startApp')

@section('content')
    <div class="middler" dir="rtl">
        <div class="login__form">
            <div class="login__form__name">{{ __('ورود') }}</div>
            <div class="">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="">
                        <label for="email" class="login__form__label">{{ __('پست الکترونیکی') }}</label>

                        <div class="">
                            <input dir="ltr" id="email" type="email" class="login__form__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <label for="password" class="login__form__label">{{ __('رمز عبور') }}</label>

                        <div class="">
                            <input dir="ltr" id="password" type="password" class="login__form__input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <input class="login__form__checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="login__form__label__sm" for="remember">
                            {{ __('مرا بخاطر بسپار') }}
                        </label>
                    </div>
                    <div class="">
                        <button type="submit" class="login__form__btn">
                            {{ __('ورود') }}
                        </button>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            @if (Route::has('password.request'))
                                <a class="login__form__label__sm text-decoration-none" href="{{ route('password.request') }}">
                                    {{ __('فراموشی رمز عبور') }}
                                </a>
                            @endif
                        </div>
                        <div>
                                <a class="login__form__label__sm text-decoration-none" href="{{ route('register') }}">
                                    {{ __('هنوز ثبت نام نکردی؟') }}
                                </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
