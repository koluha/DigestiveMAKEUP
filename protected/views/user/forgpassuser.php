<?php

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Вспомнить пароль',
);
?>
<div class="flash-success">
   <?php if(Yii::app()->user->hasFlash('Forgpass')):
     echo Yii::app()->user->getFlash('Forgpass'); 
endif; ?>
</div>

<div class="form">
    <?php
    $form_pass = $this->beginWidget('CActiveForm', array(
        'id' => 'forgpassuser-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <br>
    <div class="row">
        <?php echo $form_pass->labelEx($form, 'mail'); ?>
        <?php echo $form_pass->textField($form, 'mail'); ?>
        <?php echo $form_pass->error($form, 'mail'); ?>
    </div>
      
    <div class="row buttons">
        <?php echo CHtml::submitButton('Отправить пароль'); ?>
    </div>
    <?php $this->endWidget(); 
  ?>
</div><!-- form -->


