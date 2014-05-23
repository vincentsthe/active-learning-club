<?php

/**
 * UpdateContestForm class.
 * UpdateContestForm is the data structure for creating
 * the contest model with additional field
 */
class UpdateContestForm extends CFormModel
{
	public $title;
	public $start_time;
	public $end_time;
	public $duration;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('title, start_time, end_time, duration', 'required'),
			array('duration', 'numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>600),
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
			'duration'=>'Durasi',
		);
	}
}