<?php

class ProductController extends Controller {
    
    private $rq;
    private $db;
    private $ob_prod; //Объект модели каталога

    public function init() {
        $this->rq = Yii::app()->request;
        $this->db = Yii::app()->db;
        $this->ob_prod = new Product;
    }

    //Карточка товара
    public function actionIndex(){
        if($this->rq->getQuery('url')){
            $url=$this->rq->getQuery('url');
           
            //Найти данные товара
            $product['desc']=$this->ob_prod->DescProduct($url);
            
            //Установить мета данные 
            Yii::app()->params['meta_title']=$product['desc']['t_meta_title'];
            Yii::app()->params['meta_keywords']=$product['desc']['t_meta_keyword'];
            Yii::app()->params['meta_description']=$product['desc']['t_meta_description'];
            
            
            $this->render('index', array('data'=>$product));
        }
    }

    //Продукты отобранные по фильтру
    public function actionFiltrSpec() {
        if ($this->rq->getQuery('id_cat')) {
            
            $data['id_cat'] = $this->rq->getQuery('id_cat');
            $data['id_spec'] = $this->rq->getQuery('id_spec');
            
            $res=$this->ob_prod->GetFilterSpec($data['id_cat'],$data['id_spec']);
            
       }
        echo '<pre>';
        print_r($data);
        print_r($res);
    }

}
