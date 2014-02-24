<?php
/* @var $this WeekController */
/* @var $model Week */

$this->breadcrumbs=array(
	'Weeks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Week', 'url'=>array('index')),
	array('label'=>'Create Week', 'url'=>array('create')),
	array('label'=>'View Week', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Week', 'url'=>array('admin')),
);
?>

<h1>Update Week <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>