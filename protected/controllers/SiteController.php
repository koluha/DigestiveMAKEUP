<?php

class SiteController extends Controller {
    private $ob_bread; //Объект модели хлебных крошек

    public function init() {
        $this->layout = '//layouts/template1';
        $this->ob_bread = new Breadcrumbs;
        //$this->ob_bread->ClearBreadSessian();
        
    }

    public function actionIndex() {
        $this->ob_bread->SetBreadSessian('','','','Главная');
        $this->render('index');
    }
    
    public function actionContact() {
        $this->layout = '//layouts/template2';
        $this->ob_bread->SetBreadSessian('','','','Контакты');
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
    
    //Подтверждение 18+
    public function actionConfir(){
        
    }

}
