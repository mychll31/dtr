
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
<br>
<?php
$script = array();
foreach($department as $dep){
				$script[] = $dep;
}

$ctr = 0;
$varname ="";
foreach($script as $dept):
				$ctr++;
				$varname = "varname".$ctr;
				$varCheckname = "varname".$ctr."check";
				echo "<input type='checkbox' id='$varCheckname' onclick='$varname()' checked>";
				echo " ".$dept['name']."<br>";
				endforeach;
				?>

<br>
		<?php echo CHtml::submitButton('Get Schedule',array('class' => 'btn btn-primary')); ?>
<br>
	<?php
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
$vartotal = null;
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
$totalAllLates = null;
$totalAllHourw = null;
$totalAllUnder = null;
$totalAllOver = null;
$totalAllLeave = null;
$daysabsent = null;
$totalAllAbsent = null;

$totalIss = null;
$totalCore = null;
$totalSystems = null;
$totalAdmin = null;
$totalHead = null;
$totalHr = null;
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
	echo "<tr><td>Name</td>".$currDate."<td style='border-top:1px solid white;'></td>
		<td>Lates</td>
		<td>UT</td>
		<td>OT</td>
		<td>Leave</td>
		<td>Absent</td>
		<td>HalfDay</td>
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
				if($inouts['user_id'] == $emp['id']){
					if(strtotime($chkins) == strtotime($inouts['date'])){
						$checkdate = date('H:i',strtotime($inouts['checkin'])).' - '.date('H:i',strtotime($inouts['checkout']));
						$yesio = $checkdate;
					}
				}
			endforeach;//foreach inout

				#CHECKIFOVERRIDE
				if($overr != null){
					foreach($overr as $o){
						if($o['employee_id'] == $emp['id']){
							if($chkins >= $o['start_date'] && $chkins <= $o['end_date']){
								$checksched = date('H:i',strtotime($o['start_time']))." - ".date('H:i',strtotime($o['end_time']));
								$overrRD = $o['rd'];
								}
							}
						}
				}

			$cur = $checksched;

			if (strpos($cur,'RD') !== false) {
							$cur = 'RD';
							$checksched = 'RD';
			}


			if($checksched == null){
				$cur = "no schedule";
				$yesio = '';
			}else{
				$cur = $checksched;
			}
      if($overrRD != null){
				$cur = 'RD';
			}

			$overrRD = null;
			$absent = null;
			if($yesio == null){
				if($cur != "no schedule" && $cur!= 'RD'){
					$absent = "Absent";
					$daysabsent ++;
				}
				else{
					$absent = "";
				}
				

				#CHECK IF LEAVE
				if($leavetime != null){
							foreach($leavetime as $lv):
								if($lv['employee_id'] == $emp['id']){
											if($chkins >= $lv['start_date'] && $chkins <= $lv['end_date']){
															$yesleave .= $lv['name'];
															$absent = "";
															$daysleave ++;
											}else{
															$yesleave .= "";
											}
								}
								$yesio = $absent.$yesleave;
							endforeach;
							$leave .= "<td> $yesleave </td>";
				}
			}

			$cur = substr($cur, 13);
			##COLOR
			if($cur == 'RD'){
				$bgcolor = '#BBBBBB';
			}else if(strpos($cur,'06:00 -') !== false){
				$bgcolor = 'rgb(88, 206, 252)';
			}else if(strpos($cur,'07:00 -') !== false){
				$bgcolor = 'rgb(70, 160, 70)';
			}else if(strpos($cur,'08:00 -') !== false){
				$bgcolor = 'rgb(5, 168, 5)';
			}else if(strpos($cur,'09:00 -') !== false){
				$bgcolor = 'rgb(172, 250, 172)';
			}else if(strpos($cur,'10:00 -') !== false){
				$bgcolor = 'rgb(0, 170, 0)';
			}else if(strpos($cur,'21:00 -') !== false){
				$bgcolor = 'rgb(255, 145, 102)';
			}else if(strpos($cur,'12:30 -') !== false){
				$bgcolor = 'rgb(218, 142, 142)';
			}else{
				$bgcolor = '';
			}

			$currD .= "<td>".$cur."</td>"; //schedule

			$io .= "<td style='background-color:".$bgcolor."'>".$yesio."</td>"; //checkin

			#CHECK IF LATE
			$checkifLate = (strtotime(substr($yesio, 0, 5)) - strtotime(substr($checksched, 0, 5))) / 60;
			if($checksched != null && $yesio != null){
				if($checkifLate > 0 && $checksched != 'RD'){
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
			if($checksched != null && $yesio != null && $checksched != 'RD' && $absent == null && $yesleave == null){
				if($checkifUnder > 0){
					$ut .= "<td>".$checkifUnder."</td>";
					$totalUnder = $totalUnder + $checkifUnder;
				}else{
					$ut .= "<td></td>";
				}
			}else{
				$ut .= "<td></td>";
			}

			$yesleave = null;

			#CHECK IF OT
			$checkifOT = (strtotime(substr($yesio, 8)) - strtotime(substr($checksched, 8))) / 60;

			if($checksched != null && $yesio != null && $checksched != 'RD'){
				if($checkifOT > 0){
					foreach($ottime as $oTt):
						if($oTt['employee_id'] == $emp['id']){
							if($oTt['date'] == $chkins){
								$yesot = $checkifOT;
							}
						}
					endforeach;
					$ot .= "<td>$yesot</td>";
				
					if($yesot != null){
							$totalOT = $totalOT + $checkifOT;
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

			if($checksched != null && $yesio != null && $checksched != 'RD' && $absent == null){
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
		$total_al = null;
		if($daysabsent == 0 || $daysabsent == null){
			$total_al = $daysabsent;
		}else{
			$total_al = $daysabsent-$daysleave;
		}


#echo "<tr><td>sched</td>".$currD."<td></td></tr>";
		echo $empname = "<tr class='".$emp['department_id']."'><td>".CHtml::link($emp['lastname'].", ".$emp['firstname']." ".$emp['middle_initial'].".",array('employeeSchedule/empSched','id'=>$emp['id']))."</td>".
		$io."<td style='border-top:1px solid white;'></td>
		<td>";
		if($totalLates == 0) { echo ''; }else{ echo number_format($totalLates);}
		echo "</td>
		<td>";
		if($totalUnder == 0) {echo '';}else{echo number_format($totalUnder);}
		echo "</td>
		<td>";
		if($totalOT == 0) {echo '';}else{ echo number_format($totalOT);}
		echo "</td>
		<td>";
		if($daysleave == 0){echo '';}else{ echo number_format($daysleave);}
		echo "</td>
		<td>";
		if($total_al == 0){echo '';}else{ echo number_format($total_al);}
		echo "</td>
		<td>";
		if($totalhd == 0){echo '';}else{echo number_format($totalhd);}
#		echo "<td>". number_format($totalHourw)."</td>";
		echo "</td>
		</tr>";
#		    echo "<tr><td>Late in Minutes</td>".$late."<td>$totalLates</td></tr>";
#		    echo "<tr><td>Hourw in Minutes</td>".$hourw."<td>$totalHourw</td></tr>";
#		    echo "<tr><td>Undertime in Minutes</td>".$ut."<td>$totalUnder</td></tr>";
#		    echo "<tr><td>OT in Minutes</td>".$ot."<td>$totalOT</td></tr>";


		$vartotal[$emp['department_id']][] = $totalHourw;

		$totalAllOver = $totalAllOver + $totalOT;
		$totalAllLates = $totalAllLates + $totalLates;
		$totalAllHourw = $totalAllHourw + $totalHourw;
		$totalAllUnder = $totalAllUnder + $totalUnder;
		$totalAllLeave = $totalAllLeave + $daysleave;
		$totalAllAbsent = $totalAllAbsent + $total_al;
		$dept1L = 0;
		$dept1O = 0;
		$dept1U = 0;
		$dept1LE = 0;
		$dept1A = 0;
#FIX FOR NOW
		if($emp['id'] == 1){
		echo $emp['firstname'];
			$dept1L = $deptL + $totalLates;
			$dept1O = $deptO + $totalOT;
			$dept1U = $deptU + $totalUnder;
			$dept1LE = $deptLE + $daysleave;
			$dept1A = $deptA + $total_al;
		}

		$currD = null;
		$cur = null;
		$io = null;
		$late = null;
		$hourw = null;
		$ut = null;
		$totalLates = null;
		$totalHourw = null;
		$totalUnder = null;
		$checksched = null;
		$checkdate = null;
		$totalhd = null;
		$ot = null;
		$totalOT = null;
		$yesot = null;
		$yesio = null;
		$leave = null;
		$daysleave = null;
		$daysabsent = null;
		$yesleave = null;

	endforeach; //foreach employees

	$dd=Department::model()->findAll();
?>
</table>
<br>
Hours Work
<table border=1>
	<tr>
	<?php 
		foreach($dd as $d):
			echo "<td>".$d['name']."</td>";
		endforeach;
	?>
	</tr>
	<tr>
	<?php 
	$addvartotal = 0;
		foreach($dd as $d):
			foreach($vartotal as $key=>$value){
				if($d['id'] == $key){
					foreach($value as $val){
						$addvartotal = $addvartotal + $val;
					}
				}
			}
			echo "<td>".number_format($addvartotal)."</td>";
			$addvartotal = 0;
		endforeach;
	?>
	</tr>
</table>
<br>
TOTAL
<table border=1>
	<tr>
		<td>Lates in Minutes</td>
		<td>Hours work in Minutes</td>
		<td>Undertime in Minutes</td>
		<td>Overtime in Minutes</td>
		<td>Leave in Days</td>
		<td>Absent in Days</td>
	</tr>
	<tr>
		<td><?php echo number_format($totalAllLates);?></td>
		<td><?php echo number_format($totalAllHourw);?></td>
		<td><?php echo number_format($totalAllUnder);?></td>
		<td><?php echo number_format($totalAllOver);?></td>
		<td><?php echo number_format($totalAllLeave);?></td>
		<td><?php echo number_format($totalAllAbsent);?></td>
	</tr>
</table>
<?php
	} #endtable
	else{
		echo "No schedule yet.";
	}
?>
<br>

	<div class="row">
		<?php echo $form->labelEx($model,''); ?>
		<?php echo $form->hiddenField($model,'emp_id'); ?>
		<?php echo $form->error($model,'emp_id'); ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$varname = '';
$ctr ='';
foreach($script as $deptF){
				$ctr ++;
				$varname = "varname".$ctr;
				?>
								<script>
								$('.<?php echo $deptF['id']?>').show();
				</script>
								<?php
}
?>
<?php
$varname = '';
$ctr ='';
foreach($script as $deptF){
				$ctr ++;
				$varname = "varname".$ctr;
				$varCheckname = "varname".$ctr."check";
				?>
								<script>
								function <?php echo $varname.'()'?>{
												if(document.getElementById('<?php echo $varCheckname?>').checked){
																$('.<?php echo $deptF["id"]?>').show();
												}else{
																$('.<?php echo $deptF["id"]?>').hide();
												}
								}
				</script>
				<?php
				  }
					?>
