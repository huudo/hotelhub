<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bedding-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->labelEx($model,'id_room'); ?>
	<?php 
		// echo $form->textField($model,'id_room',array('size'=>10,'maxlength'=>10)); 
		echo $form->dropDownList($model, 'id_room', Room::items());
	?>
	<?php echo $form->error($model,'id_room'); ?>

	<?php echo $form->textFieldRow($model,'gest_num',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'single_num',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'double_num',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'beddig_desc',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'additional_cost',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'cots_available',array('class'=>'span5','maxlength'=>2)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
