<div class="row m-4" dir="rtl">
    @section('MusicCenterActive')
        active
    @endsection
    <div class="col-md-6 offset-md-3">
        <h4 class="mb-3">بروزرسانی آهنگ : </h4>
        <p>در صورتی که قصد تغییر بخشی را ندارید آن را خالی بگذارید!</p>
        <form wire:submit.prevent="update">
            <div class="mb-3">
                <label class="form-label">عنوان</label>
                <input wire:model="title" type="text" class="form-control">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">فایل موزیک</label>
                <input class="form-control" wire:model="songFile" type="file" id="formFile">
                @error('songFile')
                    <label class="form-text text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div wire:loading wire:target="songFile">
                درحال آپلود موزیک...
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">کاور موزیک</label>
                <input class="form-control" wire:model="image" type="file" id="formFile">
                @error('image')
                    <label class="form-text text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div wire:loading wire:target="image">
                درحال آپلود تصویر...
            </div>
            @php
                $url = null;
                try {
                    $url = $image->temporaryUrl();
                } catch (\Throwable $th) {
                    $url = null;
                }
            @endphp
            @if ($url)
                <div class="mb-1">
                    پیشنمایش کاور:
                    <br>
                    <img width="200" src="{{ $image->temporaryUrl() }}" alt="">
                </div>
            @endif

            <button type="submit" wire:loading.attr="disabled" wire:target="image" class="btn btn-primary">
                بروزرسانی
                <div wire:loading wire:target="update">
                    <div class="spinner-border spinner-border-sm"></div>
                </div>
            </button>
        </form>
    </div>
</div>
