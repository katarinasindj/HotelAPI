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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rating');
            $table->enum('category', ['hotel', 'alternative', 'hostel', 'lodge', 'resort', 'guest-house']);
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->integer('reputation');
            $table->enum('reputationBadge', ['red', 'yellow', 'green']);
            $table->integer('price');
            $table->integer('availability');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
