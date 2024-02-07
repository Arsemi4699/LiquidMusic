@extends('layouts.adminApp')

@section('pageName')
    مدیریت ادمین ها
@endsection

@section('AdminsActive')
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
                        <h6 class="m-0">ادمین ها:</h6>
                        <a href="{{ route('admin.addNewAdmin') }}" class="btn btn-dark m-0">افزودن ادمین</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            نام</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ایمیل</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            سطح دسترسی</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $admin->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $admin->email }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            @if ($admin->role == 'super')
                                                                ویژه
                                                            @elseif ($admin->role == 'master')
                                                                عادی
                                                            @elseif ($admin->role == 'basic')
                                                                پایه
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex">
                                                <a href="{{ route('admin.editAdmin', ['id' => $admin->id]) }}"
                                                    class="text-decoration-none mx-3">
                                                    <span class="btn btn-primary mb-0">ویرایش</span>
                                                </a>
                                                @if ($admin->id != 1)
                                                    <form action="{{ route('admin.deleteAdmin') }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="id" value="{{ $admin->id }}">
                                                        <button type="submit"
                                                            onclick="return confirm('از حذف ادمین اطمینان دارید؟')"
                                                            class="btn btn-danger mb-0">حذف</button>
                                                    </form>
                                                @endif
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
