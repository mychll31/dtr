<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */

$this->breadcrumbs=array(
	'Employee Schedules'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List EmployeeSchedule', 'url'=>array('index')),
	array('label'=>'Manage EmployeeSchedule', 'url'=>array('admin')),
);*/
?>

<h1>Create EmployeeSchedule</h1>

<?php $this->renderPartial('_form', array('model'=>$model,'employee'=>$employee,'alert'=>$alert,'emp'=>$emp)); ?>
