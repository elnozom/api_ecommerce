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
            $table->string('ProductCode')->unique()->nullable();
            $table->string('ItemNameEn');
            $table->string('ItemName');
            $table->string('ItemImage');
            $table->text('ItemDesc')->nullable();
            $table->text('ItemDescEn')->nullable();
            $table->boolean('ByWeight')->default(false);
            $table->boolean('hasOptions')->default(false);
            $table->boolean('latest')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('bestseller')->default(false);
            $table->unsignedFloat('vat')->default(0);
            $table->unsignedFloat('POSTP');
            $table->unsignedFloat('POSPP');
            $table->unsignedInteger('MinorPerMajor');
            $table->boolean('ActiveItem')->default(true);
            $table->boolean('InStock');
            $table->unsignedBigInteger('GroupCode');
            $table->foreign('GroupCode')->references('id')->on('groups');
            $table->timestamps();
            $table->softDeletes();
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
