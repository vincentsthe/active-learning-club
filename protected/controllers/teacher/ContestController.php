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
	public $active;
	/**
	 * @var string the current active in top menu (home/about us/kontak)
	 */
	public $topBarActive = 'home';

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
			//hak-hak umum
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			//hak khusus untuk admin : boleh melakukan apapun
			array('allow',
				'actions'=>array('register','delete','view','create','update','scoring','grading','contestant','updateContestProblem','viewContestProblem', 'removeContestant', 'addContestant','grading','image'),
				'users'=>array('@'),
				'expression'=>array('ContestController','isAdmin'),
			),
			//open dan conditional contest: user manapunboleh mendaftar
			array('allow',
				'actions'=>array('register'),
				'users'=>array('@'),
				'expression'=>array('ContestController','isOpenForRegister'),
			),
			//hanya approved teacher yang boleh melakukan
			array('allow',
				'actions'=>array('delete','update','scoring','grading','contestant','removeContestantWithAjax','updateDiscussion','updateContestProblem','viewContestProblem','removeContestant','addContestant','approveContestantWithAjax','grading','image','removeContestSubmission','gradeSubmission'),
				'users'=>array('@'),
				'expression'=>array('ContestController','isApprovedTeacher'),
			),
			//kontestan dan manager yang approved yang boleh melakukan
			array('allow',
				'actions'=>array('start','news','problem','scoreboard','image','submitEssay'),
				'actions'=>array('start','news','problem','scoreboard','image','viewDiscussion','loadDiscussionWithAjax','submitEssay'),
				'users'=>array('@'),
				'expression'=>array('ContestController','isApprovedContestant'),
			),
			//dua ini gw special case karena males banget (pake jquery dia)
			//bisa jadi loophole security (misal kebanyakan diklik. tapi enggak lah ya)
			array('allow',
				'actions'=>array('submitAnswerWithAjax','loadProblemWithAjax','loadProblem','submitAnswer','image','submitEssay','downloadAnswer'),
				'users'=>array('@'),
			),
			//hanya apporved
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($id = 0)
	{
		//die($id);
		$this->active = 'contest/index';
		$filter = array();
		$bidang = Bidang::findAllBidang();
		/*
			foreach($bidang as $key=>$nama){
		$filter['bidang'][$key]['nama'] = $nama;
		$filter['bidang'][$key]['checked'] = 1;
		}*/
		$criteria = new CDbCriteria;
	
		if(isset($_POST['filter'])){
			foreach($_POST['filter'] as $key=>$value){
				if ($key == 'title'){
					$criteria->addCondition("title LIKE " . "'%" . $value . "%'");
				} else if ($key == 'bidang' && $value != 0){
					$criteria->addCondition("bidang = $value");
				}
			}
			//die("here")
		}
		if (Yii::app()->user->isAdmin || Yii::app()->user->isTeacher){ //use manager logic.
			$dataProvider=new CActiveDataProvider('Contest', array(
					'pagination' => array(
							'pageSize' => 20,
					),
					'criteria' => $criteria,
			));
			$this->render('index',array(
					'dataProvider'=>$dataProvider,
					'listBidang'=>$bidang,
					'filter'=>$filter,
			));
		} else { // use contestant logic
			/* if id  = 0, list pages */
			if ($id == 0){
				$listContest = Contest::model()->findAll($criteria);
				$this->render('contestant/index',array(
						'listContest'=>$listContest,
						'listBidang'=>$bidang,
						'filter'=>$filter,
				));
			} else { /* render the announcement */
				$this->redirect(array('news','id'=>$id));
			}
		}
			
	}
	
	/**
	 * Creates a new model.
	 * In successful validation and saving the record,
	 * this function will create the problem instance for this contest too.
	 */
	public function actionCreate()
	{
		$this->active = 'contest/create';
		$this->topBarActive = 'home';
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
	
			if($newContest->validate() && $newContest->save()) {
			if($newContest->type == "essay") {
			mkdir(Utilities::getEssaySubmissionPath() . $newContest->id);
			}
				
			//insert the current creator into ContestUserSchema
			$contestUserModel = new ContestUser;
			$contestUserModel->user_id = Yii::app()->user->id;
			$contestUserModel->contest_id = $newContest->id;
			$contestUserModel->approved = true;
			$contestUserModel->save();
				
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		//ubah mode ke manager
		Yii::app()->session['view_as'] = User::TEACHER;
		//die(Yii::app()->user->viewAs." hello");
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
			$contestModel->sifat = $_POST['ContestForm']['sifat'];
			if($contestModel->save()){
				$this->redirect(array('view','id'=>$contestModel->id));
			}
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
	 * Return list of contest submission
	 */
	public function actionGrading($id)
	{
		//$this->active='grading';
		$model = $this->loadModel($id);
		if ($model == null){
			throw new CHttpException(404,"Kontes tidak ditemukan");
		}
		if (isset($_POST['CheckList'])){
			foreach($_POST['CheckList'] as $contestSubId=>$checked){
				//echo $contestSubId;
				if ($checked){
					$contestSubmissionModel = ContestSubmission::model()->findByPk($contestSubId);
					$contestSubmissionModel->grade();
				}
			}
		}
		//die("here");
		$dataProvider = new CActiveDataProvider('ContestSubmission',array(
				'criteria'=>array(
						'condition'=>'contest_id=:contest_id',
						'params'=>array('contest_id'=>$id),
						'with'=>array('user'),
				),
				'pagination'=>array(
						'pageSize'=>20,
				),
				'sort'=>array(
						'attributes'=>array(
								'Username'=>array(
										'asc'=>'username',
										'desc'=>'username DESC',
								),
								'Name'=>array(
										'asc'=>'username',
										'desc'=>'username DESC',
								),
								'sekolah'=>array(
										'asc'=>'school',
										'desc'=>'school desc',
								),
								'*',
						),
				),
		));
		$this->render('grading',array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
		));
	
	}
	
	/**
	 * update contestant in contest
	 */
	public function actionContestant($id){
		$model = $this->loadModel($id);
		if ($model === null){
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
	
	public function actionRemoveContestantWithAjax($id,$userId){
		$contestUserModel = ContestUser::model()->find("contest_id=$id AND user_id=$userId");
		if ($contestUserModel !== null){
			$contestUserModel->delete();
		}
	}
	
	/**
	 * update pembahasan kontes.
	 */
	public function actionUpdateDiscussion($id,$page = 0){
		$model = $this->loadModel($id);
		if ($model === null){
			throw new CHttpException(404,"Contest not found");
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
	
		$listProblemData = Problem::model()->findAll($criteria);
	
		if(isset($_POST['Problem'])) {
			foreach($listProblemData as $i=>$problem) {
				if(isset($_POST['Problem'][$i])) {
					foreach($_POST['Problem'][$i] as $key=>$value){
						$problem->setAttribute($key,$value);
					}
					$problem->save();
				}
			}
		}
	
		$this->render('updateDiscussion', array('listProblemData'=>$listProblemData, 'model'=>$model, 'page'=>$page, 'pagination'=>$pages,'controllerAction'=>'updateDiscussion'));
	
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
		switch ($contest->type) {
			case Problem::MULTIPLE_CHOICE:
				$criteria->with = 'problemChoice';
				break;
			case Problem::SHORT_ANSWER:
				$criteria->with = 'problemShort';
				break;
			case Problem::ESSAY:
				$criteria->with = 'problemEssay';
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
	
	public function actionRemoveContestant($id, $userId) {
		Contest::model()->findByPk($id)->removeFromContest($userId);
		$this->redirect(array('contestant', 'id'=>$id));
	}
	
	/**
	 * @param int id contest id
	 * @param int userId user id
	 */
	public function actionAddContestant($id, $userId) {
		Contest::model()->findByPk($id)->addToContest($userId);
		$this->redirect(array('contestant', 'id'=>$id));
	}
	

	public function actionApproveContestantWithAjax($id){
		if (isset($_POST['ContestUser'])){
			foreach($_POST['ContestUser'] as $key=>$contestUser){
				$userId = $key;
				$contestUserModel = ContestUser::model()->find("contest_id=$id AND user_id=$userId");
				if ($contestUser['approved']){
					$contestUserModel->approveUser();
				} else {
					$contestUserModel->denyUser();
				}
			}
		}
	}
	

	public function actionImage($id)
	{
		$contest = Contest::model()->findByPk($id);
	
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
	
		$criteria->condition = "contest_id=" . $id;
	
		$dataProvider=new CActiveDataProvider('Image', array(
				'criteria'=>$criteria,
				'sort'=>array(
						'defaultOrder'=>'id DESC',
				),
				'pagination'=>array(
						'pageSize'=>20,
				)
		));
	
		$imageForm = new ImageForm;
	
		if(isset($_POST['ImageForm'])) {
			$imageForm->attributes = $_POST['ImageForm'];
			$imageForm->image = CUploadedFile::getInstance($imageForm, 'image');
	
			if($imageForm->validate()) {
				$image = new Image;
				$image->uploader = Yii::app()->user->id;
				$image->token = Utilities::generateToken(64);
				$image->name = $imageForm->image->getName();
				$image->contest_id = $id;
	
				if($image->save()) {
					$imageForm->image->saveAs(Utilities::getUploadedImagePath() . $image->token);
				} else {
					Yii::app()->user->setFlash('error', 'Terjadi error.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'File image tidak valid,');
			}
	
		}
	
		$this->render('image',array(
				'dataProvider'=>$dataProvider,
				'imageForm'=>$imageForm,
				'model'=>$contest,
		));
	}
	
	public function actionGradeSubmission($id, $contestSubId) {
		$model = $this->loadModel($id);
		if ($model === null){
			throw new CHttpException(404,"Contest not found");
		}
	
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$id);
	
		$submissionCriteria = new CDbCriteria;
		$submissionCriteria->condition = 'contest_submission_id=:contest_submission_id';
		$submissionCriteria->params = array('contest_submission_id'=>$contestSubId);
	
		$count = Problem::model()->count($criteria);
	
		$listProblem = Problem::model()->findAll($criteria);
		$listSubmission = Submission::model()->findAll($submissionCriteria);
	
		if(isset($_POST['Submission'])) {
			foreach($listSubmission as $i=>$submission) {
				if(isset($_POST['Submission'][$i])) {
					$submission->attributes = $_POST['Submission'][$i];
					$submission->save();
				}
			}
		}
	
		$this->render('gradeSubmission', array('listProblem'=>$listProblem, 'contest'=>$model, 'listSubmission'=>$listSubmission));
	
	}
	
	public function actionRemoveContestSubmission($id,$contestSubId){
		$model = ContestSubmission::model()->findByPk($contestSubId);
		if ($model!==null)
			$model->delete();
		$this->redirect(array('grading','id'=>$id));
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
	
	/**
	 * return the administrator status of logged in user
	 * @return boolean
	 */
	public function isAdmin(){
		return Yii::app()->user->isAdmin;
	}
	
	/**
	 * cek apakah current user boleh mengganti kontes.
	 */
	public function isApprovedTeacher(){
		if (isset($_GET['id'])){
			return Yii::app()->user->isAdmin || (Yii::app()->user->isTeacher && ContestUser::isCurrentUserRegistered($_GET['id']));
		} else {
			return false;
		}
	
	}
}