<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bid_products', function (Blueprint $table) {
            $table->id('bp_id');
            $table->integer('bp_product_id')->nullable();
            $table->boolean('bp_winner')->nullable();
            $table->text('bp_firebase_user_id')->nullable();
            $table->text('bp_comment')->nullable();
            $table->bigInteger('bp_ammount_bid');
            $table->enum('bp_status',['active','disabled','pending','deleted'])->default('active');
            $table->timestamp('bp_created_at')->nullable();
            $table->timestamp('bp_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bid_products');
    }
}
