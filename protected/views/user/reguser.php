<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Регистрация',
);
?>
<h1>Регистрация покупателя</h1>
<p>Для совершения покупок, пожалуйста зарегистрируйтесь,или зайдите под своим логином <?php echo CHtml::link('ВХОД', array('/user/login')); ?> </p>

<?php
$form_reg = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form',
    'enableClientValidation' => true,
    'clientOptions' => array(
                            'validateOnSubmit' => true,)
    ));
?>
<div class="form">
    <div class="row">
        <?php echo $form_reg->labelEx($form, 'username'); ?>
        <?php echo $form_reg->textField($form, 'username'); ?>
        <?php echo $form_reg->error($form, 'username'); ?>
    </div>
    <div class="row">
        <?php echo $form_reg->labelEx($form, 'password'); ?>
        <?php echo $form_reg->passwordField($form, 'password'); ?>
        <?php echo $form_reg->error($form, 'password'); ?>
    </div>
    <div class="row">
        <?php echo $form_reg->labelEx($form, 'password2'); ?>
        <?php echo $form_reg->passwordField($form, 'password2'); ?>
        <?php echo $form_reg->error($form, 'password2'); ?>
    </div>
      <div class="row">
        <?php echo $form_reg->labelEx($form, 'fio'); ?>
        <?php echo $form_reg->textField($form, 'fio'); ?>
        <?php echo $form_reg->error($form, 'fio'); ?>
    </div>
    <div class="row">
        <?php echo $form_reg->labelEx($form, 'mail'); ?>
        <?php echo $form_reg->textField($form, 'mail'); ?>
        <?php echo $form_reg->error($form, 'mail'); ?>
    </div>
    <div class="row">
        <?php echo $form_reg->labelEx($form, 'tel'); ?>
        <?php echo $form_reg->textField($form, 'tel'); ?>
        <?php echo $form_reg->error($form, 'tel'); ?>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Зарегистрировать'); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
