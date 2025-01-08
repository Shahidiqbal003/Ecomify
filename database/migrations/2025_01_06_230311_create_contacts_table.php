<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id'); // Foreign key
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('comment');
            $table->timestamps();

            // Foreign key constraint (assuming a 'shops' table exists)
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
