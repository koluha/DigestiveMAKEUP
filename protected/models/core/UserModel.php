<?php

class UserModel extends CActiveRecord {

    public function tableName() {
        return '{{user}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
