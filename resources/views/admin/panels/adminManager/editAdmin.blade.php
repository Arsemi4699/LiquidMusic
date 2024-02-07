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
                <h4 class="mb-3">ویرایش ادمین: </h4>
                <form action="{{ route('admin.updateAdmin', ['id' => $admin->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">نام</label>
                        <input name="title" type="text" class="form-control" id="title" value="{{ $admin->name }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="mail">ایمیل</label>
                        <input name="email" type="email" class="form-control" id="mail"
                            value="{{ $admin->email }}">
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
                        @if ($admin->id != 1)
                            <div class="">
                                <input type="radio" name="role" value=1 id="basic"
                                    @if ($admin->role == 'basic') checked @endif>
                                <label for="basic" class="m-0">پایه</label>
                            </div>
                            <div class="">
                                <input type="radio" name="role" value=2 id="master"
                                    @if ($admin->role == 'master') checked @endif>
                                <label for="master" class="m-0">عادی</label>
                            </div>
                        @endif
                        <div class="">
                            <input type="radio" name="role" value=3 id="super"
                                @if ($admin->role == 'super') checked @endif>
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
