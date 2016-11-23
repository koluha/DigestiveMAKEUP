<?php

class CatalogController extends Controller {

    private $rq;
    private $db;
    private $ob_cat; //Объект модели каталога
    private $ob_pagination; //Объект пагинация
    private $ob_bread; //Объект хлебных крошек
    public $breadcrumbs;  //Переменная доступна в шаблоне

    public function init() {
        $this->rq = Yii::app()->request;
        $this->db = Yii::app()->db;
        $this->ob_cat = new ModelCatalog();
        $this->ob_pagination = new Pagination;
        $this->ob_bread = new Breadcrumbs;
    }

    public function actiontest() {
    }

    //Управление каталогом
    public function actionIndex() {

        //Если нету фильтра и нет фильтра типа
        if ($this->rq->getQuery('url') && !$this->rq->getQuery('var_filter') && !$this->rq->getQuery('filter_type')) {
            //Получаем url и найдем id_category
            $catal['url'] = $this->rq->getQuery('url');
            $catal['id'] = $this->ob_cat->get_id($catal['url']);
            //Категорий
            $data['categories'] = $this->ob_cat->listCategory($catal['id']);

            //Нужно узнать уроверь вложенности
           // $level=$this->ob_bread->level($catal['id']);
            
   
           /* $data_bread = array('group' => array(
                                                'id'=>$catal['id'],
                                                'level'=>$level,
                                                'title'=> $this->ob_bread->get_title_group($catal['id']),
                                                'parents group'=>$this->ob_bread->list_allgroup($this->ob_bread->parent_id($catal['id']))),
                                'product' => array('id_p', 'url_p', 'title_p'),
                                'filter' => ''
            );
            
            
            $this->ob_bread->SetBreadSessian($data_bread);
            
            $this->breadcrumbs = $data['bread']; //Для шаблона
              */
              

            //Продукты без фильтра
            $data['products'] = $this->ob_cat->ListProduct($catal['id']);
            $this->render('index', array('data' => $data));

            //Если есть фильтра 
        } elseif ($this->rq->getQuery('url') && $this->rq->getQuery('var_filter')) {
            //Получаем url 
            $catal['url'] = $this->rq->getQuery('url');
            $catal['id'] = $this->ob_cat->get_id($catal['url']);
            //Получить родителя категорий
            $catal['parent_id'] = $this->ob_cat->parent($catal['id']);
            //Значение фильтра
            $catal['var_filter'] = $this->rq->getQuery('var_filter');
            //Имя фильтра (массива)
            $catal['name_filter'] = $this->rq->getQuery('name_filter');
            //Продукты c фильтром
            $data['products'] = $this->ob_cat->ListProduct($catal['parent_id'], $catal['name_filter'], $catal['var_filter']);

            $this->render('index', array('data' => $data));


            //Если есть фильтр по типу
        } elseif ($this->rq->getQuery('filter_type')) {
            //Получаем имя поля по фильтру 
            $catal['filter_type'] = trim($this->rq->getQuery('filter_type'));
            //Получаем url 
            $catal['url'] = $this->rq->getQuery('url');
            //Получиим id по url
            $catal['id'] = $this->ob_cat->get_id($catal['url']);
            //Получить родителя категорий
            $catal['parent_group_2'] = $this->ob_cat->parent($catal['id']);
            $catal['parent_group_1'] = $this->ob_cat->parent($catal['parent_group_2']);
            //Получить родителя категорий
            //$catal['parent_id']=$this->ob_cat->parent($catal['id']);


            $catal['name_filter'] = '';
            $catal['var_filter'] = '';
            //Продукты c фильтром
            $data['products'] = $this->ob_cat->ListProduct($catal['parent_group_1'], $catal['name_filter'], $catal['var_filter'], $catal['filter_type']);

            $this->render('index', array('data' => $data));
        }
    }

    private function pagination($id, $url, $page) {
        $pag['page'] = $page;
        //общее кол-во записей продуктов
        $pag['posts'] = $this->ob_pagination->AllPage($id);
        //кол-во записйе на странице
        $pag['num'] = Yii::app()->params['papagination_limit'];
        // Находим общее число страниц  
        $pag['total'] = intval(($pag['posts'] - 1) / $pag['num']) + 1;
        // Если значение $page меньше единицы или отрицательно  
        // переходим на первую страницу  
        // А если слишком большое, то переходим на последнюю 
        if (empty($pag['page']) or $pag['page'] < 0)
            $pag['page'] = 1;
        if ($pag['page'] > $pag['total'])
            $pag['page'] = $pag['total'];
        $pag['start'] = $pag['page'] * $pag['num'] - $pag['num'];

        $pag['url'] = $url;

        return $pag;
    }

    private function paginationFilter($id, $url, $page, $name_filter) {
        $pag['page'] = $page;
        //общее кол-во записей продуктов
        $pag['posts'] = $this->ob_pagination->AllPageFilter($id, $name_filter);

        //кол-во записйе на странице
        $pag['num'] = Yii::app()->params['papagination_limit'];
        // Находим общее число страниц  
        $pag['total'] = intval(($pag['posts'] - 1) / $pag['num']) + 1;
        // Если значение $page меньше единицы или отрицательно  
        // переходим на первую страницу  
        // А если слишком большое, то переходим на последнюю 
        if (empty($pag['page']) or $pag['page'] < 0)
            $pag['page'] = 1;
        if ($pag['page'] > $pag['total'])
            $pag['page'] = $pag['total'];
        $pag['start'] = $pag['page'] * $pag['num'] - $pag['num'];

        $pag['url'] = $url;

        return $pag;
    }

    public function actionFiltrSpec() {
        if ($this->rq->getQuery('url')) {
            //Эти данные помогут для активных фильтров
            $data['url'] = $this->rq->getQuery('url');
            $data['id_cat'] = $this->ob_cat->get_id($data['url']);


            $data['id_spec'] = (int) $this->rq->getQuery('id_spec');
            $pag['page'] = intval($this->rq->getQuery('page'));

            $this->paginationFilter($data['id_cat'], $data['id_cat'], $data['id_spec'], $pag['page']);

            //Получить массив для хлебных крошек
            $data['bread'] = $this->ob_cat->free($data['id_cat']);
            $this->breadcrumbs = $data['bread']; //Для шаблона
            //Получение продуктов по выбранной категории и фильтру
            $data['products'] = $this->ob_cat->GetFilterSpec($data['id_cat'], $data['id_spec']);
            $this->render('index', array('data' => $data));
        }
        //echo '<pre>';
        // print_r($data);
        //print_r( $data['products']);
    }

    //Вернет случайную запись выбраннной категорий
    public function randomdesc($data) {
        if ($data) {
            foreach ($data as $value) {
                $res[] = $value['id'];
            }

            $number = mt_rand(0, count($res) - 1);

            $data = $this->ob_cat->get_all($res[$number]);
            return ($data) ? $data : '';
        }
    }

}
