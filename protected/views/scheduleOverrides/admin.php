<?php
/* @var $this ScheduleOverridesController */
/* @var $model ScheduleOverrides */

$this->breadcrumbs=array(
	'Schedule Overrides'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ScheduleOverrides', 'url'=>array('index')),
	array('label'=>'Create ScheduleOverrides', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#schedule-overrides-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Schedule Overrides</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'schedule-overrides-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'start_time',
		'end_time',
		'emp_id',
		'start_date',
		'end_date',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
