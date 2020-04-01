<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PermissionsMasterTable extends Migration
{
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->unique();
	        $table->timestamps();
        });


        // Create table for storing permissions
        Schema::create('module_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->unique();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permissions', function (Blueprint $table) {
            $table->integer('module_id')->unsigned();
            $table->integer('role_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('can_view')->default(0)->unsigned();
            $table->integer('can_add')->default(0)->unsigned();
            $table->integer('can_update')->default(0)->unsigned();
            $table->integer('can_delete')->default(0)->unsigned();
            $table->primary(['module_id', 'role_id','user_id']);
        });
    }

    public function down()
    {
        Schema::drop('permissions');
        Schema::drop('module_details');
        Schema::drop('roles');
    }
}
