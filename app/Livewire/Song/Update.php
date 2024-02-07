<?php

namespace App\Livewire\Song;

use Carbon\Carbon;
use App\Models\Song;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use wapmorgan\Mp3Info\Mp3Info;
use Illuminate\Support\Facades\Auth;


class Update extends Component
{
    use WithFileUploads;

    public $title;
    public ?\Illuminate\Http\UploadedFile $songFile = null; // Declare as nullable
    public ?\Illuminate\Http\UploadedFile $image = null;

    public $MusicId;
    public function update()
    {
        try {
            $song = Song::findOrFail($this->MusicId);
            if ($this->image) {
                $this->validate([
                    'image' => ['nullable', 'image', 'max:2048', 'dimensions:ratio=1/1'],
                ]);
                $imageName = 'img_' . Carbon::now()->microsecond . '.' . $this->image->extension();
                $this->image->storeAs('images/covers', $imageName, 'public');
                $song->update([
                    'img_path_name' => $imageName
                ]);
            }
            if ($this->songFile) {
                $this->validate([
                    'songFile' => ['nullable', 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav', 'max:51200'],
                ]);
                $songFileName = 'aud_' . Carbon::now()->microsecond . '.' . $this->songFile->extension();
                $this->songFile->storeAs('musics/songs', $songFileName, 'public');
                $audio = new Mp3Info('./storage/musics/songs/' . $songFileName);
                $song->update([
                    'file_path_name' => $songFileName,
                    'file_duration' => $audio->duration
                ]);
            }
            if ($this->title) {
                $song->update([
                    'name' => $this->title,
                ]);
            }
        } catch (\Throwable $th) {
            session()->flash('error', 'بروز رسانی موزیک با شکست مواجه شد!');
        }
        $this->redirect(route('musicCenter'));
    }
    public function mount($id)
    {
        $this->MusicId = $id;
    }

    public function render()
    {
        return view('livewire.song.update')->extends('layouts.studioApp')->section('PageContnet');
    }
}
