<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id'); // Link to the shop
            $table->decimal('sub_total', 10, 2)->default(0.00); // Subtotal (before shipping)
            $table->decimal('total_payment', 10, 2)->default(0.00); // Total payment (subtotal + shipping)
            $table->text('note')->nullable(); // Additional note for the order
            $table->string('email')->nullable();
            $table->boolean('news_offers')->default(false);
            $table->string('country')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->text('address')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('save_info')->default(false);
            $table->decimal('shipping', 10, 2)->default(0.00);
            $table->string('payment_method')->nullable();
            $table->longText('order_data')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
