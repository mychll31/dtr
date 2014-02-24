<?php
/* @var $this ScheduleOverridesController */
/* @var $model ScheduleOverrides */

$this->breadcrumbs=array(
	'Schedule Overrides'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ScheduleOverrides', 'url'=>array('index')),
	array('label'=>'Create ScheduleOverrides', 'url'=>array('create')),
	array('label'=>'Delete ScheduleOverrides', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ScheduleOverrides', 'url'=>array('admin')),
);
?>

<table>
	<tr>
		<th>ID</th>
		<td><?php echo $model->id;?></td>
	</tr>
	<tr>
		<th>Employee Name</th>
		<td><?php $emp=Employee::model()->findAll();foreach($emp as $e){if($e['id']==$model->emp_id){echo $e['lastname'].", ".$e['firstname']." ".$e['middle_initial'].".";}}?></td>
	</tr>
	<tr>
		<th>Start Date</th>
		<td><?php echo date('d-M-y',strtotime($model->start_date));?></td>
	</tr>
	<tr>
		<th>End Date</th>
		<td><?php echo date('d-M-y',strtotime($model->end_date));?></td>
	</tr>
	<tr>
		<th>Start Time</th>
		<td><?php echo date('H:i',strtotime($model->start_time));?></td>
	</tr>
	<tr>
		<th>End Time</th>
		<td><?php echo date('H:i',strtotime($model->end_time));?></td>
	</tr>
</table>
