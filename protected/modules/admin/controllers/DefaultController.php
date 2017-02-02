<?php

class DefaultController extends AController
{
     
  public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('user/login'));
            return false;
        } else {
            return true;
        }
    }

    public function actionIndex()
	{
		$this->render('index');
	}
}