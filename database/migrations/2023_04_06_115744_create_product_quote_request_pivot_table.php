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
        Schema::create('product_quote_request', function (Blueprint $table) {
            $table->foreignId('product_description_id')->constrained();
            $table->foreignId('quote_request_id')->constrained();
            $table->primary(['product_description_id','quote_request_id']);
            $table->float('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_quote_request_pivot');
    }
};
