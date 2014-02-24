<?php

class ScheduleController extends Controller
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Schedule;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['sched']))
		{
      $schedType = $_POST['sched'];
      if ($schedType == 'fixed') {
        $cfrom = $_POST['checkinFrom'];
        $cto   = $_POST['checkinTo'];
        $time  = $cfrom .' - '. $cto;
        $mon = $_POST['mo']; 
        $tue = $_POST['tu']; 
        $wed = $_POST['we']; 
        $thu = $_POST['th']; 
        $fri = $_POST['fr']; 
        $sat = $_POST['sa']; 
        $sun = $_POST['su']; 
        //fixed 
        if ($mon)
          $model->mon=$time;
        if ($tue)
          $model->tue=$time;
        if ($wed)
          $model->wed=$time;
        if ($thu)
          $model->thur=$time;
        if ($fri)
          $model->fri=$time;
        if ($sat)
          $model->sat=$time;
        if ($sun)
          $model->sun=$time;
      }elseif ($schedType == 'custom'){
        $cusMonFrom = $_POST['monFrom']; 
        $cusTueFrom = $_POST['tueFrom']; 
        $cusWedFrom = $_POST['wedFrom']; 
        $cusThuFrom = $_POST['thurFrom']; 
        $cusFriFrom = $_POST['friFrom']; 
        $cusSatFrom = $_POST['satFrom']; 
        $cusSunFrom = $_POST['sunFrom']; 
        $cusMonTo = $_POST['monTo']; 
        $cusTueTo = $_POST['tueTo']; 
        $cusWedTo = $_POST['wedTo']; 
        $cusThuTo = $_POST['thurTo']; 
        $cusFriTo = $_POST['friTo']; 
        $cusSatTo = $_POST['satTo']; 
        $cusSunTo = $_POST['sunTo']; 
       
        //custom
        if ($cusMonFrom != '00:00'){
          $mon = "$cusMonFrom - $cusMonTo";
          $model->mon=$mon;
        }
        if ($cusTueFrom != '00:00'){
          $tue = "$cusTueFrom - $cusTueTo";
          $model->tue=$tue;
        }
        if ($cusWedFrom != '00:00'){
          $wed = "$cusWedFrom - $cusWedTo";
          $model->wed=$wed;
        }
        if ($cusThuFrom != '00:00'){
          $thur = "$cusThuFrom - $cusThuTo";
          $model->thur=$thur;
        }
        if ($cusFriFrom != '00:00'){
          $fri = "$cusFriFrom - $cusFriTo";
          $model->fri=$fri;
        }
        if ($cusSatFrom != '00:00'){
          $sat = "$cusSatFrom - $cusSatTo";
          $model->sat=$sat;
        }
        if ($cusSunFrom != '00:00'){
          $sun = "$cusSunFrom - $cusSunTo";
          $model->sun=$sun;
        }
      }
			#$model->attributes=$_POST['Schedule'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Schedule']))
		{
			$model->attributes=$_POST['Schedule'];
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
		$dataProvider=new CActiveDataProvider('Schedule');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Schedule('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Schedule']))
			$model->attributes=$_GET['Schedule'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Schedule the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Schedule::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Schedule $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='schedule-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
