@extends('layouts.adminApp')

@section('pageName')
    مدیریت ادمین ها
@endsection

@section('AdminsActive')
    active
@endsection

@section('PageContnet')
    <div>
        <div class="row m-4" dir="rtl">
            <div class="col-md-6 offset-md-3">
                <h4 class="mb-3">افزودن ادمین: </h4>
                <form action="{{ route('admin.createAdmin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">نام</label>
                        <input name="title" type="text" class="form-control" id="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="mail">ایمیل</label>
                        <input name="email" type="email" class="form-control" id="mail" value="{{ old('email') }}">
                        @error('email')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="pass">رمز ورود</label>
                        <input name="password" type="password" class="form-control" id="pass">
                        @error('password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="conf_pass">تایید رمز ورود</label>
                        <input name="password_confirmation" type="password" class="form-control" id="conf_pass">
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex align-items-center gap-3">
                        <label class="form-label">به عنوان:</label>
                        <div class="">
                            <input type="radio" name="role" value=1 id="basic" checked>
                            <label for="basic" class="m-0">پایه</label>
                        </div>
                        <div class="">
                            <input type="radio" name="role" value=2 id="master">
                            <label for="master" class="m-0">عادی</label>
                        </div>
                        <div class="">
                            <input type="radio" name="role" value=3 id="super">
                            <label for="super" class="m-0">ویژه</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        افزودن
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
