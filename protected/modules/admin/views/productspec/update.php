<?php
/* @var $this ProductSpecController */
/* @var $model ProductSpec */

$this->breadcrumbs=array(
	'Product Specs'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductSpec', 'url'=>array('index')),
	array('label'=>'Create ProductSpec', 'url'=>array('create')),
	array('label'=>'View ProductSpec', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSpec', 'url'=>array('admin')),
);
?>

<h1>Update ProductSpec <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>