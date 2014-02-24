<?php
/* @var $this CheckinoutController */
/* @var $data Checkinout */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checkin')); ?>:</b>
	<?php echo CHtml::encode($data->checkin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checkout')); ?>:</b>
	<?php echo CHtml::encode($data->checkout); ?>
	<br />


</div>