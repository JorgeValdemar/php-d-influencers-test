<?php

namespace App\Http\Controllers;

use App\Services\InfluencersService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class InfluencersController extends Controller
{
    function __construct(
        private InfluencersService $influencersService
    ){}

    public function saveInfluencers(Request $request): JsonResponse
    {
        $response = $this->influencersService->saveInfluencers($request->all());
        return parent::responseSuccess($response);
    }
    
    public function listInfluencers(): JsonResponse
    {
        $response = $this->influencersService->listInfluencers();
        return parent::responseSuccess($response);
    }
    public function applyCampaignsToInfluencer(Request $request): JsonResponse
    {
        $response = $this->influencersService->applyCampaignsToInfluencer($request->all());
        return parent::responseSuccess($response);
    }
    
    public function listInfluencerCampaigns(int $influencerId): JsonResponse
    {
        $response = $this->influencersService->listInfluencerCampaigns($influencerId);
        return parent::responseSuccess($response);
    }
}
