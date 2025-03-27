<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $table = "campaigns";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        "name",
        "budget",
        "description",
        "begin_date",
        "end_date"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];
}
