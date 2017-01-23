<?php

class AjaxController extends CController {


    //Сортировка каталога
    public function actionsortcatalog() {
        if (Yii::app()->request->isAjaxRequest) {

            $id_sort = Yii::app()->request->getPost('id_sort');
            $id_category = Yii::app()->request->getPost('id_category');
            

            echo $id_category;
            
            Yii::app()->end();
        }
       
       $this->out('Priver');
    }

    private function out($response) {
        echo json_encode($response);
        Yii::app()->end();
    }

    private function error($msg, $code = 0, $data = array()) {
        $this->out(array(
            'error' => true,
            'msg' => $msg,
            'code' => $code,
            'data' => array()
        ));
    }

}
