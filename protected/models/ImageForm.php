<?php


class ImageForm extends CFormModel
{
	public $image;

	 public function rules()
    {
        return array(
            array('image', 'file', 'types'=>'jpg, gif, png'),
        );
    }

}
