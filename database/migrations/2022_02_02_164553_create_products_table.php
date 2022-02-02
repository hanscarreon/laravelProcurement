<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->text('ac_firebase_id')->nullable();
            $table->text('product_name')->nullable();
            $table->boolean('product_picture')->nullable();
            $table->text('product_description')->nullable();
            $table->integer('product_min_bid')->nullable();
            $table->enum('product_status',['active','disabled','pending','deleted'])->default('active');
            $table->timestamp('product_created_at')->nullable();
            $table->timestamp('product_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
