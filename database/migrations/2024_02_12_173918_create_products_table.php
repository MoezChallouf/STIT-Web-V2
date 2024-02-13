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
            $table->id();
            $table->string('name');
            $table->text('long_desc');
            $table->text('short_desc');
            $table->text('info_supp');
            $table->string('ref');
            $table->string('color');
            $table->string('taille')->default('*/*');
            $table->enum('status', ['En Stock', 'Epuisé'])->default('En Stock');
            $table->enum('display', ['Show', 'Hide'])->default('Show');
            $table->foreignId('category_id');
            // $table->json('images');
            $table->timestamps();
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
