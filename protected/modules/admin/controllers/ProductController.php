<?php

class ProductController extends AController {

    public function init() {
        $this->layout = 'column1';
    }

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('user/login'));
            return false;
        } else {
            return true;
        }
    }

    public function actionIndex() {
        $this->render('index');
    }

}
