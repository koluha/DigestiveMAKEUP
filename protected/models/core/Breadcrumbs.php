<?php

class Breadcrumbs {

    public $visible;
    private $ob_cat;

    /* Запись в сессию Хлебных крошек
     * group=>
     * (id             # Выбранная группа
     * level,          # Уровень выбранной группы
     * title,          # Наименование выбранной группы
     * parents group)  # Родсвенники выбранной группы
     * filter          # Выбранный фильтр
     * product         # Выбранный продукт
     * title           # Выбранный страница
     */

    public function __construct() {
        $this->ob_cat = new ModelCatalog();
    }

    //Сформироние масссива для хлебных крошек
    public function SetBreadSessian($product = '', $filter = '', $id = '',$title='') {
        //Если уровень выше 1-го нужно получить уровни родителей
        $level = $this->ob_cat->level($id);  # Текущий уровень выбранной категорий 
        while ($level >= 1) {
            $group[$level] = array(
                'id' => $id,
                'url'=>$this->ob_cat->get_url($id),
                'level' => $level,
                'title' => $this->ob_cat->get_title($id),
                'parents_group' => $this->ob_cat->list_allgroup($this->ob_cat->parent_id($id)));

            $id = $this->ob_cat->parent_id($id);   # Получить id родителя предка
            $level--;                              # Вниз на один уровень
        }

        Yii::app()->session['breadcrumbs'] = array(
            'group' => $group,
            'filter' => $filter,
            'product' => $product,
            'title' => $title,
        );
    }

    //Получить сессии Хлебных крошек
    static function GetBreadSessian() {
        return Yii::app()->session['breadcrumbs'];
    }

    //Очистить сессии Хлебных крошек
    public function ClearBreadSessian() {
        Yii::app()->session['breadcrumbs'] = '';
    }

}
