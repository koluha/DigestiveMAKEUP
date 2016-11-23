<h1>Завершение оформления заказа</h1>
<?php
$form_one = $this->beginWidget('CActiveForm', array(
    'id' => 'form_one',
    'enableClientValidation' => true,
    'clientOptions' => array(
    'validateOnSubmit' => true,)
        ));
?>
<div class="form">
    <div class="row">
        <?php echo $form_one->labelEx($form, 'comments'); ?>
        <?php echo $form_one->textArea($form, 'comments', array('style'=>'width:300px')); ?>
        <?php echo $form_one->error($form, 'comments'); ?>
    </div>
    <div class="row">
        <?php echo $form_one->labelEx($form, 'delivery'); ?>
        <?php echo $form_one->textArea($form, 'delivery', array('style'=>'width:300px')); ?>
        <?php echo $form_one->error($form, 'delivery'); ?>

    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Оформить заказ'); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
