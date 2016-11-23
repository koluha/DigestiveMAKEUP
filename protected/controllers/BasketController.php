<?php

class BasketController extends Controller {

    private $cid;     //cart id
    private $uid;     //user id
    private $basket;  //object cart

    public function init() {

        $this->basket = new Basket;
        $this->cid = $this->basket->cid;
        $this->uid = $this->basket->uid;
    }

    public function actionAddCart() {
        $this->basket->Add();
        $this->actionshowcart();
    }

    public function actionDelCartItem() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = intval(Yii::app()->getRequest()->getpost('id_cart_context'));
            $this->basket->Del($id);
            $data['rowcart'] = $this->basket->show();
            $data['total'] = $this->basket->total();
            $this->basket->Getquantity();
            $this->basket->Getcartsumma();
            if ($data['rowcart']) {
               // $this->renderPartial('_ajaxbasket', array('data' => $data));
            } else {
                $this->emptylistcart();
            }
        }
    }

    //апдеит не рабочий
    public function actionshowcart() {
        $data['rowcart'] = $this->basket->show();
        $data['total'] = $this->basket->total();
        $this->basket->Getquantity();
        $this->basket->Getcartsumma();
        if ($data['rowcart']) {
            $this->render('index', array('data' => $data));
        } else {
            $this->render('empty');
        }
    }

    //AJAX корзина
    public function AJAXshowcart() {
        $data['rowcart'] = $this->basket->show();
        $data['total'] = $this->basket->total();
        $this->basket->Getquantity();
        $this->basket->Getcartsumma();
        if ($data['rowcart']) {
            $this->renderPartial('_ajaxbasket', array('data' => $data));

            exit();
        } else {
            $this->emptylistcart();
        }
    }

    //Вывод вида корзины AJAX
    public function emptylistcart() {
        echo '<div id="cart"><h1>Корзина</h1><h3>Ваша корзина пуста</h3></div>';
    }


    //миграция ид юзера
    public function MigrationUserId() {
        $this->basket->MigrationUserId();
    }

    public function GetTotal() {
        return $this->basket->quantity();
    }

    public function actionplus() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = intval(Yii::app()->getRequest()->getpost('id_cart_context'));
            if ($id > 0) {
                $this->basket->plus($id);
                $this->AJAXshowcart();
            }
        }
    }

    public function actionminus() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = intval(Yii::app()->getRequest()->getpost('id_cart_context'));
            if ($id > 0) {
                $this->basket->minus($id);
                $this->AJAXshowcart();
            }
        }
    }

    public function actionTest() {

        echo 'ty==' . Yii::app()->user->getId();
        echo '<br>';
        echo 'user==' . $this->uid;
        echo '<br>';
        echo 'cart==' . $this->cid;
    }

}
