<?php

namespace App\Livewire;

use App\Models\Song;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Search extends Component
{
    protected $debug = true;

    #[Modelable]
    public $searchQ = "";
    public $searchOn;
    public $result = [];

    public function mount($searchOn)
    {
        $this->$searchOn = $searchOn;
    }

    public function render()
    {
        if (strlen($this->searchQ) > 0)
        {
            if ($this->searchOn == 'artist')
            {
                $this->result = User::where('role', 3)
                ->where('name','like','%' . $this->searchQ . '%')
                ->limit(10)
                ->get();
            }
            elseif ($this->searchOn == 'music')
            {
                $this->result = DB::table('songs')
                ->join('users', 'songs.owner_id', '=' , 'users.id')
                ->select('users.role', 'songs.*')
                ->where('songs.name','like','%' . $this->searchQ . '%')
                ->where('users.role', 'artist')
                ->limit(10)
                ->get();
            }

        }
        return view('livewire.search');
    }
}
