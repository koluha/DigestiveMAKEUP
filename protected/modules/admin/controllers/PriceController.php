<?php

class PriceController extends AController {

    
    public function actionIndex() {
        $rq = Yii::app()->request;
        $pid = $rq->getQuery('pid', 0);
        $priceModel = new Prices(); //Извлечение прайсов
        $this->render('index', array(
            'priceList' => $priceModel->getAllPrices(),
            'price' => $priceModel->getPriceById(intval($pid)),
            'pid' => $pid
        ));
    }
    
    public function actionView(){

        
        
        $this->render('view');
    }

        public function actionDeletePrice() {
        $rq = Yii::app()->request;
        $pid = $rq->getQuery('pid', 0);
        $priceModel = new Prices();
        $priceModel->delete(intval($pid));
        $this->redirect($this->createUrl('price/index'));
    }
    
 

}
