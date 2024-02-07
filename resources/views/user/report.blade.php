@extends('layouts.userApp')

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="text__color__primary fs-1 mb-2">گزارش آهنگ {{ $name }}</h3>
            <form action="{{ route('SubmitReportMusic') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <div class="mb-3">
                    <label class="form-label text__color__primary fs-3" for="type">نوع خطا: </label>
                    <select class="form-control" name="type" id="type">
                        <option value="Copyright">نقض کپی رایت</option>
                        <option value="ChildAbuse">کودک آزاری</option>
                        <option value="Violence">خشونت شدید</option>
                        <option value="Unethical">غیر اخلاقی</option>
                        <option value="Other" selected>سایر موارد</option>
                    </select>
                    @error('type')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label text__color__primary fs-3" for="level">اولویت گزارش: </label>
                    <select class="form-control" name="level" id="level">
                        <option value="low" selected>پایین</option>
                        <option value="medium">متوسط</option>
                        <option value="high">بالا</option>
                    </select>
                    @error('level')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label text__color__primary fs-3">توضیحات</label>
                    <textarea name="info" class="form-control" placeholder="دلیل گزارش آهنگ (اختیاری)" cols="30" rows="5" maxlength="175"></textarea>
                    @error('info')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-light mt-1 fs-5">
                    ثبت گزارش
                </button>
            </form>
        </div>
    </div>
@endsection
