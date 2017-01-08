<ul class="breadcrumb">
    <li class="first">
        <a href="/" title="Home"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
    </li>

    <?php
    $separator='<li class="breadcrumb-separator"><i class="fa fa-chevron-right" aria-hidden="true"></i></li>';
    //Вывод первой группы
    if ($items['group']['1']) {
        echo $separator;
        echo '<li>';
        echo CHtml::link($items['group']['1']['title'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/', 'url' => $items['group']['1']['url']));
            echo '<ul>';
                echo '<li>';
                     foreach ($items['group']['1']['parents_group'] as $value) {
                        echo CHtml::link($value['title']. ' <i class="fa" aria-hidden="true"></i>', array('catalog/', 'url' => $value['url']));
                     }
                echo '</li>';
            echo '</ul>';
        echo '</li>';
        if ($items['filter']) { //Если есть фильтр
        echo $separator;    
        echo '<li>';
           echo '<span>'.$items['filter'].'</span>';
        echo '<li>';
        }
    }
    
    //Вывод второй группы
    if ($items['group']['2']) {
        echo $separator;
        echo '<li>';
        echo CHtml::link($items['group']['2']['title'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/', 'url' => $items['group']['2']['url']));
            echo '<ul>';
                echo '<li>';
                     foreach ($items['group']['2']['parents_group'] as $value) {
                        echo CHtml::link($value['title']. ' <i class="fa" aria-hidden="true"></i>', array('catalog/', 'url' => $value['url']));
                     }
                echo '</li>';
            echo '</ul>';
        echo '</li>';
    }
      
    
    //Вывод третьей группы
    if ($items['group']['3']) {
        echo $separator;
        echo '<li>';
        echo CHtml::link($items['group']['3']['title'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/', 'url' => $items['group']['3']['url']));
            echo '<ul>';
                echo '<li>';
                     foreach ($items['group']['3']['parents_group'] as $value) {
                        echo CHtml::link($value['title']. ' <i class="fa" aria-hidden="true"></i>', array('catalog/', 'url' => $value['url']));
                     }
                echo '</li>';
            echo '</ul>';
        echo '</li>';
    }
    
    //Вывод наименования продукта
    if ($items['product']) {
        echo $separator;
        echo '<span>'.$items['product'].'</span>';
    }

    //Вывод странцы продукта
    if ($items['title']) {
        echo $separator;
        echo '<span>'.$items['title'].'</span>';
    }

  ?>

</ul>




