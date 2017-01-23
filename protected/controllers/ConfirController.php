<?php
//Проверка на +18
class ConfirController extends Controller{
    
    public function actionIndex() {
        //Запись в кука значения
        
        $response=1;
        echo json_encode($response);
        Yii::app()->end();
    }
}