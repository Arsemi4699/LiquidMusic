@extends('layouts.adminApp')

@section('pageName')
    مدیریت اشتراک ها
@endsection

@section('PlansActive')
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
                        <h6 class="m-0">بسته های اشتراک سرویس:</h6>
                        <a href="{{ route('admin.addNewPlans') }}" class="btn btn-dark m-0">افزودن بسته</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            عنوان</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            قیمت (تومان)</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            مدت (روز)</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plans as $plan)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $plan->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $plan->price_T }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $plan->duration_D }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex">
                                                <a href="{{ route('admin.editPlans', ['id' => $plan->id]) }}"
                                                    class="text-decoration-none mx-3">
                                                    <span class="btn btn-primary mb-0">ویرایش</span>
                                                </a>
                                                <form action="{{ route('admin.deletePlans') }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $plan->id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از حذف بسته اطمینان دارید؟')"
                                                        class="btn btn-danger mb-0">حذف</button>
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
                        <h6 class="m-0">بسته های سرویس بیتس کلود:</h6>
                        <a href="{{ route('admin.addNewPacks') }}" class="btn btn-dark m-0">افزودن بسته</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            عنوان</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            قیمت (تومان)</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            مدت (روز)</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packs as $pack)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pack->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $pack->price_T }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $pack->pack_size }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex">
                                                <a href="{{ route('admin.editPacks', ['id' => $pack->id]) }}"
                                                    class="text-decoration-none mx-3">
                                                    <span class="btn btn-primary mb-0">ویرایش</span>
                                                </a>
                                                <form action="{{ route('admin.deletePacks') }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $pack->id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از حذف بسته اطمینان دارید؟')"
                                                        class="btn btn-danger mb-0">حذف</button>
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
    </div>
@endsection
