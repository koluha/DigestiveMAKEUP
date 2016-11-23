<ul class="breadcrumb">
    <li class="first">
        <a href="/" title="Home"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
    </li>
    <?php
    //Получить первый список подменю
    $category = ModelCatalog::ListGroup();
    $ob = new ModelCatalog;
    
    $id_cat = $ob->setId_cat($items['id_2']);
    $groups = $ob->levelcategory();  //Лист категорий тут категория
    
    
    
    
    
    
    
    
    
    

    if (!empty($items['title_2'])) {
        $bread = array($items['title_2'] => $items['id_2'], $items['title_1'] => $items['id_1']);

        echo '<li class="breadcrumb-separator"><i class="fa fa-angle-right " aria-hidden="true"></i></li>';
        echo '<li>';
        echo CHtml::link($items['title_2'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/',
            'url' => '' . $items['id_2'] . ''));

        if ($category) { //Первое дерево
            echo '<ul><li>';
            foreach ($category as $item) {
                echo CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $item['title'], array('catalog/', 'url' => $item['url']));
            }
            echo '</li></ul>';
        }
        echo '</li>';




        echo '<li class="breadcrumb-separator"><i class="fa fa-angle-right " aria-hidden="true"></i></li>';
        echo '<li>';
        echo CHtml::link($items['title_1'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/',
            'url' => '' . $items['id_1'] . ''));

        if ($groups) { //Второе дерево
            echo '<ul><li>';
            foreach ($groups as $item) {
                echo CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $item['title'], array('catalog/', 'url' => $item['url']));
            }
            echo '</li></ul>';
        }
        echo '</li>';
    } else {


        $bread = array($items['title_1'] => $items['id_1']);
        echo '<li class="breadcrumb-separator"><i class="fa fa-angle-right " aria-hidden="true"></i></li>';
        echo '<li>';
        echo CHtml::link($items['title_1'] . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/',
            'url' => '' . $items['id_1'] . ''));
        if ($category) { //Первое дерево
            echo '<ul><li>';
            foreach ($category as $item) {
                echo CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $item['title'], array('catalog/', 'url' => $item['url']));
            }
            echo '</li></ul>';
        }
        echo '</li>';
    }







    /* foreach ($bread as $key => $value) {
      echo '<li class="breadcrumb-separator"><i class="fa fa-angle-right " aria-hidden="true"></i></li>';
      echo '<li>';
      echo CHtml::link($key . ' <i class="fa fa-sort-desc" aria-hidden="true"></i>', array('catalog/',
      'url' => '' . $value . ''));

      if ($category) { //Первое дерево
      echo '<ul><li>';
      foreach ($category as $item) {
      echo CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> '.$item['title'], array('catalog/', 'url' => $item['url']));
      }
      echo '</li></ul>';
      }
      echo '</li>';
      }
     */
    ?>
</ul>


<?php
//echo '<pre>';
//print_r($groups);


