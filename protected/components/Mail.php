<?php
//Класс рассылки почты


class Mail {
    private $mailer;
    private $admin_mail;
            
     function __construct() {
        $this->mailer=Yii::app()->mailer;
        $this->mailer->CharSet = "utf8";
        //$this->mailer->isSMTP();                                      
      //  $this->mailer->Host = 'smtp.yandex.ru';  
      //  $this->mailer->SMTPAuth = true;                               
      //  $this->mailer->Username = 'bosskolyan@yandex.ru';                
      //  $this->mailer->Password = 'kjuentyrjd2288';                          
      //  $this->mailer->SMTPSecure = 'tls';                            
      //  $this->mailer->Port = 587;  
        
        $this->mailer->isHTML(true);    
        $this->mailer->FromName = 'Интернет-магазин digestive.ru';
        $this->admin_mail=Yii::app()->params['adminEmailOrder'];
        
        
    }
    // $data вход. данные (номер заказа и т п)
    // Уведомление о заказе
    public function notice_order_admin($data){
        $this->mailer->Subject = 'Новый заказ digestive.ru № '.$data['order'].''; 
        $this->mailer->MsgHTML('<h1>Новый заказ на сайте  № '.$data['order'].' содержимое заказа в панели администратора</h1>');
        
        if(!is_array($this->admin_mail)){
            $this->mailer->AddAddress($this->admin_mail);
        }else{
            $this->mailer->AddAddress($this->admin_mail[0]); //Один адрес
            foreach ($this->admin_mail as $value) {
                $this->mailer->AddBCC($value); // Тут копий
             }
        }
        $this->mailer->Send();
        $this->clearAdress();
    }
    
    // уведомление юзера о своем заказе
    public function notice_order_user($user, $data){
        $this->clearAdress();
        $this->mailer->Subject = 'Заказ digestive.ru № '.$data['order'].''; 
        $this->mailer->MsgHTML('Спасибо за покупку в нашем интернет магазине! Ваш заказ № '.$data['order'].' в ближайшее время с Вами свяжутся наши менеджеры.');
        
        if(!is_array($user)){
            $this->mailer->AddAddress($user);
        }else{
            $this->mailer->AddAddress($user[0]); //Один адрес
            foreach ($user as $value) {
                $this->mailer->AddBCC($value); // Тут копий
             }
        }
        $this->mailer->Send();
        $this->clearAdress();
    }
    
     // Востановление пароля
    public function notice_pass_user($user, $data){
        $this->mailer->Subject = 'Восстановление пароля digestive.ru'; 
        $this->mailer->MsgHTML('Вы можете изменить пароль в личном кабинете, Ваш новый пароль   ' . $data['pass']);
        
        if(!is_array($user)){
            $this->mailer->AddAddress($user);
        }else{
            $this->mailer->AddAddress($user[0]); //Один адрес
            foreach ($user as $value) {
                $this->mailer->AddBCC($value); // Тут копий
             }
        }
        $this->mailer->Send();
        $this->clearAdress();
        
    }
    
    public function clearAdress(){
        $this->mailer->ClearAddresses();
        $this->mailer->ClearAttachments();  
        $this->mailer->ClearAllRecipients();
    }
    
}