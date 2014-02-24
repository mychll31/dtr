<?php
/* @var $this ScheduleOverridesController */
/* @var $model ScheduleOverrides */

$this->breadcrumbs=array(
	'Schedule Overrides'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ScheduleOverrides', 'url'=>array('index')),
	array('label'=>'Manage ScheduleOverrides', 'url'=>array('admin')),
);
?>

<h3>Override Schedule</h3>

<?php $this->renderPartial('_form', array('model'=>$model,'alert'=>$alert)); ?>
