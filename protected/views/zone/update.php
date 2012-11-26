<?php
$this->breadcrumbs=array(
	'Zones'=>array('index'),
	$model->name=>array('view','id'=>$model->id_zone),
	'Update',
);

$this->menu=array(
	array('label'=>'List Zone','url'=>array('index')),
	array('label'=>'Create Zone','url'=>array('create')),
	array('label'=>'View Zone','url'=>array('view','id'=>$model->id_zone)),
	array('label'=>'Manage Zone','url'=>array('admin')),
);
?>

<h1>Update Zone <?php echo $model->id_zone; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>