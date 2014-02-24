<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Employee', 'url'=>array('index')),
	array('label'=>'Create Employee', 'url'=>array('create')),
	array('label'=>'Update Employee', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Employee', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Employee', 'url'=>array('index')),
);
?>

<h3><?php echo $model->lastname.", ".$model->firstname." ".$model->middle_initial."."; ?></h3>

<table>
<tr><th>ID</th><td><?php echo $model->id;?></td></tr>
<tr><th>Last name</th><td><?php echo $model->lastname;?></td></tr>
<tr><th>First name</th><td><?php echo $model->firstname;?></td></tr>
<tr><th>Middle Initial</th><td><?php echo $model->middle_initial;?></td></tr>
<tr><th>Position</th><td><?php foreach($pos as $p):if($p['id'] == $model->position_id){ echo $p['name'];};endforeach;?></td></tr>
<tr><th>Department</th><td><?php foreach($dep as $p):if($p['id'] == $model->department_id){ echo $p['name'];};endforeach;?></td></tr>
<tr><th>Status</th><td><?php foreach($stat as $p):if($p['id'] == $model->status_id){ echo $p['name'];};endforeach;?></td></tr>
</table>
