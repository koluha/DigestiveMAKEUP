<?php 
if($data['desc_product']){
    echo '<div class="cont_text">';
    echo '<div class="img_text">';
       echo CHtml::image('img/cat/'.$data['img'].'', $data['img']);
    echo '</div>';
    echo '<div class="desc_text">';
     echo $data['desc_product'];
   echo '</div>';
echo '</div>';
}
?>

