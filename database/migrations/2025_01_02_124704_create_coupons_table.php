<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id'); // Attach to a shop
            $table->string('code')->unique(); // Unique coupon code
            $table->enum('discount_type', ['percentage', 'free_shipping']); // Discount type
            $table->decimal('discount_value', 8, 2)->nullable(); // Discount value
            $table->boolean('free_shipping')->default(false); // Free shipping
            $table->date('expiry_date')->nullable(); // Expiry date
            $table->boolean('status')->default(true); // Active/Inactive
            $table->json('product_ids')->nullable(); // Specific product IDs
            $table->timestamps();

            // Foreign key for shop
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
