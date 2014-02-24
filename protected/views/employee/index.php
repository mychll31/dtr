<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Employees',
);

$this->menu=array(
	array('label'=>'Create Employee', 'url'=>array('create')),
	array('label'=>'Manage Employee', 'url'=>array('index')),
);
?>

<h2>Employees</h2>
<form class="navbar-search pull-left" method="get" action=""><input type="hidden" name="r" value="employee/index"><input type="text" name="q" class="search-query span2" placeholder="Search"></form>
<table class="table table-bordered">
<tr>
	<th>ID</th>
	<th>Last Name</th>
	<th>Firs Name</th>
	<th>Middle Name</th>
	<th>Department</th>
	<th>Position</th>
	<th>Status</th>
</tr>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</table>
