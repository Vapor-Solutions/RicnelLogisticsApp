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
        Schema::table('sale_product_item', function (Blueprint $table) {
            // $table->dropPrimary();

            // Drop the existing foreign key constraints
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['product_item_id']);

            // Recreate the primary key as a composite primary key
            $table->primary(['sale_id', 'product_item_id']);

            // Recreate the foreign key constraints with onDelete('cascade')
            $table->foreign('sale_id')
                ->references('id')
                ->on('sales')
                ->onDelete('cascade');
            $table->foreign('product_item_id')
                ->references('id')
                ->on('product_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_product_item', function (Blueprint $table) {
            $table->dropPrimary();

            // Drop the existing foreign key constraints
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['product_item_id']);

            // Recreate the primary key as a composite primary key
            $table->primary(['purchase_id', 'product_item_id']);

            // Recreate the foreign key constraints with onDelete('cascade')
            $table->foreignId('purchase_id')
                ->constrained();
            $table->foreignId('product_item_id')
                ->constrained();
        });
    }
};
