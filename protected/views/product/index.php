<div class="desc_product">
    <div class="row">
        <div class="col-xs-7">
            <div class="desc_img">
                <!-- 
                    [id] => 247
                    [key_category] => 28
                    [i_name_sku] => Jagermeister 0,5 l / Егермейстер 0,5 л
                    [i_price] => 895.00
                    [i_old_price] => 0.00
                    [i_availability] => 1
                    [t_url] => Jagermeister_05
                    [d_photo_middle] => jagermeister 0,5-2.jpg
                    [t_meta_title] => Ликер «Jagermeister 0,5»
                    [t_meta_keyword] => 
                    [t_meta_description] => 
                -->
                <?php
                $img = ($data['desc']['d_photo_middle']) ? '<img src="img/product/' . $data['desc']['d_photo_middle'] . '" alt="" />' : '<img src="img/noimg.jpg" alt="" />';
                echo $img;
                ?>


                <div class="flash">
                    <div class="discount">

                        <?php
                        if ($data['desc']['i_old_price'] != 0) {
                            $pr = intval($data['desc']['i_price'] * 100 / $data['desc']['i_old_price']);
                            $rpr = 100 - $pr;
                            echo '<div class="discount__bottom">Скидка</div>';
                            echo '<div class="discount__top">' . $rpr . '%</div>';
                        }
                        ?>

                    </div>
                </div>  
            </div>
        </div>
        <div class="col-xs-5">
            <h1><?php echo $data['desc']['i_name_sku']; ?> </h1>
            <!--<div class="it_1">Ром, Таиланд 70cl Ref: 51020</div>-->
            <?php
            $f = ($data['desc']['f_volume'] != 0) ? $data['desc']['f_volume'] . ' L  • ' : '';
            $v = (!empty($data['desc']['f_fortress']) ) ? $data['desc']['f_fortress'] . ' % ' : '';
            echo '<div class="volume"><b>' . $f . $v . '</b></div>';
            ?>      
            <div class="it_val">
                <?php
                switch ($data['desc']['i_availability']) {
                    case 0:
                        echo '<div class="availability_not">Нет в наличии</div>';
                        break;
                    case 1:
                        echo '<div class="availability">В наличии</div>';
                        break;
                    case 2:
                        echo '<div class="availability">Количество ограничено</div>';
                        break;
                    case 3:
                        echo '<div class="availability_pop">Популярное</div>';
                        break;
                    case 4:
                        echo '<div class="availability_ak">Акция</div>';
                        break;
                }
                ?>
            </div>
            <div class="buy clearfix">
                <div class="price_blok">
                    <span class="price"><?php echo $data['desc']['i_price']; ?></span> <span>руб.</span><br>
                    <?php $old_pr = ($data['desc']['i_old_price'] != 0) ? $data['desc']['i_old_price'] . ' руб.' : ''; ?>
                    <span class="oldprice"><?php echo $old_pr ?></span>
                </div>

                <div class="bt_buy">
                    <button class="button_buy"><i class="fa fa-shopping-cart fa-lg" ></i>&nbsp;&nbsp; В корзину</button>
                </div>
            </div>
            <div class="it_desc">
                <?php
                echo $data['desc']['d_desc_product'];
                ?>
            </div>
            <div class="desc_parameters">
                <h2 class="par_desc">Основная информация:</h2>
                <?php
                $decs = ($data['desc']['f_brand']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Брэнд</strong></div><div class="col-xs-7">' . $data['desc']['f_brand'] . '</div></div>' : '';
                $decs.=($data['desc']['f_country']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Страна</strong></div><div class="col-xs-7">' . $data['desc']['f_country'] . '</div></div>' : '';
                $decs.=($data['desc']['f_region']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Регион</strong></div><div class="col-xs-7">' . $data['desc']['f_region'] . '</div></div>' : '';
                $decs.=($data['desc']['f_type']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Тип</strong></div><div class="col-xs-7">' . $data['desc']['f_type'] . '</div></div>' : '';
                $decs.=($data['desc']['f_alcohol']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Спирт</strong></div><div class="col-xs-7">' . $data['desc']['f_alcohol'] . '</div></div>' : '';
                $decs.=($data['desc']['f_taste']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Вкус</strong></div><div class="col-xs-7">' . $data['desc']['f_taste'] . '</div></div>' : '';
                $decs.=($data['desc']['f_sugar']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Сахар</strong></div><div class="col-xs-7">' . $data['desc']['f_sugar'] . '</div></div>' : '';
                $decs.=($data['desc']['f_grape_sort']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Сорт винограда</strong></div><div class="col-xs-7">' . $data['desc']['f_grape_sort'] . '</div></div>' : '';
                $decs.=($data['desc']['f_vintage_year']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Год урожая</strong></div><div class="col-xs-7">' . $data['desc']['f_vintage_year'] . '</div></div>' : '';
                $decs.=($data['desc']['f_color']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Цвет</strong></div><div class="col-xs-7">' . $data['desc']['f_color'] . '</div></div>' : '';
                $decs.=($data['desc']['f_excerpt']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Выдержка</strong></div><div class="col-xs-7">' . $data['desc']['f_excerpt'] . '</div></div>' : '';
                $decs.=($data['desc']['f_fortress']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Крепость</strong></div><div class="col-xs-7">' . $data['desc']['f_fortress'] . '%</div></div>' : '';
                $decs.=($data['desc']['f_volume'] != 0) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Объем</strong></div><div class="col-xs-7">' . $data['desc']['f_volume'] . '</div></div>' : '';
                $decs.=($data['desc']['f_packaging']) ? '<div class="row par_desc"><div class="col-xs-5"><strong>Упаковка</strong></div><div class="col-xs-7">' . $data['desc']['f_packaging'] . '</div></div>' : '';


                $d = ($decs) ? $decs : 'Нет данных';
                echo $d;
                ?>
            </div>
        </div>
    </div>
</div>

<?php ?>