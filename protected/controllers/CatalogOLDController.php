<?php

class CatalogController extends Controller {

    private $rq;
    private $db;
    private $ob_cat; //Объект модели каталога
    private $ob_pagination; //Объект пагинация
    public $breadcrumbs;  //Переменная доступна в шаблоне

    public function init() {
        $this->rq = Yii::app()->request;
        $this->db = Yii::app()->db;
        $this->ob_cat = new ModelCatalog();
        $this->ob_pagination = new Pagination;
    }

    //Управление каталогом
    public function actionIndex() {
        if (!$this->rq->getQuery('id_spec')) {
            //Получаем url 
            $data['url'] = $this->rq->getQuery('url');
            //Получаем номер страницы
            $pag['page'] = intval($this->rq->getQuery('page'));
            //Найдем id_category b 
            $data['id'] = $this->ob_cat->get_id($data['url']);
            //Найдет название родителя Активное поле типо
            $data['title_parent'] = $this->ob_cat->get_title($data['id']);

            // Получить title дочерних элементов  список категорий
            $data['categories'] = $this->ob_cat->listCategory($data['id']);
            
            //Рандомное описание
            $data['desc']=$this->randomdesc($data['categories']);
       
            //Получить массив для хлебных крошек
            $data['bread'] = $this->ob_cat->free($data['id']);
            $this->breadcrumbs = $data['bread']; //Для шаблона
            Yii::app()->session['breadcrumbs'] = $this->breadcrumbs;
            
            //Пагинация 
            $pag = $this->pagination($data['id'], $data['url'], $pag['page']);

            //Получить все продукты
            $data['products'] = $this->ob_cat->ListProduct($data['id'], $pag['start'], $pag['num']);

            $this->render('index', array('data' => $data, 'pagin' => $pag));
            
        } else {//Если есть фильтр

            //Эти данные помогут для активных фильтров
            $data['url'] = $this->rq->getQuery('url');
            $data['id_cat'] = $this->ob_cat->get_id($data['url']);


            $data['id_spec'] =(int)$this->rq->getQuery('id_spec');
            
            $name_spec=$this->ob_cat->getNameSpec($data['id_spec']);
            $page = intval($this->rq->getQuery('page'));
            
            $pag=$this->paginationFilter($data['id_cat'], $data['url'], $page,$name_spec);
            $pag['id_spec']=$data['id_spec'];
            
            // Получить title дочерних элементов  список категорий
            $data['categories'] = $this->ob_cat->listCategory($data['id_cat']);
            //Рандомное описание
            $data['desc']=$this->randomdesc( $data['categories']);

            //Получить массив для хлебных крошек
            $data['bread'] = $this->ob_cat->free($data['id_cat']);
            $this->breadcrumbs = $data['bread']; //Для шаблона
            Yii::app()->session['breadcrumbs'] = $this->breadcrumbs;
            
            //Получение продуктов по выбранной категории и фильтру
            $data['products'] = $this->ob_cat->GetFilterSpec($data['id_cat'], $name_spec,$pag['start'], $pag['num']);
          
            $this->render('index', array('data' => $data, 'pagin' => $pag));
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

    private function paginationFilter($id, $url, $page,$name_filter) {
        $pag['page'] = $page;
        //общее кол-во записей продуктов
        $pag['posts'] = $this->ob_pagination->AllPageFilter($id,$name_filter);
        
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
    public function randomdesc($data){
         if($data){
            foreach ( $data as $value) {
                $res[]=$value['id'];
                }

            $number = mt_rand(0, count($res) - 1); 
            
            $data = $this->ob_cat->get_all($res[$number]);
            return ($data)?$data:'';
           
            }
       
    }

}
