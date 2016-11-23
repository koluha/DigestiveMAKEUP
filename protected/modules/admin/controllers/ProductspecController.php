<?php

class ProductspecController extends AController {

     public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('user/login'));
            return false;
        } else {
            return true;
        }
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new ProductSpec;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductSpec'])) {
            $model->attributes = $_POST['ProductSpec'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductSpec'])) {
            $model->attributes = $_POST['ProductSpec'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionIndex() {
        $model = new ProductSpec('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductSpec']))
            $model->attributes = $_GET['ProductSpec'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = ProductSpec::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-spec-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
