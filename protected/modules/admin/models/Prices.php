<?php

class Prices {

    public function getAllPrices() {
        $db = Yii::app()->db;
        $listCmd = $db->createCommand("
	   SELECT pr.pid, pr.name, pr.created, pr.updated,
            (SELECT COUNT(p.id) FROM {{product}} AS p WHERE p.pid=pr.pid) AS parts_count
                FROM {{prices}} AS pr
            ORDER BY pr.updated DESC
	");
        return $listCmd->queryAll();
    }

    public function getPriceById($pid) {
        $db = Yii::app()->db;
        $listCmd = $db->createCommand("
	     SELECT pr.pid, pr.name, pr.created, pr.updated,
            (SELECT COUNT(p.id) FROM {{product}} AS p WHERE p.pid=pr.pid) AS parts_count
                FROM {{prices}} AS pr
	    WHERE pr.pid=:pid
	");
        return $listCmd->queryRow(TRUE, array(
                    ':pid' => $pid
        ));
    }

    public function delete($pid) {
        $db = Yii::app()->db;
          $deleteParts = $db->createCommand("DELETE FROM {{product}} WHERE pid=:pid");
          $deletePrice = $db->createCommand("DELETE FROM {{prices}} WHERE pid=:pid");
          $deleteParts->execute(array(
          ':pid' => $pid
          ));
          $deletePrice->execute(array(
          ':pid' => $pid
          ));

        
    }
    
    static function namePrice($id){
        $db = Yii::app()->db;
        $namePrice = $db->createCommand("SELECT name FROM tb_prices  WHERE pid='$id'");
        $nameP=$namePrice->queryScalar();
         return $nameP;
    }
    


}
