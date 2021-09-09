<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS products_view");
        DB::statement("
        CREATE VIEW products_view AS
        select
        id,
        GroupCode,
        ItemNameEn,
        ItemName,
        ItemNameEnWhole,
        ItemNameWhole,
        ItemImage,
        ItemImageWhole,
        ItemDesc,
        ItemDescEn,
        ByWeight,
        hasOptions,
        latest,
        featured,
        bestseller,
        POSPP price,
        MinorPerMajor,
        ActiveItem,
        InStock,
        0 AS whole
    from
        products
    where
        (whole = 2)
    union
    select
        id,
        GroupCode,
        ItemNameEn,
        ItemName,
        ItemNameEnWhole,
        ItemNameWhole,
        ItemImage,
        ItemImageWhole,
        ItemDesc,
        ItemDescEn,
        ByWeight,
        hasOptions,
        latest,
        featured,
        bestseller,
        POSTP price,
        MinorPerMajor,
        ActiveItem,
        InStock,
        1 AS whole
    from
        products
    where
        (whole = 2)
    union
    select
        id,
        GroupCode,
        ItemNameEn,
        ItemName,
        ItemNameEnWhole,
        ItemNameWhole,
        ItemImage,
        ItemImageWhole,
        ItemDesc,
        ItemDescEn,
        ByWeight,
        hasOptions,
        latest,
        featured,
        bestseller,
        POSPP price,
        MinorPerMajor,
        ActiveItem,
        InStock,
        0 AS whole
    from
        products
    where
        (whole <> 2)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement("DROP VIEW IF EXISTS products_view");
    }
}
