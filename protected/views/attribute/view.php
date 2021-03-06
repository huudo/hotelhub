<?php
$this->breadcrumbs=array(
	'Attributes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Attribute','url'=>array('index')),
	array('label'=>'Create Attribute','url'=>array('create')),
	array('label'=>'Update Attribute','url'=>array('update','id'=>$model->id_attribute)),
	array('label'=>'Delete Attribute','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id_attribute),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Attribute','url'=>array('admin')),
);
?>

<h1>View Attribute #<?php echo $model->id_attribute; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id_attribute',
		'id_attribute_group',
		'name',
		'attr_type',
		'active',
		'position',
	),
)); ?>

<?php
	if($model->attr_type == "checkbox" || $model->attr_type == "radiobox") { 
		echo '<h4> Items </h4>';
		echo '<ul>';
		foreach($model->attributeItems as $item) {
			echo '<li>' . $item->item . '</li>';
		}
		echo '</ul>';
	}
?>