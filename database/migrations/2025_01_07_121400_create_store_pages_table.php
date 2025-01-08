<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('store_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->longText('about')->nullable();
            $table->longText('contact')->nullable();
            $table->longText('faq')->nullable();
            $table->longText('how_to_order')->nullable();
            $table->longText('shipping_details')->nullable();
            $table->longText('payment_details')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('return_refund')->nullable();
            $table->longText('terms_of_service')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_pages');
    }
};

