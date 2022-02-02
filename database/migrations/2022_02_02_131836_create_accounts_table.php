<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('ac_id');
            $table->text('ac_firebase_id')->unique();
            $table->text('ac_email')->nullable();
            $table->text('ac_first_name')->nullable();
            $table->text('ac_last_name')->nullable();
            $table->text('ac_profile_pic')->nullable();
            $table->boolean('ac_bidder')->nullable();
            $table->boolean('ac_seller')->nullable();
            $table->enum('ac_role',['user','admin'])->default('user');
            $table->enum('ac_status',['active','disabled','pending','deleted'])->default('active');
            $table->timestamp('ac_created_at')->nullable();
            $table->timestamp('ac_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
