<?php

namespace App\Http\Controllers;

use App\Services\CampaignsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CampaignsController extends Controller
{
    function __construct(
        private CampaignsService $campaignsService
    ){}

    public function saveCampaign(Request $request): JsonResponse
    {
        $response = $this->campaignsService->saveCampaign($request->all());
        return parent::responseSuccess($response);
    }
    
    public function listCampaign(): JsonResponse
    {
        $response = $this->campaignsService->listCampaigns();
        return parent::responseSuccess($response);
    }
    
    public function applyInfluencersToCampaign(Request $request): JsonResponse
    {
        $response = $this->campaignsService->applyInfluencersToCampaign($request->all());
        return parent::responseSuccess($response);
    }
    
    public function listCampaignInfluencers(int $campaignId): JsonResponse
    {
        $response = $this->campaignsService->listCampaignInfluencers($campaignId);
        return parent::responseSuccess($response);
    }
}
