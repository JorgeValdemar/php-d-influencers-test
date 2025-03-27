<?php
 
namespace App\Repositories;

use App\Models\Campaigns;
use App\Models\InfluencersCampaigns;
use Exception;
use Illuminate\Support\Collection;
 
class CampaignsRepository extends Repository
{
    public function __construct(
    ){}
 
    /**
     * Summary of insertCampaign
     * @param array $data data to insert
     * @return int ID primary
     */
    public function insertCampaign(array $data): int
    {
        return Campaigns::insertGetId($data);
    }

    /**
     * Summary of listCampaigns
     * @return \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    public function listCampaigns(): Collection
    {
        return Campaigns::all(['id', 'name', 'budget', 'description', 'begin_date', 'end_date']);
    }

    /**
     * Summary of applyInfluencersToCampaign
     * @param array $data
     * @return bool
     */
    public function applyInfluencersToCampaign(array $data): bool
    {
        return InfluencersCampaigns::insert($data);
    }
    
    /**
     * Summary of listCampaignInfluencers
     * @param int $campaign_id
     * @return array
     */
    public function listCampaignInfluencers(int $campaignId): array
    {
        return Campaigns::where('campaigns.id', $campaignId)
            ->join('influencers_campaigns', 'influencers_campaigns.campaign_id', '=', 'campaigns.id')
            ->join('influencers', 'influencers.id', '=', 'influencers_campaigns.influencer_id')
            ->get(['influencers.id', 'influencers.name', 'influencers.instagram', 'influencers.qtd_followers', 'influencers.category'])
            ->toArray();
    }
}