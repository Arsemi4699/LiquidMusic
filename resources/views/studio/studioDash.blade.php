@extends('layouts.studioApp')

@section('pageName')
    داشبورد
@endsection

@section('DashActive')
    active
@endsection

@section('PageContnet')
    <div>
        <div class="row" dir="rtl">
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">درآمد کل</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $balance }} تومان
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">دنبال کننده ها</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $Artistfollowers }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">بازدید 30 روزه اخیر</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $lastMViews }}
                                        <span
                                            class="@if ($growingRateViews == 0) text-muted @elseif ($growingRateViews > 0) text-success @else text-danger @endif text-sm font-weight-bolder">{{ $growingRateViews }}%</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header p-3" dir="rtl">
                        <div class="row">
                            <div class="col">
                                <h6>آمار موزیک های شما:</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            موزیک</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            بازدید</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            درصد علاقه مندی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ArtistMusics as $Music)
                                        @php
                                            $viewCnt = DB::table('views')
                                                ->where('music_id', $Music->id)
                                                ->count();

                                            $LikeCnt = DB::table('likes')
                                                ->where('music_id', $Music->id)
                                                ->count();

                                            $likePerc = 0;
                                            if ($viewCnt > 0) {
                                                $likePerc = ($LikeCnt / $viewCnt) * 100;
                                            }

                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/images/covers/' . $Music->img_path_name) }}"
                                                            class="avatar avatar-sm me-3" alt="xd">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $Music->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold"> {{ $viewCnt }} </span>
                                            </td>
                                            <td class="align-middle">
                                                <div class="progress-wrapper mx-auto">
                                                    <div class="progress-info">
                                                        <div class="progress-percentage text-center">
                                                            <span
                                                                class="text-xs font-weight-bold">{{ $likePerc }}%</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mx-auto">
                                                        <div class="progress-bar bg-gradient-info w-{{ $likePerc }}"
                                                            role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
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
