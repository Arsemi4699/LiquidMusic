<div class="row">
    <div class="col-md-6 offset-md-3">
        <form wire:submit.prevent="create">
            <div class="mb-3">
                <label class="form-label text__color__primary fs-3">عنوان</label>
                <input wire:model="title" type="text" class="form-control">
                @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label text__color__primary fs-3">فایل موزیک</label>
                <input class="form-control" wire:model="songFile" type="file" id="formFile">
                @error('songFile')
                    <label class="form-text text-danger">{{ $message }}</label>
                @enderror
            </div>
            <div wire:loading wire:target="songFile">
                <span class="text__color__side fs-5">
                    در حال آپلود موزیک...
                </span>
            </div>
            {{-- @if ($songFile)
                <div>
                    <span class="text__color__side fs-5">
                        پیش نمایش آهنگ:
                    </span>
                    <br>
                    <audio controls>
                        <source src="{{ $songFile->temporaryUrl() }}">
                    </audio>
                </div>
            @endif --}}

            <div class="mb-3">
                <label for="formFile" class="form-label text__color__primary fs-3">کاور موزیک</label>
                <input class="form-control" wire:model="image" type="file" id="formFile">
                @error('image')
                    <label class="form-text text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div wire:loading wire:target="image">
                <span class="text__color__side fs-5">
                    در حال آپلود تصویر...
                </span>
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

            <button type="submit" wire:loading.attr="disabled" wire:target="image" class="btn btn-light mt-1 fs-5">
                افزودن آهنگ
                <div wire:loading wire:target="create">
                    <div class="spinner-border spinner-border-sm"></div>
                </div>
            </button>
        </form>
    </div>
</div>
