<?php 
$this->beginWidget(
								'bootstrap.widgets.TbModal',
								array('id' => 'myModal')
								); ?>

<p id="err" style="padding:3px; background-color:pink;"></p>
<table>
<tr>
<td>
Start Date:
<?php
$this->widget(
    'bootstrap.widgets.TbDatePicker',
		  array(
			'name' => 'start_date'
			)
		);
?>
</td>
<td>
End Date:
<?php
$this->widget(
    'bootstrap.widgets.TbDatePicker',
		  array(
			'name' => 'end_date',
			)
		);
?>
</td>
</tr>
<tr>
	<td colspan=2>
		Working Days:
		<table>
		<tr>
		<td><input id="wmon" type="Checkbox"> Mon</td>
		<td><input id="wtue" type="Checkbox"> Tue</td>
		<td><input id="wwed" type="Checkbox"> Wed</td>
		<td><input id="wthur" type="Checkbox"> Thur</td>
		<td><input id="wfri" type="Checkbox"> Fri</td>
		<td><input id="wsat" type="Checkbox"> Sat</td>
		<td><input id="wsun" type="Checkbox"> Sun</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan=2>
		Rest Days:
		<table>
		<tr>
		<td><input id="rmon" type="Checkbox"> Mon</td>
		<td><input id="rtue" type="Checkbox"> Tue</td>
		<td><input id="rwed" type="Checkbox"> Wed</td>
		<td><input id="rthur" type="Checkbox"> Thur</td>
		<td><input id="rfri" type="Checkbox"> Fri</td>
		<td><input id="rsat" type="Checkbox"> Sat</td>
		<td><input id="rsun" type="Checkbox"> Sun</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
<td>
Start Time:
<?php
$this->widget(
    'bootstrap.widgets.TbTimePicker',
		 array(
			 'name' => 'start_time',
			 'id' => 'start_time-start_time',
			 )
		);
?>
</td>
<td>
End Time:
<?php
$this->widget(
    'bootstrap.widgets.TbTimePicker',
		 array(
			 'name' => 'end_time',
			 'id' => 'end_time-end_time',
			 )
		);
?>
</td>
</tr>
</table>

<div class="modal-footer">
<?php $this->widget(
								'bootstrap.widgets.TbButton',
								array(
												'type' => 'primary',
												'label' => 'Save changes',
												'url' => '#',
												'htmlOptions' => array('data-dismiss' => 'modal','class'=>'saveBtn'),
										 )
								); ?>
<?php $this->widget(
								'bootstrap.widgets.TbButton',
								array(
												'label' => 'Close',
												'url' => '#',
												'htmlOptions' => array('data-dismiss' => 'modal','id'=>'closeBtn'),
										 )
								); ?>
</div>

<?php $this->endWidget(); ?>

