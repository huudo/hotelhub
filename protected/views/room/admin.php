<?php
$this->breadcrumbs=array(
	'Rooms'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Room','url'=>array('index')),
	array('label'=>'Create Room','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('room-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Rooms</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'room-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id_product',
		'id_supplier',
		array('name'=>'room_code', 'value'=>'$data->roomCode->name'),
		'room_type_code',
		array('name'=>'room_name', 'value'=>'$data->product->name'),
		/*
		'min_night_stay',
		'max_night_stay',
		'room_name',
		'root_description',
		'guests_tot_room_cap',
		'guests_included_price',
		'children_maxnum',
		'children_years',
		'children_extra',
		'adults_maxnum',
		'adults_extra',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
