<?php
/* @var $this EmployeeScheduleController */
/* @var $model EmployeeSchedule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'employee-schedule-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


<h3 style="text-transform:uppercase;"> <?php foreach ($employees as $e){ echo $e['lastname'],', '.$e['firstname'].' ',$e['middle_initial'].'.'; } ?></h3>
	<?php echo $alert;?>

	<?php
	$overr = array();
	if($overrides != null){
					foreach($overrides as $lt):
									$overr[] = array(
																	'id' => $lt['id'],
																	'employee_id' => $lt['emp_id'],
																	'start_date' => $lt['start_date'],
																	'end_date' => $lt['end_date'],
																	'start_time' => $lt['start_time'],
																	'end_time' => $lt['end_time'],
																	'rd' => $lt['rd'],
																	);
					endforeach;
																																																																																																	}
	?>

<?php
echo $form->datepickerRow($model,'start_date',array(
												'name'=>'startDate',
												'value'=>date("Y-m-d"),                                                                             
												'options' => array(                                                                             
																'language' => 'en',
																 'autoclose'=>true,
																'format'=>'yyyy-mm-dd',                                                                             
																),                                                                                              
												'prepend' => '<i class="icon-calendar"></i>'        ));                                            
																																																							       
echo $form->datepickerRow($model,'end_date',array(
												'name'=>'endDate',
												'value'=>date("Y-m-d"),                                                                             
												'options' => array(                                                                             
																'language' => 'en',                                                                           
																 'autoclose'=>true,
																'format'=>'yyyy-mm-dd',                                                                             
																),                                                                                              
												'prepend' => '<i class="icon-calendar"></i>'        ));                                            
																																																							       
?>

<br><br>
		<?php echo CHtml::submitButton('Get Schedule',array('class' => 'btn btn-primary')); ?>
<br>
	<?php
	$varday = null;
	if($emps_lists != null){ 	#starttable
		$lists = array();
		foreach($emps_lists as $e){
			$lists[] = array(
				'id' => $e['id'],
				'lname' => $e['lastname'],
				'fname' => $e['firstname'],
				'start_date' => $e['start_date'],
				'end_date' => $e['end_date'],
				'mon' => ($e['mon'] == null ? $varday='RD' : $varday=$e['mon']), 
				'tue' => ($e['tue'] == null ? $varday='RD' : $varday=$e['tue']), 
				'wed' => ($e['wed'] == null ? $varday='RD' : $varday=$e['wed']), 
				'thur' => ($e['thur'] == null ? $varday='RD' : $varday=$e['thur']), 
				'fri' => ($e['fri'] == null ? $varday='RD' : $varday=$e['fri']), 
				'sat' => ($e['sat'] == null ? $varday='RD' : $varday=$e['sat']), 
				'sun' => ($e['sun'] == null ? $varday='RD' : $varday=$e['sun']), 
				);
		}
	$ottime = array();
	if($checkot != null){
		foreach($checkot as $ott):
			$ottime[] = array(
				'id' => $ott['id'],
				'employee_id' => $ott['employee_id'],
				'start_time' => $ott['start_time'],
				'end_time' => $ott['end_time'],
				'date' => $ott['date'],
				'status' => $ott['status'],
			);
		endforeach;
	}

	$leavetime = array();
	if($leave != null){
		foreach($leave as $lt):
			$leavetime[] = array(
				'id' => $lt['id'],
				'employee_id' => $lt['employee_id'],
				'start_date' => $lt['start_date'],
				'end_date' => $lt['end_date'],
				'name' => $lt['name'],
			);
		endforeach;
	}
	?>

<br>
<table class="table table-bordered">
<?php
$checkdate = null;
$late = null;
$hourw = null;
$ut = null;
$check = '';
$currDate ='';
$currD ='';
$empname ='';
$io = null;
$totalLates = null;
$totalHourw = null;
$totalUnder = null;
$ot = null;
$totalOT = null;
$yesot = null;
$yesio = null;
$yesleave = null;
$leave = null;
$daysleave = null;
$daysabsent = null;
$overrRD = null;
$hd = null;
$yeshd = null;
$totalhd = 0;


	if($startDate != '' || $endDate != ''){
		$chkin = $startDate;
		$chkout = $endDate;
			while(strtotime($chkin) <= strtotime($chkout)){
				$currDate .= "<td>".date('M-d',strtotime($chkin))."<br>".date('D',strtotime($chkin))."</td>";
				$chkin = date('Y-M-d', strtotime('+1 day', strtotime($chkin)));
			}
	echo "<tr><td>Name</td>".$currDate."
				<td>Total</td>
				<td>Lates</td>
				<td>Hourw</td>
				<td>UnderTime</td>
				<td>OT</td>
				<td>Leave</td>
				<td>A</td>
				<td>HD</td>
				</tr>";
	}

	foreach($employees as $emp):

	if($startDate != '' || $endDate != ''){
		$chkins = $startDate;
		$chkouts = $endDate;
			$checksched ='';
		while(strtotime($chkins) <= strtotime($chkouts)){

			foreach($lists as $key => $value):
				if($value['id'] == $emp['id']){
						if(strtotime($value['start_date']) <= strtotime($chkins) && strtotime($value['end_date']) >= strtotime($chkins)){
							$day = date('D',strtotime($chkins));	
							if($day == 'Mon'){
								$checksched .= $value['mon'];	
							}else if($day == "Tue"){
								$checksched .= $value['tue'];	
							}else if($day == "Wed"){
								$checksched .= $value['wed'];	
							}else if($day == "Thu"){
								$checksched .= $value['thur'];	
							}else if($day == "Fri"){
								$checksched .= $value['fri'];	
							}else if($day == "Sat"){
								$checksched .= $value['sat'];	
							}else if($day == "Sun"){
								$checksched .= $value['sun'];	
							}else{
								$checksched .= '';
							}
						}else{
						}
					}
			endforeach; //foreach lists

			foreach($checkinout as $inouts):
				if(strtotime($chkins) == strtotime($inouts['date'])){
					$checkdate = date('H:i',strtotime($inouts['checkin'])).' - '.date('H:i',strtotime($inouts['checkout']));
					$yesio = $checkdate;
				}
			endforeach;//foreach inout
##OVERR
			if($overr != null){
				foreach($overr as $o){
						if($chkins >= $o['start_date'] && $chkins <= $o['end_date']){
							$checksched = date('H:i',strtotime($o['start_time']))." - ".date('H:i',strtotime($o['end_time']));
							$overrRD = $o['rd'];
						}
				}
			}

#####
			$cur = $checksched;
			if($checksched == null){
				$cur = "no schedule";
			}else{
				$cur = $checksched;
			}

			if($overrRD != null){
				$cur = 'RD';
			}
			$overrRD = null;

			$absent = null;
			$cur = substr($cur, 0, 13);
			if (strpos($cur,'RD') !== false) {
			    $cur = 'RD';
					$checksched = 'RD';
					}
			$currD .= "<td>".$cur."</td>"; //schedule
			if($yesio != null){
				$io .= "<td>".$yesio."</td>"; //checkin
			}else{
				
				#CHECK IF ABSENT
				if($checksched != 'RD'){
					$absent = "Absent";
					$daysabsent ++;
				}else{
					$absent = "";
				}

				#CHECK IF LEAVE
				if($leavetime != null){
					foreach($leavetime as $lv):
						if($chkins >= $lv['start_date'] && $chkins <= $lv['end_date']){
							$yesleave .= $lv['name'];
							$daysleave ++;
							$absent = "";
						}else{
							$yesleave .= "";
						}
					endforeach;
			}
				$io .= "<td> $absent"."$yesleave </td>";
				$yesleave = null;
				
			}
			#CHECK IF LATE
			$checkifLate = (strtotime(substr($yesio, 0, 5)) - strtotime(substr($checksched, 0, 5))) / 60;
			if($yesio != null && $checksched != null && $checksched != 'RD'){
				if($checkifLate > 0){
					$yeshd = $checkifLate;
					if($checkifLate > 60){
						$checkifLate = '';
					}else{
						$totalLates = $totalLates + $checkifLate;
					}
						$late .= "<td>".$checkifLate."</td>";
				}else{
					$late .= "<td></td>";
				}
			}else{
				$late .= "<td></td>";
			}

			#halfday
			if($yeshd != null && $yeshd > 60){
				$hd .= "<td>Halfday</td>";
				$totalhd = $totalhd + 1;
			}else{
				$hd .= "<td></td>";
			}
		$yeshd = null;

			#CHECK IF UNDERTIME
			$checkifUnder = (strtotime(substr($checksched, 8)) - strtotime(substr($yesio, 8))) / 60;
			if($checksched != null && $yesio != null && $checksched != 'RD'){
				if($checkifUnder > 0){
					$ut .= "<td>".$checkifUnder."</td>";
					$totalUnder = $totalUnder + $checkifUnder;
				}else{
					$ut .= "<td></td>";
				}
			}else{
				$ut .= "<td></td>";
			}

			#CHECK IF OT
			$checkifOT = (strtotime(substr($yesio, 8)) - strtotime(substr($checksched, 8))) / 60;

			if($checksched != null && $yesio != null && $checksched != 'RD'){
				if($checkifOT > 0){

			foreach($ottime as $oTt):
				if($oTt['date'] == $chkins){
					$yesot = $checkifOT;
				}
			endforeach;
					$ot .= "<td>$yesot</td>";
					if($yesot != null){
						$totalOT = $totalOT + $checkifOT."<br>";
					}
					$yesot = null;

				}else{
					$ot .= "<td></td>";
				}
			}else{
				$ot .= "<td></td>";
			}

			#CHECK TOTAL HOURS WORK
			$y1=substr($yesio, 0, 5);
			$y2=substr($yesio, 7, 6);
			$c1=substr($checksched, 0, 5);
			$c2=substr($checksched, 7, 6);

			if($checkifLate >= 1){
				//late
					$checkifHourw = ((strtotime($c2) - strtotime($c1)) / 60)-60-$checkifLate;

			}else{
				//notlate
				if($checkifUnder >= 1){
					//undertime
					$checkifHourw = ((strtotime($c2) - strtotime($c1)) / 60)-60-$checkifUnder;

				}else{
					//notunder
					$checkifHourw = ((strtotime($c2) - strtotime($c1)) / 60)-60;
				}
			}

			if($checksched != null && $yesio != null && $checksched != 'RD'){
				if($checkifHourw > 0){
					$hourw .= "<td>$checkifHourw</td>";
					$totalHourw = $totalHourw + $checkifHourw;
				}else{
					$hourw .= "<td></td>";
				}
			}else{
				$hourw .= "<td></td>";
			}
##
			$yesio = null;
			$chkins = date('Y-m-d', strtotime('+1 day', strtotime($chkins)));
			$checksched ='';
		}
	}
		echo $empname = "<tr class='".$emp['department_id']."'>
											<td>".CHtml::link($emp['firstname'].", ".$emp['lastname'],array('employeeSchedule/empSched','id'=>$emp['id']))."</td>"
											.$currD.
											"<td></td>
											<td>$totalLates</td>
											<td>$totalHourw</td>
											<td>$totalUnder</td>
											<td>$totalOT</td>
											<td>$daysleave</td>
											<td>".($daysabsent-$daysleave)."</td>
											<td>$totalhd</td>
										</tr>";
		echo "<tr><td>Checkin - Checkout</td>".$io."<td></td></tr>";
		echo "<tr><td>Late in Minutes</td>".$late."<td>$totalLates</td></tr>";
		echo "<tr><td>Hourw in Minutes</td>".$hourw."<td>$totalHourw</td></tr>";
		echo "<tr><td>Undertime in Minutes</td>".$ut."<td>$totalUnder</td></tr>";
		echo "<tr><td>OT in Minutes</td>".$ot."<td>$totalOT</td></tr>";
		echo "<tr><td>HD</td>".$hd."<td>$totalhd</td></tr>";
		$daysabsent = 0;
		$currD = null;
		$io = null;
		$checkifLate = null;
		$checkifHourw = null;
		$checkifUnder = null;
		$late = null;
		$hourw = null;
		$ut = null;
		$totalUnder = null;
		$totalLates = null;
		$totalHourw = null;
		$totalOT = null;
		$checkifOT = null;
		$cur = null;
		$overrRD = null;
		$hd = null;
		$totalhd = null;
		$yeshd = null;

	endforeach; //foreach employees
	} #endtable
	else{
		echo "No schedule yet.";
	}
?>
</table>



	<div class="row">
		<?php echo $form->labelEx($model,''); ?>
		<?php echo $form->hiddenField($model,'emp_id'); ?>
		<?php echo $form->error($model,'emp_id'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

