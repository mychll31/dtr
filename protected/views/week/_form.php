<?php
/* @var $this WeekController */
/* @var $model Week */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'week-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php #echo $form->labelEx($model,'week_no'); ?>
		<?php #echo $form->textField($model,'week_no'); ?>
		<?php #echo $form->error($model,'week_no'); ?>
	</div>

	<div class="row">
		<?php #echo $form->labelEx($model,'start_date'); ?>
		<?php #echo $form->textField($model,'start_date'); ?>
		<?php #echo $form->error($model,'start_date'); ?>
        <?php echo $form->datepickerRow($model,'year',array(
          'name'=>'y',
          'value'=>date("Y"),     
          'options' => array(              
            'language' => 'en',
            'format'=>'yyyy',
            'startView'=>'decade',
            'minViewMode'=>2,
            'autoclose'=>true,
          ),
          'prepend' => '<i class="icon-calendar"></i>'
        )); ?>

	</div>

	<div class="row">
		<?php #echo $form->labelEx($model,'end_date'); ?>
		<?php #echo $form->textField($model,'end_date'); ?>
		<?php #echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row buttons">
		<?php #echo CHtml::submitButton($model->isNewRecord ? 'Generate Weeks' : 'Save'); ?>
  <?php $this->widget('bootstrap.widgets.TbButton', array(
      'buttonType'=>'submit',
      'type'=>'primary',
      'label'=>$model->isNewRecord ? 'Generate Weeks' : 'Save',
    )); ?>

	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
