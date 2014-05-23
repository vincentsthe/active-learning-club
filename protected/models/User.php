<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $fullname
 * @property string $school
 * @property integer $is_admin
 * @property integer $is_teacher
 *
 * The followings are the available model relations:
 * @property ContestAnnouncement[] $contestAnnouncements
 * @property ContestSubmission[] $contestSubmissions
 * @property Contest[] $contests
 * @property Image[] $images
 */
class User extends CActiveRecord
{
	const ADMIN = 0;
	const TEACHER = 1;
	const CONTESTANT = 2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, fullname, school', 'required'),
			array('is_admin, is_teacher', 'numerical', 'integerOnly'=>true),
			array('username, password, email, fullname, school', 'length', 'max'=>127),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, fullname, school, is_admin, is_teacher', 'safe', 'on'=>'search'),
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
			'contestAnnouncements' => array(self::HAS_MANY, 'ContestAnnouncement', 'author_id'),
			'contestSubmissions' => array(self::HAS_MANY, 'ContestSubmission', 'user_id'),
			'contestUsers' => array(self::HAS_MANY, 'ContestUser', 'user_id'),
			'contests' => array(self::MANY_MANY, 'Contest', 'contest_user(user_id, contest_id)'),
			'images' => array(self::HAS_MANY, 'Image', 'uploader'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'is_admin' => 'Admin',
			'is_teacher' => 'Pengajar',
			'fullname' => 'Fullname',
			'school' => 'School',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('school',$this->school,true);
		$criteria->compare('is_admin',$this->is_admin);
		$criteria->compare('is_teacher',$this->is_teacher);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * validate the password
	 */
	public function validatePassword($password){
		$user = User::model()->find('username=:username', array('username'=>$this->username));
		return $user->password == sha1($password);
	}


}
