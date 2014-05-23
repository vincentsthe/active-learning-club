<?php

/**
 * This is the model class for table "contest".
 *
 * The followings are the available columns in table 'contest':
 * @property integer $id
 * @property string $title
 * @property string $start_time
 * @property string $end_time
 * @property integer $duration
 * @property integer $correct_score
 * @property integer $wrong_score
 * @property integer $bidang
 * @property string $description
 * @property string $sifat
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Bidang $bidang0
 * @property ContestAnnouncement[] $contestAnnouncements
 * @property ContestSubmission[] $contestSubmissions
 * @property User[] $users
 * @property Image[] $images
 * @property Problem[] $problems
 */
class Contest extends CActiveRecord
{
	const NOT_REGISTERED = -2; //belum register
	const NOT_APPROVED = -1; //udah daftar, belum di ACC sama admin
	const NOT_STARTED = 0; //kontes belum dimulai
	const NOT_WORKED = 1; //kontes sudah dimulai, belum dikerjakan
	const WORKED = 2; // kontes sedang dikerjakan
	const TIME_UP = 3; // waktu pengerjaan sudah habis
	const ENDED = 4; //kontes telah berkahir

	const OPEN = 0;
	const CLOSED = 1;
	const CONDITIONAL = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, start_time, end_time, duration, correct_score, wrong_score, bidang, description, sifat', 'required'),
			array('duration, correct_score, wrong_score, bidang', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>127),
			array('start_time, end_time', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, start_time, end_time, duration, correct_score, wrong_score, bidang, description, sifat', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'contestAnnouncements' => array(self::HAS_MANY, 'ContestAnnouncement', 'contest_id'),
			'contestSubmissions' => array(self::HAS_MANY, 'ContestSubmission', 'contest_id'),
			'contestUsers' => array(self::HAS_MANY,'ContestUser','contest_id'),
			'users' => array(self::MANY_MANY, 'User', 'contest_user(contest_id, user_id)'),
			'problems' => array(self::HAS_MANY, 'Problem', 'contest_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'duration' => 'Duration',
			'correct_score' => 'Correct Score',
			'wrong_score' => 'Wrong Score',
			'bidang' => 'Bidang',
			'description' => 'Description',
			'type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('correct_score',$this->correct_score);
		$criteria->compare('wrong_score',$this->wrong_score);
		$criteria->compare('bidang',$this->bidang);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * This function create problem instance for this contest
	 * as many as $problemCount
	 * @param int $problemCount Number of problem instance to be created.
	 * @param CActiveRecord $contest contest model
	 * @return boolean true if succesfully maded.
	 */
	public function createProblemInstance($problemCount,$contest) {
		$problemType = $contest->type;
		for($i=0 ; $i<$problemCount ; $i++) {
			//echo $i; continue;
			$newProblem = new Problem;
			$newProblem->contest_id = $this->id;
			$newProblem->type = $problemType;
			$newProblem->save();

			$problemExt;
			if ($problemType == Problem::SHORT_ANSWER){
				//short answer
				$problemExt = new ProblemShort;
			} else if ($problemType == Problem::ESSAY){
				//essay
				$problemExt = new ProblemEssay;
			} else {
				//default to choice.
				$problemExt = new ProblemChoice;
			}
			$problemExt->id = $newProblem->id;
			$problemExt->save();
		}
		return true;
	}

	/* Delete all problem instance belong to this contest
	 * after deleting the contest.
	 * 
	 * @see CActiveRecord::beforeDelete()
	 */
	protected function beforeDelete(){
		$criteria = new CDbCriteria();
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$this->id);
		
		$listProblem = Problem::model()->findAll($criteria);
		foreach($listProblem as $problem) {
			$problem->delete();
		}

		$listContestUser = ContestUser::model()->findAll($criteria);
		foreach($listContestUser as $contestUser){
			$contestUser->delete();
		}

		$listAnnouncement = ContestAnnouncement::model()->findAll($criteria);
		foreach($listAnnouncement as $announcement){
			$announcement->delete();
		}
		
		$listContestSubmission = ContestSubmission::model()->findAll($criteria);
		foreach($listContestSubmission as $contestSubmission){
			$contestSubmission->delete();
		}

		return Parent::beforeDelete();
	}

	/**
	 * Get all problem instance belong to this contest.
	 * 
	 * @return CActiveRecord all problem belong to this contest
	 */
	public function getAllProblem() {
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id';
		$criteria->params = array('contest_id'=>$this->id);
		
		return Problem::model()->findAll($criteria);
	}
	
	/**
	 * menambahkan kontestan ke kontes. update isi ContestUser
	 * @param $userId id dari user yang ingin ditambahkan.
	 */
	public function addToContest($userId) {
		$register = new ContestUser;
		$register->contest_id = $this->id;
		$register->user_id = $userId;
		
		$criteria = new CDbCriteria;
		$criteria->condition = "contest_id=:contest_id AND user_id=:user_id";
		$criteria->params = array('contest_id' => $this->id, 'user_id' => $userId);
		
		$existing = ContestUser::model()->find($criteria);
		
		if($existing == null) {
			$register->save();
		}
	}
	
	/**
	 * menghapus kontestan dari kontes. update isi ContestUser.
	 * @param $userId id dari user yang dihapus
	 */
	public function removeFromContest($userId) {
		$criteria = new CDbCriteria;
		$criteria->condition = "contest_id=:contest_id AND user_id=:user_id";
		$criteria->params = array('contest_id' => $this->id, 'user_id' => $userId);
		
		$register = ContestUser::model()->find($criteria);
		if($register != null) {
			$register->delete();
		}
	}

	/**
	 * menentukan status pengerjaan kontes dari user yang login.
	 * @return string
	 */
	public function contestStatus(){
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id AND user_id=:user_id';
		$criteria->params = array('contest_id'=>$this->id,'user_id'=>Yii::app()->user->id);
		$contestUserModel = ContestUser::model()->find($criteria);
		$contestStartTime = $this->start_time;
		$contestEndTime = $this->end_time;
		$currentTime = time();
		$csModel = ContestSubmission::model()->find($criteria);

		if ($contestUserModel == null){ 
			//tidak terdaftar.
			return Self::NOT_REGISTERED;
		} else if ($contestEndTime < $currentTime){ 
			//sudah selesai
			return Self::ENDED;
		} else if (!$contestUserModel->approved){
			//belum di ACC
			return Self::NOT_APPROVED;
		} else {
			if ($currentTime < $contestStartTime){
				//udah daftar, belum mulai
				return Self::NOT_STARTED;
			} else if($csModel == null){
				//udah daftar, belum kerja
				return Self::NOT_WORKED;
			} else if ($currentTime < $csModel->end_time){
				//udah daftar, sudah kerja, waktu masih ada
				return Self::WORKED;
			} else {
				//udah daftar, sudah kerja, waktu udah habis
				return Self::TIME_UP;
			}
		}
	}

	public static function contestStatusMessage($status){
		switch ($status) {
			case Self::NOT_REGISTERED:
				return "Anda tidak/belum mendaftar.";
				break;
			case Self::NOT_APPROVED:
				return "Silakan lengkapi syarat administrasi.";
				break;
			case Self::NOT_STARTED:
				return "Kontes belum dimulai.";
				break;
			case Self::NOT_WORKED:
				return "Anda bisa mulai mengerjakan kontes ini.";
				break;
			case Self::TIME_UP:
				return "Waktu pengerjaan sudah habis. Silakan tunggu sampai kontes berakhir.";
				break;
			case Self::WORKED:
				return "Silakan lanjutkan kontes sampai waktu habis.";
				break;
			case Self::ENDED:
				return "Kontes telah berakhir.";
				break;
			default:
				# code...
				break;
		}
	}

	/**
	 * cek apakah sifat kontes terbuka.
	 * @return boolean
	 */
	public function isOpen(){
		return Self::OPEN == $this->sifat;
	}

	/**
	 * cek apakah sifat kontes tertutup
	 * @return boolean
	 */
	public function isClosed(){
		return Self::CLOSED == $this->sifat;
	}

	/**
	 * cek apakah sifat kontes kondisional (tertutup namun boleh mendaftar)
	 * @return boolean
	 */
	public function isConditional(){
		return Self::CONDITIONAL == $this->sifat;
	}

}
