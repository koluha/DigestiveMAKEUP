<?php /*   [6] => Array
        (
            [id_order] => 97
            [text_good] => Сайлентблок передн.рычага  ОmА  [ 0352341/H ]
            [status] => 0
            [count] => 1
            [price] => 330
            [date] => 2015-04-30
        )
  
 
 */?>
<h1>Мои заказы</h1>
                    <table id="lot">
                        <tr>
                            <th width="40">№ заказа</th>
                            <th width="50" class="w80">Производитель</th>
                            <th width="50" class="w80">№ детали</th>
                            <th width="80" class="w80">Наименование</th>
                            <th width="60" class="w80">Статус</th>
                            <th width="50" class="w80">Кол-во</th>
                            <th width="50" class="w80">Цена</th>
                            <th width="50" class="w80">Сумма</th>
                            <th width="50" class="w80">Дата заказа</th>
                        </tr>
                       <?php                        
                       foreach ($orders as $order) {
                           echo '<tr class="bg1">';
                           echo '<td class="gray">'.$order['id_order'].'</td>';
                           echo '<td>'.$order['brand'].'</td>';
                           echo '<td>'.$order['article'].'</td>';
                           echo '<td>'.$order['name'].'</td>';
                           echo '<td class="cost">'.$order['status'].'</td>';
                           echo '<td class="cost">'.$order['count'] .' шт.</td>';
                           echo '<td class="cost">'.$order['price'] .' руб.</td>';
                           echo '<td class="cost">'.$order['price']*$order['count'] .' руб.</td>';
                           echo '<td>'.$order['date'].'</td>';
                           echo '</tr>';
                       }
                        ?> 
                    </table>
                