<?php echo '<div id="cart">
    <table id="lot">
        <h1>Корзина</h1>
        <tr>
            <th width="190">Наименование</th>
            <th width="80" class="cost">Кол-во</th>
            <th width="80" class="cost">Цена</th>
            <th width="80" class="cost">Сумма</th>
            <th width="80">Удалить</th>
        </tr>
'?>
<?php
foreach ($data['rowcart'] as $cart) {
    echo '<tr>';


    echo '<td>' . $cart['i_name_sku'] . '</td>';

    echo '<td class="cost"><div class="amound_cart"><div class="amound_sel">' .
    CHtml::ajaxLink(CHtml::image('/img/icons/minus.png', 'Минус'), CController::createUrl('/basket/minus'), array(
        'type' => 'POST', // method
        'data' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,'id_cart_context' => $cart['id']), // DATA
        'update' => '#cart',)) . '</div>
                                    <input  type="text" name="in" value="' . $cart['cart_count'] . '"  readonly="readonly" />
      <div class="amound_sel ">' . CHtml::ajaxLink(CHtml::image('/img/icons/plus.png', 'Плюс'),CController::createUrl('/basket/plus'), array(
        'type' => 'POST', // method
        'data' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,'id_cart_context' => $cart['id']), // DATA
        'update' => '#cart',)).'</div>';


    echo '<td class="cost">' . $cart['i_price'] . ' руб.</td>';
    echo '<td class="cost">' . $cart['cart_count'] * $cart['i_price'] . ' руб.</td>';

    echo '<td class="cost">';
   // echo CHtml::Link(CHtml::image('/img/icons/del.png', 'Удалить'), array('/basket/delcartitem', 'id_cart_context' => $cart['id']));
    echo CHtml::ajaxLink(CHtml::image('/img/icons/del.png', 'Удалить'),array('/basket/delcartitem'), array(
        'type' => 'POST', // method
        'data' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,'id_cart_context' => $cart['id']), // DATA
        //'data' => array(), // DATA
        //'update' => '#cart',
        'complete' =>'js:function() {location.reload();}',
        ));
    echo '</td>';
    echo '</tr>';
    
}
  //  echo '</div>';

    echo '</table>';
    echo '<br>';
    echo '<div class="total"><b>Сумма заказа '.$data['total'].'руб.</b></div>';

?>
<?php
echo '<br>';
echo '<div  class="button_oformit">';
echo CHtml::button('Оформление заказа', array(
    'submit' => array('/order/executionone'),
    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
    'class' => 'button_design w160 right_tb',
        )
);
echo '</div></div>';
                           




