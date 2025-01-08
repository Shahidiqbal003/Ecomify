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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title'); // Required: Product title
            $table->string('slug')->nullable(); // Nullable: Slug for SEO
            $table->string('cover_image_data')->nullable(); // Nullable: For cover image
            $table->text('product_images_data')->nullable(); // Nullable: For product images (Base64 or URL)
            $table->decimal('price', 10, 2); // Required: Product price
            $table->decimal('compare_at_price', 10, 2)->nullable(); // Nullable: Price comparison
            $table->integer('stock')->nullable(); // Nullable: Stock quantity
            $table->boolean('status')->default(true); // Nullable: Product status (active/inactive)
            $table->string('variations')->nullable(); // Nullable: Variation type (e.g., 'on' or 'off')
            $table->json('sizes')->nullable(); // Nullable: Array of sizes
            $table->json('colors')->nullable(); // Nullable: Array of colors
            $table->json('color_images')->nullable(); // Nullable: Array of color images (file paths)
            $table->json('category_ids')->nullable(); // Nullable: Array of category IDs
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
