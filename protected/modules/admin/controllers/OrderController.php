<?php

Class OrderController extends Controller {

    private $user_id;
    private $cart_id;

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'ajaxOnly + editstatus',
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('executionone', 'view', 'test', 'QuickOrder'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('list'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('adminlist', 'adminlistuser', 'adminlistorder', 'editstatus'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function init() {
        $this->layout = 'column1';
        $this->user_id = !Yii::app()->user->isGuest ? Yii::app()->user->getId() : NULL;
        $this->cart_id = isset(Yii::app()->request->cookies['cart_id']) ? Yii::app()->request->cookies['cart_id']->value : NULL;
    }

    public function actionTest() {
        $mail = new Mail;
        $data = array('order' => 65);
        $mail->notice_order_admin($data);
    }

    //Оформление заказа для зарегистрированного пользователя
    public function actionExecutionOne() {

        $user_id = !Yii::app()->user->isGuest ? Yii::app()->user->getId() : NULL;
        // Проверяем есть ли cookie с ID корзины. 
        $cart_id = isset(Yii::app()->request->cookies['cart_id']) ? Yii::app()->request->cookies['cart_id']->value : NULL;

        //Если поль-тель зарегистрирован то показывает сокрашенную форму
        if (!Yii::app()->user->isGuest) {
            $form = new OrderExecutionOneForm;

            if (isset($_POST['OrderExecutionOneForm'])) {
                $form->attributes = Yii::app()->request->getPost('OrderExecutionOneForm', array());
                if ($form->validate()) {

                    //создаем запись в тб связи tb_order  
                    $date = date("Y-m-d H:i:s");

                    Yii::app()->db->createCommand("INSERT INTO tb_order (id_user,comments,delivery,date)
                               VALUES ('$this->user_id', '$form->comments','$form->delivery','$date')")->execute();
                    $id_order = Yii::app()->db->getLastInsertID(); //Последнии сгененированный id 
                    $date = date("Y-m-d H:i:s");

                    //Copy записей корзины в тб tb_order_content, так же соединяются записи имени
                    Yii::app()->db->createCommand("INSERT INTO tb_order_content (id_order,id_good,count, status, date, title, price)
                                       SELECT '$id_order', cart_content_id, cart_count, '1', '$date', p.title, p.price
                                       FROM tb_cart_content AS z
                                           INNER JOIN tb_product AS p ON p.id = z.cart_content_id
                                                 WHERE z.cart_id='$this->cart_id' ")->execute();
                    //Очистить корзину 
                    Yii::app()->db->createCommand("DELETE FROM tb_cart_content WHERE cart_id='$this->cart_id'")->execute();

                    ////////////////Mail
                    $user = UserModel::model()->findByPk($user_id);
                    $mail = new Mail();
                    $data = array('order' => $id_order);
                    $mail->notice_order_admin($data);              //Администратору
                    $mail->notice_order_user($user->mail, $data);  //Покупателю
                    ///////////////////////
                    //Чистка корзины
                    Yii::app()->db->createCommand("DELETE FROM tb_cart_content WHERE cart_id=UNHEX('$cart_id') ")->execute();

                    
                    $this->render('end', array('id_order' => $id_order));
                }
            }
            $this->render('first', array('form' => $form));
        }

        //Если поль-тель аноним то полная форма - Регистрация
        if (Yii::app()->user->isGuest) {
            Yii::app()->createUrl('user/registeruser');
            $this->redirect(Yii::app()->createUrl('user/registeruser'));
        }
    }

    //Заказы клиента список
    public function actionList() {
        $data = Yii::app()->db->createCommand("SELECT c.id_order, c.brand, c.article, c.name, c.price, c.count, s.status,p.price,c.date
          FROM tb_order_content AS c
            INNER JOIN tb_order AS o ON c.id_order = o.id_order
            INNER JOIN p_parts AS p ON p.id = c.id_good
                      INNER JOIN tb_order_status AS s ON s.id = c.status
                        WHERE o.id_user ='$this->user_id' ORDER BY o.id_order DESC 
          ")->queryAll();
        $this->render('index', array('orders' => $data));
    }

    //Заказы для администратора список
    public function actionAdminList() {
        $data = Yii::app()->db->createCommand(" SELECT o.id_order, IFNULL(u.username,'Аноним') AS username,id_user,  o.comments, o.delivery, o.anonymousUser, o.date
                                                 FROM tb_order AS o
                                                    LEFT JOIN tb_user AS u ON u.id = o.id_user
                                                       ORDER BY id_order DESC 
          ")->queryAll();
        if ($data) {
            $this->render('admin_index', array('orders' => $data));
        } else {
            $this->render('admin_error');
        }
    }

    public function actionAdminListUser() {
        $id_user = Yii::app()->request->getQuery('id_user');
        $user = Yii::app()->db->createCommand("SELECT username,fio,mail,tel,delivery,date_reg
                                                 FROM tb_user WHERE id=$id_user
             ")->queryRow();
        if ($user) {
            $this->render('admin_user', array('user' => $user));
        } else {
            $this->render('admin_error');
        }
    }

    public function actionAdminListOrder() {
        $id_order = Yii::app()->request->getQuery('id_order');
        $id_user = Yii::app()->request->getQuery('id_user');

        $orders = Yii::app()->db->createCommand("SELECT c.id, c.id_order, c.brand, c.article, c.title, c.price, c.count,c.date, s.status
          FROM tb_order_content AS c
            INNER JOIN tb_order AS o ON c.id_order = o.id_order
            INNER JOIN tb_order_status AS s ON s.id = c.status
                        WHERE o.id_user ='$id_user' AND c.id_order='$id_order'   ORDER BY o.id_order DESC")->queryAll();
        if ($orders) {
            // при помощи listData создаем массив вида $ключ=>$значение
            $list_status = CHtml::listData(OrderStatus::model()->findAll(), 'id', 'status');

            $this->render('admin_order', array('orders' => $orders,
                'list' => $list_status));
        } else {
            $this->render('admin_error');
        }
    }

    public function actionEditStatus() {
        if (Yii::app()->request->isAjaxRequest) {

            $id = Yii::app()->request->getQuery('id'); //Номер записи

            $id_status = Yii::app()->request->getPost('id_status');

            Yii::app()->db->createCommand("UPDATE tb_order_content SET status='$id_status'
          WHERE id='$id'")->execute();

            //////////Отправить на мыло оповещание покупателю
            ////////////

            Yii::app()->end();
        }
    }

    static function defaultStatus($id) {
        $default = Yii::app()->db->createCommand("SELECT status FROM tb_order_content WHERE id=$id")->queryScalar();
        return $default;
    }

    //Отправить всю форму заказа
    public function mail_to_list() {
        $arr = Yii::app()->request->getPost(' ');
        // В доработке
    }

    //Заказ в один клик от быстрой формы
    public function actionQuickOrder() {
        $user_id = !Yii::app()->user->isGuest ? Yii::app()->user->getId() : NULL;
        // Проверяем есть ли cookie с ID корзины. 
        $cart_id = isset(Yii::app()->request->cookies['cart_id']) ? Yii::app()->request->cookies['cart_id']->value : NULL;
        //Защита от бота, проверим наполнена ли корзина
        $cart = new Basket;
        $k = $cart->quantity(); //Если корзина не пуста
        if ($k>0) {
            $form = new QuickForm;
            $form->attributes = $_POST['QuickForm'];
            if ($form->validate()) {
                //создаем запись в тб связи tb_order  
                $date = date("Y-m-d H:i:s");
                $label = 'Имя: ' . $form->name . '    Телефон: ' . $form->phone . '    Mail: ' . $form->email;
                Yii::app()->db->createCommand("INSERT INTO tb_order (id_user,comments,date)
                               VALUES ('$this->user_id', '$label','$date')")->execute();

                $id_order = Yii::app()->db->getLastInsertID(); //Последнии сгененированный id 
                $date = date("Y-m-d H:i:s");

                //Copy записей корзины в тб tb_order_content, так же соединяются записи имени
                Yii::app()->db->createCommand("INSERT INTO tb_order_content (id_order,id_good,count, status, date, brand, article, name, price)
                                       SELECT '$id_order',cart_content_id ,cart_count, '1', '$date', p.brand, p.article, p.title, p.price
                                       FROM tb_cart_content AS z
                                           INNER JOIN tb_product AS p ON p.id = z.cart_content_id
                                                 WHERE z.cart_id='$this->cart_id' ")->execute();
                //Очистить корзину 
                Yii::app()->db->createCommand("DELETE FROM tb_cart_content WHERE cart_id='$this->cart_id'")->execute();

                ////////////////Mail
                $user = UserModel::model()->findByPk($user_id);
                $mail = new Mail();
                $data = array('order' => $id_order);
                $mail->notice_order_admin($data);              //Администратору
                
                $mail->notice_order_user($form->email, $data);  //Покупателю
                ///////////////////////
                //Чистка корзины
                Yii::app()->db->createCommand("DELETE FROM tb_cart_content WHERE cart_id=UNHEX('$cart_id') ")->execute();

                $this->render('end', array('id_order' =>$id_order));
            }
        }  else {
            return FALSE; 
        }
    }

}
