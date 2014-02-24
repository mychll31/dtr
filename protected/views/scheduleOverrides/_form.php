<?php
/* @var $this ScheduleOverridesController */
/* @var $model ScheduleOverrides */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'schedule-overrides-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	</div>	
	
	<?php echo $form->errorSummary($model); 
	if($alert != null){
		echo $alert;
	}
	?>
	<div class="row">
	<?php
	$employee = Employee::model()->findAll();
	$emp = array();
	foreach($employee as $emps){
		array_push($emp, $emps['id'].". ".$emps['lastname']." ".$emps['firstname']);
		}

	$this->widget(
									'bootstrap.widgets.TbSelect2',
									array(
													'asDropDownList' => false,
													'name' => 'emp_sel',
													'options' => array(
																	'tags' => $emp,
																	'placeholder' => 'Type the name of employee and press enter to select',
																	'width' => '500px',
																	'tokenSeparators' => array(',', ' ')
																	)
											 )
							 );
	?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'start_time'); ?>
		<?php
		$this->widget(
										'bootstrap.widgets.TbTimePicker',
										array(
														'name' => 'start_time',
														'attribute' => 'hours',
														'options' => array(
																		'showMeridian' => false
																		)
												 )
								 );
		?>
		<?php echo $form->error($model,'start_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_time'); ?>
		<?php
		$this->widget(
										'bootstrap.widgets.TbTimePicker',
										array(
														'name' => 'end_time',
														'attribute' => 'hours',
														'options' => array(
																		'showMeridian' => false
																		)
												 )
								 );
		?>
		<?php echo $form->error($model,'end_time'); ?>
	</div>

	<div class="row">
		<?php #echo $form->labelEx($model,'emp_id'); ?>
		<?php echo $form->hiddenField($model,'emp_id'); ?>
		<?php #echo $form->error($model,'emp_id'); ?>
	</div>

	<div class="row">
		<?php
		echo $form->datepickerRow($model,'start_date',array(
														'name'=>'start_date',
														'value'=>date("Y-m-d"),
														'options' => array(
																		'language' => 'en',
																		'autoclose'=>true,
																		'format'=>'yyyy-mm-dd',
																		),
														'prepend' => '<i class="icon-calendar"></i>'
														));

		?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php
		echo $form->datepickerRow($model,'end_date',array(
														'name'=>'end_date',
														'value'=>date("Y-m-d"),
														'options' => array(
																		'language' => 'en',
																		'autoclose'=>true,
																		'format'=>'yyyy-mm-dd',
																		),
														'prepend' => '<i class="icon-calendar"></i>'
														));

		?>
		<?php echo $form->error($model,'end_date'); ?>
	<br>RD
	<input type="checkbox" name="rd" value="RD" /> 
	</div>

	<br>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
