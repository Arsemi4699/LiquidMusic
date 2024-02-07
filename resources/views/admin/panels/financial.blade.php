<?php
use App\Models\User;
?>
@extends('layouts.adminApp')

@section('pageName')
    امور مالی
@endsection

@section('BankActive')
    active
@endsection

@section('PageContnet')
    <div>
        @if (session('success'))
            <div class="alert alert-success" dir="rtl">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" dir="rtl">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center p-3" dir="rtl">
                        <h6 class="m-0">درخواست های درآمدزایی</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            کد ملی
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            نام و نام خانوادگی
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره حساب
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره کارت
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره شبا
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($BankRequests as $BankRequest)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $BankRequest->CID }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $BankRequest->ownerFName }}
                                                            {{ $BankRequest->ownerLName }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $BankRequest->accountNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $BankRequest->BankCardNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $BankRequest->ShabaNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex gap-2">
                                                <form action="{{ route('admin.AcceptBank') }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id"
                                                        value="{{ $BankRequest->artist_id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از پذیرش حساب بانکی اطمینان دارید؟')"
                                                        class="btn btn-success mb-0">پذیرش</button>
                                                </form>
                                                <form action="{{ route('admin.RejectBank') }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id"
                                                        value="{{ $BankRequest->artist_id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از رد حساب بانکی اطمینان دارید؟')"
                                                        class="btn btn-danger mb-0"> لغو </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center p-3" dir="rtl">
                        <h6 class="m-0">درخواست های واریز</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            نام و نام خانوادگی
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره حساب
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره کارت
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            شماره شبا
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            مبلغ (تومان)
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($PayoffRequests as $PayoffRequest)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $PayoffRequest->ownerFName }}
                                                            {{ $PayoffRequest->ownerLName }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $PayoffRequest->accountNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $PayoffRequest->BankCardNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $PayoffRequest->ShabaNum }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $PayoffRequest->money }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex gap-2">
                                                <form action="{{ route('admin.AcceptPayoff') }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="id" value="{{ $PayoffRequest->id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از پذیرش حساب بانکی اطمینان دارید؟')"
                                                        class="btn btn-success mb-0">تایید</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center p-3" dir="rtl">
                        <h6 class="m-0">
                            گزارش پرداخت های شنوندگان
                        </h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            نام کاربری
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ایمیل
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ایتم خریداری شده
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            توکن
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            وضعیت
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            مبلغ (تومان)
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            تاریخ ثبت
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            تاریخ ویرایش
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ User::find($transaction->user_id)->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ User::find($transaction->user_id)->email }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            @if ($transaction->plan_item_id != null)
                                                                اشتراک سرویس:
                                                                {{ DB::table('sub_plans')->find($transaction->plan_item_id)->name }}
                                                            @elseif ($transaction->beatsPack_item_id != null)
                                                                بیتس کلود:
                                                                {{ DB::table('beats_pack')->find($transaction->beatsPack_item_id)->name }}
                                                            @else
                                                                حذف شده
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->token }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6
                                                            class="mb-0 text-sm @if ($transaction->status == 1) text-success
                                                        @else
                                                            text-danger @endif">
                                                            @if ($transaction->status == 1)
                                                                انجام شده
                                                            @else
                                                                ناتمام
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->price_T }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->created_at }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $transaction->updated_at }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="m-2 d-flex align-items-center justify-content-center">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
