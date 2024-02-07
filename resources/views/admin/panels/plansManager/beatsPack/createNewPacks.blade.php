@extends('layouts.adminApp')

@section('pageName')
    مدیریت اشتراک ها
@endsection

@section('PlansActive')
    active
@endsection

@section('PageContnet')
    <div>
        <div class="row m-4" dir="rtl">
            <div class="col-md-6 offset-md-3">
                <h4 class="mb-3">افزودن بسته بیتس کلود: </h4>
                <form action="{{ route('admin.createPacks') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">عنوان</label>
                        <input name="title" type="text" class="form-control" id="title" value="{{ old('title') }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">قیمت</label>
                        <input name="price" type="number" class="form-control" id="price" value="{{ old('price') }}" min="0" placeholder="قیمت به تومان">
                        @error('price')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="size">تعداد</label>
                        <input name="size" type="number" class="form-control" id="size" value="{{ old('size') }}" min="0" placeholder="تعداد آهنگ های بسته">
                        @error('size')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        افزودن
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
