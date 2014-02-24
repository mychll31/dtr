<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */

$this->breadcrumbs=array(
	'Employee Schedules'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List EmployeeSchedule', 'url'=>array('index')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);*/
?>

<?php $this->renderPartial('_report', array(
	'model'=>$model,
	'emps_lists'=>$emps_lists,
	'startDate'=>$startDate,
	'endDate'=>$endDate,
	'employees'=>$employees,
	'alert'=>$alert,
	'department'=>$department,
	'checkinout'=>$checkinout,
	'checkot' => $checkot,
	'leave' => $leave,
	'overrides' => $overrides,
	)); ?>
