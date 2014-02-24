<?php

class EmployeeScheduleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','viewsched','empsched','manpower','upload','addfield','mod','uploadsched','report'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','viewsched','testview'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate(){

		$model=new EmployeeSchedule;
		$checkifExist = EmployeeSchedule::model()->findAll();
		
		$emp_s = array();
		foreach($checkifExist as $w){
			$emp_s[] = array(
				'emp_id' => $w['emp_id'],
				'start_date' => $w['start_date'],
				'end_date' => $w['end_date'],
				);
		}
		
		$alertwS = null;
		$alertwoS = null;
		$empschedId = null;
		$employee = Employee::model()->findAll(array("condition"=>"status_id = 1"));
    $emp = array();
		    foreach($employee as $emps){
					array_push($emp, $emps['id'].". ".$emps['lastname']." ".$emps['firstname']);
				}
		
		$confsched = null;
		$alert = '';
		$alertTo = null;
		$dayswithsched = null;
		$dayswithoutsched = null;

		if(isset($_POST['EmployeeSchedule']))
		{

		$employeeselect = $_POST['emp_sel'];
		$scheduleselect = $_POST['sched_sel'];
		$startD = $_POST['startDate'];
		$endD = $_POST['endDate'];
		
		if($employeeselect == null){$alertTo .= '* Employee/s Must not be Empty<br>';}
		if($scheduleselect == null){$alertTo .= '* Schedule Must not be Empty<br>';}
		if($startD == null){$alertTo .= '* Start Date Must not be Empty<br>';}
		if($endD == null){$alertTo .= '* End Date Must not be Empty<br>';}

		if($alertTo != null){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$alertTo.'</div>';
		}else{


		$arr_sched = explode('.',$scheduleselect);
		$saveit = 0;
		$array = $employeeselect;
		$notExistName = '';

		$output = array();
		$i = 0;

		$bits = explode(',', $array);
		foreach($bits as $bit):
			if(strpos($bit,'. ') != false){
						$has_num = explode('.', $bit);
						if(count($has_num) > 1) {
										$i = $has_num[0];
										$name = $has_num[1];
						} else {
										$name = $has_num[0];
						}
						$output[$i][] = trim($name);
			} else{
						$saveit++; //checkif exist
						$notExistName .= $bit.",";
			}
		endforeach;

		if($saveit == 0){
			foreach($output as $key => $value):
				$checkOutput = Yii::app()->db->createCommand(/*'
						SELECT es.sched_id, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun
						FROM employee_schedule AS es
						INNER JOIN schedule AS s ON s.id = es.sched_id
						WHERE emp_id=\''.$key.'\' AND (start_date <= \''.$startD.'\' and end_date >= \''.$endD.'\')
						'*/
						'SELECT es.sched_id, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun 
						FROM employee_schedule AS es 
						INNER JOIN schedule AS s ON s.id = es.sched_id 
						WHERE emp_id=\''.$key.'\' AND (start_date <= \''.$startD.'\' and end_date >= \''.$startD.'\' or end_date <= \''.$endD.'\')
						')->queryAll();

						$day = $startD;
						while($day <= $endD){
							foreach($checkOutput as $cA){
								if($cA['start_date'] <= $day && $cA['end_date'] >= $day){
									//days with schedule
									$dayswithsched .= $day."<br>";
								}else{
									//days without schedule
									$dayswithoutsched .= $day."<br>";
								}
							}
								$day = date('Y-m-d', strtotime('+1 day', strtotime($day)));
						}
								if($dayswithsched == null){
									//the employee schedule has been save	
									$model = new EmployeeSchedule;
									$model->emp_id = $key;
									$model->sched_id = $arr_sched[0];
									$model->start_date = $startD;
									$model->end_date = $endD;
									$model->save();

									$emp_key = Employee::model()->findByPk($key);
									$alertwS .= $emp_key['lastname'].', '.$emp_key['firstname'].' has been saved <br>';
								}else{
									//cant be save
									$emp_key = Employee::model()->findByPk($key);
									$alertwoS .= $emp_key['id']."-".$emp_key['lastname'].', '.$emp_key['firstname'].'  can\'t be saved <br> Conflict Schedule:<br>'.$dayswithsched;
								}
								$confsched .= $dayswithsched;
								$dayswithsched = null;
								$dayswithoutsched = null;

			endforeach;
			if($alertwS != null){
				$alert .= "<div class='alert-success' style='padding:10px'>SUCCESS!<br />$alertwS</div>";}
			if($alertwoS != null){
				$alert .= "<div class='alert-error' style='padding:10px;'>ERROR<br />$alertwoS</div>";}
			}else{
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$notExistName.' does not Exist. Please try again.</div>';
			}
		}
}
				$this->render('create',array(
				'employee'=>$employee,
				'model'=>$model,
				'alert'=>$alert,
				'emp'=>$emp,
				));
	}

