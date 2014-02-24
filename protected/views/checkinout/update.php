<?php
/* @var $this CheckinoutController */
/* @var $model Checkinout */

$this->breadcrumbs=array(
	'Checkinouts'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Checkinout', 'url'=>array('index')),
	array('label'=>'Create Checkinout', 'url'=>array('create')),
	array('label'=>'View Checkinout', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Checkinout', 'url'=>array('admin')),
);
?>

<h1>Update Checkinout <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>