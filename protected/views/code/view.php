<?php
$this->breadcrumbs=array(
	'Codes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Code','url'=>array('index')),
	array('label'=>'Create Code','url'=>array('create')),
	array('label'=>'Update Code','url'=>array('update','id'=>$model->code)),
	array('label'=>'Delete Code','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->code),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Code','url'=>array('admin')),
);
?>

<h1>View Code #<?php echo $model->code; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'type',
		'name',
		'position',
	),
)); ?>
