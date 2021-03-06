<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'supplier-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
)); ?>

	<fieldset>
		<legend>Details</legend>
		<p class="help-block">Fields with <span class="required">*</span> are required.</p>
		<?php echo $form->errorSummary($model); ?>

		<?php			
			if($model->isNewRecord) {
				
				Yii::app()->clientScript->registerScript(
			       'id_supplier',
			       '$("#id_user").on("change", function() {
			       		$("#supplier-form").submit();
					})',
					CClientScript::POS_READY
				);
				
				echo $form->dropDownListRow($model,'id_supplier', User::getUnLinkSupplierUserItems(),
					array('prompt' => '--Please select--','id'=>'id_user','class' => 'span5'));
			} else {
				echo $form->hiddenField($model,'id_supplier',array('class'=>'span5','maxlength'=>64));
			}
		?>
		<?php echo $form->error($model,'id_supplier'); ?>
	
		<fieldset>
			<legend>Contact Information</legend>

			<?php
				if($model->isNewRecord) {
					echo $form->dropDownListRow($model,'id_service', Service::items(), array('class'=>'span5')); 
				}
			?>
			<?php echo $form->textFieldRow($model,'manager_name',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'manager_email',array('class'=>'span5','maxlength'=>128)); ?>
			<?php echo $form->textFieldRow($model,'sales_name',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'sales_email',array('class'=>'span5','maxlength'=>128)); ?>
			<?php echo $form->textFieldRow($model,'reservations_name',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'reservations_email',array('class'=>'span5','maxlength'=>128)); ?>
			<?php echo $form->textFieldRow($model,'reservations_phone',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'reservations_fx',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'accounts_name',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'accounts_email',array('class'=>'span5','maxlength'=>128)); ?>
			<?php echo $form->textFieldRow($model,'accounts_phone',array('class'=>'span5','maxlength'=>64)); ?>
			<?php echo $form->textFieldRow($model,'accounts_fx',array('class'=>'span5','maxlength'=>64)); ?>
		</fieldset>

		<fieldset>
			<legend>Supplier Tax Details</legend>
			<?php echo $form->textFieldRow($model,'supplier_abn',array('class'=>'span5','maxlength'=>64)); ?>
		</fieldset>

		<fieldset>
			<legend>Property Information</legend>
			<?php echo $form->textFieldRow($model,'member_chain_group',array('class'=>'span5','maxlength'=>64)); ?>
			
			<?php if(Service::getCurrentService() == Service::HOTEL) {
				echo $form->textFieldRow($model,'room_count',array('class'=>'span5'));
			} ?>
			<?php echo $form->textFieldRow($model,'website',array('class'=>'span5','maxlength'=>128)); ?>
		</fieldset>
		
		<fieldset>
			<legend>Website Display Details</legend>
			<?php $this->widget('MultiLangSelector'); ?>

			<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255, 'multilang'=>'1')); ?>
			<?php echo $form->textAreaRow($model,'short_promotional_blurb',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			<?php echo $form->textAreaRow($model,'property_details',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			<?php echo $form->textAreaRow($model,'business_facilities',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			<fieldset>
				<legend>Check In Details</legend>
				<?php echo $form->dropDownListRow($model,'check_in_time', Supplier::checkInOutTimeItems(), array('class' => 'span5')); ?>
				<?php echo $form->dropDownListRow($model,'check_out_time', Supplier::checkInOutTimeItems(), array('class' => 'span5')); ?>
				<?php echo $form->textAreaRow($model,'checkin_instructions',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			</fieldset>
			
			<?php echo $form->textAreaRow($model,'car_parking',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			<?php echo $form->textAreaRow($model,'getting_there',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
			<?php echo $form->textAreaRow($model,'things_to_do',array('rows'=>6, 'class'=>'span5', 'multilang'=>'1')); ?>
		</fieldset>
				
		<fieldset>
			<legend>Supplier Facilities</legend>
			<div>
			<?php		
				$attributeInfos = $model->getAllAttributes();
				foreach($attributeInfos as $info) {
					echo '<div>';
					echo '<fieldset><legend>' . $info['attribute']->name . '</legend>';
						
					echo CHtml::checkBoxList('selectedAttributeItemIds' , $info['selectedAttributeItemIds'],
						CHtml::listData(
							$info['attributeItem'],
							'id_attribute_item',
							'item'
						),
						array('container' => 'span',
						'separator' => '',
						'template' => '<p class="label_checkbox_pair">{input}{label}</p>')
					);
					echo '</fieldset></div>';
					echo '<div class="cb"></div>';
				}
			?>
			</div>
		</fieldset>
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>$model->isNewRecord ? 'Create' : 'Save',
			)); ?>
		</div>
	</fieldset>

<?php $this->endWidget(); ?>
