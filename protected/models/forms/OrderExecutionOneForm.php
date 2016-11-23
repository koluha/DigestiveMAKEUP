<?php

//Форма для зарегистрированых и авторизовнных поль-лей шаг 1 
class OrderExecutionOneForm extends CFormModel {
    
    public $delivery;
    public $comments;


    public function rules() {
        return array(
            array('delivery, comments', 'length', 'max' => 350),
            array('delivery, comments', 'safe'),
           );
    }

    public function attributeLabels() {
        return array(
            'delivery' => 'Адрес доставки (При самовывозе оставьте поле пустым)',
            'comments' => 'Комментарий к заказу (Необязательное поле заполнения)',
          );
    }
}
