<?php

/**
 * This is the model class for table "submission".
 *
 * The followings are the available columns in table 'submission':
 * @property integer $id
 * @property integer $problem_id
 * @property integer $contest_submission_id
 * @property integer $answer
 *
 * The followings are the available model relations:
 * @property Problem $problem
 * @property ContestSubmission $contestSubmission
 */
class Submission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'submission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('problem_id, contest_submission_id', 'required'),
			array('problem_id, contest_submission_id, answer', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, problem_id, contest_submission_id, answer', 'safe', 'on'=>'search'),
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
			'problem' => array(self::BELONGS_TO, 'Problem', 'problem_id'),
			'contestSubmission' => array(self::BELONGS_TO, 'ContestSubmission', 'contest_submission_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'problem_id' => 'Problem',
			'contest_submission_id' => 'Contest Submission',
			'answer' => 'Answer',
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
		$criteria->compare('problem_id',$this->problem_id);
		$criteria->compare('contest_submission_id',$this->contest_submission_id);
		$criteria->compare('answer',$this->answer);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Submission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
