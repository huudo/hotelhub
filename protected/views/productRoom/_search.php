<?php
/* @var $this ProductRoomController */
/* @var $model ProductRoom */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id_product_room'); ?>
		<?php echo $form->textField($model,'id_product_room',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_product'); ?>
		<?php echo $form->textField($model,'id_product',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_hotel'); ?>
		<?php echo $form->textField($model,'id_hotel',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_room_type'); ?>
		<?php echo $form->textField($model,'id_room_type',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_type_code'); ?>
		<?php echo $form->textField($model,'room_type_code',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lead_in_room_type'); ?>
		<?php echo $form->textField($model,'lead_in_room_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'full_rate'); ?>
		<?php echo $form->textField($model,'full_rate',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'min_night_stay'); ?>
		<?php echo $form->textField($model,'min_night_stay',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_night_stay'); ?>
		<?php echo $form->textField($model,'max_night_stay',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_name'); ?>
		<?php echo $form->textField($model,'room_name',array('size'=>60,'maxlength'=>64)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'root_description'); ?>
		<?php echo $form->textField($model,'root_description',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guests_tot_room_cap'); ?>
		<?php echo $form->textField($model,'guests_tot_room_cap',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guests_included_price'); ?>
		<?php echo $form->textField($model,'guests_included_price',array('size'=>2,'maxlength'=>2)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->