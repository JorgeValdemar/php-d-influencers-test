<?php

namespace Tests\Feature;

use App\Models\Campaigns;
use App\Models\Influencers;
use App\Models\InfluencersCampaigns;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignsTest extends TestCase
{
    use RefreshDatabase;

    private $campaigns = [
        "name" => "Campanha expressa phpunit",
        "budget" => 19.90,
        "begin_date"=>"2024-12-05",
        "end_date"=>"2024-12-24"
    ];
    private $influencer = [
        "name" => "Influencer phpunit",
        "instagram" => "#super_phpunit",
        "qtd_followers" => 216,
        "category" => "Tecnologia"
    ];
    
    public function test_register_success(): void
    {
        $token = parent::getToken();
        $response = $this->post(route('campaigns.save', $this->campaigns),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson([
            "campaign" => [
                "name" => true,
                "budget" => true,
                "begin_date" => true,
                "end_date" => true,
                "updated_at" => true,
                "created_at" => true,
                "id" => true
            ]
        ]);
    }
    
    public function test_register_failed(): void
    {
        $token = parent::getToken();
        $response = $this->post(route('campaigns.save', []),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson([
            "error" => [
                "name" => true,
                "budget" => true,
                "begin_date" => true,
                "end_date" => true
            ]
        ]);
    }
    
    public function test_apply_success_two_campaigns(): void
    {
        $token = parent::getToken();
        $influencerSave = $this->influencer;
        $influencerSave['instagram'] = $influencerSave['instagram'] . '_two_campaigns';

        $campaign = Campaigns::create($this->campaigns);
        $campaign2 = Campaigns::create($this->campaigns);
        $influencer = Influencers::create($influencerSave);

        $response = $this->post(route('campaigns.influencers.apply', [
            "campaign_id" => $campaign->id,
            "influencers_ids" => [$influencer->id]
        ]),[], ['Authorization' => "Bearer ". $token]);
        
        $response2 = $this->post(route('campaigns.influencers.apply', [
            "campaign_id" => $campaign2->id,
            "influencers_ids" => [$influencer->id]
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson(["status" => true]);
        $response2->assertStatus(200)->assertJson(["status" => true]);
    }
    
    public function test_apply_success_two_influencers(): void
    {
        $token = parent::getToken();
        $influencer = $this->influencer;
        $influencer['instagram'] = $influencer['instagram'] . "_i_one";
        
        $influencer2 = $this->influencer;
        $influencer2['instagram'] = $influencer2['instagram'] . "_i_two";

        $campaign = Campaigns::create($this->campaigns);
        $influencers = [];
        $influencers[] = Influencers::insertGetId($influencer);
        $influencers[] = Influencers::insertGetId($influencer2);

        $response = $this->post(route('campaigns.influencers.apply', [
            "campaign_id" => $campaign->id,
            "influencers_ids" => $influencers
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson(["status" => true]);
    }
    
    public function test_apply_duplicated(): void
    {
        $token = parent::getToken();
        $influencer = $this->influencer;
        $influencer['instagram'] = $influencer['instagram'] . "_duplicated";

        $campaign = Campaigns::create($this->campaigns);
        $influencer = Influencers::create($influencer);

        $response = $this->post(route('campaigns.influencers.apply', [
            "campaign_id" => $campaign->id,
            "influencers_ids" => [$influencer->id]
        ]),[], ['Authorization' => "Bearer ". $token]);
        
        $response2 = $this->post(route('campaigns.influencers.apply', [
            "campaign_id" => $campaign->id,
            "influencers_ids" => [$influencer->id]
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson(["status" => true]);
        $response2->assertStatus(200)->assertJson(["error" => "Erro ao cadastrar vinculo"]);
    }
}
