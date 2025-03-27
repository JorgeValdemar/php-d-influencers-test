<?php

namespace Tests\Feature;

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
}
