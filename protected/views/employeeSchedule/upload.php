<?php
/* @var $this CheckinoutController */
/* @var $model Checkinout */

$this->breadcrumbs=array(
	'Checkinouts'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Checkinout', 'url'=>array('index')),
	array('label'=>'Manage Checkinout', 'url'=>array('admin')),
);*/
?>

<h3>Upload</h3>

<?php echo $this->renderPartial('_upload', array('model'=>$model,'alert'=>$alert,'symbol'=>$symbol)); ?>
