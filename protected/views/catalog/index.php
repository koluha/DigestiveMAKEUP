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
               
                <span>Сортировать по:</span> 
                <?php 
                CHtml::dropDownList($name, $select, $data);
                ?>
                 <select>
                     <option>Акции, скидка</option>
                     <option>Популярное, хит продаж</option>
                     <option>Ограниченное количество</option>
                    <option>Возврастание цены</option>
                    <option>Убывание цены</option>
                </select>
                
                
                <a href="#">Лидеры продаж <i class="fa fa-caret-down" aria-hidden="true"></i></a>
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
        <?php $this->renderPartial('_product', array('products' => $data['products'])); ?>
    </div>
</div>

<?php
if (!empty($data['products'])) {
    $this->renderPartial('_pagination', array('pag' => $pagin));
    $this->renderPartial('_desccategory', array('data' => $data['desc']));
}
?>


