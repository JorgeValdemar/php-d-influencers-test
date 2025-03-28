<?php
 
namespace App\Services;

use App\Repositories\InfluencersRepository;
use Illuminate\Support\Facades\Validator;

 
class InfluencersService 
{
    public function __construct(
        private InfluencersRepository $influencersRepository
    ){}
 
    /**
     * Summary of saveInfluencers
     * @param array $data
     * @return array{id: int|mixed|\Illuminate\Http\JsonResponse}
     */
    public function saveInfluencers(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:30',
            'instagram' => 'required|string|max:30|unique:influencers',
            'qtd_followers' => 'required|numeric|min:0',
            'category' => 'required|in:Tecnologia,Beleza,Saúde'
        ]);
        
        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        $influencer = $this->influencersRepository->insertInfluencer($data);

        return ['influencer' => $influencer];
    }
    
    /**
     * Summary of listInfluencers
     * @return array
     */
    public function listInfluencers(): array
    {
        return $this->influencersRepository->listInfluencers()->toArray();
    }

    /**
     * Summary of applyCampaignsToInfluencer
     * @param array $data
     * @return array{error: string|array{error: \Illuminate\Support\MessageBag}|array{status: bool}}
     */
    public function applyCampaignsToInfluencer(array $data): array
    {
        $validator = Validator::make($data, [
            'influencer_id' => 'required|integer',
            'campaigns_ids' => 'required|array|min:1',
            'campaigns_ids.*' => 'integer|min:1'
        ]);
        
        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        try {
            $influencerId = $data['influencer_id'];
            $campaignsIds = $data['campaigns_ids'];
            $saveData = [];

            foreach($campaignsIds as $campaignId) {
                $saveData[] = [
                    'campaign_id' => $campaignId,
                    'influencer_id' => $influencerId
                ];
            }

            if($this->influencersRepository->applyCampaignsToInfluencer($saveData)) {
                return ['status' => true];
            }

            return ['error' => "Erro ao cadastrar vinculo"];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return ['error' => "Erro ao cadastrar vinculo"];
        }
    }
    
    /**
     * Summary of listInfluencerCampaigns
     * @param int $influencerId
     * @return array
     */
    public function listInfluencerCampaigns(int $influencerId): array
    {
        return $this->influencersRepository->listInfluencerCampaigns($influencerId);
    }
}