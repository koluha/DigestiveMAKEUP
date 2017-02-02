<?php
Yii::import('ext.yii-elfinder-master.*');

class ElfinderController extends CController {

    public function actions() {
        return array(
            'connector' => array(
                'class' => 'ext.yii-elfinder-master.ElFinderConnectorAction',
                'settings' => array(
                    'root' => Yii::getPathOfAlias('webroot') . '/uploads/',
                    'URL' => Yii::app()->baseUrl . '/uploads/',
                    'rootAlias' => 'Files',
                    'mimeDetect' => 'none'
                    
                )
            ),
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

}


