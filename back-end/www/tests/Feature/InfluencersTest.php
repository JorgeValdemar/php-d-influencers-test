<?php

namespace Tests\Feature;

use App\Models\Campaigns;
use App\Models\Influencers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InfluencersTest extends TestCase
{
    use RefreshDatabase;
    
    private $influencer = [
        "name" => "Influencer phpunit",
        "instagram" => "#super_phpunit",
        "qtd_followers" => 216,
        "category" => "Tecnologia"
    ];

    private $campaigns = [
        "name" => "Campanha expressa phpunit",
        "budget" => 19.90,
        "begin_date"=>"2024-12-05",
        "end_date"=>"2024-12-24"
    ];

    public function test_register_success(): void
    {
        $token = parent::getToken();

        $response = $this->post(route('influencers.save', $this->influencer),[], ['Authorization' => "Bearer ". $token]);

        $response->assertJson([
            "influencer" => [
                "name" => true,
                "instagram" => true,
                "qtd_followers" => true,
                "category" => true,
                "updated_at" => true,
                "created_at" => true,
                "id" => true
            ]
        ]);
    }

    public function test_register_failed(): void
    {
        $token = parent::getToken();

        $response = $this->post(route('influencers.save', []),[], ['Authorization' => "Bearer ". $token]);

        $response->assertJson([
            "error" => [
                "name" => true,
                "instagram" => true,
                "qtd_followers" => true,
                "category" => true
            ]
        ]);
    }
    
    public function test_register_instagram_failed(): void
    {
        $token = parent::getToken();

        $response = $this->post(route('influencers.save', $this->influencer),[], ['Authorization' => "Bearer ". $token]);
        
        $influencer2 = [
            "name" => "Influencer instagran duplicado phpunit",
            "instagram" => $this->influencer['instagram'],
            "qtd_followers" => 3,
            "category" => "Tecnologia"
        ];

        $response2 = $this->post(route('influencers.save', $influencer2),[], ['Authorization' => "Bearer ". $token]);

        $response2->assertJson(
            [
                "error" => [
                    "instagram" => [
                        "O instagram já está em uso."
                    ]
                ]
            ]
        );
    }

    /**
     * Testa aplicar uma campanha em dois profissionais
     * @return void
     */
    public function test_apply_success_two_influencers(): void
    {
        $token = parent::getToken();
        $influencer = $this->influencer;
        $influencer['instagram'] = $influencer['instagram'] . "_i_one";
        
        $influencer2 = $this->influencer;
        $influencer2['instagram'] = $influencer2['instagram'] . "_i_two";

        $campaign = Campaigns::create($this->campaigns);
        $influencerId1 = Influencers::insertGetId($influencer);
        $influencerId2 = Influencers::insertGetId($influencer2);

        $response = $this->post(route('influencers.campaigns.apply', [
            "influencer_id" => $influencerId1,
            "campaigns_ids" => [$campaign->id]
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response2 = $this->post(route('influencers.campaigns.apply', [
            "influencer_id" => $influencerId2,
            "campaigns_ids" => [$campaign->id]
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson(["status" => true]);
        $response2->assertStatus(200)->assertJson(["status" => true]);
    }
    

    public function test_apply_success_two_campaigns(): void
    {
        $token = parent::getToken();
        $influencerSave = $this->influencer;
        $influencerSave['instagram'] = $influencerSave['instagram'] . '_two_campaigns';

        $influencer = Influencers::create($influencerSave);
        
        $campaigns = [];
        $campaigns[] = Campaigns::insertGetId($this->campaigns);
        $campaigns[] = Campaigns::insertGetId($this->campaigns);

        $response = $this->post(route('influencers.campaigns.apply', [
            "influencer_id" => $influencer->id,
            "campaigns_ids" => $campaigns
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

        $response = $this->post(route('influencers.campaigns.apply', [
            "influencer_id" => $influencer->id,
            "campaigns_ids" => [$campaign->id]
        ]),[], ['Authorization' => "Bearer ". $token]);
        
        $response2 = $this->post(route('influencers.campaigns.apply', [
            "influencer_id" => $influencer->id,
            "campaigns_ids" => [$campaign->id]
        ]),[], ['Authorization' => "Bearer ". $token]);

        $response->assertStatus(200)->assertJson(["status" => true]);
        $response2->assertStatus(200)->assertJson(["error" => "Erro ao cadastrar vinculo"]);
    }
    
}
