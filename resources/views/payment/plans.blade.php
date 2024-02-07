@extends('layouts.userApp')

@section('content')
    <div>
        <h3 class="text__color__primary fs-1 mb-3">
            اشتراک های سرویس:
        </h3>
        <div class="d-flex gap-3 align-items-center justify-content-center flex-column flex-md-row flex-wrap">
            @foreach ($subPlans as $plan)
                <div class="sub__plans">
                    <div class="sub__plans__info">
                        <h4 class="fw-bold fs-3" >{{$plan->name}}</h4>
                        <h4 class="fs-3">قیمت:</h4>
                        <h4 class="fs-3">{{ $plan->price_T }} تومان </h4>
                        <h4 class="fs-3">مدت زمان:</h4>
                        <h4 class="fs-3">{{ $plan->duration_D }} روز </h4>
                        <form action="{{route('payment') }}"" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $plan->id }}">
                            <input type="hidden" name="type" value="plan">
                            <button type="submit" class="w-100 btn btn-success">خرید اشتراک</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
