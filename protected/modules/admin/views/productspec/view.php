<?php
/* @var $this ProductSpecController */
/* @var $model ProductSpec */

$this->breadcrumbs=array(
	'Product Specs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List ProductSpec', 'url'=>array('index')),
	array('label'=>'Create ProductSpec', 'url'=>array('create')),
	array('label'=>'Update ProductSpec', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProductSpec', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProductSpec', 'url'=>array('admin')),
);
?>

<h1>View ProductSpec #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'type',
	),
)); ?>
