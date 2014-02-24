<?php
/* @var $this EmployeeController */
/* @var $data Employee */
?>
<tr>
<div class="view">
<td>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
</td><td>
	<?php echo CHtml::link(CHtml::encode($data->lastname), array('view', 'id'=>$data->id)); ?>
	<br />

</td><td>
	<?php echo CHtml::link(CHtml::encode($data->firstname), array('view', 'id'=>$data->id)); ?>
	<br />

</td><td>
	<?php echo CHtml::link(CHtml::encode($data->middle_initial), array('view', 'id'=>$data->id)); ?>
	<br />

</td><td>
	<?php echo CHtml::link(CHtml::encode($data->pos->name), array('view', 'id'=>$data->id)); ?>
	<br />

</td><td>
	<?php echo CHtml::link(CHtml::encode($data->dept->name), array('view', 'id'=>$data->id)); ?>
	<br />

</td><td>
	<?php echo CHtml::link(CHtml::encode($data->stat->name), array('view', 'id'=>$data->id)); ?>
	<br />

</td>
</tr>
</div>

