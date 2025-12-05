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
    Schema::create('menu_items', function (Blueprint $table) {
        $table->id();
        $table->string('name');          // e.g., "Nicey Burger"
        $table->string('type');          // e.g., "Buy 1 Take 1" or "Burgers"
        $table->decimal('price', 8, 2);  // e.g., 150.00
        $table->string('image_path')->nullable(); // For the picture
        $table->text('description')->nullable();
        $table->boolean('is_available')->default(true); // Manual toggle for now
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
