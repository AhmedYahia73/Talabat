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
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->json("name"); 
            $table->float("price")->default(0);
            $table->foreignId('product_id')->nullable()->constrained("products")->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('variation_id')->nullable()->constrained("product_variations")->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean("status")->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_options');
    }
};
