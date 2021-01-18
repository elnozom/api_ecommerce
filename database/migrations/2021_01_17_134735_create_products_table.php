<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('ProductCode')->unique();
            $table->string('ItemName');
            $table->string('ItemImage');
            $table->boolean('ByWeight')->default(false);
            $table->unsignedFloat('vat')->default(0);
            $table->unsignedFloat('POSTP');
            $table->unsignedFloat('POSPP');
            $table->unsignedInteger('MinorPerMajor');
            $table->boolean('ActiveItem')->default(true);
            $table->boolean('InStock');
            $table->unsignedBigInteger('GroupCode');
            $table->foreign('GroupCode')->references('id')->on('groups');
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
        Schema::dropIfExists('products');
    }
}
