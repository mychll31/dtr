<?php
/* @var $this EmployeeScheduleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employee Schedules',
);

$this->menu=array(
	array('label'=>'Create EmployeeSchedule', 'url'=>array('create')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);
?>

<h1>Employee Schedules</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
