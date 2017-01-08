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
        $this->ob_pagination = new Pagination($id, $url, $page);
        $this->ob_bread = new Breadcrumbs;
    }


    //Управление каталогом
    public function actionIndex() {

        //Если нету фильтра 
        if ($this->rq->getQuery('url') && !$this->rq->getQuery('var_filter') && !$this->rq->getQuery('filter_type')) {
            //Получаем url и найдем id_category
            $catal['url'] = $this->rq->getQuery('url');
            $catal['id'] = $this->ob_cat->get_id($catal['url']);
            //Категорий
            $data['categories'] = $this->ob_cat->listCategory($catal['id']);
            
            //Рандомное описание
            $data['desc']=$this->randomdesc($data['categories']);
          
            //Работа хлебных крошек
            $this->ob_bread->SetBreadSessian('','',$catal['id']);
            # $this->breadcrumbs = $data['bread']; //Для шаблона
            
            //Пагинация 
            $page = intval($this->rq->getQuery('page'));
            $pag = $this->ob_pagination->use_pagination($catal['id'], $catal['url'], $page);
           
            //Продукты без фильтра
            $data['products'] = $this->ob_cat->ListProduct($catal['id'],'','',$pag['start'], $pag['num']);
            
            
              
              
            $this->render('index', array('data' => $data, 'pagin' => $pag));

            //Если есть фильтра 
        } elseif ($this->rq->getQuery('url') && $this->rq->getQuery('var_filter')) {
            //Получаем url 
            $catal['url'] = $this->rq->getQuery('url');
            $catal['id'] = $this->ob_cat->get_id($catal['url']);
            //Получить родителя категорий
            $catal['parent_id'] = $this->ob_cat->parent_id($catal['id']);
            //Значение фильтра
            $catal['var_filter'] = $this->rq->getQuery('var_filter');
            //Имя фильтра (массива)
            $catal['name_filter'] = $this->rq->getQuery('name_filter');
            
            
            
           //Пагинация 
            $page = intval($this->rq->getQuery('page'));
            $pag = $this->ob_pagination->use_paginationfilter($catal['parent_id'], $catal['url'], $page, $catal['name_filter'], $catal['var_filter']);
            //Передаем данные фильтра
            $pag['var_filter']=$catal['var_filter'];
            $pag['name_filter']=$catal['name_filter'];
            
            //Категорий
            $data['categories'] = $this->ob_cat->listCategory($catal['id']);
             //Рандомное описание
            $data['desc']=$this->randomdesc($data['categories']);
      
            //Продукты c фильтром
            $data['products'] = $this->ob_cat->ListProduct($catal['parent_id'], $catal['name_filter'], $catal['var_filter'],$pag['start'], $pag['num']);

            //Работа хлебных крошек
            $this->ob_bread->ClearBreadSessian;
            $this->ob_bread->SetBreadSessian('',$catal['var_filter'],$catal['parent_id']);
            
            $this->render('index', array('data' => $data,'pagin' => $pag));

        } 
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
