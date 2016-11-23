<?php

class AdminModule extends CWebModule {
    //public $layout = 'admin.views.layouts.column2';

    public function init() {
        
        
        $this->setImport(array(
            'admin.models.*',
            'admin.models.core*',
            'admin.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
