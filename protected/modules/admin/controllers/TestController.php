<?php

class TestController extends AController {

    public function actionIndex() {
        $db = Yii::app()->db;
        $url = '';
        $res = $db->createCommand("SELECT id,t_url FROM tb_product WHERE t_url='Jagermeister_029'")->queryRow();

        if ($res) {
            echo 'ДА';
        } else {
            echo 'НЕТ';
        }
        print_r($res);
    }

}
