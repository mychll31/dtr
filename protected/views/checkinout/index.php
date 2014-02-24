<?php
/* @var $this CheckinoutController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Checkinouts',
);

$this->menu=array(
	array('label'=>'Create Checkinout', 'url'=>array('create')),
	array('label'=>'Manage Checkinout', 'url'=>array('admin')),
);
?>

<h1>Checkinouts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
