<?php

/**
 * This is the model class for table "problem".
 *
 * The followings are the available columns in table 'problem':
 * @property integer $id
 * @property integer $contest_id
 * @property string $answer
 * @property integer $correct_score
 * @property integer $wrong_score
 * @property integer $blank_score
 * @property integer $anulir
 * @property string $content
 * @property string $type
 * @property string $discussion
 *
 * The followings are the available model relations:
 * @property Contest $contest
 * @property ProblemChoice $problemChoice
 * @property ProblemEssay $problemEssay
 * @property ProblemShort $problemShort
 * @property Submission[] $submissions
 */
class Problem extends CActiveRecord
{
	const MULTIPLE_CHOICE = 'choice';
	const SHORT_ANSWER = 'short';
	const ESSAY = 'essay';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'problem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('contest_id, correct_score, wrong_score, blank_score, anulir, content', 'required'),
			array('contest_id, correct_score, wrong_score, blank_score, anulir', 'numerical', 'integerOnly'=>true),
			array('answer', 'length', 'max'=>100),
			array('type', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contest_id, answer, correct_score, wrong_score, blank_score, anulir, type', 'safe', 'on'=>'search'),
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
			'problemChoice' => array(self::HAS_ONE, 'ProblemChoice', 'id'),
			'problemEssay' => array(self::HAS_ONE, 'ProblemEssay', 'id'),
			'problemShort' => array(self::HAS_ONE, 'ProblemShort', 'id'),
			'submissions' => array(self::HAS_MANY, 'Submission', 'problem_id'),
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
			'answer' => 'Answer',
			'correct_score' => 'Correct Score',
			'wrong_score' => 'Wrong Score',
			'blank_score' => 'Blank Score',
			'anulir' => 'Anulir',
			'content' => 'Content',
			'type' => 'Type',
			'discussion'=> 'Pembahasan',
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
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('correct_score',$this->correct_score);
		$criteria->compare('wrong_score',$this->wrong_score);
		$criteria->compare('blank_score',$this->blank_score);
		$criteria->compare('anulir',$this->anulir);
		//$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Problem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/* Delete all problem instance belong to this contest
	 * after deleting the contest.
	 * 
	 * @see CActiveRecord::afterDelete()
	 */
	public function beforeDelete(){
		$childModel;

		switch ($this->type) {
			case Problem::MULTIPLE_CHOICE:
				$childModel = ProblemChoice::model()->findByPk($this->id);
				break;
			case Problem::SHORT_ANSWER:
				$childModel = ProblemShort::model()->findByPk($this->id);
				break;
			case Problem::ESSAY:
				$childModel = ProblemEssay::model()->findByPk($this->id);
				break;
			default:
				# code...
				break;
		}
		$childModel->delete();
	}

	public function isMultipleChoice(){
		return $this->type == Self::MULTIPLE_CHOICE;
	}

	public function isShortAnswer(){
		return $this->type == Self::SHORT_ANSWER;
	}

	public function isEssay(){
		return $this->type == Self::ESSAY;
	}

	public function convertToArray(){
		$retval = array();
		
		$childModel = null;
		switch ($this->type) {
			case Problem::MULTIPLE_CHOICE:
				$childModel = $this->problemChoice;
				break;
			case Problem::SHORT_ANSWER:
				$childModel = $this->problemShort;
				break;
			case Problem::ESSAY:
				$childModel = $this->problemEssay;
				break;
			default:
				# code...
				break;
		}
		foreach($this->getAttributes() as $key=>$value){
			$retval[$key] = $value;
		}
		foreach($childModel as $key=>$value){
			$retval[$key] = $value;
		}
		return $retval;
	}
}
