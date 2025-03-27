<?php
 
namespace App\Services;

use App\Repositories\CampaignsRepository;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;

 
class CampaignsService 
{
    public function __construct(
        private CampaignsRepository $campaignsRepository
    ){}

    /**
     * Summary of saveCampaign
     * @param array $data
     * @return array{id: int|mixed|\Illuminate\Http\JsonResponse}
     */
    public function saveCampaign(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:30',
            'budget' => 'required|numeric|min:0',
            'description' => 'string|max:40',
            'begin_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d|after:begin_date'
        ]);
        
        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        $campaign = $this->campaignsRepository->insertCampaign($data);

        return ['campaign' => $campaign];
    }
    
    /**
     * Summary of listCampaigns
     * @return array
     */
    public function listCampaigns(): array
    {
        return $this->campaignsRepository->listCampaigns()->toArray();
    }
    
    /**
     * Summary of applyInfluencersToCampaign
     * @param array $data
     * @throws \Exception
     * @return bool|mixed|\Illuminate\Http\JsonResponse
     */
    public function applyInfluencersToCampaign(array $data): array
    {
        $validator = Validator::make($data, [
            'campaign_id' => 'required|integer',
            'influencers_ids' => 'required|array|min:1',
            'influencers_ids.*' => 'integer|min:1'
        ]);
        
        if($validator->fails()){
            return ['error' => $validator->errors()];
        }

        try {
            $campaignId = $data['campaign_id'];
            $influencersIds = $data['influencers_ids'];
            $saveData = [];

            foreach($influencersIds as $influencer_id) {
                $saveData[] = [
                    'campaign_id' => $campaignId,
                    'influencer_id' => $influencer_id
                ];
            }

            if($this->campaignsRepository->applyInfluencersToCampaign($saveData)) {
                return ['status' => true];
            }

            return ['error' => "Erro ao cadastrar vinculo"];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['error' => "Erro ao cadastrar vinculo"];
        }
    }
    
    /**
     * Summary of listCampaignInfluencers
     * @param int $campaignId
     * @return array
     */
    public function listCampaignInfluencers(int $campaignId): array
    {
        return $this->campaignsRepository->listCampaignInfluencers($campaignId);
    }
}