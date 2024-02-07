@extends('layouts.studioApp')

@section('pageName')
    پروفایل
@endsection

@section('ProfileActive')
    active
@endsection


@section('PageContnet')
    <div class="container-fluid">
        <div class="row">
            <div class="page-header min-height-200 border-radius-xl mt-4"
                style="background-image: url('{{ asset('images/studio/profileCoverBg.jpg') }}'); background-position-y: 40%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('storage/images/avatars/' . $artist->file_path_profile_img) }}"
                                alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $artist->name }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm" dir="ltr">
                                دنبال کننده {{ $followers }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="d-flex flex-column gap-2">
                            <button
                                onclick="document.getElementById('ChangeProfImgRow').classList.toggle('d-none'); if(!document.getElementById('ChangeProfNameRow').classList.contains('d-none')) document.getElementById('ChangeProfNameRow').classList.add('d-none');
                                        "
                                class="btn btn-dark mb-0">
                                <span>تغییر تصویر پروفایل</span>
                            </button>
                            <button
                                onclick="document.getElementById('ChangeProfNameRow').classList.toggle('d-none'); if(!document.getElementById('ChangeProfImgRow').classList.contains('d-none')) document.getElementById('ChangeProfImgRow').classList.add('d-none');"
                                class="btn btn-dark mb-0">
                                <span>تغییر نام</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2 d-none" id="ChangeProfNameRow">
            <div class="card card-body mx-4" dir="rtl">
                <form action="{{ route('studioProfileUpdateName') }}" method="post"
                    class="d-flex gap-1 justify-content-start align-items-center">
                    @csrf
                    @method('put')
                    <div>
                        <div class="d-flex align-items-center gap-1">
                            <label for="fromText" class="fs-6 m-0 text-nowrap">نام جدید: </label>
                            <input type="text" name="name" class="fs-6 form-control p-1" id="fromText">
                        </div>
                    </div>
                    <button type="submit" class="btn p-1 btn-primary m-0">
                        بروزرسانی
                    </button>
                    @error('name')
                        <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </form>
            </div>
        </div>
        <div class="row mt-2 d-none" id="ChangeProfImgRow">
            <div class="card card-body mx-4" dir="rtl">
                <form action="{{ route('studioProfileUpdateImg') }}" enctype="multipart/form-data" method="post"
                    class="d-flex gap-1 justify-content-start align-items-center">
                    @csrf
                    @method('put')
                    <div>
                        <div class="d-flex align-items-center gap-1">
                            <label for="formFile" class="fs-6 m-0 text-nowrap">تصویر جدید: </label>
                            <input dir="ltr" name="image" class="fs-6 form-control p-1" type="file"
                                id="formFile">
                        </div>
                        @error('image')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn p-1 btn-primary m-0">
                        بروزرسانی
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
