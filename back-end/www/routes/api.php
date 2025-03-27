<?php

use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\InfluencersController;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

// groups without restrict access
Route::group([], function (): void {
    Route::controller(JWTAuthController::class)->group(function(): void {
        Route::get('/user/login', 'login');
        Route::post('/user/register', 'register');
    });
});

// groups with restrict access
Route::middleware([JwtMiddleware::class])->group( function (): void {
    Route::controller(JWTAuthController::class)->group(function(): void {
        Route::post('/user/logout', 'logout');
    });

    Route::controller(InfluencersController::class)->group(function(): void {
        Route::post('/influencers/save', 'saveInfluencers');
        Route::get('/influencers/list', 'listInfluencers');
    });
    
    Route::controller(CampaignsController::class)->group(function(): void {
        Route::post('/campaigns/save', 'saveCampaign');
        Route::get('/campaigns/list', 'listCampaign');
        Route::post('/campaigns/influencers/apply', 'applyInfluencersToCampaign');
        Route::get('/campaigns/influencers/list/{id}', 'listCampaignInfluencers')->where(['id' => '[0-9]+']);;
    });
});
