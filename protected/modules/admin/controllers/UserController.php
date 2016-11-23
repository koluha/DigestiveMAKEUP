<?php

class UserController extends AController {
      public function init() {
        $this->layout = 'main_1';
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('user/login'));
        }
        $rq = Yii::app()->request;
        $form = new LoginForm();
        if ($rq->isPostRequest) {
            $form->attributes = $rq->getPost('LoginForm', array());
            if ($form->validate() && $form->login()) {
                $this->redirect($this->createUrl('default/index'));
            }
        }
        $this->render('login', array(
            'form' => $form
        ));
    }

    public function actionLogout() {
        if (!Yii::app()->user->isGuest) {
            Yii::app()->user->logout();
            $this->redirect($this->createUrl('user/login'));
        }
    }

    public function actionDelete() {
        if (!Yii::app()->user->isGuest) {
            $uid = Yii::app()->request->getQuery('uid', 0);
            $user = UserModel::model()->findByPk($uid);
            $user->delete();
        }
        $this->redirect($this->createUrl('main/index'));
    }

}
