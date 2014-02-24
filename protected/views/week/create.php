<?php
/* @var $this WeekController */
/* @var $model Week */

$this->breadcrumbs=array(
	'Weeks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Week', 'url'=>array('index')),
	array('label'=>'Manage Week', 'url'=>array('admin')),
);
?>

<h2>Generate Week</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
