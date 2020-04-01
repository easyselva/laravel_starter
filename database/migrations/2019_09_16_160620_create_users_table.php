<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name',50)->unique();
            $table->string('email',50)->nullable();
            $table->string('password');
            $table->string('display_name');
            $table->integer('role_id')->unsigned();
            $table->string('mobile_no')->nullable();
            $table->string('image_location')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('otp_no')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->rememberToken();
            $table->integer('last_modified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
