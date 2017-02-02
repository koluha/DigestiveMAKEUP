<nav id="top-menu">
    <ul class="root">
<?php $route?>
	<li <?php if ($route=='/admin/default/index') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('/admin/default/index') ?>">Главная</a>
	</li>
        <li <?php if ($route=='admin/category/index') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/category/index') ?>">Категорий</a>
	</li>
        <li <?php if ($route=='admin/price/index') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/price/index') ?>">Загрузка прайса</a>
	</li>
        
        <li <?php if ($route=='admin/price/view') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/price/view') ?>">Лист прайса</a>
	</li>
        
        <li <?php if ($route=='admin/elfinder/index') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/elfinder/index') ?>">Менеджер файлов</a>
	</li>
        
        <li <?php if ($route=='admin/productspec/index') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/productspec/index') ?>">Спецификация DEL</a>
	</li>
        <li <?php if ($route=='admin/prices2') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/product/index') ?>">Продукты DEL</a>
	</li>
        
        <li <?php if ($route=='admin/prices2') echo 'class="active"' ?>>
	    <a href="<? echo Yii::app()->createUrl('admin/order/adminList') ?>">Заказы</a>
	</li>
        

 	<li>
	    <a href="<? echo Yii::app()->createUrl('admin/user/logout') ?>">
		Выход: <?php echo Yii::app()->user->name ?>
	    </a>
	</li>
    </ul>
</nav>