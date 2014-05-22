<?php
Yii::import('ext.Utilities');

class ContestController extends Controller
{
	/*
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//
	public $layout='//layouts/lobbyLayout';
	
	/**
	 * @var string the current active page (used for highlighting in the sidebar)
	 */
	public $active="";
	
	public $mainLayoutActive = "contest";

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function userAuthenticated($contestId) {
		return true;
		//return (Yii::app()->user->bidang == Contest::model()->findByPk($contestId)->bidang); 
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('delete','index','view','create','update','scoring','grading','contestant','updateContestProblem', 'viewContestProblem', 'removeContestant', 'addContestant', 'rank','grading'),
				'users'=>array('@'),
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
		if(!Self::userAuthenticated($id)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		$this->active = 'view';
		$contestantList = Contest::model()->findByPk($id)->users;
		
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
			'contestantList' => $contestantList,
		));
	}
	
	public function actionViewContestProblem($id, $page = 0) {
		$model = $this->loadModel($id);
		if ($model == null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}

		if(isset($_GET['renderImage'])) {
			ob_clean();
			$filename = $_GET['renderImage'];
			$filepath = Utilities::getUploadedImagePath() . $_GET['renderImage'];
			header('Content-Type: '. CFileHelper::getMimeType($filepath));
			header('Content-Length: ' . filesize($filepath));
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			readfile($filepath);
			exit;
		}
	
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$id);
		
		$count = Problem::model()->count($criteria);
		
		$pages = new CPagination($count);
		$pages->pageSize = 10;
		$pages->currentPage = $page;
		$pages->applyLimit($criteria);
		
		$table = Problem::tableName();
		$joinTable;
		if ($model->type == Problem::MULTIPLE_CHOICE){
			$joinTable = 'problemChoice';
		} else if ($model->type == Problem::SHORT_ANSWER){
			$joinTable = 'problemShort';
		} else { //Problem::ESSAY
			$joinTable = 'problemEssay';
		}
		$criteria->with = $joinTable;
		$listProblem = Problem::model()->findAll($criteria);
		$this->render('viewContestProblem', array(
			'listProblem' => $listProblem,
			'page' => $page,
			'pagination' => $pages,
			'model' =>$model
		));
	}

	/**
	 * Creates a new model.
	 * In successful validation and saving the record,
	 * this function will create the problem instance for this contest too.
	 */
	public function actionCreate()
	{
		$this->active = 'create';
		
		$model=new ContestForm;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['ContestForm']))
		{
			$newContest = new Contest;
			$model->attributes=$_POST['ContestForm'];
			//kalo ini dihapus kenapa gak jalan ya???
			//sepertinya $model->attributes = nya bermasalah. konda.
			$model->problemCount = $_POST['ContestForm']['problemCount']; 
			$model->type = $_POST['ContestForm']['type'];
			//foreach($_POST['ContestForm'] as $key=>$values){
			//	echo $key." ".$values."<br>";
			//}
			if ($model->validate()) {
				$newContest->attributes = $model->attributes;
				$newContest->start_time = Utilities::formattedDateToTimestamp($model->start_time);		
				$newContest->end_time = Utilities::formattedDateToTimestamp($model->end_time);
				$newContest->type = $model->type;
				//die($newContest->type);
				if($newContest->validate() && $newContest->save()) {
					$newContest->createProblemInstance($model->problemCount,$newContest);
					$this->redirect(array('index'));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'controllerAction'=>'create',
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{	
		$model=new ContestForm;
		$contestModel = Contest::model()->findByPk($id);
		if ($contestModel == null){ //no such contest
			throw new CHttpException(404,"Kontes tidak ditemukan.");
		}
		
		$model->attributes = $contestModel->attributes;
		$model->start_time = Utilities::timestampToFormattedDate($contestModel->start_time);
		$model->end_time = Utilities::timestampToFormattedDate($contestModel->end_time);
		
		$userList = $contestModel->users;
		$userSearchList = new CActiveDataProvider('User', array(
			'criteria' => array(
				'condition' => 'id=0',
			),
		));
		
		if(isset($_GET['userKey'])) {
			$userCriteria = new CDbCriteria;
			$userCriteria->condition = "username LIKE :key OR fullname LIKE :key OR school LIKE :key";
			$userCriteria->params = array(":key" => "%" . $_GET["userKey"] . "%");
			
			$userSearchList = new CActiveDataProvider('User', array(
				'criteria' => $userCriteria,
				'pagination' => array(
					'pageSize' => 15,
				)
			));
		}

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ContestForm']))
		{
			foreach($_POST['ContestForm'] as $key=>$value){
				if ($key != 'start_time' && $key != 'end_time')
					$contestModel->setAttributes($key,$value);
			}
			$contestModel->start_time = Utilities::formattedDateToTimestamp($_POST['ContestForm']['start_time']);
			$contestModel->end_time = Utilities::formattedDateToTimestamp($_POST['ContestForm']['end_time']);
			
			if($contestModel->save())
				$this->redirect(array('view','id'=>$contestModel->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'userList'=>$userList,
			'contestId' => $id,
			'userSearchList'=>$userSearchList,
			'controllerAction'=>'update',
		));
	}
	
	/**
	 * update contestant in contest
	 */
	public function actionContestant($id){
		$model = $this->loadModel($id);
		if ($model == null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}
		$contestUserList = ContestUser::model()->with('user')->findAll('contest_id=:contest_id',array('contest_id'=>$id));
		$userSearchList = new CActiveDataProvider('User', array(
			'criteria' => array(
				'condition' => 'id=0',
			),
		));
		
		if(isset($_GET['userKey'])) {
			$userCriteria = new CDbCriteria;
			$userCriteria->condition = "username LIKE :key OR fullname LIKE :key OR school LIKE :key";
			$userCriteria->params = array(":key" => "%" . $_GET["userKey"] . "%");
			
			$userSearchList = new CActiveDataProvider('User', array(
				'criteria' => $userCriteria,
				'pagination' => array(
					'pageSize' => 15,
				)
			));
		}
		$this->render('contestant',array(
			'model'=>$model,
			'contestUserList'=>$contestUserList,
			'userSearchList'=>$userSearchList,
			'controllerAction'=>'update',
		));
	}
	/**
	 * @param integer id the contest id
	 */
	public function actionScoring($id){
		$model = $this->loadModel($id);
		if ($model == null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}
		$listProblem = $model->getAllProblem();
		if (isset($_POST['Problem'])){
			foreach($listProblem as $i=>$problem){
				foreach($_POST['Problem'][$i] as $key=>$value){
					$problem->setAttribute($key,$value);
				}
				$problem->save();
			}
		}
		$this->render('scoring',array(
			'model'=>$model,
			'listProblem'=>$listProblem,
			));

	}
	/**
	 * Update problems belong to this Contest
	 * 
	 * @param unknown $id
	 */
	public function actionUpdateContestProblem($id, $page = 0) {
		$contest = $this->loadModel($id);
		if ($contest==null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}

		if(!Self::userAuthenticated($id)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		if(isset($_GET['renderImage'])) {
			ob_clean();
			$filename = $_GET['renderImage'];
			$filepath = Utilities::getUploadedImagePath() . $_GET['renderImage'];
			header('Content-Type: '. CFileHelper::getMimeType($filepath));
			header('Content-Length: ' . filesize($filepath));
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			readfile($filepath);
			exit;
		}

		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$id);
		
		$count = Problem::model()->count($criteria);
		
		$pages = new CPagination($count);
		$pages->pageSize = 5;
		$pages->currentPage = $page;
		$pages->applyLimit($criteria);
		
		//cari mau di join sama tabel mana
		$childModelName;
		switch ($contest->type) {
			case Problem::MULTIPLE_CHOICE:
				$criteria->with = 'problemChoice';
				$childModelName = 'ProblemChoice';
				break;
			case Problem::SHORT_ANSWER:
				$criteria->with = 'problemShort';
				$childModelName = 'ProblemShort';
				break;
			case Problem::ESSAY:
				$criteria->with = 'problemEssay';
				$childModelName = 'ProblemEssay';
				break;
			default:
				# code...
				break;
		}
		$listProblemData = Problem::model()->findAll($criteria);
		
		if(isset($_POST['Problem'])) {
			foreach($listProblemData as $i=>$problem) {
				if(isset($_POST['Problem'][$i])) {
					foreach($_POST['Problem'][$i] as $key=>$value){
						$problem->setAttribute($key,$value);
					}
					$problem->save();
				}
				//save the child
				switch($contest->type){
					case Problem::MULTIPLE_CHOICE:
						if(isset($_POST['ProblemChoice'][$i])){
							foreach($_POST['ProblemChoice'][$i] as $key=>$value){
								$problem->problemChoice->setAttribute($key,$value);
							}
							$problem->problemChoice->save();
						}
						break;
					case Problem::SHORT_ANSWER:
						if (isset($_POST['ProblemShort'][$i])){
							foreach($_POST['ProblemShort'][$i] as $key=>$value){
								$problem->problemShort->setAttribute($key,$value);
							}
							$problem->problemShort->save();
						}
						
						break;
					case Problem::ESSAY:
						if (isset($_POST['ProblemEssay'][$i])){
							foreach($_POST['ProblemEssay'][$i] as $key=>$value){
								$problem->problemEssay->setAttribute($key,$value);
							}
							$problem->problemEssay->save();
						}
						
						break;
					default:
						# code...
						break;
				}

			}
		}
		
		$this->render('updateContestProblem', array('listProblemData'=>$listProblemData, 'model'=>$contest, 'page'=>$page, 'pagination'=>$pages,'controllerAction'=>'updateContestProblem'));
	}
	
	public function actionRank($id) {
		if(!Self::userAuthenticated($id)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		$this->active = "view";
		
		$contest = Contest::model()->findByPk($id);
		
		$criteria = new CDbCriteria;
		$criteria->condition = "contest_id=" . $id;
		$criteria->order = "score DESC";
		
		$rankList = new CActiveDataProvider('ContestSubmission', array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize'=>30,
			)
		));
		
		$this->render('rank', array(
			'contest'=>$contest,
			'rankList'=>$rankList,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(!Self::userAuthenticated($id)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		$this->loadModel($id)->delete();
		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->active = 'index';
		$criteria = new CDbCriteria;
		
		if(isset($_GET['filter'])) {
			$criteria->addCondition("title LIKE " . "'%" . $_GET['filter'] . "%'");
		}
		
		$dataProvider=new CActiveDataProvider('Contest', array(
			'pagination' => array(
				'pageSize' => 20,
			),
			'criteria' => $criteria,
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Return list of contest submission 
	 */

	public function actionGrading($id)
	{
		$model = $this->loadModel($id);
		if ($model == null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}
		$problemList = Contest::model()->getAllProblem($id);


	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contest the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contest::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contest $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contest-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionRemoveContestant($userId, $contestId) {
		if(!Self::userAuthenticated($contestId)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		Contest::model()->findByPk($contestId)->removeFromContest($userId);
		$this->redirect(array('contestant', 'id'=>$contestId));
	}
	
	public function actionAddContestant($userId, $contestId) {
		if(!Self::userAuthenticated($contestId)) {
			throw new CHttpException(403, "Anda tidak terauntentikasi untuk mengakses data ini.");
		}
		
		Contest::model()->findByPk($contestId)->addToContest($userId);
		$this->redirect(array('contestant', 'id'=>$contestId));
	}

	
}
