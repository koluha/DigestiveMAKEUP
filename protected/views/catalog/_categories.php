<div class="container">
 
    <?php
    //echo '<pre>';
    //print_r($data['categories'])
    ?>
    <div class="filter_item">
        <div class="row">
            <div class="col-xs-12">
                <ul class="filter_item_ul">
                    
                    <?php foreach ($data['categories'] as $item): ?>
                        <?php// $image = '<img src="img/cat/' . $item['img'] . '" alt="' . $item['title'] . '" />' .$item['title']. ''; ?>
                    
                         <?php $image = ($item['img']) ? '<img src="/img/cat/' . $item['img'] . '" alt="' . $item['title'] . '" /><span>' .$item['title']. '</span>' : '<img src="/img/noimg.jpg" alt="" /><span>' .$item['title']. '</span>';
          
                    ?>
                        <?php echo '<li>'.CHtml::link($image, array('catalog/', 'url' => $item['url'])).'</li>'; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>