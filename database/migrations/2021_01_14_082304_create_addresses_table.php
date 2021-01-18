<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('BuildingNo');
            $table->string('RowNo');
            $table->string('FlatNo');
            $table->string('Street');
            $table->string('Remark')->nullable();
            $table->boolean('Main')->default(false);
            $table->unsignedBigInteger('AreaNo');
            $table->unsignedBigInteger('AccSerial');
            $table->unsignedBigInteger('PhSerial');
            $table->foreign('AreaNo')->references('id')->on('areas');
            $table->foreign('AccSerial')->references('id')->on('users');
            $table->foreign('PhSerial')->references('id')->on('phones');
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
        Schema::dropIfExists('addresses');
    }
}
