<?php

Class UserController extends Controller {

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('login', 'logout', 'registeruser', 'updateuser', 'forgpass'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    //Авторизоваться login
    public function actionLogin() {
        $model = new LoginForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = Yii::app()->request->getPost('LoginForm', array());
            if ($model->validate() && $model->login()) {
                //Изменим в корзину id поль-ля
                Basket::MigrationUserId();
                
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('login', array('model' => $model));
    }

    //Выход
    public function actionLogout() {
        $returnUrl = Yii::app()->user->returnUrl;
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->getHomeUrl());
    }

    //Регистрация покупателя  
    public function actionRegisterUser() {

        $form = new RegUserForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'reg-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }


        if (isset($_POST['RegUserForm'])) {

            $form->attributes = Yii::app()->request->getPost('RegUserForm', array());

            if ($form->validate() and $form->register()) {
                //Регистрация покупателя запись в БД
                //Авторизуемся
                $FormLogin = new LoginForm;
                $FormLogin->username = $_POST['RegUserForm']['username'];
                $FormLogin->password = $_POST['RegUserForm']['password'];
                $FormLogin->login();

                //Изменим в корзину id поль-ля
                Basket::MigrationUserId();
                //Переход на страницу после авторизации
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        $this->render('reguser', array('form' => $form));
    }

    //Иземенение данных Покупателя
    public function actionUpdateUser() {
        $form = new UpdateUserForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }

        $form->UpdateFormUser();  //Это обновление поля при первом заходе с бд
        $form->validate();

        $form->attributes = Yii::app()->request->getPost('UpdateUserForm', array());
        if ($form->validate()) {
            $form->SaveUserId();  //Сохранение изменении
        }

        $this->render('updateuser', array('form' => $form));
    }

    //Восстановление пароля пользователя
    public function actionForgpass() {
        $form = new ForgPassUserForm;

        if (isset($_POST['ForgPassUserForm'])) {
            $mail = CHtml::encode($_POST['ForgPassUserForm']['mail']);
            $model = new UserModel();
            $user = $model->find('mail=:pmail', array(':pmail' => $mail));

            if (!empty($user)) {
                $NewPass = $form->GeneratePassword(); //Новый пароль
                $hashNewPass = CPasswordHelper::hashPassword($NewPass);
                $user->password = $hashNewPass;
                $user->save(); // сохраняем изменения
                //Отправим на почту
                $mail= new Mail();
                $data_m=array('pass'=>$NewPass);
                $mail->notice_pass_user($user->mail, $data_m);
                Yii::app()->user->setFlash('Forgpass', "Ваш новый пароль отправлен на почту");
            } else {
                Yii::app()->user->setFlash('Forgpass', "Такой почты в базе нет");
            }
        }
        $this->render('forgpassuser', array(
            'form' => $form));
    }

    public function actionProfile() {
        if (!Yii::app()->user->isGuest) {

            $this->render('profile');
        }
    }

}

?>