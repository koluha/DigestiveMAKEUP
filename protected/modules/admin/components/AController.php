<?php

class AController extends Controller {
    
    public $menu=array();
    public $breadcrumbs=array();

    public function init() {
        $this->layout = $this->module->layout;
    }

}
