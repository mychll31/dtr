<?php

class CheckinoutController extends Controller
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
			#'accessControl', // perform access control for CRUD operations
			#'postOnly + delete', // we only allow deletion via POST request
      'rights',
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
				'actions'=>array('create','update','saveio','dtrupload'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','saveio'),
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
	public function actionCreate()
	{
		$model=new Checkinout;
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
														"</div>";
														$symbol = 'succ';

														//if file already exists
												/*		if (file_exists("upload/" . $_FILES["file"]["name"])) {
																		#echo $_FILES["file"]["name"] . " already exists. ";
														}
														else {
																		//Store file in directory "upload" with the name of "uploaded_file.txt"
																		$storagename = $_FILES["file"]["name"];
																		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);

																		#echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
														}*/
										}
										/* NOTE: THE FILE DID NOT STORED
										*/
										$storagename = $_FILES["file"]["tmp_name"];
						} else {
											$alert= 'ERROR<br />No file selected.';
											$symbol = 'error';
						}
		}
		if($storagename != null){
						if ( $file = fopen( $storagename , 'r' ) ) {

										$firstline = fgets ($file, 4096 );
										//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
										$num = strlen($firstline) - strlen(str_replace(";", "", $firstline));

										//save the different fields of the firstline in an array called fields
										$fields = array();
										$fields = explode( ";", $firstline, ($num+1) );

										$line = array();
										$i = 0;

										//CSV: one line is one record and the cells/fields are seperated by ";"
										//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
										while ( $line[$i] = fgets ($file, 4096) ) {

														$record[$i] = array();
														$record[$i] = explode( ";", $line[$i], ($num+1) );
														$i++;
										}

										for ( $k = 0; $k != ($num+1); $k++ ) {
														//   echo "<td>" . $fields[$k] . "</td>";
										}
										$logs=array();
										$i=1;
										$cnt=count($record);
										foreach ($record as $key => $number) {
														foreach ($number as $k => $content) {
																		$cols=explode(',',$content);
																		$pnch=date('Y-m-d',strtotime($cols[3]));
																		$time=date('H:i:s',strtotime($cols[3]));
																		//$time=date('g:i:A',strtotime($cols[3]));
																		$ename=$cols[1];
																		$eid=$cols[2];
																		$userid[]=$cols[2];
																		if(!isset($logs[$eid]['ename']))
																						$logs[$eid]['ename']=$ename;
																		$logs[$eid]['eid']=$eid;
																		if(strtolower($cols[4])=='c/in'){
																						$logs[$eid]['io'][$pnch]['in'][]=$time;
																		}
																		if(strtolower($cols[4])=='c/out'){
																						$logs[$eid]['io'][$pnch]['out'][]=$time;
																		}
														}
										}
						}


#$db = new PDO('mysql:host=localhost;dbname=lima', 'root', 'asdfasdf');

						if(count($logs)): 
										$values=array();
						foreach($logs as $l):
										$empName = htmlentities($l['ename']);
						$userid = htmlentities($l['eid']);
#print_r(array_unique($userid));

#print_r($l);
						foreach($l['io'] as $k=>$v):

										$in='';
						$out='';
						@$in = $v['in'][0];
#@$in = $v['in'][0] ?  $v['in'][0]:$v['out'][0];
						@$out = end($v['out']);
#@$out = end($v['out']) ?  end($v['out']):end($v['in']);
#$values[] = "($userid,'$empName', '$k', '$in', '$out')";
						$values[] = array(
														'uid'=>$userid,
														'ename'=>$empName,
														'date'=>$k,
														'in'=>$in,
														'out'=>$out
														);
						//savedata

						//savedata

						endforeach;
						endforeach;
#print_r($values);
						foreach($values as $value){
							if($empArr == null){
										$model=new Checkinout;
										$model->user_id = $value['uid'];
										$model->name = $value['ename'];
										$model->date = $value['date'];
										$model->checkin = $value['in'];
										$model->checkout = $value['out'];
										$model->save();
							}else{

							$checkio = Yii::app()->db->createCommand(
								'SELECT * FROM checkinout WHERE `user_id` = '.$value['uid'].' AND `name` LIKE \'%'.$value['ename'].'%\' AND  `date` = \''.$value['date'].'\' AND `checkin` = \''.$value['in'].'\' AND `checkout` = \''.$value['out'].'\''
							)->queryAll();

								if($checkio == null){
										$model=new Checkinout;
										$model->user_id = $value['uid'];
										$model->name = $value['ename'];
										$model->date = $value['date'];
										$model->checkin = $value['in'];
										$model->checkout = $value['out'];
										$model->save();
								}
							}
						
						}

						endif;
		}
		/*UPLOAD*/

		$this->render('create',array(
														'model'=>$model,
														'alert'=>$alert,
														'symbol'=>$symbol,
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

					if(isset($_POST['Checkinout']))
					{
									$model->attributes=$_POST['Checkinout'];
									if($model->save())
													$this->redirect(array('view','id'=>$model->id));
					}

					$this->render('update',array(
																	'model'=>$model,
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
					$dataProvider=new CActiveDataProvider('Checkinout');
					$this->render('index',array(
																	'dataProvider'=>$dataProvider,
																	));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
					$model=new Checkinout('search');
					$model->unsetAttributes();  // clear any default values
					if(isset($_GET['Checkinout']))
									$model->attributes=$_GET['Checkinout'];

					$this->render('admin',array(
																	'model'=>$model,
																	));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Checkinout the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
					$model=Checkinout::model()->findByPk($id);
					if($model===null)
									throw new CHttpException(404,'The requested page does not exist.');
					return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Checkinout $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
					if(isset($_POST['ajax']) && $_POST['ajax']==='checkinout-form')
					{
									echo CActiveForm::validate($model);
									Yii::app()->end();
					}
	}

	public function actionManpower()
	{
					$model=new Checkinout;

					// uncomment the following code to enable ajax-based validation
					/*
						 if(isset($_POST['ajax']) && $_POST['ajax']==='checkinout-manpower-form')
						 {
						 echo CActiveForm::validate($model);
						 Yii::app()->end();
						 }
					 */

					if(isset($_GET['Checkinout']))
					{
									$model->attributes=$_GET['Checkinout'];
									if($model->validate())
									{
													// form inputs are valid, do something here
													return;
									}
					}
					$this->render('manpower',array('model'=>$model));
	}

	protected function dataColumn($data)
	{
					$date = $data->date;
					$timeIn = $data->checkin;
					$dateTimeIn = $date.' '.$timeIn;

					$schedIn = $date.' 09:00:00';
					$schedTime = strtotime($schedIn);
					$logTime = strtotime($dateTimeIn);
					if ($logTime > $schedTime) {
									$lt = floor(abs($logTime - $schedTime) / 60);
					}else {
									$lt = 0;
					}
					return 	$lt;
					//return 	print_r($data);
	}
	public function actionSaveio()
	{
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
			$arr_data = array();
			$data = array();
			$file_handle = fopen($storagename, "r");
			while (!feof($file_handle) ) {
				$line_of_text = fgetcsv($file_handle, 1024);
				$arr_data[] = $line_of_text[1].",".$line_of_text[2].",".$line_of_text[3];
			}
			fclose($file_handle);
			$hold_date = array();
			$hold_id = array();
			foreach($arr_data as $rd):
				$arr_rd = explode(',',$rd);
				$strarr = date('Y-m-d',strtotime($arr_rd[2]));
				if(in_array($strarr,$hold_date)){
					
				}else{
					array_push($hold_date,$strarr);
				}
				if(in_array($arr_rd[1],$hold_id)){
					
				}else{
					array_push($hold_id,$arr_rd[1]);
				}
				$data [] = array(
					'id'=>$arr_rd[1],
					'name'=>$arr_rd[0],
					'date'=>date('Y-m-d',strtotime($arr_rd[2])),
					'time'=>date('H:i:s',strtotime($arr_rd[2])),
					);
			endforeach;
			$hold_array = array();
			$all_array = array();
			#print_r($hold_date);
			foreach($hold_id as $id):
				foreach($data as $dt):
					if($id == $dt['id']){
						$hold_array [] = array(
							'id'=>$dt['id'],
							'name'=>$dt['name'],
							'date'=>$dt['date'],
							'time'=>$dt['time'],
						);
					}
				endforeach;
			$all_array [] = $hold_array;
			$hold_array = null;
			endforeach;
			$temp1 = null;
			$temp2 = null;
			$empname = null;
			$empdate = null;
			$empid = null;
			$io = array();
			foreach($hold_date as $date):
				foreach($all_array as $a=>$value):
					foreach($value as $key=>$val):
						if($val['date'] == $date){
							if($temp1 == null){
								$temp1 = $val['time'];
							}else{
								if($val['time'] < $temp1){
									$temp1 = $val['time'];
								}
							}
							if($temp2 == null){
								$temp2 = $val['time'];
							}else{
								if($val['time'] > $temp2){
									$temp2 = $val['time'];
								}
							}
							$empname = $val['name'];
							$empdate = $val['date'];
							$empid = $val['id'];
						}
					endforeach;
					if($empdate != null){
						$io [] = array(
							'id'=>$empid,
							'name'=>$empname,
							'date'=>$empdate,
							'in'=>$temp1,
							'out'=>$temp2
						);
					}
					$temp2 = null;
					$temp1 = null;
					$empdate = null;
					$empid = null;
					$empname = null;
				endforeach;
			endforeach;
			foreach($io as $i):
				$model=new Checkinout;
				$model->user_id = $i['id'];
				$model->name = $i['name'];
				$model->date = $i['date'];
				$model->checkin = $i['in'];
				$model->checkout = $i['out'];
				$model->save();
#				echo "INSERT INTO `dtr`.`checkinout` (`id`, `user_id`, `name`, `date`, `checkin`, `checkout`, `late`) VALUES (NULL, '".$i['id']."', '".$i['name']."', '".$i['date']."', '".$i['in']."', '".$i['out']."', '');<br>";
			endforeach;
		}
	}
		$this->render('saveio');
	}

	public function actionDtrupload()
	{
		$model = new Checkinout;

		$employees = Employee::model()->findAll();

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
		$arr_data= array();
		if($storagename != null){

			$file_handle = fopen($storagename,'r');
			while (!feof($file_handle) ) {
				$line_of_text = fgetcsv($file_handle, 1024);
				$arr_data[] = array(
							'no'=>$line_of_text[2],
							'name'=>$line_of_text[1],
							'date'=>date('d-Y-m',strtotime($line_of_text[3])),
							'time'=>date('H:i',strtotime($line_of_text[3])),
							'status'=>$line_of_text[4],
							);
			}
			fclose($file_handle);
			sort($arr_data);

			$tmp = null;
			foreach($arr_data as $rdata){
				
			}
			
			echo "<pre>";
			print_r($arr_data);
			#print_r($arr_data);
			echo "</pre>";
			

		}

	}

	$this->render('dtrupload',array(
													'model'=>$model,
													));
	
	}
}
