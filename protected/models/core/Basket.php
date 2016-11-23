<?php

class Basket {

    public $cid;
    public $uid;
    private $req;
    private $db;      //object db

    function __construct() {
        $this->req = Yii::app()->request;
        $this->db = Yii::app()->db;

        //Запись кука для пользователя
        $this->SetCookUserId();
        $this->uid = $this->GetCookUserId();

        //Запись кука для корзины
        $this->SetCookCartId();
        $this->cid = $this->GetCookCartId();
        //Запись в корзину бд
        $this->CreationBasket();
    }

    //Запись в базу новой корзины
    public function CreationBasket() {
        $count = $this->db->createCommand("SELECT COUNT(*) FROM tb_cart WHERE cart_id='$this->cid' AND user_id='$this->uid'")->queryScalar();
        if ($count == 0) {
            $this->db->createCommand("
                INSERT INTO tb_cart(user_id,cart_id) 
                            VALUES('$this->uid','$this->cid')")->execute();
        }
    }

    //Добавление новой записи
    public function Add() {
        $k = 1;  //по умолчанию добавим 1 товар
        $product_id = $this->req->getQuery('product_id');
        if ($product_id) {
            //Проверяем добавлен уже ли такой товар в корзину 
            $count = $this->db->createCommand("SELECT count(*) FROM tb_cart_content WHERE cart_id='$this->cid' AND cart_content_id='$product_id' ")->queryScalar();
            if ($count == 1) {
                $this->db->createCommand("UPDATE tb_cart_content SET cart_count=cart_count+1 WHERE cart_id='$this->cid' AND cart_content_id='$product_id'")->execute();
            } elseif ($count == 0) {
                $this->db->createCommand("INSERT INTO tb_cart_content(cart_id,cart_content_id,cart_count) VALUES('$this->cid','$product_id','$k')")->execute();
            }
        } else {
            throw new Exception('Не получен Id товара');
        }
    }

    //Просмотр корзины
    public function Show() {
        $data = $this->db->createCommand("SELECT c.id,c.cart_id,c.cart_content_id,c.cart_count,
              p.i_name_sku ,p.i_price          
                
                 FROM tb_cart_content  AS c 
                    INNER JOIN tb_product AS p ON   c.cart_content_id=p.id 
                         WHERE c.cart_id='$this->cid'")->queryAll();
        return $data;
    }

    //Удаление из корзины
    public function Del($id_cart_context) {
        Yii::app()->db->createCommand("DELETE FROM tb_cart_content WHERE id='$id_cart_context'")->execute();
    }

    //Увеличить значение кол-ва
    public function plus($id) {
        $this->db->createCommand("UPDATE tb_cart_content SET cart_count=cart_count+1 WHERE cart_id='$this->cid' AND id='$id'")->execute();
    }

    public function minus($id) {
        $cart_count = $this->db->createCommand("SELECT cart_count FROM tb_cart_content WHERE cart_id='$this->cid' AND id='$id'")->queryScalar();
        if ($cart_count > 1) {
            $this->db->createCommand("UPDATE tb_cart_content SET cart_count=cart_count-1 WHERE cart_id='$this->cid' AND id='$id'")->execute();
        }
    }

    //Общая Сумма Руб.
    public function total() {
        $total = $this->db->createCommand("SELECT sum(p.i_price*c.cart_count) AS total
                FROM tb_cart_content AS c
                  INNER JOIN tb_product AS p 
                    ON c.cart_content_id=p.id
                       WHERE cart_id='$this->cid'")->queryScalar();
        return ($total ? $total : 0);
    }

    //Кол-во товара в корзине запись в куки
    public function Getquantity() {
        $quantity = $this->db->createCommand("SELECT COUNT(*) FROM tb_cart_content AS c
                       WHERE cart_id='$this->cid'")->queryScalar();
        //Записать в куки
        $cook = new CHttpCookie('quantity', $quantity);
        $this->req->cookies['quantity'] = $cook;
    }
    
    //Сумма товара в корзине запись в куки
    public function Getcartsumma() {
        $cartsumma = $this->total();
        //Записать в куки
        $cook = new CHttpCookie('cartsumma', $cartsumma);
        $this->req->cookies['cartsumma'] = $cook;
    }
    
    //Вернет кол-во в корзине
    public function quantity() {
        $quantity = $this->db->createCommand("SELECT COUNT(*) FROM tb_cart_content AS c
                       WHERE cart_id='$this->cid'")->queryScalar();
        //Записать в куки
        return $quantity;
    }

    public function Setquantity() {
        $quantity = $this->req->cookies['quantity']->value;
        return ($quantity ? $quantity : 0);
    }

    static function MigrationUserId() {
        //Получить id зарегистрированного пользователя изменить польз-ля на зареганного
        if (Yii::app()->user->getId()) {
            $user = Yii::app()->user->getId();
            $cart_id = Yii::app()->request->cookies['cart_id']->value;
            Yii::app()->db->createCommand("UPDATE tb_cart SET user_id ='$user' WHERE cart_id = '$cart_id'")->execute();
        }
    }

/////////////////////////////////////////////////////////////////
    //Присвоить id пользователя
    public function SetCookUserId() {
        //$user=Yii::app()->user->getId();
        if (isset($this->req->cookies['user_id']->value)) {
            $uid = $this->req->cookies['user_id']->value;
        } else {
            $cookie = new CHttpCookie('user_id', Guid::model()->getGUID(FALSE));
            $cookie->expire = time() + 3600;
            $this->req->cookies['user_id'] = $cookie;
            $uid = $this->req->cookies['user_id']->value;
        }
        $this->uid = $uid;
    }

    public function GetCookUserId() {
        return $this->uid;
    }

    //Присвоить id корзины
    public function SetCookCartId() {
        if (isset($this->req->cookies['cart_id']->value)) {
            $cid = $this->req->cookies['cart_id']->value;
        } else {
            $cookie = new CHttpCookie('cart_id', Guid::model()->getGUID(FALSE));
            //$cookie->expire = time() + 3600;
            $this->req->cookies['cart_id'] = $cookie;
            $cid = $this->req->cookies['cart_id']->value;
        }
        $this->cid = $cid;
    }

    public function GetCookCartId() {
        return $this->cid;
    }

}
