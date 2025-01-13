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
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('show_on_list')->default(true);
            $table->enum('visibility', ['public', 'restricted', 'private'])->default('public');
            $table->boolean('share_link_active')->default(false);
        });

        Schema::create('videos_allowed_for', function (Blueprint $table) {
           $table->id();
           $table->foreignId('video_id')->references('id')->on('videos')->cascadeOnDelete();
           $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos_visibility_column');
    }
};
