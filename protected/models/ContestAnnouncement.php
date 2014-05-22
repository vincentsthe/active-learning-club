<?php

/**
 * This is the model class for table "contest_announcement".
 *
 * The followings are the available columns in table 'contest_announcement':
 * @property integer $id
 * @property string $title
 * @property integer $contest_id
 * @property integer $author_id
 * @property string $created_date
 * @property string $content
 *
 * The followings are the available model relations:
 * @property Contest $contest
 * @property Admin $author
 */
class ContestAnnouncement extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contest_announcement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contest_id, author_id, created_date', 'required'),
			array('contest_id, author_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('created_date', 'length', 'max'=>10),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, contest_id, author_id, created_date, content', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'Admin', 'author_id'),
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
			'contest_id' => 'Contest',
			'author_id' => 'Author',
			'created_date' => 'Created Date',
			'content' => 'Content',
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
		$criteria->compare('contest_id',$this->contest_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContestAnnouncement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
