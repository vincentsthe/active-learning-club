<?php

/**
 * This is the model class for table "contest_submission".
 *
 * The followings are the available columns in table 'contest_submission':
 * @property integer $id
 * @property integer $contest_id
 * @property integer $user_id
 * @property integer $score
 * @property integer $correct
 * @property integer $wrong
 * @property integer $blank
 * @property integer $started
 * @property string $start_time
 * @property string $end_time
 *
 * The followings are the available model relations:
 * @property Contest $contest
 * @property User $user
 * @property Submission[] $submissions
 */
class ContestSubmission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest_submission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, user_id', 'required'),
			array('contest_id, user_id, score, correct, wrong, blank, started', 'numerical', 'integerOnly'=>true),
			array('start_time, end_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contest_id, user_id, score, correct, wrong, blank, started, start_time, end_time', 'safe', 'on'=>'search'),
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
			'contest' => array(self::BELONGS_TO, 'Contest', 'contest_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'submissions' => array(self::HAS_MANY, 'Submission', 'contest_submission_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contest_id' => 'Contest',
			'user_id' => 'User',
			'score' => 'Score',
			'correct' => 'Correct',
			'wrong' => 'Wrong',
			'blank' => 'Blank',
			'started' => 'Started',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
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
		$criteria->compare('contest_id',$this->contest_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('score',$this->score);
		$criteria->compare('correct',$this->correct);
		$criteria->compare('wrong',$this->wrong);
		$criteria->compare('blank',$this->blank);
		$criteria->compare('started',$this->started);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContestSubmission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * grade the current contest submission and save into array
	 */
	public function grade() {
		$listSubmission = $this->submissions;
		$correctAnswer = 0;
		$wrongAnswer = 0;
		$blankAnswer = 0;
		$totalScore = 0;
		
		foreach($listSubmission as $submission) {
			$problem = $submission->problem;

			if($submission->answer == null || $submission->answer==="") {
				$blankAnswer++;
				$totalScore += $problem->blank_score;
			} else if($submission->answer == $problem->answer) {
				$correctAnswer++;
				$totalScore += $correctScore;
			} else {
				$wrongAnswer++;
				$totalScore += $wrongScore;
			}
		}
		
		$this->score = $totalScore;
		$this->correct = $correctAnswer;
		$this->wrong = $wrongAnswer;
		$this->blank = $blankAnswer;
		
		$this->save();
	}

	/* Delete all problem instance belong to this contest submission
	 * before deleting the contest.
	 * 
	 * @see CActiveRecord::beforeDelete()
	 */
	protected function beforeDelete(){
		$criteria = new CDbCriteria();
		$criteria->condition = 'contest_submission_id=:contest_submission_id';
		$criteria->params = array('contest_submission_id'=>$this->id);

		$listSubmission  = Submission::model()->findAll($criteria);
		foreach($listSubmission as $submission){
			$submission->delete();
		}
		return Parent::beforeDelete();
	}

	/**
	 * return the contestSubmission based on user and contest id
	 * @param userId int the user id
	 * @param contestId int the user id
	 * @return CActiveRecord Contest Submission
	 */
	public static function getCurrentUserModel($contestId){
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id AND user_id=:user_id';
		$criteria->params = array('contest_id'=>$contestId,'user_id'=>Yii::app()->user->id);
		return ContestSubmission::model()->find($criteria);
	}
	/**
	 * get array of submissions with indexed places
	 * for example array[i] have submission with problem id = i.
	 * @return CActiveRecord Submission Model
	 */
	public function getAllSubmissionIndexed(){
		$tmp = $this->submissions;
		$submissions = array();
		foreach($tmp as $submission){
			$submissions[$submission->id] = $submission;
		}
		return $submissions;

	}

	/**
	 * generate submission for contest submission model
	 * @param CActiveRecord ContestSubmission model
	 */
	public function generateSubmissions($contestSubModel){
		$problemList = Contest::model()->getAllProblem();
		foreach($problemList as $problem){
			$submission = new Submission;
			$submission->answer = '';
			$submission->problem_id = $problem->id;
			$submission->contest_submission_id = $contestSubModel->id;
		}
	}
}
