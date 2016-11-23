<?php

class ForgPassUserForm extends CFormModel {

    public $mail;

    public function rules() {
        return array(
            array('mail', 'required'),
            array('mail',
                'match',
                'pattern' => '/^((?:(?:(?:[a-zA-Z0-9][\.\-\+_]?)*)[a-zA-Z0-9])+)\@((?:(?:(?:[a-zA-Z0-9][\.\-_]?){0,62})[a-zA-Z0-9])+)\.([a-zA-Z0-9]{2,6})$/',
                'message' => 'Некорректный формат поля {attribute}'
            ),
            array('id, username, password, mail', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'mail' => 'Для восстановления пароля введите ваш mail',
        );
    }

    public function GeneratePassword() {
        //Сгенерируем новый пароль
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $length = 8;
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

}
