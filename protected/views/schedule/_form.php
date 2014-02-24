<?php
/* @var $this ScheduleController */
/* @var $model Schedule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'schedule-form',
	'enableAjaxValidation'=>false,
)); ?>

<table>
  <tr>
    <td>
      <input type="radio" id="sched" name="sched" value="fixed" onclick="rad1();" checked>Fixed
      <input type="radio" id="sched" name="sched" value="custom" onclick="rad2();">Custom
    <td>
  </tr>
</table>


<table id="fixed">
  <tr>
    <td>
      <?php echo "From"; ?><br>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'checkinFrom',
          'value' => '',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
      <br>
      <?php echo "To"; ?><br>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'checkinTo',
          'value' => null,
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo "Days:"; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'mo')) . ' Monday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'tu')) . ' Tuesday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'we')) . ' Wednesday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'th')) . ' Thursday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'fr')) . ' Friday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'sa')) . ' Saturday'; ?><br>
      <?php echo $form->checkBox($model,'mon',array('name'=>'su')) . ' Sunday'; ?><br>
    </td>
  </tr>

  <tr>
    <td>

    </td>
  </tr>
</table>

<table id="custom">
  <tr>
    <td>
      <?php echo $form->labelEx($model,'mon'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'monFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'monTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'tue'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'tueFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'tueTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'wed'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'wedFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'wedTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'thur'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'thurFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'thurTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'fri'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'friFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'friTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'sat'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'satFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'satTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>

  <tr>
    <td>
      <?php echo $form->labelEx($model,'sun'); ?>
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'sunFrom',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?> -
      <?php $this->widget(
      'bootstrap.widgets.TbTimePicker',
        array(
          'name' => 'sunTo',
          'value' => 'null',
          'options' => array(
            'showMeridian'=>false
          )
        )
      ); ?>
    </td>
  </tr>
</table>

<table>
  <tr>
    <td>
      <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Create Schedule' : 'Save',
      )); ?>
    </td>
  </tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$('#custom').hide();
    function rad1(){
        $('#custom').hide();
        $('#fixed').show();
    }  
    function rad2(){
        $('#custom').show();
        $('#fixed').hide();
    }  

</script>

