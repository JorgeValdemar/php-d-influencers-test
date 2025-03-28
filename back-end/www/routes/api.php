<?php

use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\InfluencersController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

// groups without restrict access
Route::group([], function (): void {
    Route::controller(JWTAuthController::class)->group(function(): void {
        Route::post('/user/login', 'login')->name('user.login');
        Route::post('/user/register', 'register')->name('user.register');
    });
});

// groups with restrict access
Route::middleware([JwtMiddleware::class])->group( function (): void {
    Route::controller(JWTAuthController::class)->group(function(): void {
        Route::post('/user/logout', 'logout')->name('user.logout');
    });

    Route::controller(InfluencersController::class)->group(function(): void {
        Route::post('/influencers/save', 'saveInfluencers')->name('influencers.save');
        Route::get('/influencers/list', 'listInfluencers')->name('influencers.list');
        Route::post('/influencers/campaigns/apply', 'applyCampaignsToInfluencer')->name('influencers.campaigns.apply');
        Route::get('/influencers/campaigns/list/{id}', 'listInfluencerCampaigns')->where(['id' => '[0-9]+'])->name('influencers.campaigns.list');
    });
    
    Route::controller(CampaignsController::class)->group(function(): void {
        Route::post('/campaigns/save', 'saveCampaign')->name('campaigns.save');
        Route::get('/campaigns/list', 'listCampaign')->name('campaigns.list');
        Route::post('/campaigns/influencers/apply', 'applyInfluencersToCampaign')->name('campaigns.influencers.apply');
        Route::get('/campaigns/influencers/list/{id}', 'listCampaignInfluencers')->where(['id' => '[0-9]+'])->name('campaigns.influencers.list');
    });
});
