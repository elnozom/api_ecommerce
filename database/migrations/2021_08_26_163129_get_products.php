<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GetProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP PROCEDURE IF EXISTS GetProducts");
        DB::statement("CREATE DEFINER = `root` @`%` PROCEDURE `GetProducts`(
            IN `Search` VARCHAR(200),
            IN `ImagePrefix` VARCHAR(50),
            IN `PriceFrom` FLOAT(10),
            IN `PriceTo` FLOAT(10),
            IN `GroupCode` BIGINT(20),
            IN `Page` SMALLINT(6),
            OUT `CountRecords` SMALLINT(6)
        ) BEGIN DECLARE PriceFromCond VARCHAR(100) DEFAULT '';
        
        DECLARE PriceToCond VARCHAR(100) DEFAULT '';
        
        DECLARE GroupCond VARCHAR(100) DEFAULT '';
        
        DECLARE SearchCond VARCHAR(200) DEFAULT '';
        
        IF PriceFrom IS NOT NULL THEN
        SET
            PriceFromCond = CONCAT(' AND price >= ', PriceFrom);
        
        END IF;
        
        IF PriceTo IS NOT NULL THEN
        SET
            PriceToCond = CONCAT(' AND price <= ', PriceTo);
        
        END IF;
        
        #ItemNameEn
        #ItemName
        #ItemNameEnWhole
        #ItemNameWhole
        #ItemDesc
        #ItemDescEn
        IF Search IS NOT NULL THEN
        SET
            SearchCond = CONCAT(
                ' AND (ItemNameEn LIKE \"%',
                Search,
                '%\" OR ItemName LIKE \"%',
                Search,
                '%\" OR ItemNameEnWhole LIKE \"%',
                Search,
                '%\" OR ItemNameWhole LIKE \"%',
                Search,
                '%\")'
            );
        
        END IF;
        
        IF GroupCode IS NOT NULL THEN
        SET
            GroupCond = CONCAT(' AND GroupCode = ', GroupCode);
        
        END IF;
        
        SET
            @query = CONCAT(
                'SELECT id , GroupCode , ItemNameEn , ItemName ,  ItemNameEnWhole , ItemNameWhole ,(CONCAT( \"',
                ImagePrefix,
                '/\" ,  ItemImage)) ItemImage ,(CONCAT( \"',
                ImagePrefix,
                '/\" ,  ItemImageWhole)) ItemImageWhole, ItemDesc , ItemDescEn , ByWeight , hasOptions , latest , featured , bestseller , price , MinorPerMajor , ActiveItem , InStock , whole FROM products_view WHERE 1 = 1',
                SearchCond,
                PriceFromCond,
                PriceToCond,
                GroupCond,
                \" LIMIT 8 OFFSET \" , IF(Page > 1 ,8 * Page , 0));
        
            
            
        #SELECT @query;   
        PREPARE stmt FROM @query;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
          
          SELECT COUNT(*)
            INTO CountRecords
            FROM products_view WHERE 1 = 1 ;
        
        
            
        END
");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
