<?php
/* @var $this ScheduleOverridesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Schedule Overrides',
);

$this->menu=array(
	array('label'=>'Create ScheduleOverrides', 'url'=>array('create')),
	array('label'=>'Manage ScheduleOverrides', 'url'=>array('admin')),
);
?>

<h2>Schedule Overrides</h2>
<table border=1>
<tr>
	<th></th>
	<th>Employee Name</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Start Time</th>
	<th>End Time</th>
</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</table>
