<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Изменить данные',
);
?>


<h1>Изменить данные </h1>
<?php
$form_update = $this->beginWidget('CActiveForm', array(
    'id' => 'update-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
                            'validateOnSubmit' => true,)
        ));
?>
<div class="form">
    <br><p><b>Регистрационные данные:</b></p>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'username'); ?>
        <?php echo $form_update->textField($form, 'username'); ?>
        <?php echo $form_update->error($form, 'username'); ?>
    </div>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'password'); ?>
        <?php echo $form_update->passwordField($form, 'password'); ?>
        <?php echo $form_update->error($form, 'password'); ?>
    </div>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'password2'); ?>
        <?php echo $form_update->passwordField($form, 'password2'); ?>
        <?php echo $form_update->error($form, 'password2'); ?>
    </div>

    <br><p><b>Контактные данные:</b></p>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'fio'); ?>
        <?php echo $form_update->textField($form, 'fio'); ?>
        <?php echo $form_update->error($form, 'fio'); ?>
    </div>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'mail'); ?>
        <?php echo $form_update->textField($form, 'mail'); ?>
        <?php echo $form_update->error($form, 'mail'); ?>
    </div>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'tel'); ?>
        <?php echo $form_update->textField($form, 'tel'); ?>
        <?php echo $form_update->error($form, 'tel'); ?>
    </div>
    <br><p><b>Данные о доставке</b></p>
    <div class="row">
        <?php echo $form_update->labelEx($form, 'delivery'); ?>
        <?php echo $form_update->textArea($form, 'delivery'); ?>
        <?php echo $form_update->error($form, 'delivery'); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
