<?php

class MyBreadcrumbs extends CWidget {

    public $items = array();

    public function init() {
        
    }

    public function run() {
        $this->render('mybreadcrumbs', array(
            'items' => $this->items,
        ));
    }

}
