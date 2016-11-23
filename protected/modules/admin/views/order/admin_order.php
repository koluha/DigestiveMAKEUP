<?php /*
  [6] => Array
  (
  [id_order] => 111
  [text_good] => Колпак колеса 14" комплект (4шт) Шевролет General Motors [ 96452301 ]
  [status] => В обработке
  [count] => 1
  [price] => 2940
  [date] => 2015-05-03
  )


 */ 
?>

<h1>Заказы</h1>
<table id="lot">
    <tr>
        <th width="30">№ заказа</th>
        <th width="40" class="w80">Производитель</th>
        <th width="40" class="w80">№ детали</th>
        <th width="100" class="w80">Наименование</th>
        <th width="60" class="w80">Статус</th>
        <th width="50" class="w80">Кол-во</th>
        <th width="50" class="w80">Цена</th>
        <th width="50" class="w80">Сумма</th>
        <th width="50" class="w80">Дата заказа</th>
    </tr>
    <?php
    $table='';
    foreach ($orders as $order) {
        $table.= '<tr class="bg1">';
        $table.= '<td class="gray">'.$order['id_order'] . '</td>';
        $table.= '<td class="gray">'.$order['brand'].'</td>';
        $table.= '<td class="gray">'.$order['article'].'</td>';
        $table.= '<td class="gray">'.$order['name'].'</td>';
        
        $table.= '<td class="cost">' . CHtml::dropDownList('status', OrderController::defaultStatus($order['id']), $list, array(
                //'class' => "select-panel__select",
                'id' => 'status-'.$order['id'],
                'params'=>array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,),
                'ajax' => array(
                'type' => 'POST',
                'url' => CController::createUrl('/order/editstatus',array('id'=>$order['id'])),
                 //'update' => '#models',
                 //'success' => 'function(html,script,script1){
                 //              jQuery("#models").html(html);
                 //              eval(script1);
                 //              }',
                 'data' => array('id_status' => 'js:this.value','YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
            )
        )) . '</td>';

       $table.= '<td class="gray">' . $order['count'] . ' шт.</td>';
       //  echo '<td class="gray">id=' . $order['id'] . ' </td>';
        $table.= '<td class="gray">' . $order['price'] . ' руб. </td>';
        $table.= '<td class="gray">' . $order['price'] * $order['count'] . ' руб.</td>';
        $table.= '<td class="gray">' . $order['date'] . '</td>';
        $table.= '</tr>';
       
    }
    
     echo $table;
    ?> 
</table>
<br>
<?php

echo CHtml::link('Назад к заказам', array('order/AdminList'));
echo '<br>';
echo '<br>';
echo CHtml::link('Отправить состояние заказов покупателю покупателю', array('order/AdminList','table'=>$table,
                                                                                              'id_order'=>$order['id_order']));