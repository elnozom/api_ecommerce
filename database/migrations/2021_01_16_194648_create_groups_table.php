<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('GroupNameEn');
            $table->string('GroupName');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->boolean('ByWeight')->default(false);
            $table->unsignedBigInteger('FatherCode')->nullable();
            $table->boolean('Active')->default(true);
            $table->boolean('Featured')->default(false);
            $table->boolean('Home')->default(false);
            $table->foreign('FatherCode')->references('id')->on('groups');
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
        Schema::dropIfExists('groups');
    }
}
