<div class="pr_button">
    <div class="row">
        <div class="col-xs-4">
        </div>
        <div class="col-xs-4">
          <!--  <button class="bt_ede">Показать еще</button> -->
        </div>
        <div class="col-xs-4">
            <ul class="page-numbers">
<?php  
//параметр спецификаций

//Сортировка 
 $order=($pag['sort'])?'&order='.$pag['sort']:'';
//вместо пробелов плюс в ссылке
$pag['var_filter']=str_replace(" ", "+", $pag['var_filter']);

//Если есть популярное
$popular=($pag['popular'])?'&popular=1':'';
//Если есть фильтр
    $spec=($pag['var_filter'] && $pag['name_filter'])?'&var_filter='.$pag['var_filter'].'&name_filter='.$pag['name_filter'].$popular.$order:'';




// Проверяем нужны ли стрелки назад  
if ($pag['page'] != 1) 
    $pervpage = '<li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page=1><<</a></li>  
                               <li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] - 1) .'><</a></li> ';  
// Проверяем нужны ли стрелки вперед  
if ($pag['page'] != $pag['total']) $nextpage = '<li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] + 1) .'>></a></li>  
                                   <li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page=' .$pag['total']. '>>></a></li>';  

// Находим две ближайшие станицы с обоих краев, если они есть  
if($pag['page'] - 2 > 0) $page2left = '<li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] - 2) .'>'. ($pag['page'] - 2) .'</a></li>  ';  
if($pag['page'] - 1 > 0) $page1left = '<li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] - 1) .'>'. ($pag['page'] - 1) .'</a></li>  ';  
if($pag['page'] + 2 <= $pag['total']) $page2right = '  <li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] + 2) .'>'. ($pag['page'] + 2) .'</a></li>';  
if($pag['page'] + 1 <= $pag['total']) $page1right = '  <li><a href='.Yii::app()->getRequest()->getPathInfo().'?r=catalog&url='.$pag['url'].$spec.$order.'&page='. ($pag['page'] + 1) .'>'. ($pag['page'] + 1) .'</a></li>'; 

// Вывод меню  
echo $pervpage.$page2left.$page1left.'<span class="active">'.$pag['page'].'</span>'.$page1right.$page2right.$nextpage;  

?>

<!--
  <li><a href="/likery-c11?page=1" title="" class="selected">1</a></li>
  <li><a href="/likery-c11?page=2" title="">2</a></li>
  <li><a href="/likery-c11?page=3" title="">3</a></li>
  <li><a href="/likery-c11?page=4" title="">4</a></li>
  <li><a href="/likery-c11?page=5" title="">5</a></li>

  <li class="page_next" rel="next"><a href="/likery-c11?page=2" title="Ďalej"><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
-->
            </ul>
        </div>
    </div>
</div>