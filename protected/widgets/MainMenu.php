<?php

class MainMenu extends CWidget {

    public $items = array();

    public function init() {
        
    }

    public function run() {
        $this->render('v_mainmenu', array(
            'items' => $this->items,
        ));
    }

}
