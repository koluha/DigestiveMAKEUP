<script>
    $(document).ready(function () {
        $('.button_b').click(function () {
            var id_pr = $(this).attr('data-idproduct');
            console.log(id_pr);
            $.get("/index.php?r=basket/addcart", {product_id: id_pr});
            document.location.href = 'http://ydigestive.ru/index.php?r=basket/showcart';
        });


        window.onload = function () {
            document.getElementById('button_filter').onclick = function () {
                openbox('filter_block', this, 'right_block');
                return false;
            };



        };
        /* Функция открывает блок фильтра и меняет класс у блока товара*/

        function openbox(id, toggler, right_block) {
            var div = document.getElementById(id);
            var div_right = document.getElementById(right_block);
            if (div.style.display == 'block') {
                div.style.display = 'none';
                toggler.innerHTML = '<i class="fa fa-tasks fa-lg" aria-hidden="true"></i>&nbsp; показать фильтр';
                div_right.className = 'prod_block';

            }
            else {
                div.style.display = 'block';
                toggler.innerHTML = '<i class="fa fa-tasks fa-lg" aria-hidden="true"></i>&nbsp; закрыть фильтр';
                div_right.className = 'prod_block_filtr';
            }
        }
    });


</script>

<h1><?php
//Заголовок
    //  if ($data['bread'][0]['title_2']) {
    //      echo $data['bread'][0]['title_2'];
    //      echo ' / ';
    //      echo $data['bread'][0]['title_1'];
    //  } else {
    //      echo $data['bread'][0]['title_1'];
    //  }
    ?>
</h1>  


<?php
if ($data['categories']) {
    $this->renderPartial('_categories', array('data' => $data));
    $this->renderPartial('_inline');
}
?>

<div class="filter_line">
    <div class="row">
        <div class="col-xs-4">
            <button id="button_filter" class="button left"><i class="fa fa-tasks fa-lg" aria-hidden="true"></i>&nbsp; показать фильтр</button>
        </div>
        <div class="col-xs-4">
            <span>Цена от - до: (в разработке)</span>
        </div>
        <div class="col-xs-4">
            <button class="button right button_sh">отобразить</button>
        </div>
    </div>
</div>

