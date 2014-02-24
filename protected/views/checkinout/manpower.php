<h2>Manpower</h2>

<?php
$total =1; 

$this->widget('bootstrap.widgets.TbGridView', array(
  'type' => 'striped bordered condensed',
  'dataProvider' => $model->search(),
  'filter'=>$model,
  #'template' => "{items}",
  'columns' => array(
    'user_id',
    'name',
    'date',
    'checkin',
    'checkout',
    array(
      'name'=>'late', 
      'value'=>array($this, 'dataColumn'), 
    ),
    #array(
      #'class'=>'CButtonColumn',
    #),
  ),
));
?>
