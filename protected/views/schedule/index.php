<?php
/* @var $this ScheduleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Schedules',
);

$this->menu=array(
	array('label'=>'Create Schedule', 'url'=>array('create')),
	array('label'=>'Manage Schedule', 'url'=>array('admin')),
);
?>

<h1>Schedules</h1>

<table border=1>
<tr>
	<th>ID</th>
	<th>Monday</th>
	<th>Tuesday</th>
	<th>Wednesday</th>
	<th>Thursday</th>
	<th>Friday</th>
	<th>Saturday</th>
	<th>Sunday</th>
</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</table>
