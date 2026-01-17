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
        Schema::create('business_setups', function (Blueprint $table) {
            $table->id();
            $table->json("name");
            $table->json("brand_image");
            $table->json("brand_cover");
            $table->json("slider_imgs");
            $table->json("ads_imgs");
            $table->string("currency");
            $table->string("time_zone");
            $table->integer("coverage");
            $table->float("km_price");
            $table->float("low_distance_price");
            $table->float("low_resturant_order");
            $table->string('android_link');
            $table->string('apple_link');
            $table->string('website_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_setups');
    }
};
