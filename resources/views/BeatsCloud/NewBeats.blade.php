@extends('layouts.userApp')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <h3 class="text__color__primary fs-1 mb-3">
            افزودن به بیتس کلود:
            </h3>
        </div>
        <div class="p-3">
            @livewire("beatsCloud.beats-add")
        </div>

    </div>
@endsection
