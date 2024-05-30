<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payoff extends Model
{
    protected $table = "payoffs";
    protected $guarded = [];

    use HasFactory;
}
