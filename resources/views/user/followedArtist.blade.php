@extends('layouts.userApp')

@section('content')
    <div>
        <h3 class="text__color__primary fs-1 mb-3">هنرمندان دنبال شده:</h3>
        @foreach ($Followed as $Artist)
        <a  wire:navigate href="{{ route('user.artistShow',['id' => $Artist->id]) }}" dir="ltr" class="list_result_item">
            <div class="list_result_item_info">
                <img class="list_result_item_avatar" src="{{ asset('storage/images/avatars/' . $Artist->file_path_profile_img) }}" alt="">
                <p class="text__color__primary fs-5 lh-sm">{{ $Artist->name }}</p>
            </div>
        </a>
        @endforeach
    </div>
@endsection