<div class="filter_line_view">
    <div class="row">
        <div class="col-xs-6">
            <div class="view_sort">
                <span>Сортировать по:</span> <a href="#">Лидеры продаж <i class="fa fa-caret-down" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="show_view">
                <span>Вид просмотра:</span>  <a href="#"><i class="fa fa-th fa-lg" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="prod_items clearfix">
    <div id="filter_block" class="filtr_block">
        <div class="h_filtr">Параметры фильтра</div>
        <ul class="filter_ul">
            <?php
            //В сессию записать ид категорий
              $filters = ModelCatalog::listFilters(1);
              echo '<pre>';
              print_r($filters);
               
            //Формируем массив для вывода
            //    foreach ($filters as $key => $filtr) {
            //        $endfilters[$filtr['name_spec']][] = array('val_id' => $filtr['id_spec'],
            //             'val_spec' => $filtr['val_spec']);
            //      }
            //print_r($endfilters);
            /*
              if (!empty($data['products'])) {
              foreach ($endfilters as $key => $filters) {
              $text = '<li>';
              $text.='<button class="filtr_ul_button">';
              $text.='<span><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp; ' . $key . '</span>';
              $text.='</button>';

              $text.='<ul class="filter_options">';
              foreach ($filters as $value) {
              $text.='<li>';
              $text.='<label>';
              $text.='<input type="checkbox" name="filter_parameters[]" value=' . $value['val_id'] . '>';
              $text.='<span class="name"><font><font class="">' . $value['val_spec'] . '</font></font></span>';
              $text.='</label>';
              $text.='</li>';
              }
              $text.='</ul>';
              echo $text;
              }
              }
             */
            ?>

            <!--<li>
                <button class="filtr_ul_button">
                    <span><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp; Страна_N</span>
                </button>
                <ul class="filter_options">
                    <li>
                        <label>
                            <input type="checkbox" name="filter_parameters[]" value="Parametre|7|Drevený box">
                            <span class="name"><font><font class="">Франция</font></font></span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="checkbox" name="filter_parameters[]" value="Parametre|7|Plech">
                            <span class="name"><font><font>Россия</font></font></span>
                        </label>
                    </li>
                </ul>
            </li>
            <li>
                <button class="filtr_ul_button">
                    <span><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp; Возраст_N</span>
                </button>
                <ul class="filter_options">
                    <li>
                        <label>
                            <input type="checkbox" name="filter_parameters[]" value="Parametre|7|Drevený box">
                            <span class="name"><font><font class="">10 лет.</font></font></span>
                        </label>
                    </li>
                </ul>
            </li>


        </ul>
         -->
    </div>

    <div id="right_block" class="prod_block">
        <?php
       
        if (!empty($data['products'])) {
            
            //echo '<pre>';
            //print_r($data);
            foreach ($data['products'] as $product) {
                               
                $url = Yii::app()->createUrl('product', array('url' => $product['t_url']));

                $text = '<div class="cont_pr">';
                $text.= '<a class="item_link" href=' . $url . '>';
                $text.=($product['d_photo_middle']) ? '<img src="img/product/' . $product['d_photo_middle'] . '" alt="" />' : '<img src="img/noimg.jpg" alt="" />';

                //$static = ModelCatalog::statdata($product['id']);
                $f = ($product['f_volume'] != 0) ? $product['f_volume'] . ' L  • ' : '';
                $v = (!empty($product['f_fortress'])) ? $product['f_fortress'] . ' % ' : '';
                $text.='<div class="volume">' . $f . $v . '</div>';

                //Вырезаем строку до символа /
                $pos = strpos($product['i_name_sku'], '/');
                $title = substr($product['i_name_sku'], 0, $pos);
                $text.='<div class="name_pr">' . $title . '</div>';




                $aval = ($product['i_availability'] == 0) ? 'На складе' : '';
                switch ($product['i_availability']) {
                    case 0:
                        $aval = '<div class="availability_not">Нет в наличии</div>';
                        break;
                    case 1:
                        $aval = '<div class="availability">В наличии</div>';
                        break;
                    case 2:
                        $aval = '<div class="availability">Количество ограничено</div>';
                        break;
                    case 3:
                        $aval = '<div class="availability_pop">Популярное</div>';
                        break;
                    case 4:
                        $aval = '<div class="availability_ak">Акция</div>';
                        break;
                }

                $text.=$aval;

                $old_pr = ($product['i_old_price'] != 0) ? $product['i_old_price'] . ' руб.' : '';
                $text.='<div class="price_old">' . $old_pr . ' </div>';

                $text.='<div class="price">' . $product['i_price'] . ' руб</div>';
                $text.='<div class="flash">';
                
                
                if ($product['i_old_price'] != 0) {
                    $text.='<div class="label label_red">';
                    $pr = intval($product['i_price'] * 100 / $product['i_old_price']);
                    $rpr = 100 - $pr;
                    $text.='<div class="discount__top">' . $rpr . '%</div>';
                    $text.='<div class="discount__bottom">Скидка</div>';
                    $text.='</div>';
                }
                 if ($product['i_popular'] != 0) {
                     $text.='<div class="label label_green">';
                     $text.='<div class="l_popular">Популярное</div>';
                     $text.='</div>';
                 }
                
                 if ($product['i_limitedly'] != 0) {
                     $text.='<div class="label label_yelow">';
                     $text.='<div class="l_limit">Ограниченное</div>';
                     $text.=' <div class="l2_limit">количество</div>';
                     $text.='</div>';
                 }
                
               
                
                $text.='</div>';
                $text.='</a>';
                $text.='<button class="button_b"  data-idproduct="' . $product['id'] . '" ><i class="fa fa-shopping-cart fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp; В корзину</button>';
                $text.='</div>';
                echo $text;
            }
        } else {
            echo '<br><br><br><h2>Товара еще нет в данной категории!!!</h2><br><br><br>';
        }
        ?>
    </div>
</div>

<?php
   if (!empty($data['products'])) {
        $this->renderPartial('_pagination', array('pag' => $pagin));
        $this->renderPartial('_desccategory', array('data' => $data['desc']));
   }
?>


