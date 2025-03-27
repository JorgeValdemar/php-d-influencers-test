<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('influencers_campaigns', function (Blueprint $table) {
            $table->foreign('influencer_id')->references('id')->on('influencers');
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->unique(['influencer_id', 'campaign_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('influencers_campaigns', function (Blueprint $table) {
            $table->dropUnique(['influencer_id', 'campaign_id']);
            $table->dropForeign(['campaign_id']);
            $table->dropForeign(['influencer_id']);
        });
    }
};
