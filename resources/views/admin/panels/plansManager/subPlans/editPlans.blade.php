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
                <h4 class="mb-3">ویرایش اشتراک: </h4>
                <form action="{{ route('admin.updatePlans', ['id' => $plan->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">عنوان</label>
                        <input name="title" type="text" class="form-control" id="title" value="{{ $plan->name }}">
                        @error('title')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">قیمت</label>
                        <input name="price" type="number" class="form-control" id="price"
                            value="{{ $plan->price_T }}" min="0" placeholder="قیمت به تومان">
                        @error('price')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="duration">مدت</label>
                        <input name="duration" type="number" class="form-control" id="duration"
                            value="{{ $plan->duration_D }}" min="0" placeholder="مدت به روز">
                        @error('duration')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        ویرایش
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
