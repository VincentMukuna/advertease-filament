<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('billboard_campaign', function (Blueprint $table) {
            $table->foreignId('billboard_id');
            $table->foreignId('campaign_id');
            $table->enum('status', Arr::pluck(App\Enum\Campaign\BillboardCampaignStatus::cases(), 'value'))
                ->default(App\Enum\Campaign\BillboardCampaignStatus::Pending);
            $table->timestamp('active_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billboard_campaign');
    }
};
