<?php

class SiteController extends Controller {

    public function init() {
        $this->layout = '//layouts/template1';
    }

    public function actionIndex() {

        $this->render('index');
    }
    
    public function actionContact() {
        $this->layout = '//layouts/template2';
        $this->render('contact');
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
