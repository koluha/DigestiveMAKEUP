<?php

class Breadcrumbs {
    
    public $visible;
    /*
    $data = array('group' => array('id','level','url','title'),
                  'product' => array('id_p', 'url_p', 'title_p'),
                  'filter' => ''
            );
     */
    
    //Запись в сессию Хлебных крошек
    public function SetBreadSessian($bread) {
        Yii::app()->session['breadcrumbs'] = $bread;
    }

    //Получить сессии Хлебных крошек
    static function GetBreadSessian() {
        return Yii::app()->session['breadcrumbs'];
    }

    //Очистить сессии Хлебных крошек
    public function ClearBreadSessian() {
        Yii::app()->session['breadcrumbs']='';
    }
    
    //Вернет уроверь вложенности 1/2/3
    public function level($id){
        $lev=ModelCatalog::level($id);
        return $lev;
   }
   
    //Вернет весь список в которой есть выбранная группы
    public function list_allgroup($id) {
        $sql = "SELECT id, parent_id, title, img, url FROM tb_catalog WHERE parent_id='$id'";
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        return $res ? $res : FALSE;
    }
    
   //Вернет первого родителя
    public function parent_id($id) {
    $sql = "SELECT parent_id FROM tb_catalog WHERE id='$id'";
    $res = Yii::app()->db->createCommand($sql)->queryScalar();
    return $res ? $res : FALSE;
}
    public function get_title_group($id) {
    $sql = "SELECT title FROM tb_catalog WHERE id='$id'";
    $text = Yii::app()->db->createCommand($sql)->queryScalar();
    return $text;
}

}
