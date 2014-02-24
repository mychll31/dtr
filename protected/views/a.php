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

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
	<?php
	echo $form->datepickerRow($model,'start_date',array(
													'name'=>'startDate',
													'value'=>date("Y-m-d"),
													'options' => array(
																	'language' => 'en',
																	'autoclose'=>true,
																	'format'=>'yyyy-mm-dd',
																	),
													'prepend' => '<i class="icon-calendar"></i>'
													));
	echo $form->datepickerRow($model,'end_date',array(
													'name'=>'endDate',
													'value'=>date("Y-m-d"),
													'options' => array(
																	'language' => 'en',
																	'autoclose'=>true,
																	'format'=>'yyyy-mm-dd',
																	),
													'prepend' => '<i class="icon-calendar"></i>'
													));
	?>
	<br>
	Start Time:<br>
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
	<br>
	End Time:<br>
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
	<br><br>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
