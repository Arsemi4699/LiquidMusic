@extends('layouts.studioApp')

@section('pageName')
    امور مالی
@endsection

@section('BillActive')
    active
@endsection

@section('PageContnet')
    <div>
        @if ($errors->any())
            <div class="alert alert-danger" dir="rtl">
                <p class="m-0 text-white">
                    پرکردن تمام فیلد ها الزامی است!
                </p>
            </div>
        @endif
        @if (session('errorOnPayoff'))
            <div dir="rtl" class="alert alert-danger" role="alert">
                {{ session('errorOnPayoff') }}
            </div>
        @endif
        @if (session('payoffDone'))
            <div dir="rtl" class="alert alert-success" role="alert">
                {{ session('payoffDone') }}
            </div>
        @endif
        @if (!$valid)
            <div>
                <div class="alert alert-danger" dir="rtl">
                    <p class="m-0 text-white">
                        تعداد دنبال کنندگان شما کافی نیست. <br>
                        شرایط لازم برای استفاده از سرویس درآمد را ندارید!
                    </p>
                </div>
            </div>
        @else
            @if (!$seted)
                <div class="row">
                    <div class="col-md-12 m-0">
                        <form action="{{ route('MonetizeRequest') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header p-2">
                                    <div class="row">
                                        <div class="col-8">
                                            <h6 class="mb-0 p-2">اطلاعات بانکی</h6>
                                        </div>
                                        <div class="col-4 d-flex" dir="rtl">
                                            <button type="submit" class="mb-0 btn btn-dark">ثبت اطلاعات بانکی</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row" dir="rtl">
                                        <div class="col">
                                            <div class="mb-2">
                                                <label for="surname" class="form-label">نام:</label>
                                                <input type="text" name="fname" class="form-control" id="surname">
                                            </div>
                                            <div class="mb-2">
                                                <label for="lastname" class="form-label">نام خانوادگی:</label>
                                                <input type="text" name="lname" class="form-control" id="lastname">
                                            </div>
                                            <div class="mb-2">
                                                <label for="cnumber" class="form-label">شماره شناسنامه:</label>
                                                <input type="text" name="cnumber" class="form-control" id="cnumber">
                                            </div>
                                            <div class="mb-2">
                                                <label for="anumber" class="form-label">شماره حساب:</label>
                                                <input type="text" name="anumber" class="form-control" id="anumber">
                                            </div>
                                            <div class="mb-2">
                                                <label for="cardnumber" class="form-label">شماره کارت:</label>
                                                <input type="text" name="cardnumber" class="form-control"
                                                    id="cardnumber">
                                            </div>
                                            <div class="mb-2">
                                                <label for="shaba" class="form-label">شماره شبا:</label>
                                                <input type="text" name="shaba" class="form-control" id="shaba">
                                            </div>
                                            <input type="hidden" name="artistID" value="{{ Auth::user()->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                @if ($confirmed == 1)
                    <div>
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-md-12 m-0">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <h6 class="mb-0 p-2">اطلاعات بانکی</h6>
                                                    </div>
                                                    <div class="col-4 d-flex" dir="rtl">
                                                        <form action="{{ route('resetMonetizeRequest') }}" method="post">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="artistID"
                                                                value="{{ Auth::user()->id }}">
                                                            <button type="submit"
                                                                onclick="return confirm('از بازنشانی اطلاعات مالی خود اطمینان دارید؟ این عمل غیر قابل بازگشت خواهد بود!')"
                                                                class="mb-0 btn btn-dark">تغییر اطلاعات بانکی</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="row">
                                                    <div class="col">
                                                        <div
                                                            class="card card-body border card-plain border-radius-lg d-flex align-items-center justify-content-between flex-row">
                                                            <h6 class="mb-0">IR{{ $shaba }}</h6>
                                                            <span class="d-inline-block">{{ $ownerFullname }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-md-0 mt-4 col-12 col-md-4 d-flex flex-column justify-content-between">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">موجودی</p>
                                                    <h5 class="font-weight-bolder mb-0">
                                                        {{ $balance }} تومان
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div
                                                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                    <i class="ni ni-money-coins text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-md-0 mt-2 card" dir="rtl">
                                    <div class="card-body p-3">
                                        <form action="{{ route('setPayoff') }}" method="post">
                                            <div class="d-flex align-items-center justify-content-between gap-1">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="artistID" value="{{ Auth::user()->id }}">
                                                <input type="number" name="payoff" class="form-control flex-grow-0"
                                                    placeholder="مبلغ به تومان">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-success mb-0 flex-grow-0 text-nowrap">درخواست
                                                        واریز</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-4">
                                <div class="card h-100 mb-4">
                                    <div class="card-header p-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="mb-0 p-2">لیست تراکنش ها</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4 p-3">
                                        <h5 class="text-uppercase text-body text-s font-weight-bolder mb-3">جدیدترین</h5>
                                        <ul class="list-group">
                                            @foreach ($payOffLogs as $log)
                                                <li dir="rtl"
                                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                    <div class="d-flex align-items-center">
                                                        <button
                                                            class="btn btn-icon-only btn-rounded  @if ($log->status == 1) btn-outline-success @elseif($log->status == 2) btn-outline-danger @elseif($log->status == 0) btn-outline-dark @endif mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                                        </button>
                                                        <div class="d-flex flex-column m-2">
                                                            <h6 class="mb-1 text-dark text-sm">درخواست واریز وجه</h6>
                                                            <span class="text-xs">{{ $log->updated_at }}</span>
                                                        </div>
                                                    </div>
                                                    @if ($log->status == 0)
                                                        <div>
                                                            <p
                                                                class="d-flex align-items-center text-dark text-gradient font-weight-bold">
                                                                {{ $log->money }} تومان درحال بررسی</p>
                                                        </div>
                                                    @elseif ($log->status == 1)
                                                        <div>
                                                            <p
                                                                class="d-flex align-items-center text-success text-gradient font-weight-bold">
                                                                {{ $log->money }}+ تومان واریز شد</p>
                                                        </div>
                                                    @elseif ($log->status == 2)
                                                        <div>
                                                            <p
                                                                class="d-flex align-items-center text-danger text-gradient font-weight-bold">
                                                                {{ $log->money }}- تومان شکست خورد</p>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($confirmed == 0)
                    <div>
                        <div class="alert alert-warning" dir="rtl">
                            <p class="m-0 text-white">
                                در انتظار تایید هویت مالی <br>
                                لطفا بعدا مراجعه کنید!
                            </p>
                        </div>
                    </div>
                @elseif ($confirmed == 2)
                    <div>
                        <div class="alert alert-danger" dir="rtl">
                            <p class="m-0 text-white">
                                اطلاعات شما رد شد!<br>
                                لطفا مجددا فرم را تکمیل کنید.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 m-0">
                            <form action="{{ route('MonetizeRequest') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-header p-2">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="mb-0 p-2">اطلاعات بانکی</h6>
                                            </div>
                                            <div class="col-4 d-flex" dir="rtl">
                                                <button type="submit" class="mb-0 btn btn-dark">ثبت اطلاعات
                                                    بانکی</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row" dir="rtl">
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="surname" class="form-label">نام:</label>
                                                    <input type="text" name="fname" class="form-control"
                                                        id="surname">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="lastname" class="form-label">نام خانوادگی:</label>
                                                    <input type="text" name="lname" class="form-control"
                                                        id="lastname">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="cnumber" class="form-label">شماره شناسنامه:</label>
                                                    <input type="text" name="cnumber" class="form-control"
                                                        id="cnumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="anumber" class="form-label">شماره حساب:</label>
                                                    <input type="text" name="anumber" class="form-control"
                                                        id="anumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="cardnumber" class="form-label">شماره کارت:</label>
                                                    <input type="text" name="cardnumber" class="form-control"
                                                        id="cardnumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="shaba" class="form-label">شماره شبا:</label>
                                                    <input type="text" name="shaba" class="form-control"
                                                        id="shaba">
                                                </div>
                                                <input type="hidden" name="artistID" value="{{ Auth::user()->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif ($confirmed == 3)
                    <div>
                        <div class="alert alert-primary" dir="rtl">
                            <p class="m-0 text-white">
                                لطفا مجددا فرم را تکمیل کنید.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 m-0">
                            <form action="{{ route('MonetizeRequest') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-header p-2">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="mb-0 p-2">اطلاعات بانکی</h6>
                                            </div>
                                            <div class="col-4 d-flex" dir="rtl">
                                                <button type="submit" class="mb-0 btn btn-dark">ثبت اطلاعات
                                                    بانکی</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row" dir="rtl">
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="surname" class="form-label">نام:</label>
                                                    <input type="text" name="fname" class="form-control"
                                                        id="surname">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="lastname" class="form-label">نام خانوادگی:</label>
                                                    <input type="text" name="lname" class="form-control"
                                                        id="lastname">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="cnumber" class="form-label">شماره شناسنامه:</label>
                                                    <input type="text" name="cnumber" class="form-control"
                                                        id="cnumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="anumber" class="form-label">شماره حساب:</label>
                                                    <input type="text" name="anumber" class="form-control"
                                                        id="anumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="cardnumber" class="form-label">شماره کارت:</label>
                                                    <input type="text" name="cardnumber" class="form-control"
                                                        id="cardnumber">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="shaba" class="form-label">شماره شبا:</label>
                                                    <input type="text" name="shaba" class="form-control"
                                                        id="shaba">
                                                </div>
                                                <input type="hidden" name="artistID" value="{{ Auth::user()->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </div>
@endsection
