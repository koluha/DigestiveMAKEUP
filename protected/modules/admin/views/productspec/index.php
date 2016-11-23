<?php
/* @var $this ProductSpecController */
/* @var $model ProductSpec */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#product-spec-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление спефикациями</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-spec-grid',
	'dataProvider'=>$model->search(),
        'columns' => array(
            array(
                'name' => 'id',
                'type' => 'raw',
                'value' => '$data->id',
            ),
            array(
                'name' => 'name',
                'type' => 'raw',
                'value' => '$data->name',
            ),
            array(
                'name' => 'type',
                'type' => 'raw',
                'value' => 'ProductSpec::getType($data->type)',
            ),
       
))); 
