<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAcc extends Model
{
    use HasFactory;

    protected $table = "artist_bank";
    protected $primaryKey = 'artist_id';
    public $incrementing = false;
    protected $guarded = [];

    public function artist()
    {
        return $this->hasOne(User::class, 'id', 'artist_id');
    }
}
