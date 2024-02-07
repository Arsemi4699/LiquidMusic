@extends('layouts.startApp')

@section('content')
    <div class="middler" dir="rtl">
        <div class="login__form">
            <div class="login__form__name">{{ __('بازنشانی رمز عبور') }}</div>

            <div class="">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="">
                        <label for="email" class="login__form__label">{{ __('ایمیل') }}</label>

                        <div class="">
                            <input id="email" dir="ltr" type="email"
                                class="login__form__input @error('email') is-invalid @enderror" name="email"
                                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                            <input id="password" dir="ltr" type="password"
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
                        <label for="password-confirm" class="login__form__label">{{ __('تایید رمز عبور') }}</label>

                        <div class="">
                            <input id="password-confirm" dir="ltr" type="password" class="login__form__input"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="">
                        <div class="">
                            <button type="submit" class="login__form__btn">
                                {{ __('بازنشانی رمز عبور') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
