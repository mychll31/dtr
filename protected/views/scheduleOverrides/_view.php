<?php
/* @var $this ScheduleOverridesController */
/* @var $data ScheduleOverrides */
?>

<div class="view">
<tr>
<td>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
</td><td>
	<?php $emp = Employee::model()->findAll(); foreach($emp as $e){if($e['id']==$data->emp_id){echo $e['lastname'].", ".$e['firstname']." ".$e['middle_initial'].".";}}?>
	<br />

</td><td>
	<?php echo CHtml::encode(date('d-M-y',strtotime($data->start_date))); ?>
	<br />
</td><td>
	<?php echo CHtml::encode(date('d-M-y',strtotime($data->end_date))); ?>
	<br />

</td><td>
	<?php echo CHtml::encode(date('H:i',strtotime($data->start_time))); ?>
	<br />

</td><td>
	<?php echo CHtml::encode(date('H:i',strtotime($data->end_time))); ?>
	<br />

</td>
</tr>

</div>
