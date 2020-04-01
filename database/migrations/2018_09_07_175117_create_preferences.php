<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferences extends Migration
{
    public function up()
    {
        Schema::create('preference_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',15);
            $table->timestamps();
        });

        Schema::create('preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id');
            $table->string('key', 100);
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('preferences');
        Schema::dropIfExists('preference_categories');
    }
}
