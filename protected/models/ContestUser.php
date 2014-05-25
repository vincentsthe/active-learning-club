<?php

/**
 * This is the model class for table "contest_user".
 *
 * The followings are the available columns in table 'contest_user':
 * @property integer $id
 * @property integer $contest_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Contest $contest
 * @property User $user
 */
class ContestUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest_user';
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
			array('contest_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contest_id, user_id', 'safe', 'on'=>'search'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContestUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Delete the contest submission before deleting the user from contest
	 * 
	 * @see CActiveRecord::beforeDelete()
	 */
	protected function beforeDelete(){
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id AND user_id=:user_id';
		$criteria->params = array('contest_id'=>$this->contest_id,'user_id'=>$this->user_id);
		$contestSub = ContestSubmission::model()->find($criteria);
		if ($contestSub != null){
			$contestSub->delete();
		}
		return parent::beforeDelete();
	}

	/**
	 * return the Contest User Model based on logged in user and contest id
	 * @param contestId int the user id
	 * @return boolean
	 */
	public static function isCurrentUserRegistered($contestId){
		$contestUserModel = ContestUser::model()->getCurrentUserModel($contestId);
		if ($contestUserModel !== null)
			return $contestUserModel->approved;
		else
			return 0;
	}
	/**
	 *
	 */
	public function getCurrentUserModel($contestId){
		$criteria = new CDbCriteria;
		$criteria->condition = 'contest_id=:contest_id AND user_id=:user_id';
		$criteria->params = array('contest_id'=>$contestId,'user_id'=>Yii::app()->user->id);
		$contestUserModel = ContestUser::model()->find($criteria);
		return $contestUserModel;
	}
	/**
	 * approve current contestant
	 */
	public function approveUser(){
		if ($this !== null){
			$this->approved = 1;
			$this->save();
		}
	}
	/**
	 * deny current contestant
	 */
	public function denyUser(){
		if ($this !== null){
			$this->approved = 0;
			$this->save();
		}
	}
}
