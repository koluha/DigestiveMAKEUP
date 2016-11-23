<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Войти на сайт',
);
?>
<h1>Войти</h1>
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'login-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'Логин / Mail'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'Пароль'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
    <?php echo (Yii::app()->user->isGuest)? CHtml::link('Забыли пароль?',array('user/forgpass')):' '; ?>
    <br>
    <?php echo (Yii::app()->user->isGuest)? CHtml::link('Зарегистрироваться',array('user/registeruser')):' ';  ?>
    
    
    <div class="row rememberMe">
        <?php echo $form->checkBox($model, 'rememberMe'); ?>
        <?php echo $form->label($model, 'rememberMe'); ?>
        <?php echo $form->error($model, 'rememberMe'); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Вход'); ?>
    </div>
    <?php $this->endWidget(); 
  ?>
</div><!-- form -->
