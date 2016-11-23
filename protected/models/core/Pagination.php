<?php
class Pagination{
    
    // Определяем общее число 
    //Параметр выбранная категория
    public function AllPage($key_category){
         $sql = "SELECT 
                   COUNT(*)
                FROM tb_catalog as c
                    INNER JOIN tb_product as p ON p.key_catalog = c.id
                WHERE c.parent_id='$key_category' OR c.id='$key_category';";
        $count = Yii::app()->db->createCommand($sql)->queryScalar();
        return $count;
    }
    
    //Параметр выбранная категория
    public function AllPageFilter($id_cat,$name_spec){
         $sql = "SELECT 
                       COUNT(*)
                            FROM tb_product as p
                                INNER JOIN tb_link as l  ON p.id = l.key_product
                                INNER JOIN tb_spec_value as sv  ON sv.id = l.key_spec_value
                                INNER JOIN tb_product_spec as psv  ON psv.id = sv.key_prod_spec
				INNER JOIN tb_catalog as c  ON c.id = p.key_catalog
                            WHERE c.parent_id='$id_cat'  AND '$name_spec'=CASE
			                 						WHEN (sv.val_text!='')  THEN   sv.val_text  
					         					WHEN sv.val_int 	THEN   sv.val_int
						                        		WHEN sv.val_float       THEN   sv.val_float
									           END   ";
        $count = Yii::app()->db->createCommand($sql)->queryScalar();
        return $count;
    }
}
