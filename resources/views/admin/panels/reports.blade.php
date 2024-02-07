@php
    use App\Models\Song;
@endphp

@extends('layouts.adminApp')

@section('pageName')
    گزارشات
@endsection

@section('ReportActive')
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
                        <h6 class="m-0">گزارش ها:</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            موزیک</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            نوع</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            سطح</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            توضیحات</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            تاریخ</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            فایل صوتی</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">
                                            عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allReports as $report)
                                        @php
                                            $music = Song::find($report->music_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/images/covers/' . $music->img_path_name) }}"
                                                            class="avatar avatar-md me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $music->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            @if ($report->type == 'Copyright')
                                                                نقض کپی رایت
                                                            @elseif ($report->type == 'ChildAbuse')
                                                                کودک آزاری
                                                            @elseif ($report->type == 'Violence')
                                                                خشونت شدید
                                                            @elseif ($report->type == 'Unethical')
                                                                غیر اخلاقی
                                                            @elseif ($report->type == 'Other')
                                                                سایر موارد
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            @if ($report->level == 'high')
                                                                بالا
                                                            @elseif ($report->level == 'medium')
                                                                متوسط
                                                            @elseif ($report->level == 'low')
                                                                پایین
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $report->info }}
                                                            @if ($report->info == null)
                                                                ندارد
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{ $report->created_at }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <audio controls>
                                                            <source
                                                                src="{{ asset('storage/musics/songs/' . $music->file_path_name) }}">
                                                        </audio>
                                                    </div>
                                                </div>
                                            </td>
                                            <td dir="rtl">
                                                <form action="{{ route('admin.DeleteReportedMusic') }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $report->music_id }}">
                                                    <button type="submit"
                                                        onclick="return confirm('از حذف آهنگ اطمینان دارید؟')"
                                                        class="btn btn-danger mb-0">حذف آهنگ</button>
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
