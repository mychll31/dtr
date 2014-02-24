<?php
/* @var $this ScheduleOverridesController */
/* @var $model ScheduleOverrides */

$this->breadcrumbs=array(
	'Schedule Overrides'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ScheduleOverrides', 'url'=>array('index')),
	array('label'=>'Create ScheduleOverrides', 'url'=>array('create')),
	array('label'=>'View ScheduleOverrides', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ScheduleOverrides', 'url'=>array('admin')),
);
?>

<h1>Update ScheduleOverrides <?php echo $model->id; ?></h1>

<?php $alert=null; $this->renderPartial('_form', array('model'=>$model,'alert'=>$alert)); ?>
