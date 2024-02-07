<div>
    <div>
        <div>
            <form wire:submit.prevent="store">
                <div class="form-group">
                    <label for="title" class="text__color__primary fs-2">عنوان:</label>
                    <div class="d-flex justify-content-start gap-2 align-items-center">
                        <input wire:model="title" type="text" name="title" id="title"  class="w-75 p-2 form-control @error('title') red-alert-border @enderror" value="{{ old('title') }}">
                        <button class="btn btn-light p-0 px-2 align-self-stretch lh-sm fs-2" type="submit">ثبت</button>
                    </div>
                    @error('title')
                        <p class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </p>
                    @enderror
                </div>

            </form>
        </div>
    </div>
</div>
