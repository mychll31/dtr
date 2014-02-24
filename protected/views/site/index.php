<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<h1>DTR</h1>
<h3 style="font-weight:normal">(Daily Time Record)</h3>
<?php
	$datenow = date("F j, Y");
	$today = date('Y-m-d', strtotime('-2 day', strtotime($datenow)));
	#$today = '2013-11-11';
	echo "As of: ".date('M. d, Y',strtotime($today));
	$checkio = Checkinout::model()->findAll(array('condition'=>'date="'.$today.'"'));
	$schedule = EmployeeSchedule::model()->findAll(array('condition'=>'start_date >="'.$today.'"'));
	$employees = Employee::model()->findAll();
	$schedList = Schedule::model()->findAll();

	$empid = null;
	$empname = null;
	$empin = null;
	$empout = null;
	$empsched = null;
	$emp_schedule = null;
	$late = 0;
	$lates = null;
	foreach($employees as $emp){
		$empname = $emp['lastname'].", ".$emp['firstname']." ".$emp['middle_initial'].".";
		foreach($checkio as $io){
			if($io['user_id'] == $emp['id']){
				$empin = date('H:i',strtotime($io['checkin']));
				$empout = date('H:i',strtotime($io['checkout']));
			}
		}
		foreach($schedule as $sched){
			if($sched['emp_id'] == $emp['id']){
				$empsched = $sched['sched_id'];
			}
		}
		foreach($schedList as $sl){
			if($sl['id'] == $empsched){
				if(date('D',strtotime($today)) == 'Mon'){
					$emp_schedule = $sl['mon'];
				}else if(date('D',strtotime($today)) == 'Tue'){
					$emp_schedule = $sl['tue'];
				}else if(date('D',strtotime($today)) == 'Wed'){
					$emp_schedule = $sl['wed'];
				}else if(date('D',strtotime($today)) == 'Thu'){
					$emp_schedule = $sl['thur'];
				}else if(date('D',strtotime($today)) == 'Fri'){
					$emp_schedule = $sl['fri'];
				}else if(date('D',strtotime($today)) == 'Sat'){
					$emp_schedule = $sl['sat'];
				}else if(date('D',strtotime($today)) == 'Sun'){
					$emp_schedule = $sl['sun'];
				}
			}
		}
		
		$sched_in = (substr($emp_schedule, 0, 5));
		$sched_out = (substr($emp_schedule, 8));
		
		if($sched_in != null){
			if(strtotime($sched_in) < strtotime($empin)){
				$late = (strtotime($empin) - strtotime($sched_in))/60;
			}
		
			if($late != 0){
				/*echo "".$empid ." ".
				$empname ." ".
				$empin ." ".
				$empout ." ".
				$emp_schedule."- ";
				echo $sched_in;
				echo "=>";
				echo $late;*/
				$lates .= "<tr><td>".$empname."</td><td>".$late."</td></tr>";
			}
		}
		$late = 0;
	}
	echo "<table><tr><td style='border:1px solid black;'>";
	echo "<table><tr><td>Name</td><td>Lates</td></tr>".$lates;
	echo "</table></td>";
	echo "</tr></table>";
	
?>
