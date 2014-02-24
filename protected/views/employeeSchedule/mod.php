<?php 
$this->beginWidget(
								'bootstrap.widgets.TbModal',
								array('id' => 'myMod')
								); ?>
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

