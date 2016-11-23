<?php

class TopMenu extends CWidget {
    private $route;
    
    public function init() {
	$this->route = Yii::app()->controller->getRoute();
    }
    
    public function run() {
	$this->render('application.modules.admin.widgets.views.TopMenu', array(
	    'route' => $this->route
	));
    }
}