@extends('layouts.userApp')

@section('content')
    <div>
        <div class="d-flex justify-content-between align-items-center p-3">
            <div>
                <h3 class="text__color__primary fs-1 mb-3">بیتس کلود:</h3>
            </div>
            <a wire:navigate href="{{ route('NewBeats') }}" class="xxl-d-block xxl-w-100 text-decoration-none">
                <button class="static__new__playlist__btn fs-4">موزیک جدید</button>
                <div>
                    <i class="bi bi-plus-square-fill new__playlist__btn__i fs-1 text__color__primary"></i>
                </div>
            </a>
        </div>
        <div class="alert alert-primary p-3">
            <span class="text-dark fs-3 mb-3">کل فضا / استفاده شده: </span>
            <span class="text-dark fs-3 mb-3">{{$usedSpace}}/{{$cloudSize}}</span>
        </div>
        @if(session('CloudOutOfSize'))
            <div class="alert alert-danger">
                {{ session('CloudOutOfSize') }}
            </div>
        @endif
        <section>
            <h4 class="text__color__primary fs-2 mb-3 p-3">
                افزایش ظرفیت:
            </h4>
            <div class="d-flex gap-3 align-items-center justify-content-center flex-column flex-md-row flex-wrap">
                @foreach ($BeatsPack as $pack)
                    <div class="beatsPack">
                        <div class="beatsPack__info">
                            <h4 class="mb-1 fw-bold fs-4 p-0" >{{$pack->name}}</h4>
                            <h4 class="mb-1 fs-4">قیمت:</h4>
                            <h4 class="mb-1 fs-4">{{ $pack->price_T }} تومان </h4>
                            <h4 class="mb-1 fs-4">مدت زمان:</h4>
                            <h4 class="mb-1 fs-4">{{ $pack->pack_size}} تا </h4>
                            <form action="{{route('payment') }}"" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $pack->id }}">
                                <input type="hidden" name="type" value="beatsPack">
                                <button type="submit" class="w-100 btn btn-success">خرید</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section>
            <ul class="p-0">
                @foreach ($MusicsInBeats as $Music)
                    <li wire:key="{{$Music->id}}">
                        @livewire('ListItem', ['type' => 'beatsItem', 'item' => $Music, "list" => $ListOfIdsforMusicList], key('mucom-' . Carbon\Carbon::now()->microsecond))
                    </li>
                @endforeach
            </ul>
        </section>

        <div>
        </div>
    </div>
@endsection
