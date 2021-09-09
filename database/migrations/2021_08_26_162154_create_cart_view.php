<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCartView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW IF EXISTS cart_view");
        DB::statement("
        CREATE VIEW cart_view AS
        select
    p.id,
    p.ItemNameEn,
    p.ItemName,
    p.ItemNameEnWhole,
    p.ItemNameWhole,
    p.ItemImage,
    p.ItemImageWhole,
    cp.price,
    cp.MinorPerMajor,
    cp.whole,
    cp.cart_id,
    cp.deleted_at,
    cp.image,
    (
        select
            product_options.size
        from
            product_options
        where
            (
                product_options.id = cp.option_id
            )
        limit
            1
    ) AS size,
    (
        select
            product_options.color
        from
            product_options
        where
            (
                product_options.id = cp.option_id
            )
        limit
            1
    ) AS color,
    if(
        ((0 <> cp.whole) is true),
        (cp.qty / cp.MinorPerMajor),
        cp.qty
    ) AS qty
from
    (
        cart_product cp
        join products_view p on((cp.product_id = p.id)) AND p.whole = cp.whole
    )");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('cart_view');
    }
}
