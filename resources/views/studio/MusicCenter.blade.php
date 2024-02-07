@extends('layouts.studioApp')

@section('pageName')
    مدیریت موزیک
@endsection

@section('MusicCenterActive')
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
                        <h6 class="m-0">موزیک ها:</h6>
                        <a href="{{ route('song.create') }}" class="btn btn-dark m-0">افزودن موزیک</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            موزیک</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ArtistMusics as $Music)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/images/covers/' . $Music->img_path_name) }}"
                                                            class="avatar avatar-md me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $Music->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl" class="d-flex">
                                                <a href="{{ route('song.update', ['id' => $Music->id]) }}"
                                                    class="text-decoration-none mx-3">
                                                    <span class="btn btn-primary">بروزرسانی</span>
                                                </a>
                                                <form action="{{ route('studioDeleteMusic', ['id' => $Music->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        onclick="return confirm('از حذف موزیک اطمینان دارید؟')"
                                                        class="btn btn-danger">حذف</button>
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