	public function actionviewsched($startDate,$endDate)
	{
		$model=new EmployeeSchedule;
		$alert = '';
		$alertTo = null;
		$leave = null;

		$overrides = ScheduleOverrides::model()->findAll();

		$employees = Yii::app()->db->createCommand('
			SELECT e.id, e.firstname, e.lastname, e.middle_initial, e.position_id, e.department_id, dept.name, e.status_id
			FROM employee AS e
			LEFT JOIN department AS dept ON e.department_id = dept.id
			WHERE e.status_id = 1
			'
			)->queryAll();

		$department = Department::model()->findAll();	//Department
		
		$checkinout = null;
		$emps_lists = null;
		if(isset($_POST['EmployeeSchedule']))
		{
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
		}else{
			$startDate = $_GET['startDate'];
			$endDate = $_GET['endDate'];
		}

		if($startDate !=null && $endDate != null){
			if($startDate == null){ $alertTo .= '*Start Date must not be empty.<br />';}
			if($endDate == null){ $alertTo .= '*End Date must not be empty.<br />';}

			if($alertTo != null){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$alertTo.'</div>';
			}else{

			if(strtotime($startDate) > strtotime($endDate)){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />Invalid Date</div>';
			}else{
					$leave = Yii::app()->dbol->createCommand("
					SELECT l.id, l.employee_id, lt.name, l.leave_type_id, l.reason, l.start_date, l.end_date, l.date_filed, l.sv1, l.sv2, l.om, l.hrm, l.remarks, l.create_date, l.days_with_pay, l.days_without_pay, l.others, l.status
					FROM `leave` as l
					LEFT JOIN  leave_type AS lt  ON lt.id = l.leave_type_id
					WHERE start_date <= '$startDate' or start_date <= '$endDate'
					")->queryAll();
						$checkinout = Yii::app()->db->createCommand('
							SELECT * FROM `checkinout` where (date >= "'.$startDate.'" && date <= "'.$endDate.'")'
							)->queryAll();  //Checkin.out

						$emps_lists=Yii::app()->db->createCommand('
														SELECT e.id, e.status_id, e.firstname, e.lastname, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun, es.status, es.conflict, es.sched_id, es.id as "es_id"
														FROM employee AS e 
														LEFT JOIN  employee_schedule AS es  ON e.id = es.emp_id
														LEFT JOIN schedule AS s ON es.sched_id = s.id 
														WHERE e.status_id = 1 and (start_date <= \''.$startDate.'\''.' or start_date <= \''.$endDate.'\')'
														)->queryAll();

			}
			}
		}
		$this->render('viewsched',array(
			'model'=>$model,
			'emps_lists'=>$emps_lists,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'employees' => $employees,
			'alert'=>$alert,
			'department'=>$department,
			'checkinout'=>$checkinout,
			'overrides'=>$overrides,
			'leave'=>$leave,
		));
	}

	public function actionempsched($id)
	{
		$model=new EmployeeSchedule;
		$alert = '';
		$alertTo = null;

		$employees = Yii::app()->db->createCommand('
			SELECT e.id, e.firstname, e.lastname, e.middle_initial, e.position_id, e.department_id, dept.name
			FROM employee AS e
			LEFT JOIN department AS dept ON e.department_id = dept.id
			WHERE e.status_id = 1 and e.id = '.$id
			)->queryAll();

		$department = Department::model()->findAll();	//Department

		$checkinout = null;
		$startDate = null;
		$endDate = null;
		$emps_lists = null;
		if(isset($_POST['EmployeeSchedule']))
		{
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			if($startDate == null){ $alertTo .= '*Start Date must not be empty.<br />';}
			if($endDate == null){ $alertTo .= '*End Date must not be empty.<br />';}

			if($alertTo != null){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$alertTo.'</div>';
			}else{

			if(strtotime($startDate) > strtotime($endDate)){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />Invalid Date</div>';
			}else{
						$checkinout = Yii::app()->db->createCommand('
							SELECT * FROM `checkinout` where (date >= "'.$startDate.'" && date <= "'.$endDate.'") && user_id = '.$id
							)->queryAll();  //Checkin.out

						$emps_lists=Yii::app()->db->createCommand('
														SELECT e.id, e.firstname, e.lastname, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun 
														FROM employee AS e 
														LEFT JOIN  employee_schedule AS es  ON e.id = es.emp_id
														LEFT JOIN schedule AS s ON es.sched_id = s.id 
														WHERE e.status_id =1 and e.id ='.$id.' and (start_date <= \''.$startDate.'\''.' or start_date <= \''.$endDate.'\')'
														)->queryAll();

			}
		}
		}else{
			
		}
		//OT
		$checkot = Yii::app()->dbol->createCommand("
					SELECT * FROM `otform` WHERE employee_id = ".$id." and (date <= '$startDate' or date <= '$endDate') and status = 3
					")->queryAll();

		//LEAVE
		$leave = Yii::app()->dbol->createCommand("
					SELECT l.id, l.employee_id, lt.name, l.leave_type_id, l.reason, l.start_date, l.end_date, l.date_filed, l.sv1, l.sv2, l.om, l.hrm, l.remarks, l.create_date, l.days_with_pay, l.days_without_pay, l.others, l.status
					FROM `leave` as l
					LEFT JOIN  leave_type AS lt  ON lt.id = l.leave_type_id
					WHERE employee_id = ".$id." and (start_date <= '$startDate' or start_date <= '$endDate')
					")->queryAll();
		$overrides =  Yii::app()->db->createCommand("SELECT * FROM `schedule_overrides` WHERE emp_id = ".$id." and (start_date <= '$startDate' or start_date <= '$endDate')")->queryAll();

		$this->render('empsched',array(
			'model'=>$model,
			'emps_lists'=>$emps_lists,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'employees' => $employees,
			'alert'=>$alert,
			'department'=>$department,
			'checkinout'=>$checkinout,
			'checkot' => $checkot,
			'leave' => $leave,
			'overrides'=>$overrides,
		));
	}

	public function actionmanpower()
	{
		$model=new EmployeeSchedule;
		$alert = '';
		$alertTo = null;

		$employees = Yii::app()->db->createCommand('
			SELECT e.id, e.firstname, e.lastname, e.middle_initial, e.position_id, e.department_id, dept.name, e.status_id
			FROM employee AS e
			LEFT JOIN department AS dept ON e.department_id = dept.id
			WHERE e.status_id = 1
			'
			)->queryAll();

		$department = Department::model()->findAll();	//Department
		

		$checkinout = null;
		$startDate = null;
		$endDate = null;
		$emps_lists = null;
		if(isset($_POST['EmployeeSchedule']))
		{
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			if($startDate == null){ $alertTo .= '*Start Date must not be empty.<br />';}
			if($endDate == null){ $alertTo .= '*End Date must not be empty.<br />';}

			if($alertTo != null){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$alertTo.'</div>';
			}else{

			if(strtotime($startDate) > strtotime($endDate)){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />Invalid Date</div>';
			}else{
						$checkinout = Yii::app()->db->createCommand('
							SELECT * FROM `checkinout` where (date >= "'.$startDate.'" && date <= "'.$endDate.'")'
							)->queryAll();  //Checkin.out

						$emps_lists=Yii::app()->db->createCommand('
														SELECT e.id, e.firstname, e.lastname, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun, e.status_id
														FROM employee AS e 
														LEFT JOIN  employee_schedule AS es  ON e.id = es.emp_id
														LEFT JOIN schedule AS s ON es.sched_id = s.id 
														WHERE e.status_id =1 (start_date <= \''.$startDate.'\''.' or start_date <= \''.$endDate.'\')'
														)->queryAll();

			}
		}
		}else{
			
		}

		//OT
		$checkot = Yii::app()->dbol->createCommand("
					SELECT * FROM `otform` WHERE (date <= '$startDate' or date <= '$endDate')
					")->queryAll();

		//LEAVE
		$leave = Yii::app()->dbol->createCommand("
					SELECT l.id, l.employee_id, lt.name, l.leave_type_id, l.reason, l.start_date, l.end_date, l.date_filed, l.sv1, l.sv2, l.om, l.hrm, l.remarks, l.create_date, l.days_with_pay, l.days_without_pay, l.others, l.status
					FROM `leave` as l
					LEFT JOIN  leave_type AS lt  ON lt.id = l.leave_type_id
					WHERE (start_date <= '$startDate' or start_date <= '$endDate')
					")->queryAll();

		$this->render('manpower',array(
			'model'=>$model,
			'emps_lists'=>$emps_lists,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'employees' => $employees,
			'alert'=>$alert,
			'department'=>$department,
			'checkinout'=>$checkinout,
			'checkot' => $checkot,
			'leave' => $leave,
		));
	}

	public function actionreport()
	{
		$model=new EmployeeSchedule;
		$alert = '';
		$alertTo = null;

		$overrides = ScheduleOverrides::model()->findAll();
		$employees = Yii::app()->db->createCommand('
			SELECT e.id, e.firstname, e.lastname, e.middle_initial, e.position_id, e.department_id, dept.name, e.status_id
			FROM employee AS e
			LEFT JOIN department AS dept ON e.department_id = dept.id
			WHERE e.status_id = 1
			'	
			)->queryAll();

		$department = Department::model()->findAll();	//Department
		

		$checkinout = null;
		$startDate = null;
		$endDate = null;
		$emps_lists = null;
		if(isset($_POST['EmployeeSchedule']))
		{
			$startDate = $_POST['startDate'];
			$endDate = $_POST['endDate'];
			if($startDate == null){ $alertTo .= '*Start Date must not be empty.<br />';}
			if($endDate == null){ $alertTo .= '*End Date must not be empty.<br />';}

			if($alertTo != null){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />'.$alertTo.'</div>';
			}else{

			if(strtotime($startDate) > strtotime($endDate)){
				$alert = '<div class="alert-error" style="padding:10px;">ERROR<br />Invalid Date</div>';
			}else{
						$checkinout = Yii::app()->db->createCommand('
							SELECT * FROM `checkinout` where (date >= "'.$startDate.'" && date <= "'.$endDate.'")'
							)->queryAll();  //Checkin.out

						$emps_lists=Yii::app()->db->createCommand('
														SELECT e.id, e.firstname, e.lastname, es.emp_id, es.start_date, es.end_date, s.mon, s.tue, s.wed, s.thur, s.fri, s.sat, s.sun, e.status_id
														FROM employee AS e 
														LEFT JOIN  employee_schedule AS es  ON e.id = es.emp_id
														LEFT JOIN schedule AS s ON es.sched_id = s.id 
														WHERE e.status_id=1 and (start_date <= \''.$startDate.'\''.' or start_date <= \''.$endDate.'\')'
														)->queryAll();

			}
		}
		}else{
			
		}

		//OT
		$checkot = Yii::app()->dbol->createCommand("
					SELECT * FROM `otform` WHERE (date <= '$startDate' or date <= '$endDate')
					")->queryAll();

		//LEAVE
		$leave = Yii::app()->dbol->createCommand("
					SELECT l.id, l.employee_id, lt.name, l.leave_type_id, l.reason, l.start_date, l.end_date, l.date_filed, l.sv1, l.sv2, l.om, l.hrm, l.remarks, l.create_date, l.days_with_pay, l.days_without_pay, l.others, l.status
					FROM `leave` as l
					LEFT JOIN  leave_type AS lt  ON lt.id = l.leave_type_id
					WHERE (start_date <= '$startDate' or start_date <= '$endDate')
					")->queryAll();

		$this->render('report',array(
			'model'=>$model,
			'emps_lists'=>$emps_lists,
			'startDate' => $startDate,
			'endDate' => $endDate,
			'employees' => $employees,
			'alert'=>$alert,
			'department'=>$department,
			'checkinout'=>$checkinout,
			'checkot' => $checkot,
			'leave' => $leave,
			'overrides'=>$overrides,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EmployeeSchedule']))
		{
			$alert = null;
			$model->attributes=$_POST['EmployeeSchedule'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'alert'=>$alert,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('EmployeeSchedule');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EmployeeSchedule('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmployeeSchedule']))
			$model->attributes=$_GET['EmployeeSchedule'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EmployeeSchedule the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EmployeeSchedule::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EmployeeSchedule $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-schedule-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionTestview()
	{
					$model=new EmployeeSchedule;

					// uncomment the following code to enable ajax-based validation
					/*
						 if(isset($_POST['ajax']) && $_POST['ajax']==='employee-schedule-testview-form')
						 {
						 echo CActiveForm::validate($model);
						 Yii::app()->end();
						 }
					 */

					if(isset($_POST['EmployeeSchedule']))
					{
									$model->attributes=$_POST['EmployeeSchedule'];
									if($model->validate())
									{
													// form inputs are valid, do something here
													return;
									}
					}
					$this->render('testview',array('model'=>$model));
	}

	public function actionUpload()
	{
				$model=new EmployeeSchedule;

		$alert = null;
		$symbol = null;
		$empArr = array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/*UPLOAD*/
		$employees = Checkinout::model()->findAll();
		#echo "<pre>";
		#print_r($employees);
		#echo "</pre>";
		foreach($employees as $emp):
		$empArr[] = array(
			'id'=>$emp['id'],
			'user_id'=>$emp['user_id'],
			'name'=>$emp['name'],
			'date'=>$emp['date'],
			'checkin'=>$emp['checkin'],
			'checkout'=>$emp['checkout'],
		);
		endforeach;
		$storagename = null;
		if ( isset($_POST["submit"]) ) {

						if ( isset($_FILES["file"])) {

										//if there was an error uploading the file
										if ($_FILES["file"]["error"] > 0) {
														$alert= 'ERROR<br />Invalid file.Please check the file and try again.';
														$symbol = 'error';

										}
										else {
														//Print file details
														$alert = "<div class='alert-success' style='padding:10px'>SUCCESS!<br />
														Upload: ". $_FILES["file"]["name"] . "<br />".
														"Type: " . $_FILES["file"]["type"] . "<br />".
														"Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />".
														"Temp file: " . $_FILES["file"]["tmp_name"] . "<br />".
														"</div>";
														$symbol = 'succ';

														//if file already exists
													/*	if (file_exists("upload/" . $_FILES["file"]["name"])) {
																		#echo $_FILES["file"]["name"] . " already exists. ";
														}
														else {
																		//Store file in directory "upload" with the name of "uploaded_file.txt"
																		#$storagename = $_FILES["file"]["name"];
																		$storagename = "uploadedfile.csv";
																		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);

																		echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
														}*/
										}
										$storagename = $_FILES["file"]["tmp_name"];
						} else {
											$alert= 'ERROR<br />No file selected.';
											$symbol = 'error';
						}
		}
		$csv = array();
		if($storagename != null){
			if ( $file = fopen( $storagename , 'r' ) ) {

					$result = fgetcsv($file);
					while (($result != false)) {
					$result = fgetcsv($file);
				  if (array(null) != $result) { // ignore blank lines
				      $csv[] = $result;
				   }
					}
			}
		}
		/*UPLOAD*/

		$this->render('upload',array(
														'model'=>$model,
														'alert'=>$alert,
														'symbol'=>$symbol,
														));
	}

	public function actionAddfield($id,$sd,$ed,$st,$et,$rd)
	{
				$model=new EmployeeSchedule;

				// uncomment the following code to enable ajax-based validation
				/*
					 if(isset($_POST['ajax']) && $_POST['ajax']==='employee-schedule-addfield-form')
					 {
					 echo CActiveForm::validate($model);
					 Yii::app()->end();
					 }

				if(isset($_POST['EmployeeSchedule']))
				{
								$model->attributes=$_POST['EmployeeSchedule'];
								if($model->validate())
								{
												// form inputs are valid, do something here
												return;
								}
				}
				 */
				$rdstat = null;
				echo $id = $_GET['id'];
				echo "<br>";
				echo $sd = $_GET['sd'];
				echo "<br>";
				echo $ed = $_GET['ed'];
				echo "<br>";
				echo $st = date('H:i',strtotime($_GET['st']));
				echo "<br>";
				echo $et = date('H:i',strtotime($_GET['et']));
				echo $rd = $_GET['rd'];
				if($rd != null){
					$rdstat = 1;
				}else{
					$rdstat = 0;
				}

					$model = new ScheduleOverrides;
					$model->emp_id = $id;
					$model->start_date = date('Y-m-d', strtotime($sd));
					$model->end_date = date('Y-m-d', strtotime($ed));
					$model->start_time = $st;
					$model->end_time = $et;
					$model->rd = $rdstat;
					$model->save();
				$this->render('addfield',array('model'=>$model));
	}

	public function actionMod(){
				$model=new EmployeeSchedule;
				$this->render('mod',array('model'=>$model));
	}
	public function actionUploadsched(){

		$getdata_es = Yii::app()->db->createCommand('
			SELECT * FROM `employee_schedule`
		')->queryAll();
		$getdata_arr = array();
		foreach($getdata_es as $ga){
			$getdata_arr[] = array(
				'id'=>$ga['id'],
				'empid'=>$ga['emp_id'],
				'startdate'=>$ga['start_date'],
				'enddate'=>$ga['end_date'],
				'schedid'=>$ga['sched_id'],
			);
		}
		$alert= null;
		$model = new EmployeeSchedule;
		
		$check_bool_sched = null;
		$arr_sched = array();
		$checksched = Schedule::model()->findAll();
		foreach($checksched as $e){
			$arr_sched [] = array(
				'id'=>$e['id'],
				'mon' => ($e['mon'] == null ? $varday=NULL : $varday=$e['mon']),
				'tue' => ($e['tue'] == null ? $varday=NULL : $varday=$e['tue']),
				'wed' => ($e['wed'] == null ? $varday=NULL : $varday=$e['wed']),
				'thur' => ($e['thur'] == null ? $varday=NULL : $varday=$e['thur']),
				'fri' => ($e['fri'] == null ? $varday=NULL : $varday=$e['fri']),
				'sat' => ($e['sat'] == null ? $varday=NULL : $varday=$e['sat']),
				'sun' => ($e['sun'] == null ? $varday=NULL : $varday=$e['sun']),
			);
		}
		$array_sched = array();
		foreach($arr_sched as $rs){
			$array_sched [] = array(
				'id'=>$rs['id'],
				'sched_day'=>'>Mon>'.$rs['mon']. '>Tue>'.$rs['tue'].'>Wed>'.$rs['wed'].'>Thu>'.$rs['thur'].'>Fri>'.$rs['fri'].'>Sat>'.$rs['sat'].'>Sun>'.$rs['sun'],
			);
		}
		$overall_data = array();
		$overall_count = 0;
		#echo "<pre>";print_r($array_sched);echo "</pre>";
		if ( isset($_POST["submit"]) ) {
			if ( isset($_FILES["file"])) {

			//if there was an error uploading the file
			if ($_FILES["file"]["error"] > 0) {
				$alert= 'ERROR<br />Invalid file.Please check the file and try again.';
				$symbol = 'error';
			}else {
				//Print file details
				$alert = "<div class='alert-success' style='padding:10px'>SUCCESS!<br />
				Upload: ". $_FILES["file"]["name"] . "<br />".
				"Type: " . $_FILES["file"]["type"] . "<br />".
				"Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />".
				"Temp file: " . $_FILES["file"]["tmp_name"] . "<br />".
				"</div>";
				$symbol = 'succ';
			}
				$storagename = $_FILES["file"]["tmp_name"];
		} else {
			$alert= 'ERROR<br />No file selected.';
			$symbol = 'error';
		}
		
		if($storagename != null){
		
		//open csv
		$strfile = fopen($storagename,"r");
		$fstr= (fgetcsv($strfile));
		//firstdate
		$start_date = date('Y-m-d',strtotime($fstr[1]));
		//enddate
		$end_date = date('Y-m-d',strtotime(end($fstr)));
		fclose($strfile);
		//close csv
		$arr_date = null;
		
		$arr_date[0] = "id";
		$k = 1;
		while($start_date <= $end_date){
			#echo $k.">>";
			$arr_date[$k] = $start_date;
			//minus 1 day
			$start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
			$k++;
		}
		#array_unshift($arr_date,"id");
		//csv column
		#print_r($arr_date);
		
		$file = file_get_contents($storagename);
		$data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $file));
		$arr_data = array();
		$all_data = null;
		$mon = null; $tue = null; $wed = null; $thu = null; $fri = null; $sat = null; $sun = null; 
		
		$i=0;
		foreach($data as $key=>$value):
			if($key != 0){
				$all_data[$i] = $value;
			}
			$i++;
		endforeach;
	
		$day_data_start = null;
		$day_data_end = null;
		$day = null;
		$sqlinsert = null;
		for($x = 1; $x < $i; $x++){

			$j = 0;
			$l = 0;
			$bool_sched = null;
			$emp_id_count = 0;
			$id_of_emp = null;

			foreach($all_data[$x] as $ddata){
			#M 08:00 - 17:00 T 12:30 - 21:30 W 12:30 - 21:30 Th 12:30 - 21:30 F RD Sa RD Su 06:00 - 15:00
				if($emp_id_count == 0){
				#echo "<br>ID: ".$ddata;
				$overall_data[$overall_count] = $id_of_emp = $ddata;
				$overall_count++;
				}else{
				#echo "<br>data: ".$ddata;
				}
				$emp_id_count++;
				#echo "<br>Date: ".$arr_date[$j];
				$checkarr_date = date('D',strtotime($arr_date[$j]));
				if($checkarr_date == 'Mon'){$mon = $ddata;if($mon == '' or $mon == null){$mon=NULL;}}
				else if($checkarr_date == 'Tue'){$tue = $ddata;if($tue == '' or $tue == null){$tue=NULL;}}
				else if($checkarr_date == 'Wed'){$wed = $ddata;if($wed == '' or $wed == null){$wed=NULL;}}
				else if($checkarr_date == 'Thu'){$thu = $ddata;if($thu == '' or $thu == null){$thu=NULL;}}
				else if($checkarr_date == 'Fri'){$fri = $ddata;if($fri == '' or $fri == null){$fri=NULL;}}
				else if($checkarr_date == 'Sat'){$sat = $ddata;if($sat == '' or $sat == null){$sat=NULL;}}
				else if($checkarr_date == 'Sun'){$sun = $ddata;if($sun == '' or $sun == null){$sun=NULL;}}
				$sqlinsert = "INSERT INTO `dtr`.`schedule` (`id`, `mon`, `tue`, `wed`, `thur`, `fri`, `sat`, `sun`) VALUES (NULL, '".$mon."', '".$tue."', '".$wed."', '".$thu."', '".$fri."','".$sat."','".$sun."');
";
				#echo "<br>";
				if($checkarr_date=='Sun'){
					if($l != 0){
						$day .= $checkarr_date = ">".date('D',strtotime($arr_date[$j])).">".$ddata;
					}
					#echo "<br>Start Date:".$day_data_end = date('d-M-y',strtotime($arr_date[$j]));
					$overall_data[$overall_count]=$day_data_end = date('d-M-y',strtotime($arr_date[$j]));
					$overall_count++;
					#echo "<hr>";
					$l = 0;
					#echo $day;
					#echo "<br>";
					
					foreach($array_sched as $arrays){
					#echo "<br>##".$arrays['sched_day']."<br>";
						if($arrays['sched_day'] == $day){
							$bool_sched = $arrays['id'];
							 $arrays['id'];
							#echo "";
						}
					}
					#echo "<br>sched id:".$bool_sched;
					$overall_data[$overall_count]=$bool_sched;
					$overall_count++;
					if($bool_sched == null){
					#echo "no";
						//nosched
						$sqlinsert;
						$model=new Schedule;
						if(strlen($mon) <= 3){$mon = null;}
						$model->mon = $mon;
						if(strlen($tue) <= 3){$tue = null;}
						$model->tue = $tue;
						if(strlen($wed) <= 3){$wed = null;}
						$model->wed = $wed;
						if(strlen($thu) <= 3){$thu = null;}
						$model->thur = $thu;
						if(strlen($fri) <= 3){$fri = null;}
						$model->fri = $fri;
						if(strlen($sat) <= 3){$sat = null;}
						$model->sat = $sat;
						if(strlen($sun) <= 3){$sun = null;}
						$model->sun = $sun;
					#	$model->save();
					}else{
						#echo "yes";
						$check_bool_sched = 'true';
					}
					$day = null;
					
					#$mon = null; $tue = null; $wed = null; $thu = null; $fri = null; $sat = null; $sun = null; 
				}else{
					if($l != 0){
						$day .= $checkarr_date = ">".date('D',strtotime($arr_date[$j])).">". $ddata;
						if(date('D',strtotime($arr_date[$j])) == 'Mon'){
							#echo "<br>End Date:".$day_data_start = date('d-M-y',strtotime($arr_date[$j]));
							$overall_data[$overall_count]=$day_data_start = date('d-M-y',strtotime($arr_date[$j]));
							$overall_count++;
						}
					}
				}
				
				$l++;
				$j++;
				$bool_sched = null;
				$day_data_start = null;
				$day_data_end = null;
			}
			//ENDENDEND
			#echo "<br>";

		}
		if($check_bool_sched != null){
		$n_empid = null;
		$n_startdate = null;
		$n_enddate = null;
		$n_schedid = null;
		$eno_empid = null;
		$thisOk = null;
		$n = 0;
	  $conn = new PDO("mysql:host=localhost;dbname=DTR","root","asdfasdf");
		for($m = 0; $m < $overall_count ; $m++){
			$n++;
			if($n == 1){
				$n_empid = intval($overall_data[$m]);
				$eno_empid = $n_empid;
#				echo "--->".$eno_empid."<<---.<br>";
			}
			if($n == 2){
				$n_startdate = date('Y-m-d',strtotime($overall_data[$m]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 3){
				$n_enddate = date('Y-m-d',strtotime($overall_data[2]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 4){
				$n_schedid = intval($overall_data[$m]);
#				echo "--->".$overall_data[$m]."<<---.<br>";
				
				if($n_empid != null && $n_startdate != null && $n_enddate != null && $n_schedid != null){
				$sql = "INSERT INTO `DTR`.`employee_schedule` (`id`, `sched_id`, `emp_id`, `start_date`, `end_date`, `status`, `conflict`) VALUES (NULL, '".$n_schedid."', '".$n_empid."', '".$n_startdate."', '".$n_enddate."', '1', '0');<br>";
				$q = $conn->prepare($sql);
				$q->execute();
				}

				$n_startdate = null; $n_enddate = null; $n_schedid = null;$thisOk = null;
			}
			if($n == 5){
				$n_empid = $eno_empid;
#				echo "--->".$eno_empid."<<---.<br>";
				$n_startdate = date('Y-m-d',strtotime($overall_data[$m]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 6){
				$n_enddate = date('Y-m-d',strtotime($overall_data[5]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 7){
				$n_schedid = intval($overall_data[$m]);
#				echo "--->".$overall_data[$m]."<<---.<br>";
				if($n_empid != null && $n_startdate != null && $n_enddate != null && $n_schedid != null){
				$sql = "INSERT INTO `DTR`.`employee_schedule` (`id`, `sched_id`, `emp_id`, `start_date`, `end_date`, `status`, `conflict`) VALUES (NULL, '".$n_schedid."', '".$n_empid."', '".$n_startdate."', '".$n_enddate."', '1', '0');<br>";
				$q = $conn->prepare($sql);
				$q->execute();
				}
				$n_startdate = null; $n_enddate = null; $n_schedid = null; $thisOk = null;
			}
			if($n == 8){
				$n_empid = $eno_empid;
#				echo "--->".$eno_empid."<<---.<br>";
				$n_startdate = date('Y-m-d',strtotime($overall_data[$m]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 9){
				$n_enddate = date('Y-m-d',strtotime($overall_data[8]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 10){
				$n_schedid = intval($overall_data[$m]);
#				echo "--->".$overall_data[$m]."<<---.<br>";
				if($n_empid != null && $n_startdate != null && $n_enddate != null && $n_schedid != null){
				$sql = "INSERT INTO `DTR`.`employee_schedule` (`id`, `sched_id`, `emp_id`, `start_date`, `end_date`, `status`, `conflict`) VALUES (NULL, '".$n_schedid."', '".$n_empid."', '".$n_startdate."', '".$n_enddate."', '1', '0');<br>";
				$q = $conn->prepare($sql);
				$q->execute();
				}
				$n_startdate = null; $n_enddate = null; $n_schedid = null; $thisOk = null;
			}
			if($n == 11){
				$n_empid = $eno_empid;
#				echo "--->".$eno_empid."<<---.<br>";
				$n_startdate = date('Y-m-d',strtotime($overall_data[$m]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 12){
				$n_enddate = date('Y-m-d',strtotime($overall_data[11]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 13){
				$n_schedid = intval($overall_data[$m]);
#				echo "--->".$overall_data[$m]."<<---.<br>";
				if($n_empid != null && $n_startdate != null && $n_enddate != null && $n_schedid != null){
				$sql = "INSERT INTO `DTR`.`employee_schedule` (`id`, `sched_id`, `emp_id`, `start_date`, `end_date`, `status`, `conflict`) VALUES (NULL, '".$n_schedid."', '".$n_empid."', '".$n_startdate."', '".$n_enddate."', '1', '0');<br>";
				$q = $conn->prepare($sql);
				$q->execute();
				}
				$n_startdate = null; $n_enddate = null; $n_schedid = null; $thisOk = null;
			}
			if($n == 14){
				$n_empid = $eno_empid;
#				echo "--->".$n_empid."<<---.<br>";
				$n_startdate = date('Y-m-d',strtotime($overall_data[$m]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 15){
				$n_enddate = date('Y-m-d',strtotime($overall_data[14]));
#				echo "--->".$overall_data[$m]."<<---.<br>";
			}
			if($n == 16){
				$n_schedid = intval($overall_data[$m]);
#				echo "--->".$overall_data[$m]."<<---.<br>";
				if($n_empid != null && $n_startdate != null && $n_enddate != null && $n_schedid != null){
				$sql = "INSERT INTO `DTR`.`employee_schedule` (`id`, `sched_id`, `emp_id`, `start_date`, `end_date`, `status`, `conflict`) VALUES (NULL, '".$n_schedid."', '".$n_empid."', '".$n_startdate."', '".$n_enddate."', '1', '0');<br>";
				$q = $conn->prepare($sql);
				$q->execute();
				}else{
#				echo "not";
				}
				$n_startdate = null; $n_enddate = null; $n_schedid = null; $thisOk = null;
#		echo "<hr>";
				$n = 0;
				$eno_empid = null;$n_empid = null;
			}
#			echo $n;
		}
		}//endboolsched
		else{
			$alert = "All the schedule has saved first. Please input the File to upload the schedule. Thank you.";
		}

		}
		
		
		}
			$this->render('uploadsched',array('model'=>$model,'alert'=>$alert));
		}

}

