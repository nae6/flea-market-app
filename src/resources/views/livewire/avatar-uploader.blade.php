<div class="profile-form">
    <form class="form" wire:submit.prevent="save" enctype="multipart/form-data" novalidate>
        <div class="form__img">
            <div class="profile-img" id="avatar-preview" style="
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-image:
                    @if ($avatar)
                        url('{{ $avatar->temporaryUrl() }}')
                    @elseif ($currentAvatarUrl)
                        url('{{ asset('storage/'.$currentAvatarUrl) }}')
                    @else
                        none
                    @endif">
            </div>

            <input type="file" wire:model="avatar" id="avatar" hidden accept="image/jpeg,image/png">
            <label for="avatar" class="img-select">画像を選択する</label>

            @error('avatar') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__group">
            <label class="form__label">ユーザー名</label>
            <div class="form__content">
                <input type="text" wire:model.defer="user_name">
            </div>
            @error('user_name') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <div class="form__content">
                <input type="text" wire:model.defer="zip_code">
            </div>
            @error('zip_code') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__group">
            <label class="form__label">住所</label>
            <div class="form__content">
                <input type="text" wire:model.defer="address">
            </div>
            @error('address') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__group">
            <label class="form__label">建物名</label>
            <div class="form__content">
                <input type="text" wire:model.defer="building">
            </div>
            @error('building') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__btn">
            <button class="form__btn-submit" type="submit">更新する</button>
        </div>

        @if (session('status'))
            <p class="form__success">{{ session('status') }}</p>
        @endif
    </form>
</div>