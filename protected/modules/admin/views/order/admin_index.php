<?php /*   
 [6] => Array
        (
            [id_order] => 108
            [id_user] => 18
            [comments] => 
            [delivery] => 
            [anonymousUser] => 
        )
  
 
 */?>
<h1>Заказы</h1>
                    <table id="lot">
                        <tr>
                            <th width="50">№ заказа</th>
                            <th width="80" class="w80">Покупатель</th>
                            <th width="80" class="w80">Комментарии к заказу</th>
                            <th width="80" class="w80">Данные о доставке</th>
 
                            <th width="80" class="w80">Дата заказа</th>
                        </tr>
                       <?php                        
                       foreach ($orders as $order) {
                           echo '<tr class="bg1">';
                           
                          echo '<td class="gray">'.CHtml::link($order['id_order'],array('order/AdminListOrder',
                                         'id_order'=>$order['id_order'],
                                         'id_user'=>$order['id_user']
                                         )).'</td>'; 
                           
                           
                           if($order['username']=='Аноним'){
                             echo '<td class="gray">Аноним</td>';
                           }  else {
                               echo '<td class="gray">'.CHtml::link($order['username'],array('order/AdminListUser',
                                         'id_user'=>$order['id_user'])).'</td>'; 
                           }
                           
                           
                           
                           echo '<td class="cost">'.$order['comments'].'</td>';
                           echo '<td class="cost">'.$order['delivery'] .'</td>';

                           echo '<td class="cost">'.$order['date'] .'</td>';
                           echo '</tr>';
                       }
                        ?> 
                    </table>
                