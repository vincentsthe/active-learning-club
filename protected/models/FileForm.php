<?php


class FileForm extends CFormModel
{
	public $file;

	 public function rules()
    {
        return array(
            array('file', 'file'),
        );
    }

}
