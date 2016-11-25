<?php

class ProductController extends Controller {
    
    private $rq;
    private $db;
    private $ob_prod; //Объект модели каталога
    private $ob_bread; //Объект модели хлебных крошек

    public function init() {
        $this->rq = Yii::app()->request;
        $this->db = Yii::app()->db;
        $this->ob_prod = new Product;
        $this->ob_bread = new Breadcrumbs;
    }

    //Карточка товара
    public function actionIndex(){
        if($this->rq->getQuery('url')){
            $url=$this->rq->getQuery('url');
           
            //Найти данные товара
            $product['desc']=$this->ob_prod->DescProduct($url);
            
           // echo $product['desc']['key_group_1'].'-'.$product['desc']['key_group_2'].'-'.$product['desc']['key_group_3'].'-';
            
            //Поиск последней категории этого продукта
            if($product['desc']['key_group_3']!=0){
                $id_c=$product['desc']['key_group_3'];
            }elseif ($product['desc']['key_group_2']!=0) {
                $id_c=$product['desc']['key_group_2'];
            }elseif ($product['desc']['key_group_1']!=0) {
                $id_c=$product['desc']['key_group_1'];
            }
            if($id_c==''){
                echo 'В таблице продукт отсутвуют значения категорий';
            }
             //Работа хлебных крошек, передаем наименование и ид продукта
            $this->ob_bread->ClearBreadSessian;
            $this->ob_bread->SetBreadSessian($product['desc']['i_name_sku'],'',$id_c);
            
            //Установить мета данные 
            Yii::app()->params['meta_title']=$product['desc']['t_meta_title'];
            Yii::app()->params['meta_keywords']=$product['desc']['t_meta_keyword'];
            Yii::app()->params['meta_description']=$product['desc']['t_meta_description'];
            
            
            $this->render('index', array('data'=>$product));
            
         
        }
    }



}
