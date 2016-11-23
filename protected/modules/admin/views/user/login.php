<section id="login-form">
    <div class="wrapper">
	<? $loginForm = $this->beginWidget('CActiveForm', array(
	    'action' => Yii::app()->createUrl('admin/user/login'),
	    'enableAjaxValidation'=>false,
	)); ?>
	<div class="row">
	    <? echo $loginForm->label($form, 'Логин'); ?>
	    <? echo $loginForm->textField($form,'username') ?>
	    <? if ($form->getError('username')): ?>
	    <span class="err">
		<? echo $form->getError('username'); ?>
	    </span>
	    <? endif ?>
	</div>
        <br/>
	<div class="row">
	    <? echo $loginForm->label($form,'Пароль'); ?>
	    <? echo $loginForm->passwordField($form,'password') ?>
	    <? if ($form->getError('password')): ?>
	    <span class="err">
		<? echo $form->getError('password'); ?>
	    </span>
	    <? endif ?>
	</div>
	<div class="row">
	    <? echo CHtml::submitButton('Вход'); ?>
	</div>
	<? $this->endWidget(); ?>
    </div>
</section>