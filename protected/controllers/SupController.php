<?php

class SupController extends Controller
{
	
	public $layout='//layouts/supplier/column1';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		//$this->render('index');
		//$this->redirect(Yii::app()->baseUrl . '/supplier/index');
		
		if(Yii::app()->user->isSupplier()) {
			//$this->redirect(Yii::app()->baseUrl . '/supplier/index');
			if(Yii::app()->user->getSupplier()->id_service == Service::HOTEL) {
				$this->hotelHome();
			} else if(Yii::app()->user->getSupplier()->id_service == Service::CAR) {
				$this->carHome();
			} else if(Yii::app()->user->getSupplier()->id_service == Service::TICKET) {
				$this->ticketHome();
			} else if(Yii::app()->user->getSupplier()->id_service == Service::DAY_TOUR) {
				$this->daytourHome();
			} else if(Yii::app()->user->getSupplier()->id_service == Service::HOT_DEAL) {
				$this->doydealHome();
			}
		} else {
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->baseUrl . '/sup/login');
		}
	}
	
	private function hotelHome() {
		//echo 'HotelHome';
		$this->render('hotel_home');
	}
	
	private function carHome() {
		$this->render('car_home');
	}
	
	private function ticketHome() {
		$this->render('ticket_home');
	}
	
	private function daytourHome() {
		$this->render('daytour_home');
	}
	
	private function doydealHome() {
		$this->render('doydeal_home');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {

				Yii::app()->session->add('service', Yii::app()->user->getSupplier()->id_service);
				
				//$this->redirect(Yii::app()->user->returnUrl);
				$this->redirect(Yii::app()->baseUrl . '/sup/index');
			}
		}
		// display the login form
		//$this->layout = null;
		$this->render('login',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->homeUrl);
		$this->redirect(Yii::app()->baseUrl . '/sup/index');
	}
}