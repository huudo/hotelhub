<?php
$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	$model->id_hotel=>array('view','id'=>$model->id_hotel),
	'Update',
);

$this->menu=array(
	array('label'=>'List Hotel','url'=>array('index')),
	array('label'=>'Create Hotel','url'=>array('create')),
	array('label'=>'View Hotel','url'=>array('view','id'=>$model->id_hotel)),
	array('label'=>'Manage Hotel','url'=>array('admin')),
);
?>

<h1>Update Hotel <?php echo $model->id_hotel; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>