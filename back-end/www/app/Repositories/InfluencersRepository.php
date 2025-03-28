<?php
 
namespace App\Repositories;

use App\Models\Influencers;
use App\Models\InfluencersCampaigns;
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
    
    /**
     * Summary of applyCampaignsToInfluencer
     * @param array $data
     * @return bool
     */
    public function applyCampaignsToInfluencer(array $data): bool
    {
        return InfluencersCampaigns::insert($data);
    }
    
    /**
     * Summary of listInfluencerCampaigns
     * @param int $influencerId
     * @return array
     */
    public function listInfluencerCampaigns(int $influencerId): array
    {
        return Influencers::where('influencers.id', $influencerId)
            ->join('influencers_campaigns', 'influencers_campaigns.influencer_id', '=', 'influencers.id')
            ->join('campaigns', 'campaigns.id', '=', 'influencers_campaigns.campaign_id')
            ->get(['campaigns.id', 'campaigns.name', 'campaigns.budget', 'campaigns.description', 'campaigns.begin_date', 'campaigns.end_date'])
            ->toArray();
    }
}