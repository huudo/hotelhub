<?php
/* @var $this CartController */
/* @var $model Cart */

$this->breadcrumbs=array(
	'Carts'=>array('index'),
	$model->id_cart=>array('view','id'=>$model->id_cart),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cart', 'url'=>array('index')),
	array('label'=>'Create Cart', 'url'=>array('create')),
	array('label'=>'View Cart', 'url'=>array('view', 'id'=>$model->id_cart)),
	array('label'=>'Manage Cart', 'url'=>array('admin')),
);
?>

<h1>Update Cart <?php echo $model->id_cart; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>