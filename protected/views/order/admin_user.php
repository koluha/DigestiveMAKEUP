<?php /*   
 [6] => Array
        (
     [username] => kolyan2288
    [fio] => Николай
    [mail] => kolyan2288@mail.ru
    [tel] => 9057825445
    [delivery] => 
    [date_reg] => 2015-04-28 08:01:47
        )
  
 
 */?>
<h1>Данные покупателя</h1>
                    <table id="lot">
                        <tr>
                            <th width="50">Покупатель (Логин)</th>
                            <th width="80" class="w80">ФИО </th>
                            <th width="80" class="w80">Mail</th>
                            <th width="80" class="w80">Телефон</th>
                            <th width="80" class="w80">Адрес доставки</th>
                            <th width="80" class="w80">Дата регистрации</th>
                        </tr>
                       <?php                        
                      
                           echo '<tr class="bg1">';
                           echo '<td class="gray">'.$user['username'].'</td>';
                           echo '<td class="cost">'.$user['fio'].'</td>';
                           echo '<td class="cost">'.$user['mail'] .'</td>';
                           echo '<td class="cost">'.$user['tel'] .'</td>';
                           echo '<td class="cost">'.$user['delivery'] .'</td>';
                           echo '<td class="cost">'.$user['date_reg'] .'</td>';
                           echo '</tr>';
                 
                        ?> 
                    </table>
<br>
                