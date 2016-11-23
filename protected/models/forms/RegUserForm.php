<?php

//Форма Регистрации Покупателя
class RegUserForm extends CFormModel {

    public $username;
    public $password;
    public $password2;
    public $fio;
    public $mail;
    public $tel;
    public $id;
    public $date_reg;
  

    public function tableName() {
        return '{{user}}';
    }

    public function rules() {
        return array(
            array('username, password, password2, mail, tel , fio', 'required'),
            array('username, password, password2, mail, tel , fio', 'length', 'max' => 60),
            array('password', 'length', 'min' => 3),
            array('password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'),
            array('id, username, password,password2, mail, tel ,date_reg', 'safe'),
            array('username', 'check'), //Валидатор если в тб user уже есть такое имя пользователя
            array('mail',
                'match',
                'pattern' => '/^((?:(?:(?:[a-zA-Z0-9][\.\-\+_]?)*)[a-zA-Z0-9])+)\@((?:(?:(?:[a-zA-Z0-9][\.\-_]?){0,62})[a-zA-Z0-9])+)\.([a-zA-Z0-9]{2,6})$/',
                'message' => 'Некорректный формат поля {attribute}'
            ),
            array('mail', 'checkmail'), //Валидатор если в тб user уже есть такую почту
           
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'password2' => 'Пароль еще раз',
            'fio' => 'Ваше Имя или (ФИО)',
            'mail' => 'Электронная почта',
            'tel' => 'Номер телефона',
            
        );
    }

    public function check($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = UserModel::model()->find('username=:pusername', array(
                ':pusername' => $this->username,
            ));
            if (!empty($user)) {
                $this->addError('username', 'Пользователь с таким логином уже существует.');
            }
        }
    }

    public function checkmail($attribute, $params) {
        if (!$this->hasErrors()) {
            $mail = UserModel::model()->find('mail=:pmail', array(
                ':pmail' => $this->mail,
            ));
            if (!empty($mail)) {
                $this->addError('mail', 'Пользователь с такой почтой уже существует.');
            }
        }
    }

    //Регистрация покупателя запись в БД
    public function register() {
        $user = new UserModel();
        $user->username = $this->username;
        $user->password = CPasswordHelper::hashPassword($this->password);
        $user->fio = $this->fio;
        $user->mail = $this->mail;
        $user->tel = $this->tel;
        $user->date_reg=date("Y-m-d H:i:s");
        return $user->save();
    }

}
