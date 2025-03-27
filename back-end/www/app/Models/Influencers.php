<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Influencers extends Model
{
    protected $table = "influencers";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
