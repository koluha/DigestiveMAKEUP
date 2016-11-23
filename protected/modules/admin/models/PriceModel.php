<?php

class PriceModel extends CActiveRecord {

    public function tableName() {
        return '{{prices}}';
    }

    public function primaryKey() {
        return 'pid';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function checkByName($name) {
        $price = self::model()->find('name=:name', array(
            ':name' => $name
        ));
        return ($price !== null);
    }

}