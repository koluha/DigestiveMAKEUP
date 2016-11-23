<?php

class CategoryController extends AController {

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('user/login'));
            return false;
        } else {
            return true;
        }
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionTest() {
        $sql = "SELECT id,title  FROM tb_catalog WHERE parent_id='0' ORDER BY title";
        $res = Yii::app()->db->createCommand($sql)->queryAll();
        echo '<pre>';
        print_r($res);
        
         $drop = CHtml::listData($res, 'id', 'title');
         print_r($drop);
         
         foreach ($res as $value) {
             $r[$value['id']]=$value['title'].'-'.$value['id'];
         }
         print_r($r);
    }

    //Ajax Select
    //Получение списка Категории Ajax
    public function actionAjaxDropCategory() {
        if (Yii::app()->request->isAjaxRequest) {
            $var = Yii::app()->request->getPost('id_group');
            $p_id = intval($var);
            if ($p_id != 0) {  //чтобы не открывался второй список
                $sql = "SELECT id, parent_id, title FROM tb_catalog WHERE parent_id='$p_id' ORDER BY title ASC";
                $data = Yii::app()->db->createCommand($sql)->queryAll();
                $list[] = '(Выбрать категорию)';
                foreach ($data as $value) {
                    $list[$value['id']] = $value['id'].'-'.$value['title'];
                }
                foreach ($list as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                array();
            }
        }
    }
    
        //Получение списка Категории Ajax
    public function actionAjaxDropType() {
        if (Yii::app()->request->isAjaxRequest) {
            $var = Yii::app()->request->getPost('id_category');
            $p_id = intval($var);
            if ($p_id != 0) {  //чтобы не открывался второй список
                $sql = "SELECT id, parent_id, title FROM tb_catalog WHERE parent_id='$p_id' ORDER BY title ASC";
                $data = Yii::app()->db->createCommand($sql)->queryAll();
                $list[] = '(Выбрать Тип)';
                foreach ($data as $value) {
                    $list[$value['id']] = $value['id'].'-'.$value['title'];
                }
                foreach ($list as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            } else {
                array();
            }
        }
    }

}
