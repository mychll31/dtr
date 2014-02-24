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
<tr>
<td>
Start Time:
<?php
$this->widget(
    'bootstrap.widgets.TbTimePicker',
		 array(
			 'name' => 'start_time',
			 	'attribute' => 'hours',
				'options'=> array(
					'showMeridian' => false
				)
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
			 	'attribute' => 'hours',
				'options'=> array(
					'showMeridian' => false
				)
			 )
		);
?>
</td>
</tr>
<tr><td colspan=2>
RD  <input type="checkbox" id="rd" name="rd" value="RD" />
<br>
</td></tr>
</table>
<br>

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

