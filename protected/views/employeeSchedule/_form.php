<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */
/* @var $form CActiveForm */
?>
<?php echo $alert;?>
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'employee-schedule-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<!--div class="row">
		<?php #echo $form->labelEx($model,'sched_id'); ?>
		<?php #echo $form->textField($model,'sched_id'); ?>
		<?php #echo $form->error($model,'sched_id'); ?>
	</div-->

	<div class="row">
		<?php echo $form->labelEx($model,'Employee/s Name:'); ?>
		<?php echo $form->hiddenField($model,'emp_id'); ?>
		<?php echo $form->error($model,'emp_id'); ?>

		<?php
		$this->widget(
										'bootstrap.widgets.TbSelect2',
										array(
														'asDropDownList' => false,
														'name' => 'emp_sel',
														'options' => array(
																		'tags' => $emp,
																		'placeholder' => 'Type the name of employee and press enter to select',
																		'width' => '100%',
																		'tokenSeparators' => array(',', ' ')
																		)
												 )
								 );
		?>
	</div>
	<br>
	<div class="row">
	<?php
	$sched = Schedule::model()->findAll();
	$totalsched = 0;
	$days = array();
	$varMon = null;
	$vartue = null;
	$varwed = null;
	$varthu = null;
	$varfri = null;
	$varsat = null;
	$varsun = null;
	$resultString = null;
	$res_day = null;
	$output = array();

	foreach($sched as $schedule){

	$array_s = array(
		'M'=>$varMon = ($schedule['mon'] == null ? $varMon='RD' : $varMon=$schedule['mon']),
		'T'=>$vartue = ($schedule['tue'] == null ? $vartue='RD' : $vartue=$schedule['tue']),
		'W'=>$varwed = ($schedule['wed'] == null ? $varwed='RD' : $varwed=$schedule['wed']),
		'Th'=>$varthu = ($schedule['thur'] == null ? $varthu='RD' : $varthu=$schedule['thur']),
		'F'=>$varfri = ($schedule['fri'] == null ? $varfri='RD' : $varfri=$schedule['fri']),
		'Sa'=>$varsat = ($schedule['sat'] == null ? $varsat='RD' : $varsat=$schedule['sat']),
		'Su'=>$varsun = ($schedule['sun'] == null ? $varsun='RD' : $varsun=$schedule['sun']),
		);	

	foreach(array_values($array_s) as $value) {
					foreach($array_s as $key => $current) {
									if($value != $current)
													continue;
									if(!array_key_exists($value, $output))
													$output[$value] = array();
									if(!in_array($key, $output[$value]))
													$output[$value][] = $key;
					}
	}
	$varPush = null;
	$push = array();
	foreach($output as $key => $current) {
					$varme = implode('', $current) . '-' . $key . ' ';
					$push[] = $varme;
	}
	foreach ($push as $t => $val){
					$varPush .= $val;

	}
	array_push($days, $schedule['id']."| ".$varPush);
	$totalsched ++;
	$varPush = null;
	$output = array();
	}
#echo "<pre>";
#print_r($days);
#echo "</pre>";

	echo "Schedule:  ";
	$this->widget(
									'bootstrap.widgets.TbTypeahead',
									array(
													'name' => 'sched_sel',
													'options' => array(
																	'source' => $days,
																	'items' => $totalsched,
																	),
													));
	?>
	</div>

	<div class="row">
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
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
