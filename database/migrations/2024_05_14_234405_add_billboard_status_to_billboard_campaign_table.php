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
        Schema::table('billboard_campaign', function (Blueprint $table) {
            $table->enum('status', Arr::pluck(App\Enum\Campaign\BillboardCampaignStatus::cases(), 'value'))->default(App\Enum\Campaign\BillboardCampaignStatus::Printing);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billboard_campaign', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
