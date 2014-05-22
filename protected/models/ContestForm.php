<?php

/**
 * ContestForm class.
 * ContestForm is the data structure for creating
 * the contest model with additional field
 */
class ContestForm extends CFormModel
{
	public $title;
	public $start_time;
	public $end_time;
	public $duration;
	public $correct_score;
    public $wrong_score;
    public $blank_score;
	public $problemCount;
	public $type;
	public $sifat;
    public $bidang;
    public $description;

    const DEFAULT_DURATION = 60;
    const DEFAULT_CORRECT_SCORE = 1;
    const DEFAULT_WRONG_SCORE = 0;
    const DEFAULT_BLANK_SCORE = 0;
    const DEFAULT_PROBLEM_COUNT = 5;
	
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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, start_time, end_time, duration, correct_score, wrong_score, bidang, description, sifat', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'title'=>'Judul',
			'start_time'=>'Waktu Mulai',
			'end_time'=>'Waktu Selesai',
			'duration'=>'Durasi (menit)',
			'problemCount'=>'Jumlah Soal',
			'correct_score'=>'Skor benar',
			'wrong_score'=>'Skor salah',
			'bidang'=>'Bidang',
			'description'=>'description',
			'type'=>'Tipe Soal',
			'sifat'=>'Sifat'
		);
	}

}