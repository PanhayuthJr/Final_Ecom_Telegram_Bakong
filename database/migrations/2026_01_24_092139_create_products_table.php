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
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->text('desc')->nullable();
            $t->decimal('price', 15, 2);
            $t->string('image')->nullable();
            $t->string('category')->default('Gaming');
            $t->string('stock')->default('in-stock');
            $t->json('specifications')->nullable();
            $t->timestamps();
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
