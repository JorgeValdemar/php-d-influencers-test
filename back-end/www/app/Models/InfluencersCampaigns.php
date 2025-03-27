<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfluencersCampaigns extends Model
{
    protected $table = "influencers_campaigns";

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
