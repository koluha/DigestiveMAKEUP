<h1>Завершение оформления заказа</h1>
<?php
$form_oneanon = $this->beginWidget('CActiveForm', array(
    'id' => 'form_oneanon',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,)
        ));
?>
<div class="form">
    <div class="row">
        <?php echo $form_oneanon->labelEx($form, 'tel'); ?>
        <?php echo $form_oneanon->textField($form, 'tel', array('style'=>'width:300px')); ?>
        <?php echo $form_oneanon->error($form, 'tel'); ?>
    </div>
    <div class="row">
        <?php echo $form_oneanon->labelEx($form, 'fio'); ?>
        <?php echo $form_oneanon->textField($form, 'fio', array('style'=>'width:300px')); ?>
        <?php echo $form_oneanon->error($form, 'fio'); ?>
    </div>
    <div class="row">
        <?php echo $form_oneanon->labelEx($form, 'mail'); ?>
        <?php echo $form_oneanon->textField($form, 'mail', array('style'=>'width:300px')); ?>
        <?php echo $form_oneanon->error($form, 'mail'); ?>
    </div>
     <div class="row">
        <?php echo $form_oneanon->labelEx($form, 'comments'); ?>
        <?php echo $form_oneanon->textArea($form, 'comments', array('style'=>'width:300px')); ?>
        <?php echo $form_oneanon->error($form, 'comments'); ?>
    </div>
    <div class="row">
        <?php echo $form_oneanon->labelEx($form, 'delivery'); ?>
        <?php echo $form_oneanon->textArea($form, 'delivery', array('style'=>'width:300px')); ?>
        <?php echo $form_oneanon->error($form, 'delivery'); ?>

    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Оформить заказ'); ?>
    </div>
</div>
<?php $this->endWidget(); 
