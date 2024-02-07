@extends('layouts.startApp')

@section('content')
    <div class="middler" dir="rtl">
        <div class="login__form">
            <div class="login__form__name">{{ __('ایمیل خود رو تایید کنید') }}</div>

            <div class="">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('یک لینک جدید برای تایید به ایمیل شما ارسال شد!') }}
                    </div>
                @endif

                {{ __('پیش از ادامه لطفا ایمیل خود را برای لینک تایید حساب کاربری بررسی کنید.') }}
                {{ __('اگر ایمیل را دریافت نکردید') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit"
                        class="btn btn-link text__color__primary p-0 m-0 align-baseline">{{ __('اینجا برای درخواست یک لینک تایید دیگر کلید کنید.') }}</button>.
                </form>
            </div>
        </div>
    </div>
@endsection
