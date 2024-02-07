@extends('layouts.userApp')
@php
    $id = null;
    if (isset($musicId))
        $id = $musicId;
@endphp

@section('content')
    <div>
        <h3 class="text__color__primary fs-1 mb-3">
            ساخت لیست پخش جدید:
        </h3>
        @livewire('playlist.create-play-list', ['musicId' => $id])
    </div>
@endsection
