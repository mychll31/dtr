<?php
if($alert != null){
	echo $alert;
}
?>
<h3>Upload Schedule</h3>
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

<br>
<br>
CSV FORMAT:
<br>
<table border=1>
<tr><td></td>	<td>Date</td>	<td>Date</td>	<td>Date</td>	<td>Date</td>	<td>Date</td></tr>
<tr><td>Emp ID</td>	<td>06:00 – 15:00</td>	<td>06:00 – 15:00</td>	<td>06:00 – 15:00</td>	<td>06:00 – 15:00</td>	<td>06:00 – 15:00</td></tr>
<tr><td>Emp ID</td>	<td>09:00 – 18:00</td>	<td>09:00 – 18:00</td>	<td>09:00 – 18:00</td>	<td>09:00 – 18:00</td>	<td>09:00 – 18:00</td></tr>
</table>

