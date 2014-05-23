<?php

/**
 * This is the model class for table "problem".
 *
 * The followings are the available columns in table 'problem':
 * @property integer $id
 * @property string $content
 * @property string $option_a
 * @property string $option_b
 * @property string $option_c
 * @property string $option_d
 * @property string $option_e
 * @property integer $answer
 * @property integer $contest_id
 * @property integer $anulir
 *
 * The followings are the available model relations:
 * @property Contest $contest
 * @property Submission[] $submissions
 */
class Problem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'problem_choice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('answer, contest_id, anulir', 'numerical', 'integerOnly'=>true),
			array('content, option_a, option_b, option_c, option_d, option_e', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, content, option_a, option_b, option_c, option_d, option_e, answer, contest_id, anulir', 'safe', 'on'=>'search'),
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
			'content' => 'Content',
			'option_a' => 'Option A',
			'option_b' => 'Option B',
			'option_c' => 'Option C',
			'option_d' => 'Option D',
			'option_e' => 'Option E',
			'answer' => 'Answer',
			'contest_id' => 'Contest',
			'anulir' => 'Anulir',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('option_a',$this->option_a,true);
		$criteria->compare('option_b',$this->option_b,true);
		$criteria->compare('option_c',$this->option_c,true);
		$criteria->compare('option_d',$this->option_d,true);
		$criteria->compare('option_e',$this->option_e,true);
		$criteria->compare('answer',$this->answer);
		$criteria->compare('contest_id',$this->contest_id);
		$criteria->compare('anulir',$this->anulir);

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
}
