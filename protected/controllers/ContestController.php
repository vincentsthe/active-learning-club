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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->active = 'contest/index';
		$model = $this->loadModel($id);
		$contestSubModel = ContestSubmission::model()->getCurrentUserModel($id);
		$contestStatus = $model->contestStatus();
		$contestantList = ContestUser::model()->with('user')->findAll("contest_id=$id");
		
		
		$this->render('view',array(
			'model'=>$model,
			'contestantList' => $contestantList,
			'contestStatus' => $contestStatus,
			'contestSubModel' => $contestSubModel,
		));
	}
	
	/**
	 * mengerjakan problem
	 * @param id number contest_id
	 */
	/*
	public function actionProblem($id) {
		if (!Self::userAuthenticated($id)){
			$this->redirect(array('view','id'=>$id));
		}

		$contestSubModel = ContestSubmission::getCurrentUserModel($id);
		$contestSubId = $contestSubModel->id;
		$this->active = 'problem';
		$model = Contest::model()->findByPk($id);
		$criteria = new CDbCriteria;
		// join the problem and submission table 
		
		//$criteria->condition = 'contest_id=:contest_id';
		//$criteria->params = array('contest_id'=>$id,);
		//$tblProblem = Problem::tableName(); $tblSubmission = Submission::tableName();
		//$criteria->select = array('id',$tblSubmission.'.answer AS answer');
		//$criteria->join = 'JOIN '.$tblSubmission.' ON '.$tblProblem.'.id='.$tblSubmission.'.problem_id AND contest_id='.$id;
		$problemIdList = Problem::model()->findAllBySql(
			"SELECT `problem`.`id`,`problem`.`type`,`submission`.`answer` 
			FROM `problem` LEFT OUTER JOIN `submission` ON `problem`.`id`=`submission`.`problem_id` AND `contest_submission_id`=$contestSubId
			WHERE `problem`.`contest_id`=$id");
		
		$this->render('problem', array(
			'model' =>$model,
			'problemIdList'=>$problemIdList,
			'contestSubId'=>$contestSubId,
			'endTime'=>$contestSubModel->end_time,
		));
	}*/

	/**
	 * memulai kontes.
	 * create contest submission jika belum ada
	 * create submission untuk seluruh soal
	 * @param integer $id the ID of contest
	 */
	public function actionStart($id){
		//dijamin pasti ada
		$contestModel = $this->loadModel($id);
		$contestSubmission = ContestSubmission::getCurrentUserModel($id);

		$contestStatus = $contestModel->contestStatus();

		if ($contestSubmission == null){ //pertama kali register
			$contestSubmission = new ContestSubmission;
			$timeNow = time() + 0;
			$startTime = $timeNow;
			$endTime = min($contestModel->end_time,$startTime + $contestModel->duration * 60);

			$contestSubmission->contest_id = $id;
			$contestSubmission->user_id = Yii::app()->user->id;
			$contestSubmission->started = 1;
			$contestSubmission->start_time = $startTime;
			$contestSubmission->end_time = $endTime;
			$contestSubmission->save();
			$contestSubmission->generateSubmissions($contestSubmission);
		}
		$this->redirect(array('news','id'=>$id));

	}

	/**
	 * view scoreboard
	 * @param id the contest idnumber
     */
	public function actionScoreboard($id){
		
		$this->active="scoreboard";
		if (!isset($id)){
			throw new CHttpException(404,"Halaman tidak ditemukan");
		}
		if (!Self::userAuthenticated($id)){
			$this->redirect(array('view','id'=>$id));
		}
		//$criteria = new CDbCriteria; $criteria->with = array('contestSubmissions'=>array('condition'=>"contest_id=$id")); $criteria->together = true;
		//Coba pake data provider: ternyata jalan.
		//$dataProvider = User::model()->with(array('contestSubmissions'=>array('condition'=>"contest_id=$id")))->together()->findAll();
		// $dataProvider = new CActiveDataProvider('User',array(
		// 	'pagination' => array(
		// 		'pageSize' => 20,
		// 	),
		// 	'criteria'=>$criteria,
		// ));
		$criteria = new CDbCriteria; 
		$criteria->with = 'user'; $criteria->together = true;
		$criteria->condition = "contest_id=$id";
		$dataProvider = new CActiveDataProvider('ContestSubmission',array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'Nama'=>array(
						'asc'=>'fullname',
						'desc'=>'fullname DESC',
						),
					'sekolah'=>array(
						'asc'=>'school',
						'desc'=>'school desc',
						),
					'*',
					),
				),
		));
		// foreach($dataProvider as $key=>$value){

		// 	echo $value->id." ";
		// 	foreach($value->contestSubmissions as $contestSubmission){
		// 		echo $contestSubmission->id." ";
		// 	}
		// 	echo "<br>";
		// }
		$contestModel = Contest::model()->findByPk($id);
		$this->render('scoreboard',array(
			'dataProvider'=>$dataProvider,
			'id'=>$id,
			'model'=>$contestModel,
		));
		/*
		//line in backup. jangan dihapus, in case yang data provider gak jalan
		$command=Yii::app()->db->createCommand("SELECT DISTINCT 
												`user`.`username` AS `username`,`user`.`fullname` AS `name`,`user`.`school` AS `school`,`contest_submission`.`score` AS `score`
												FROM `user` INNER JOIN `contest_submission`
												ON `user`.`id`=`contest_submission`.`user_id` AND `contest_submission`.`contest_id`=$id");
		$listContestant = $command->queryAll();
		$model = $this->loadModel($id);
		$this->render('scoreboard',array(
			'model'=>$model,
			'listContestant'=>$listContestant,
			'id'=>$id,
			));
		*/
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
			$this->render('teacher/index',array(
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
	 * melihat pembahasan kontes
	 * @param id contest id
	 */
	public function actionViewDiscussion($id){
		$model = $this->loadModel($id);
		if ($model === null){
			throw new CHttpException(404,"Contest not found");
		}
		$criteria = new CDbCriteria;
		$criteria->select = 'id';
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$id);
		$problemIdList = Problem::model()->findAll($criteria);
		$timeLeft = $model->end_time - time();
		if ($timeLeft > 0){
			throw new CHttpException(403,"Wait until contest is over");
		}
		$this->render('discussion/view',
			array(
				'problemIdList'=>$problemIdList,
				'model'=>$model
				)
			);

	}

	/**
	 * List all announcement
	 * @param id the contest id number
	 */
	public function actionNews($id){
		Yii::app()->session['view_as'] = User::CONTESTANT;
		$criteria = new CDbCriteria;
		$criteria->condition = "contest_id=:contest_id";
		$criteria->params = array('contest_id'=>$id,);

		$listAnnouncement = ContestAnnouncement::model()->findAll($criteria);
		$model = $this->loadModel($id);
		$this->render('news',array(
			'model'=>$model,
			'listAnnouncement'=>$listAnnouncement,
			'id'=>$id,
			));
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
	 * Register the user. insert a record into ContestUser schema
	 * @param id contest_id
	 */
	public function actionRegister($id){
		$model = $this->loadModel($id);

		if (!ContestUser::model()->exists('contest_id=:contest_id AND user_id=:user_id',array('contest_id'=>$id,'user_id'=>Yii::app()->user->id))){
			$contestUser = new ContestUser;
			$contestUser->user_id = Yii::app()->user->id;
			$contestUser->contest_id = $id;
			if ($model->isOpen()){
				$contestUser->approved = 1;
			} else {
				$contestUser->approved = 0;
			}
			//echo $contestUser->user_id;
			//echo $contestUser->contest_id;
			//echo $contestUser->approved;
			//die("now");
			$retval = $contestUser->save();
			if($model->type == "essay") {
				mkdir(Utilities::getEssaySubmissionPath() . $id . "/" . Yii::app()->user->id);
			}
		}
		$this->redirect(array('view','id'=>$id));
	}

	public function actionProblem($id){
		$model = $this->loadModel($id);
		$this->topBarActive = "contest/problem";
		if ($model === null){
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
		
		$fileForm = new FileForm;
		
		$problemList = $model->getAllProblem();
		$contestSubModel = ContestSubmission::model()->getCurrentUserModel($id);
		$submissions = $contestSubModel->getAllSubmissionIndexed();
		$this->render('contestant/problem', array(
			'problemList'=>$problemList,
			'model' =>$model,
			'numberOfProblems'=>count($problemList),
			'contestSubModel'=>$contestSubModel,
			'submissions'=>$submissions,
			'fileForm'=>$fileForm,
		));
	}

	public function actionLoadDiscussionWithAjax($id,$pId){
		$contestId = $id;
		$problemId = $pId;
		$problemModel = Problem::model()->findByPk($pId);
		$this->renderPartial('discussion/_view',array(
			'problem'=>$problemModel,
		));
	}
	public function actionLoadProblemWithAjax($c,$p = 0,$i = 0){
		$contestId = $c;
		$problemId = $p;
		$indexNo = $i;
		if ($problemId != 0){
		 	$joinTable;
		 	$problem = Problem::model()->findByPk($problemId);
		 	switch ($problem->type) {
		 		case Problem::MULTIPLE_CHOICE:
		 			$joinTable = 'problemChoice';
		 			break;
		 		case Problem::SHORT_ANSWER:
					$joinTable = 'problemShort';
					break;
				case Problem::ESSAY:
					$joinTable = 'problemEssay';
					break;
				default:
					# code...
					break;
		 	}
		 	$problem = Problem::model()->with($joinTable)->findByPk($problemId);
		 	if ($problem->contest_id == $contestId){
		 		$this->renderPartial('contestant/_loadProblemGeneral',array('problem'=>$problem,'indexNo'=>$indexNo));
		 	}
		}
	}
	public function actionSubmitAnswerWithAjax($contestSubId){
		if (isset($_POST['Answer'])){
			$criteria = new CDbCriteria;

			foreach ($_POST['Answer'] as $problemId=>$answer){

				echo $problemId;
				if (isset($answer['answer'])){
					$problemAnswer = $answer['answer'];
					$criteria->condition = 'contest_submission_id=:contest_submission_id AND problem_id=:problem_id';
					$criteria->params = array('contest_submission_id'=>$contestSubId,'problem_id'=>$problemId);
					
					$submission = Submission::model()->find($criteria);

					if ($submission !== null){
						$submission->answer = $problemAnswer;
					} else {
						$submission = new Submission;
						$submission->problem_id = $problemId;
						$submission->contest_submission_id = $contestSubId;
						$submission->answer = $problemAnswer;
					}

					$submission->save();

				}
				
			}
		}
	}
	/**
	 * return the problem model in JSON
	 */
	public function actionLoadProblem(){
		$problemId = $_POST['pid']; //$_POST['pid']; //cara ngedebug, ganti $_POST jadi suatu problem_id
		//$problemId = 52;
		$problem = Problem::model()->findByPk($problemId);
		$joinTable;
		switch ($problem->type) {
			case Problem::MULTIPLE_CHOICE:
				$joinTable = 'problemChoice';
				break;
			case Problem::SHORT_ANSWER:
				$joinTable = 'problemShort';
			case Problem::ESSAY:
				$joinTable = 'problemEssay';
			default:
				# code...
				break;
		}
		$problem = Problem::model()->with($joinTable)->findByPk($problemId);
		echo json_encode($problem->convertToArray());
	}
	// /**
	//  * 
	//  */
	// public function actionSubmitAnswer(){
	// 	$problemId = $_POST['pid'];
	// 	$contestSubId = $_POST['contestSubId'];
	// 	$answer = $_POST['value'];
	// 	//echo json_encode($_POST);
	// 	//debug code. jangan dihapus. gw suka kelupaan.
	// 	//$problemId = 52;
	// 	//$contestSubId = 35;
	// 	//$answer = 1;
	// 	if ($contestSubId != null){
	// 		$model = Submission::model()->find('problem_id=:pid AND contest_submission_id=:csid',array('pid'=>$problemId,'csid'=>$contestSubId));	
	// 		if ($model == null){
	// 			$model = new Submission;
	// 			$model->problem_id = $problemId;
	// 			$model->contest_submission_id  = $contestSubId;
	// 			$model->answer = $answer;
	// 			$model->save();
	// 		} else {
	// 			$model->answer = $answer;
	// 			$model->save();
	// 		}
			
	// 		//$model->save();
	// 		echo json_encode(array('ok'));
	// 		//echo json_encode(array('result'=>$model->save()));
	// 	}
	// }

	/**
	 * return the administrator status of logged in user
	 * @return boolean 
	 */
	public function isAdmin(){
		return Yii::app()->user->isAdmin;
	}
	
	public function actionSubmitEssay($contestId, $userId, $problemId) {
		if(isset($_POST['FileForm'])) {
			$fileForm = new FileForm;
			
			$fileForm->attributes = $_POST['FileForm'];
			$fileForm->file = CUploadedFile::getInstance($fileForm, 'file');
			$name = $fileForm->file->getName();
			
			if($fileForm->file->getSize() > 2.5 * 1024 *1024) {
				Yii::app()->user->setFlash('error', 'Ukuran file terlalu besar.');
			} else if($fileForm->validate()) {
				if(!file_exists(Utilities::getEssaySubmissionPath() . $contestId . "/" . $userId . "/" . $problemId)) {
					mkdir(Utilities::getEssaySubmissionPath() . $contestId . "/" . $userId . "/" . $problemId);
				}
				
				$criteria = new CDbCriteria;
				$criteria->condition = "contest_id=" . $contestId . " AND user_id=" . $userId;
				$criteria->params = array('contest_id'=>$contestId, 'user_id'=>$userId);
				$contestSubmission = ContestSubmission::model()->find($criteria);
				
				$subCriteria = new CDbCriteria;
				$subCriteria->condition = "problem_id=:problem_id AND contest_submission_id=:contest_submission_id";
				$subCriteria->params = array("problem_id"=>$problemId, "contest_submission_id"=>$contestSubmission->id);
				$submission = Submission::model()->find($subCriteria);
				
				if($submission->answer != null) {
					unlink(Utilities::getEssaySubmissionPath() . $contestId . "/" . $userId . "/" . $problemId . "/" . $problem->answer);
				}
				
				$fileForm->file->saveAs(Utilities::getEssaySubmissionPath() . $contestId . "/" . $userId . "/" . $problemId . "/" . "$name");
				
				$submission->answer = $name;
				$submission->save();
				
				Yii::app()->user->setFlash('success', 'File berhasil diupload.');
			} else {
				Yii::app()->user->setFlash('error', 'File gagal diupload.');
			}
		}
		
		$this->redirect(array("problem", "id"=>$contestId));
	}
	
	public function actionDownloadAnswer($contestId, $userId, $problemId) {
		$criteria = new CDbCriteria;
		$criteria->condition = "contest_id=" . $contestId . " AND user_id=" . $userId;
		$criteria->params = array('contest_id'=>$contestId, 'user_id'=>$userId);
		$contestSubmission = ContestSubmission::model()->find($criteria);
		
		$subCriteria = new CDbCriteria;
		$subCriteria->condition = "problem_id=:problem_id AND contest_submission_id=:contest_submission_id";
		$subCriteria->params = array("problem_id"=>$problemId, "contest_submission_id"=>$contestSubmission->id);
		$submission = Submission::model()->find($subCriteria);
		
		header('Content-Disposition: attachment; filename="' . $submission->answer . '"');
		readfile(Utilities::getEssaySubmissionPath() . $contestId . "/" . $userId . "/" . $problemId . "/" . $submission->answer);
	}

	/**
	 * cek apakah contest terbuka untuk register
	 */
	public function isOpenForRegister(){
		if (isset($_GET['id']) && $_GET['id'] > 0){
			$model = Contest::model()->findByPk($_GET['id']);
			return $model->isOpen() || $model->isConditional();
		} else {
			return false;
		}
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
	/**
	 * cek apakah user boleh mengikuti kontes
	 */
	public function isApprovedContestant(){
		if (isset($_GET['id'])){
			return ContestUser::isCurrentUserRegistered($_GET['id']);
		} else {
			return false;
		}
		
	}
	
}
