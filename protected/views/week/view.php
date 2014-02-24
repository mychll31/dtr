<?php
/* @var $this WeekController */
/* @var $model Week */

$this->breadcrumbs=array(
	'Weeks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Week', 'url'=>array('index')),
	array('label'=>'Create Week', 'url'=>array('create')),
	array('label'=>'Update Week', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Week', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Week', 'url'=>array('admin')),
);
?>

<h1>View Week #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'week_no',
		'start_date',
		'end_date',
	),
)); ?>
