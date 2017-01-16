 <?php
 $data['products']=$products;
       
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