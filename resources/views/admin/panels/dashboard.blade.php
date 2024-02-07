@extends('layouts.adminApp')

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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">تعداد کل موزیک ها</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $totalMusic }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-album-2 text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">تعداد کل هنرمند ها</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $totalArtist }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-circle-08 text-lg opacity-10" aria-hidden="true"></i>
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
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">تعداد کل شنونده ها</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $totalUser }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-headphones text-lg opacity-10" aria-hidden="true"></i>
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
                                <h6>برترین موزیک های 30 روز اخیر:</h6>
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
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            هنرمند</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            بازدید</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            درصد علاقه مندی</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Musics as $Music)
                                        @php
                                            $viewCnt = $Music->total;

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
                                                        <img src="{{ asset('storage/images/covers/' . $Music->img) }}"
                                                            class="avatar avatar-sm me-3" alt="xd">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $Music->song_name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-center text-xs font-weight-bold"> {{ $Music->owner_name }}
                                                </span>
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
