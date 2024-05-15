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
        Schema::disableForeignKeyConstraints();

        Schema::create('billboards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('daily_rate', 8, 2);
            $table->enum('size', ['small', 'medium', 'large']);
            $table->enum('type', ['static', 'digital', 'backlit', 'mobile']);
            $table->boolean('is_visible');
            $table->enum('booking_status', ['available', 'booked']);
            $table->decimal('lat', 10, 7)->min(-90)->max(90);
            $table->decimal('lng', 10, 7)->min(-180)->max(180);
            $table->unsignedInteger('reach')->nullable();
            $table->foreignId('billboard_owner_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billboards');
    }
};
