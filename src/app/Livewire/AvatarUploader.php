<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ProfileForm extends Component
{
    use WithFileUploads;

    public $avatar;         // アップロードされた一時ファイル
    public $user_name;
    public $zip_code;
    public $address;
    public $building;

    public $currentAvatarUrl; // 既存画像表示用（DBの値）

    public function mount()
    {
        $profile = Auth::user()->profile;

        $this->currentAvatarUrl = $profile?->avatar_url;

        $this->user_name = $profile?->user_name ?? '';
        $this->zip_code  = $profile?->zip_code ?? '';
        $this->address   = $profile?->address ?? '';
        $this->building  = $profile?->building ?? '';
    }

    protected function rules()
    {
        return [
            'avatar'    => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
            'user_name' => ['required', 'string', 'max:20'],
            'zip_code'  => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'   => ['required', 'string'],
            'building'  => ['nullable', 'string'],
        ];
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        $data = [
            'user_name' => $this->user_name,
            'zip_code'  => $this->zip_code,
            'address'   => $this->address,
            'building'  => $this->building,
        ];

        // 画像が選択された時だけ保存・更新
        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $data['avatar_url'] = $path;
        }

        $user->profile()->updateOrCreate([], $data);

        // 画面反映用（保存後のDBパスを現在画像として採用）
        if (isset($data['avatar_url'])) {
            $this->currentAvatarUrl = $data['avatar_url'];
        }

        // 一時ファイルをクリア（任意）
        $this->reset('avatar');

        session()->flash('status', '更新しました');
    }

    public function render()
    {
        return view('livewire.profile-form');
    }
}