<?php $form = $this->beginWidget(
								'bootstrap.widgets.TbActiveForm',
								array( 
												'id'=>'form', 
												'enableAjaxValidation'=>false, 
												'method'=>'post', 
												'type'=>'inline', 
												'htmlOptions'=>array( 
																'enctype'=>'multipart/form-data' 
																) 
										 )); 
?> 

<input type="file" name="file" id="file" />
<br>
<input type="submit" name="submit" class="btn btn-primary"/>

<?php $this->endWidget(); ?>

