<?php

class ScheduleOverridesController extends Controller
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
		$model=new ScheduleOverrides;
		$alert = null;
		$rdstat = 0;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['ScheduleOverrides']))
		{
		$rd = $_POST['rd'];
		if($rd != null){
			$rdstat =1;
		}
		$array = $_POST['emp_sel'];
		if($array == null){
			$alert = "<div class='alert in fade alert-error'>Employee name cannot be empty</div>";
		}else{
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
						}
		endforeach;

		foreach($output as $emp=>$value){
			$model=new ScheduleOverrides;
			$model->emp_id = $emp;
			$model->start_time = $_POST['start_time'];
			$model->end_time = $_POST['end_time'];
			$model->start_date = $_POST['start_date'];
			$model->end_date = $_POST['end_date'];
			$model->rd = $rdstat;
			$model->save();
			$alert = "<div class='alert in alert-block fade alert-success'>Schedule Saved!</div>";
		}

		}
		}

		$this->render('create',array(
			'model'=>$model,
			'alert'=>$alert,
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

		if(isset($_POST['ScheduleOverrides']))
		{
			$model->attributes=$_POST['ScheduleOverrides'];
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
		$dataProvider=new CActiveDataProvider('ScheduleOverrides');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ScheduleOverrides('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScheduleOverrides']))
			$model->attributes=$_GET['ScheduleOverrides'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ScheduleOverrides the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ScheduleOverrides::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ScheduleOverrides $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='schedule-overrides-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
