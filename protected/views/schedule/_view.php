<?php
/* @var $this ScheduleController */
/* @var $data Schedule */
?>

<div class="view">
<tr>
<td>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
</td><td>
	<?php echo CHtml::encode($data->mon); ?>
	<br />
</td><td>
	<?php echo CHtml::encode($data->tue); ?>
	<br />
</td><td>

	<?php echo CHtml::encode($data->wed); ?>
	<br />
</td><td>

	<?php echo CHtml::encode($data->thur); ?>
	<br />
</td><td>

	<?php echo CHtml::encode($data->fri); ?>
	<br />
</td><td>

	<?php echo CHtml::encode($data->sat); ?>
	<br />
</td><td>

	<?php echo CHtml::encode($data->sun); ?>
	<br />
</td>

</tr>
</div>
