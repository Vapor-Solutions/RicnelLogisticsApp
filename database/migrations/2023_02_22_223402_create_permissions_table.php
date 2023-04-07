<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        DB::table('permissions')->insert([
            [
                'title'=>'Create Admins'
            ],
            [
                'title'=>'Read Admins'
            ],
            [
                'title'=>'Update Admins'
            ],
            [
                'title'=>'Delete Admins'
            ],
            [
                'title'=>'Create Roles'
            ],
            [
                'title'=>'Read Roles'
            ],
            [
                'title'=>'Update Roles'
            ],
            [
                'title'=>'Delete Roles'
            ],
            [
                'title'=>'Create Departments'
            ],
            [
                'title'=>'Read Departments'
            ],
            [
                'title'=>'Update Departments'
            ],
            [
                'title'=>'Delete Departments'
            ],
            [
                'title'=>'Create Brands'
            ],
            [
                'title'=>'Read Brands'
            ],
            [
                'title'=>'Update Brands'
            ],
            [
                'title'=>'Delete Brands'
            ],
            [
                'title'=>'Create Suppliers'
            ],
            [
                'title'=>'Read Suppliers'
            ],
            [
                'title'=>'Update Suppliers'
            ],
            [
                'title'=>'Delete Suppliers'
            ],
            [
                'title'=>'Create Unit Types'
            ],
            [
                'title'=>'Read Unit Types'
            ],
            [
                'title'=>'Update Unit Types'
            ],
            [
                'title'=>'Delete Unit Types'
            ],
            [
                'title'=>'Create Units'
            ],
            [
                'title'=>'Read Units'
            ],
            [
                'title'=>'Update Units'
            ],
            [
                'title'=>'Delete Units'
            ],
            [
                'title'=>'Create Product Categories'
            ],
            [
                'title'=>'Read Product Categories'
            ],
            [
                'title'=>'Update Product Categories'
            ],
            [
                'title'=>'Delete Product Categories'
            ],
            [
                'title'=>'Create Product Descriptions'
            ],
            [
                'title'=>'Read Product Descriptions'
            ],
            [
                'title'=>'Update Product Descriptions'
            ],
            [
                'title'=>'Delete Product Descriptions'
            ],
            [
                'title'=>'Create Product Items'
            ],
            [
                'title'=>'Read Product Items'
            ],
            [
                'title'=>'Update Product Items'
            ],
            [
                'title'=>'Delete Product Items'
            ],
            [
                'title'=>'Create Purchases'
            ],
            [
                'title'=>'Read Purchases'
            ],
            [
                'title'=>'Update Purchases'
            ],
            [
                'title'=>'Delete Purchases'
            ],
            [
                'title'=>'Create Payment Methods'
            ],
            [
                'title'=>'Read Payment Methods'
            ],
            [
                'title'=>'Update Payment Methods'
            ],
            [
                'title'=>'Delete Payment Methods'
            ],
            [
                'title'=>'Create Purchase Payments'
            ],
            [
                'title'=>'Read Purchase Payments'
            ],
            [
                'title'=>'Update Purchase Payments'
            ],
            [
                'title'=>'Delete Purchase Payments'
            ],
            [
                'title'=>'Create Quotations'
            ],
            [
                'title'=>'Read Quotations'
            ],
            [
                'title'=>'Update Quotations'
            ],
            [
                'title'=>'Delete Quotations'
            ],
            [
                'title'=>'Create Sales'
            ],
            [
                'title'=>'Read Sales'
            ],
            [
                'title'=>'Update Sales'
            ],
            [
                'title'=>'Delete Sales'
            ],
            [
                'title'=>'Create Users'
            ],
            [
                'title'=>'Read Users'
            ],
            [
                'title'=>'Update Users'
            ],
            [
                'title'=>'Delete Users'
            ],
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
