<?php

class Product {
    //Данные продукта
    public function DescProduct($url){
    $sql = "SELECT 
                    p.id,
                    p.key_category,
                    p.i_name_sku,
                    p.i_price,
                    p.i_old_price,
                    p.i_availability,
                    p.t_url,
                    p.d_photo_middle,
                    p.t_meta_title,
                    p.t_meta_keyword,
                    p.t_meta_description,
                    p.f_fortress,
                    p.f_volume,
                    p.d_desc_product,
                    p.f_brand,
                    p.f_country,
                    p.f_region,
                    p.f_type,
                    p.f_class,
                    p.f_alcohol,
                    p.f_taste,
                    p.f_sugar,
                    p.f_grape_sort,
                    p.f_vintage_year,
                    p.f_color,
                    p.f_excerpt,
                    p.f_fortress,
                    p.f_volume,
                    p.f_packaging,
                    p.i_manufacturer_importer,
                    p. i_supplier
                FROM tb_product as p 
                WHERE p.t_url='$url'";
        $res = Yii::app()->db->createCommand($sql)->queryRow();
        return $res;
    }
    
    //Характеристика продукта
    public function SpecProduct($url){
    $sql = "SELECT 
            psv.name as name_spec,
                CASE
                    WHEN (sv.val_text!='')  THEN  sv.val_text
                    WHEN sv.val_int         THEN  sv.val_int
                    WHEN sv.val_float       THEN  sv.val_float
                END as val_spec
           FROM
                tb_product as p
            INNER JOIN tb_link as l  ON p.id = l.key_product
            INNER JOIN tb_spec_value as sv  ON sv.id = l.key_spec_value
            INNER JOIN tb_product_spec as psv  ON psv.id = sv.key_prod_spec
                WHERE
            p.url='$url'";
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        return $res;
    }
}

