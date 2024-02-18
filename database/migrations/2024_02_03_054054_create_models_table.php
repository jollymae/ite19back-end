<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id('model_id');
            $table->string('name');
            $table->string('body_style');
            $table->timestamps();

            // Add foreign key for 'option_id'
            $table->unsignedBigInteger('option_id');
            $table->foreign('option_id')->references('option_id')->on('options');

            // Add foreign key for 'suppliers_id'
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
