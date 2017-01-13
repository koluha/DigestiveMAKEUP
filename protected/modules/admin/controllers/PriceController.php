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

    public function actionView() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];
        $this->render('view',array('model'=>$model));
    }

    public function actionDeletePrice() {
        $rq = Yii::app()->request;
        $pid = $rq->getQuery('pid', 0);
        $priceModel = new Prices();
        $priceModel->delete(intval($pid));
        $this->redirect($this->createUrl('price/index'));
    }

}
