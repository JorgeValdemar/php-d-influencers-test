<?php
 
namespace App\Repositories;

use App\Models\Influencers;
use Illuminate\Support\Collection;

class InfluencersRepository extends Repository
{ 
    /**
     * Summary of insertInfluencer
     * @param array $data
     * @return int
     */
    public function insertInfluencer(array $data): Influencers
    {
        return Influencers::create($data);
    }

    /**
     * Summary of listInfluencers
     * @return \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    public function listInfluencers(): Collection
    {
        return Influencers::all(['id', 'name', 'instagram', 'qtd_followers', 'category']);
    }
}