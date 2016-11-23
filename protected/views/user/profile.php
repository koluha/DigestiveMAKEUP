<?php
$this->pageTitle = Yii::app()->name . ' - Личный кабинет';
$this->breadcrumbs = array(
    'Личный кабинет',
);
?>

<div class="big_lk">
    <div class="sel_lk">
        <div class="sel_lk_in">
            <h2><?php echo CHtml::link('Личные данные', '/user/UpdateUser/')?></h2>
            <p><?php echo Yii::app()->user->get_Name() ?></p>
        </div>
    </div>
    <div class="sel_lk">
        <div class="sel_lk_in">
            <h2><?php echo CHtml::link('Корзина', '/basket/showcart/',array('class'=>'cart_lk'))?></h2>
            <p>Содержимое вашей корзины.</p>
        </div>
    </div>
    <div class="sel_lk">
        <div class="sel_lk_in">
            <h2><?php echo CHtml::link('Заказы', '/order/list/',array('class'=>'order_lk'))?></h2>
            <p>История и мониторинг ваших заказов</p>
        </div>
    </div>
</div>
