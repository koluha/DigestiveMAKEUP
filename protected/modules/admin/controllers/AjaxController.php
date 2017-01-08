<?php

//Контроллер Категорий и Продукта
class AjaxController extends AController {

    public $layout = false;

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->error('access denied');
            return false;
        } else {
            return true;
        }
    }

    public function actionTest() {
        $fname = Yii::app()->basePath . '/runtime/' . uniqid('', true);
        $reader = new Spreadsheet_Excel_Reader();
        $this->out(array(
            'msg' => 'OK',
        ));
    }

    public function actionUploadPrice() {

        $rq = Yii::app()->request;

        //$type = $rq->getPost('type', '');
        $pid = $rq->getPost('pid', '');

        try {
            $file = new File('price');
            $fname = Yii::app()->basePath . '/runtime/' . uniqid('', true);
            $file->move($fname);
            //AJAX::flushReport();
            $output = array();
            if ($pid) {
                $processor = new PriceUploaderModel($fname, $pid, true);
                $processor->process();
            } else {
                throw new Exception('Неверный тип прайса');
            }
            $this->out(array(
                'error' => false,
                'msg' => 'OK',
                'mem' => memory_get_peak_usage(true) / 1024 / 1024,
                'out' => $output
            ));
        } catch (Exception $ex) {
              $this->error($ex->getMessage());
        }
    }

    //Добавлет группу  и изменяет
    public function actionajaxdogroup() {
        $rq = Yii::app()->request;
        $title = $rq->getPost('title', '');
        $url = Myhelper::translitUrl($rq->getPost('url', ''));
        $id = $rq->getPost('id_up', '');

        $action = $rq->getPost('action', '');

        Yii::app()->session['ses_id_group'] = $id;

        try {
            if ($action == 1) {
                //Проверим url 
                $chek = ModelCatalog::chek($action, $url);
                if (!$chek) { // Если нет такого url то добавляем
                    $sql = "INSERT INTO tb_catalog (parent_id,title,url) values (0,'$title','$url')";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой URL существует'
                    ));
                }
            } elseif ($action == 0) {
                //Проверим url 
                $chek = ModelCatalog::chek($action, $url, $id);
                if (!$chek) { // Если нет такого url то добавляем
                    $sql = "UPDATE tb_catalog SET title='$title', url='$url' WHERE id='$id'";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой utl существует'
                    ));
                }
            }
        } catch (Exception $e) {
            $this->error('error', 0, array(
                'title' => $e->getMessage()
            ));
        }

        $this->out(array(
            'error' => false,
            'msg' => $action
        ));
    }

    //Добавляет Категорию  и изменяет её
    public function actionajaxdocat() {
        $rq = Yii::app()->request;
        $title = $rq->getPost('title', '');
        $url = Myhelper::translitUrl($rq->getPost('url', ''));
        $img = $rq->getPost('img', '');
        $desc_product = $rq->getPost('desc_product', '');

        $set_size_img = (int) $rq->getPost('MAX_FILE_SIZE', '');
        $size_img_load = (int) $_FILES['filename']['size'];

        $id_group = $rq->getPost('id_gr', '');
        //Еще для ред ид категорию нужно
        $id_cat = $rq->getPost('id_up', '');

        $action = $rq->getPost('action', '');

        Yii::app()->session['ses_id_group'] = $id_group;

        try {

            //Проверка фото на размер
            if ($_FILES['filename']['name'] && ($set_size_img <= $size_img_load)) {
                $this->out(array(
                    'error' => TRUE,
                    'msg' => 'Фотки большие '
                ));
            }

            if ($action == 1) {
                $chek = ModelCatalog::chek($action, $url);
                if (!$chek) { // Если нет такого url то добавляем
                    //запись файла
                    if ($_FILES['filename']['name']) {

                        $file = new File('filename');
                        $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                        //разбить название файла на 2 части
                        $f = explode(".", $_FILES['filename']['name']);
                        $new_file = $url . '.' . $f[1];
                        $img = $new_file;

                        $uploadfile = $uploaddir . $new_file;
                        $file->move($uploadfile);
                    }
                    $sql = "INSERT INTO tb_catalog (parent_id, title, url, img, desc_product) values ('$id_group','$title','$url','$img','$desc_product')";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой URL существует'
                    ));
                }
            } elseif ($action == 0) {
                $chek = ModelCatalog::chek($action, $url, $id_cat);
                if (!$chek) { // Если нет такого url то добавляем
                    //запись файла
                    if ($_FILES['filename']['name']) {

                        $file = new File('filename');
                        $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                        //разбить название файла на 2 части
                        $f = explode(".", $_FILES['filename']['name']);
                        $new_file = $url . '.' . $f[1];
                        $img = $new_file;

                        $uploadfile = $uploaddir . $new_file;
                        @unlink($uploadfile); //удаляем предыдущую фотку
                        $file->move($uploadfile);
                    }

                    $sql = "UPDATE tb_catalog SET title='$title', url='$url' , img='$img', desc_product='$desc_product' WHERE id='$id_cat'";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой URL существует'
                    ));
                }
            }
            //получим список для второго selecta и обновим через Ajax, чтобы новое значение уже было в селекте
            $select_cat = $this->DropCategory($id_group);
        } catch (Exception $e) {
            $this->error('error', 0, array(
                'title' => $e->getMessage()
            ));
        }

        $this->out(array(
            'error' => false,
            'msg' => 'ОК',
            'id_group' => $id_group,
            'select_cat' => $select_cat
        ));
    }

    //Добавляет Тип  и изменяет 
    public function actionajaxdotype() {
        $rq = Yii::app()->request;
        $title = $rq->getPost('title', '');
        $check_class = $rq->getPost('check_class', '');
        $url = Myhelper::translitUrl($rq->getPost('url', ''));
        $img = $rq->getPost('img', '');
        $desc_product = $rq->getPost('desc_product', '');


        $set_size_img = (int) $rq->getPost('MAX_FILE_SIZE', '');
        $size_img_load = (int) $_FILES['filename']['size'];

        $id_cat = $rq->getPost('id_cat', '');
        //Еще для ред ид категорию нужно
        $id_type = $rq->getPost('id_up', '');

        $action = $rq->getPost('action', '');

        Yii::app()->session['ses_id_cat'] = $id_cat;

        try {
            //Проверка фото на размер
            if ($_FILES['filename']['name'] && ($set_size_img <= $size_img_load)) {
                $this->out(array(
                    'error' => TRUE,
                    'msg' => 'Фотки большие '
                ));
            }



            if ($action == 1) {
                $chek = ModelCatalog::chek($action, $url);
                if (!$chek) { // Если нет такого url то добавляем
                    //запись файла
                    if ($_FILES['filename']['name']) {

                        $file = new File('filename');
                        $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                        //разбить название файла на 2 части
                        $f = explode(".", $_FILES['filename']['name']);
                        $new_file = $url . '.' . $f[1];
                        $img = $new_file;

                        $uploadfile = $uploaddir . $new_file;
                        $file->move($uploadfile);
                    }
                    $sql = "INSERT INTO tb_catalog (parent_id, title, url, img, desc_product, check_class) values ('$id_cat','$title','$url','$img','$desc_product','$check_class')";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой URL существует'
                    ));
                }
            } elseif ($action == 0) {
                $chek = ModelCatalog::chek($action, $url, $id_type);
                if (!$chek) { // Если нет такого url то добавляем
                    //запись файла
                    if ($_FILES['filename']['name']) {

                        $file = new File('filename');
                        $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                        //разбить название файла на 2 части
                        $f = explode(".", $_FILES['filename']['name']);
                        $new_file = $url . '.' . $f[1];
                        $img = $new_file;

                        $uploadfile = $uploaddir . $new_file;
                        @unlink($uploadfile); //удаляем предыдущую фотку
                        $file->move($uploadfile);
                    }

                    $sql = "UPDATE tb_catalog SET title='$title', url='$url' , img='$img', desc_product='$desc_product', check_class='$check_class' WHERE id='$id_type'";
                    Yii::app()->db->createCommand($sql)->execute();
                } else {
                    $this->out(array(
                        'error' => TRUE,
                        'msg' => 'Такой URL существует'
                    ));
                }
            }
            //получим список для второго selecta и обновим через Ajax, чтобы новое значение уже было в селекте
            $select_cat = $this->DropType($id_cat);
        } catch (Exception $e) {
            $this->error('error', 0, array(
                'title' => $e->getMessage()
            ));
        }

        $this->out(array(
            'error' => false,
            'msg' => $_POST,
            'id_group' => $id_group,
            'select_cat' => $select_cat
        ));
    }

    //Добавлет спецификацию изменяет её
    public function actionajaxdospec() {
        $rq = Yii::app()->request;
        $id_prod = $rq->getPost('id_prod', '');
        $id_cat = $rq->getPost('id_cat', '');

        $id_spec = $rq->getPost('drop_spec', '');
        $val_spec = $rq->getPost('val_spec', '');



        $action = $rq->getPost('action', '');
        //$id_up = $rq->getPost('id_up', '');

        $transaction = Yii::app()->db->beginTransaction();
        $type_field = '';
        try {
            //Найдем тип спецификации
            $type = Yii::app()->db->createCommand("SELECT type FROM  tb_product_spec WHERE id='$id_spec' ")->queryScalar();

            switch ($type) {
                case 'text':
                    $type_field = 'val_text';
                    break;
                case 'int':
                    $type_field = 'val_int';
                    break;
                case 'float':
                    $type_field = 'val_float';
                    break;
            }
            if ($action == 1) {   //На добавление
                //Добавить значение спецификации
                //В зависимости от значения спецификаций
                $sql = "INSERT INTO tb_spec_value (key_prod_spec, $type_field) values ('$id_spec','$val_spec')";
                Yii::app()->db->createCommand($sql)->execute();
                $id = Yii::app()->db->getLastInsertID(); //Последнии сгененированный id  таблицы tb_spec_value
                //Добавить в тб связь
                $sql = "INSERT INTO tb_link (key_spec_value, key_product) values ('$id','$id_prod')";
                Yii::app()->db->createCommand($sql)->execute();
            } elseif ($action == 0) {
                // $sql = "UPDATE tb_catalog SET title='', url='' , img='' WHERE id=''";
                // Yii::app()->db->createCommand($sql)->execute();
            }

            //Нужно ид категории для обновлении грида ajax форма продуктов
            $ajaxform = $this->alllist($id_cat);

            $transaction->commit();

            $this->out(array(
                'error' => FALSE,
                'msg' => 'ОК',
                'select' => $type,
                'ajaxform' => $ajaxform,
            ));
        } catch (Exception $e) {
            $transaction->rollback();

            $this->out(array(
                'error' => TRUE,
                'msg' => '',
                'select' => ''
            ));
        }
    }

    //Получает id выбранного селекта
    //Возврашает данные  для заполнения в edit для редактирования group
    public function actionajaxdatagroup() {
        $rq = Yii::app()->request;
        $id = (int) $rq->getPost('id_group', '');
        if ($id > 0) {
            //Получаем данные
            //Отправляем серверу
            try {
                $sql = "SELECT id, parent_id, title, url, img FROM tb_catalog WHERE id='$id'";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                $this->out(array(
                    'error' => false,
                    'msg' => 'OK',
                    'data' => $data
                ));
            } catch (Exception $e) {
                $this->error('error', 0, array());
            }
        } elseif ($id == 0) {
            $this->error('Не выбрана группа', 0, array());
        }
        //$this->out($id);
    }

    //Получает id выбранного селекта
    //Возврашает данные  для заполнения в edit для редактирования cat
    public function actionajaxdatacat() {
        $rq = Yii::app()->request;
        $id = (int) $rq->getPost('id_cat', '');
        if ($id > 0) {
            //Получаем данные
            //Отправляем серверу
            try {
                $sql = "SELECT id, parent_id, title, url, img,desc_product FROM tb_catalog WHERE id='$id'";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                $this->out(array(
                    'error' => false,
                    'msg' => 'OK',
                    'data' => $data
                ));
            } catch (Exception $e) {
                $this->error('error', 0, array());
            }
        } elseif ($id == 0) {
            $this->error('Не выбрана Категория', 0, array());
        }
        //$this->out($id);
    }

    //Возврашает данные  для заполнения в edit для редактирования cat
    public function actionajaxdatatype() {
        $rq = Yii::app()->request;
        $id = (int) $rq->getPost('id_type', '');
        if ($id > 0) {
            //Получаем данные
            //Отправляем серверу
            try {
                $sql = "SELECT id, parent_id, title, url, img,desc_product,check_class FROM tb_catalog WHERE id='$id'";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                $this->out(array(
                    'error' => false,
                    'msg' => 'OK',
                    'data' => $data
                ));
            } catch (Exception $e) {
                $this->error('error', 0, array());
            }
        } elseif ($id == 0) {
            $this->error('Не выбрана тип', 0, array());
        }
        //$this->out($id);
    }

    //Получает id продукта
    //Возврашает данные  для заполнения в input для редактирования продукта
    public function actionajaxdataprod() {
        $rq = Yii::app()->request;
        $id = (int) $rq->getPost('id_prod', '');
        if ($id > 0) {
            //Получаем данные
            //Отправляем серверу
            try {
                $sql = "SELECT id, title, price, old_price, availability, url, img, meta_title, meta_keywords,meta_description  FROM tb_product WHERE id='$id'";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                $this->out(array(
                    'error' => false,
                    'msg' => 'OK',
                    'data' => $data
                ));
            } catch (Exception $e) {
                $this->error('error', 0, array());
            }
        } elseif ($id == 0) {
            $this->error('Не выбрана Категория', 0, array());
        }
        //$this->out($id);
    }

    //Функция возвращает список SELECT
    public function DropCategory($id) {
        $id = intval($id);
        $sql = "SELECT id, parent_id, title FROM tb_catalog WHERE parent_id='$id' ORDER BY title ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $list[] = '(Выбрать категорию)';
        foreach ($data as $value) {
            $list[$value['id']] = $value['id'] . '-' . $value['title'];
        }
        foreach ($list as $value => $name) {
            $res.=CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        return $res;
    }

    //Функция возвращает список SELECT
    public function DropType($id) {
        $id = intval($id);
        $sql = "SELECT id, parent_id, title FROM tb_catalog WHERE parent_id='$id' ORDER BY title ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $list[] = '(Выбрать Тип)';
        foreach ($data as $value) {
            $list[$value['id']] = $value['id'] . '-' . $value['title'];
        }
        foreach ($list as $value => $name) {
            $res.=CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        return $res;
    }

    //!!!!!!!!!!!!!!!!!Вкладка Продукт

    public function actionajaxlist($id = '') {
        $text = '';
        $rq = Yii::app()->request;
        $id = (int) $rq->getPost('id_category', '');
        $sql = "SELECT id,title, key_catalog, price, old_price, availability, url, meta_title, meta_keywords, meta_description FROM tb_product WHERE key_catalog='$id' ORDER BY id ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $text = $this->formatbodytable($data);
        echo $text;
    }

    //Вкладка Продукт
    public function alllist($id = '') {
        $text = '';
        $rq = Yii::app()->request;
        $sql = "SELECT id, title, key_catalog, price, old_price, availability, url, meta_title, meta_keywords, meta_description FROM tb_product WHERE key_catalog='$id' ORDER BY id ASC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();

        $text = $this->formatbodytable($data);
        return $text;
    }

    //Формирование вывод таблицы
    public function formatbodytable($data) {
        $tb_body = '';
        if ($data) {
            foreach ($data as $i => $value) {
                $tb_body.='<tr class="label_tb">';
                $tb_body.='<td width="5" ><b>' . $value['id'] . '</b></td>';
                $tb_body.='<td><b>' . $value['title'] . '</b></td>';
                $tb_body.='<td>' . $value['price'] . '</td>';
                $tb_body.='<td>' . $value['old_price'] . '</td>';

                $checked = $value['availability'] == 0 ? ' ' : "checked";
                $val = $value['availability'] == 0 ? 'OFF' : 'ON';
                $tb_body.='<td><input disabled type="checkbox"  name="aval"' . $checked . ' value=' . $val . '></td>';

                $tb_body.='<td>' . $value['url'] . '</td>';
                $tb_body.='<td>' . $value['meta_title'] . '</td>';
                $tb_body.='<td>' . $value['meta_keywords'] . '</td>';
                $tb_body.='<td>' . $value['meta_description'] . '</td>';

                $tb_body.='<td><button id="button_update_prod"  data-idproduct="' . $value['id'] . '">Изменить</button>';
                $tb_body.='<td><button id="button_delete_prod"  data-idproduct="' . $value['id'] . '">Удалить</button>';

                $tb_body.='</tr>';
                //Вывести спецификацию
                $tb_body.='<tr >';
                $tb_body.='<td colspan="2"><b>Характеристика:</b></td>';
                $tb_body.='<td><b>Название</b></td>';
                $tb_body.='<td><b>Тип</b></td>';
                $tb_body.='<td><b>Значение</b></td>';
                $tb_body.='</tr>';

                $data_spec = $this->getlistspec($value['id']);
                foreach ($data_spec as $valsp) {
                    $tb_body.='<tr class="label_tb">';
                    $tb_body.='<td colspan="2"></td>';
                    $tb_body.='<td>' . $valsp['name'] . '</td>';
                    $tb_body.='<td>' . $valsp['type'] . '</td>';
                    $tb_body.='<td>' . $valsp['val_spec'] . '</td>';

                    $tb_body.='<td></td>';

                    $tb_body.='<td><button id="button_del_spec"  data-idproduct="' . $value['id'] . '" data-idspec="' . $valsp['id_spec_value'] . '" >Удалить</button>';
                    $tb_body.='</tr>';
                }

                $tb_body.='<td><button id="button_add_spec"  data-idproduct="' . $value['id'] . '">Добавить характеристику</button>';
                $tb_body.='<tr class="label_tb2"><td colspan="11" class="label_tb2"></td></tr>';
                $tb_body.='<tr class="label_tb0"><td colspan="11" class="label_tb0"></td></tr>';
            }
        }
        return $tb_body;
    }

    //По id продукта получить список спецификаций для вида в таблицу

    public function getlistspec($id_product) {
        $sql = "SELECT   
                    tb_spec_value.id AS id_spec_value,
                    tb_product_spec.name,
                    tb_product_spec.type AS type,
			CASE WHEN type = 'text' THEN tb_spec_value.val_text 
        			WHEN type = 'int' THEN  tb_spec_value.val_int
                                WHEN type = 'float' THEN  tb_spec_value.val_float 
		         	ELSE  'Неизвестно'
			END AS val_spec
                FROM tb_product_spec
                    INNER JOIN tb_spec_value ON tb_spec_value.key_prod_spec = tb_product_spec.id 
                    INNER JOIN tb_link ON tb_link.key_spec_value = tb_spec_value.id
                    WHERE key_product='$id_product'
               ";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        return $data;
    }

    public function actionajaxdeletespec() { //Удаление спецификаций 
        $rq = Yii::app()->request;

        $id_prod = $rq->getPost('id_prod', '');
        $id_spec = $rq->getPost('id_spec', '');
        $id_cat = $rq->getPost('id_cat', '');

        try {
            $transaction = Yii::app()->db->beginTransaction();
            $sql = "DELETE FROM tb_link
                          WHERE key_spec_value='$id_spec' AND key_product='$id_prod'";
            Yii::app()->db->createCommand($sql)->execute();

            $sql1 = "DELETE FROM tb_spec_value
                          WHERE id='$id_spec'";
            Yii::app()->db->createCommand($sql1)->execute();

            $transaction->commit();

            //Нужно ид категории для обновлении грида ajax форма продуктов
            $ajaxform = $this->alllist($id_cat);
            $this->out(array(
                'error' => FALSE,
                'msg' => 'OK',
                'ajaxform' => $ajaxform
            ));
        } catch (Exception $e) {
            $this->out(array(
                'error' => TRUE,
                'msg' => 'OK',
                'data' => ''
            ));
        }
    }

    public function actionajaxdeleteproduct() { //Удаление продукта 
        $rq = Yii::app()->request;

        $id_prod = $rq->getPost('id_prod', '');
        $id_cat = $rq->getPost('id_cat', '');

        try {
            $transaction = Yii::app()->db->beginTransaction();
            $sql = "DELETE FROM tb_product
                          WHERE id='$id_prod'";
            Yii::app()->db->createCommand($sql)->execute();

            $sql1 = "DELETE FROM tb_link
                          WHERE key_product='$id_prod'";
            Yii::app()->db->createCommand($sql1)->execute();

            $transaction->commit();

            //Нужно ид категории для обновлении грида ajax форма продуктов
            $ajaxform = $this->alllist($id_cat);
            $this->out(array(
                'error' => FALSE,
                'msg' => 'OK',
                'ajaxform' => $ajaxform
            ));
        } catch (Exception $e) {
            $this->out(array(
                'error' => TRUE,
                'msg' => 'OK',
                'data' => ''
            ));
        }
    }

    //Добавление и редактирование товара
    public function actionajaxdoproduct() {
        $rq = Yii::app()->request;
        $title = $rq->getPost('title', '');
        $price = $rq->getPost('price', '');
        $old_price = $rq->getPost('old_price', '');
        $id_up = $rq->getPost('id_up', '');

        $chek = $rq->getPost('availability', '');
        $ch = ($chek == 'ON') ? 1 : 0;

        $img = $rq->getPost('img', '');
        $url = Myhelper::translitUrl($rq->getPost('url', ''));
        $meta_title = $rq->getPost('meta_title', '');
        $meta_keywords = $rq->getPost('meta_keywords', '');
        $meta_description = $rq->getPost('meta_description', '');


        $id_cat = $rq->getPost('id_cat', '');

        $action = $rq->getPost('action', '');


        $transaction = Yii::app()->db->beginTransaction();
        try {

            if ($action == 1) {   //На добавление
                //запись файла
                if ($_FILES['filename']['name']) {

                    $file = new File('filename');
                    $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                    //разбить название файла на 2 части
                    $f = explode(".", $_FILES['filename']['name']);
                    $new_file = $url . '.' . $f[1];
                    $img = $new_file;

                    $uploadfile = $uploaddir . $new_file;
                    $file->move($uploadfile);
                }
                //Добавить значение спецификации
                //В зависимости от значения спецификаций
                $sql = "INSERT INTO tb_product (key_catalog, title, price, old_price, availability, url,img, meta_title,meta_keywords, meta_description) values ('$id_cat','$title','$price','$old_price','$ch', '$url','$img', '$meta_title', '$meta_keywords', '$meta_description')";
                Yii::app()->db->createCommand($sql)->execute();
            } elseif ($action == 0) {
                //запись файла
                if ($_FILES['filename']['name']) {

                    $file = new File('filename');
                    $uploaddir = dirname(Yii::app()->basePath) . '\img\cat\\';
                    //разбить название файла на 2 части
                    $f = explode(".", $_FILES['filename']['name']);
                    $new_file = $url . '.' . $f[1];
                    $img = $new_file;

                    $uploadfile = $uploaddir . $new_file;
                    @unlink($uploadfile); //удаляем предыдущую фотку
                    $file->move($uploadfile);
                }

                $sql = "UPDATE tb_product SET title='$title', price='$price' , old_price='$old_price', availability='$ch', url='$url', img='$img', meta_title='$meta_title', meta_keywords='$meta_keywords', meta_description='$meta_description'    WHERE id='$id_up'";
                Yii::app()->db->createCommand($sql)->execute();
            }

            //Нужно ид категории для обновлении грида ajax форма продуктов
            $ajaxform = $this->alllist($id_cat);

            $transaction->commit();

            $this->out(array(
                'error' => FALSE,
                'msg' => 'ОК',
                'select' => '',
                'ajaxform' => $ajaxform
            ));
        } catch (Exception $e) {
            $this->out(array(
                'error' => TRUE,
                'msg' => 'Ошибка добавления продукта',
                'select' => ''
            ));
            $transaction->rollback();
        }
    }

    //AJAX Добавление прайсa
    public function actionCreatePrice() {
        $rq = Yii::app()->request;
        $name = $rq->getPost('name', '');
        $model = new PriceModel();
        if ($model->checkByName($name)) {
            $this->error('Прайс с таким названием уже существует');
        }
        try {
            $date = date('Y-m-d H:i:s');
            $model->name = $name;
            $model->uid = Yii::app()->user->id;
            $model->updated = $date;
            $model->created = $date;
            $model->save();
            $this->out(array(
                'error' => false,
                'msg' => 'OK',
                'pid' => $model->pid
            ));
        } catch (Exception $exc) {
            $this->error($exc->getMessage());
        }
    }

    //Вывод json 
    private function out($response) {
        echo json_encode($response);
        Yii::app()->end();
    }

    private function error($msg, $code = 0, $data = array()) {
        $this->out(array(
            'error' => true,
            'msg' => $msg,
            'code' => $code,
            'data' => array()
        ));
    }

}
