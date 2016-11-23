<?php $ob = new ModelCatalog; ?>
<ul id="animenu__nav">

    <?php foreach ($items as $item): ?>
        <li><?php echo CHtml::link($item['title'] . ' <i class="fa fa-caret-down" ></i>', array('catalog/', 'url' => $item['url'])); ?>

            <?php
            $text = '';
            $id_cat = $ob->setId_cat($item['url']);
            $id_cat_m = $item['url']; //для меню

            $category = $ob->levelcategory();  //Лист категорий
            $type = $ob->leveltype_or_class(); //Лист типа или класса
            $class = $ob->leveltype_or_class(1); //Лист типа или класса

            /* 1(id)-Виски, 
              3(id)-Коньяк,
              4(id)-Водка,
              5(id)-Вино,
              6(id)-Шампанское,
              7(id)-Крепкие напитки,
              8(id)-Ликеры */

            /* бренд страна,регион,сорт винограда, класс, тип, популярное */



            $sp_brand = $ob->levelspec('p.f_brand', 'f_s_brand'); //Спецификация Брэнд
            $sp_country = $ob->levelspec('p.f_country', 'f_s_country'); //Спецификация Страна
            $sp_region = $ob->levelspec('p.f_region', 'f_s_region'); //Спецификация Регион 
            $sp_sorty = $ob->levelspec('p.f_grape_sort', 'f_s_grape_sort'); //Спецификация Сорт винограда

            $sp_popular = $ob->levelpopular(); //Спецификация Популярное
            //Максимальное кол-во строк

            $maxnum = 7;
            $show = TRUE;

            //Чтобы не показал UL, смотрим полная ли категория этой группы если нет то ничего не показываем 
            if (($item['id'] == 1) && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 3) && !$category && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 4) && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 5) && !$category && !$sp_country && !$sp_region && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 6) && !$category && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 7) && !$category && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            } elseif (($item['id'] == 8) && !$category && !$sp_brand && !$sp_country && !$type && !$class) {
                $show = FALSE;
            }

            $text.=($show) ? '<ul>' : '';

            //$item['id']!= перечисляются категории где не будет показ

            if (!empty($category) && ($item['id'] != 1) && ($item['id'] != 4)) {
                $text.= '<li><span>Категория</span>';
                $k = 0;
                foreach ($category as $lev) {
                    $k++;
                    if ($k < $maxnum) {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i>  ' . $lev['title'], array('catalog/', 'url' => $lev['url']));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }

            //++В ссылке передать категорию и ид специализации
            if (!empty($sp_brand) && ($item['id'] != 5)) {
                $text.= '<li><span>Брэнд</span>';
                $k = 0;
                foreach ($sp_brand as $sp) {
                    $k++;
                    if ($k < $maxnum) {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_brand'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_brand'], 'name_filter' => 'f_brand'));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }

            //++В ссылке передать категорию и ид специализации
            if (!empty($sp_country)) {
                $text.= '<li><span>Страна</span>';
                $k = 0;
                foreach ($sp_country as $sp) {
                    $k++;
                    if ($k < $maxnum) {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_country'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_country'], 'name_filter' => 'f_country'));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }

            //++В ссылке передать категорию и ид специализации
            if (!empty($type)) {
                $text.= '<li><span>Тип</span>';
                $k = 0;
                foreach ($type as $lev) {
                    $k++;
                    if ($k < $maxnum) {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i>  ' . $lev['title'], array('catalog/','url' => $lev['url'], 'filter_type' => $lev['title']));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }

            //++В ссылке передать категорию и ид специализации
            if (!empty($class)) {
                $text.= '<li><span>Класс</span>';
                $k = 0;
                foreach ($class as $lev) {
                    $k++;
                    if ($k < $maxnum) {
                          $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i>  ' . $lev['title'], array('catalog/','url' => $lev['url'], 'filter_type' => $lev['title']));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }

            //В ссылке передать категорию и ид специализации
            /*     if (!empty($sp_class) && ($item['id'] != 1) && ($item['id'] != 1) && ($item['id'] != 5) && ($item['id'] != 1) && ($item['id'] != 6) && ($item['id'] != 7) && ($item['id'] != 8)) {
              $text.= '<li><span>Класс</span>';
              $k = 0;
              foreach ($sp_class as $sp) {
              $k++;
              if ($k < $maxnum) {

              $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_class'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_class'], 'name_filter' => 'f_class'));
              } else {
              $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
              break;
              }
              }
              $text.='</li>';
              }
             */
            //В ссылке передать категорию и ид специализации
            if (!empty($sp_region) && ($item['id'] != 1 && ($item['id'] != 3)) && ($item['id'] != 1) && ($item['id'] != 1) && ($item['id'] != 6) && ($item['id'] != 7) && ($item['id'] != 8)) {
                $text.= '<li><span>Регион</span>';
                $k = 0;
                foreach ($sp_region as $sp) {
                    $k++;
                    if ($k < $maxnum) {

                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_region'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_region'], 'name_filter' => 'f_region'));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }



            //В ссылке передать категорию и ид специализации
            if (!empty($sp_sorty) && ($item['id'] != 1) && ($item['id'] != 3) && ($item['id'] != 1) && ($item['id'] != 1) && ($item['id'] != 6) && ($item['id'] != 7) && ($item['id'] != 8)) {
                $text.= '<li><span>Сорт</span>';
                $k = 0;
                foreach ($sp_sorty as $sp) {
                    $k++;
                    if ($k < $maxnum) {

                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_grape_sort'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_grape_sort'], 'name_filter' => 'f_grape_sort'));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }


            //Популярное
            if (!empty($sp_popular)) {
                $text.= '<li><span>Популярное</span>';
                $k = 0;
                foreach ($sp_popular as $sp) {
                    $k++;
                    if ($k < $maxnum) {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> ' . $sp['f_brand'], array('catalog/', 'url' => $sp['url'], 'var_filter' => $sp['f_brand'], 'name_filter' => 'f_brand'));
                    } else {
                        $text.=CHtml::link('<i class="fa fa-caret-right" aria-hidden="true"></i> Показать все...  ', array('catalog/', 'url' => $item['url']));
                        break;
                    }
                }
                $text.='</li>';
            }




            $text.=($show) ? '</ul>' : '';
            echo $text;
            ?>

        </li>


    <?php endforeach; ?>
</ul>