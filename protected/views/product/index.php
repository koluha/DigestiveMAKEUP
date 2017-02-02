<script>
    $(document).ready(function () {
        $('.button_buy').click(function () {
            var id_pr = $(this).attr('data-idproduct');
            // console.log(id_pr);
            $.get("<?php echo Yii::app()->createUrl('basket/addcart') ?>", {product_id: id_pr});

            //Чтобы в корзину успел добавить товар
            setTimeout(function () {
                document.location.href = '<?php echo Yii::app()->createUrl('basket/showcart') ?>'
            }, 500);
        });
    });
</script>


<div class="desc_product">
    <div class="row">
        <div class="col-xs-7">
            <div class="desc_img">
                <!-- 
                    [id] => 247
         
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
                $img = ($data['desc']['d_photo_middle']) ? '<img src="/uploads/' . $data['desc']['d_photo_middle'] . '" alt="" />' : '<img src="/img/noimg.jpg" alt="" />';
                echo $img;

                $flash = '<div class="flash">';
                if ($data['desc']['i_old_price'] != 0) {
                    $flash.='<div class="label label_red">';
                    $pr = intval($data['desc']['i_price'] * 100 / $data['desc']['i_old_price']);
                    $rpr = 100 - $pr;
                    $flash.='<div class="discount__top">' . $rpr . '%</div>';
                    $flash.='<div class="discount__bottom">Скидка</div>';
                    $flash.='</div>';
                }
                if ($data['desc']['i_popular'] != 0) {
                    $flash.='<div class="label label_green">';
                    $flash.='<div class="l_popular">Популярное</div>';
                    $flash.='</div>';
                }
                if ($data['desc']['i_limitedly'] != 0) {
                    $flash.='<div class="label label_yelow">';
                    $flash.='<div class="l_limit">Ограниченное</div>';
                    $flash.=' <div class="l2_limit">количество</div>';
                    $flash.='</div>';
                }
                $flash.='</div>';
                echo $flash;
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
            <?php
            $h_title = Myhelper::title_two($data['desc']['i_name_sku']);
            if ($h_title[0]) {
                echo '<h1 class="h_title">' . $h_title[0] . '<br><span class="h1_title">' . $h_title[1] . '</span></h1>';
            }
            ?>




            <?php
            $art = ($data['desc']['article'] != '') ? $data['desc']['article'] : '';
            if ($art) {
                echo ' <div class="it_1">Артикул: ' . $art . '</div>';
            }

            $f = ($data['desc']['f_volume'] != 0) ? $data['desc']['f_volume'] . ' L  • ' : '';
            $v = (!empty($data['desc']['f_fortress']) ) ? $data['desc']['f_fortress'] . ' % ' : '';
            echo '<div class="it_1"><b>' . $f . $v . '</b></div>';
            ?>      

            <!-- Описание продукта -->
            <div class="it_desc">
                <?php
                if ($data['desc']['d_desc_product']) {
                    echo Myhelper::obrez_text($data['desc']['d_desc_product']) . ' <a href="#ex2" title="Узнайте больше">Подробнее</a>';
                }
                ?>
            </div>
            <!-- Конец Описание продукта -->

            <div class="it_val">
                <?php
                switch ($data['desc']['i_availability']) {
                    case 0:
                        echo '<div class="it_1 availability_not">Нет в наличии</div>';
                        break;
                    case 1:
                        echo '<div class="it_1 availability">В наличии</div>';
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
                    <button class="button_buy" data-idproduct="<?php echo $data['desc']['id'] ?>"><i class="fa fa-shopping-cart fa-lg" ></i>&nbsp;&nbsp; В корзину</button>
                </div>
            </div>


        </div>
    </div>

    <!--Описание продукта снизу -->
    <div class="container">
        <div class="row">
            <div class="foot_deck ">
                <div class="nav_tags">
                    <ul>
                        <li><a href="#">Описание продукта</a></li>
                    </ul>      
                    <div class="fasert">
                        <span>Поделиться этим продуктом</span>
                        <img src="/img/icons/share/FB.png"  alt="fb">
                        <img src="/img/icons/share/VK.png"  alt="fb">
                        <img src="/img/icons/share/Twitter.png"  alt="fb">
                        <img src="/img/icons/share/Odnoklasniki.png"  alt="fb">
                        <img src="/img/icons/share/mail-ru.png"  alt="fb">
                        <img src="/img/icons/share/ya.png"  alt="fb">
                    </div>
                </div>

                <div class="col-xs-9">
                    <section id="ex2"></section>


                    <?php
                    $h_title = Myhelper::title_two($data['desc']['i_name_sku']);
                    if ($h_title[0]) {
                        echo '<h1 class="h_title">' . $h_title[0] . '<br><span class="h1_title">' . $h_title[1] . '</span></h1>';
                    }
                    ?>


                    <?php
                    if ($data['desc']['d_logo_manuf']) {
                        echo '<div class="pro_desk_1">';
                        echo CHtml::image('/uploads/' . $data['desc']['d_logo_manuf'] . '', $data['desc']['d_logo_manuf']);
                        echo '</div>';
                        echo '<div class="it_desc pro_desk_2 w70">'; //Стили меняем когда есть картинка бренд
                        echo $data['desc']['d_desc_product'];
                        echo '<div class="d_link_manuf"><br>';
                        $sait_proiz = ($data['desc']['d_link_manuf']) ? 'Сайт производителя ' : '';
                        echo $sait_proiz;
                        echo CHtml::link($data['desc']['d_link_manuf'], $data['desc']['d_link_manuf'], array('target' => '_blank'));
                        echo '</div>';
                        echo '</div>';
                    } elseif ($data['desc']['d_logo_manuf'] == '') {
                        echo '<div class="it_desc pro_desk_2 w100">'; //Стили меняем когда нет картинка бренд
                        echo $data['desc']['d_desc_product'];
                        echo '<div class="d_link_manuf"><br>';
                        $sait_proiz = ($data['desc']['d_link_manuf']) ? 'Сайт производителя ' : '';
                        echo $sait_proiz;
                        echo CHtml::link($data['desc']['d_link_manuf'], $data['desc']['d_link_manuf'], array('target' => '_blank'));
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="col-xs-3">
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
    </div>
    <!--Конец Описание продукта снизу -->


</div>

<?php ?>