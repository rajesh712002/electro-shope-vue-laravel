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
            $table->string('prod_name');
            $table->string('slug');
            $table->string('description');
            $table->double('price', 10, 2);
            $table->double('compare_price',10,2)->nullable();
            $table->foreignId('category_id')->references('id')->on('categories');
            $table->foreignId('sub_category_id')->nullable()->references('id')->on('subcategories');
            $table->foreignId('brand_id')->nullable()->references('id')->on('brands');
            $table->string('sku');
            $table->enum('track_qty',['Yes','No'])->default('Yes');
            $table->integer('qty')->nullable();
            $table->integer('status')->default(1);
                     

            $table->timestamps();

            // $table->unsignedBigInteger('subcate_id');
            // $table->foreign('subcate_id')->references('id')->on('categories');
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
