<?php

Yii::import('ext.Utilities');

class ImageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/imageLayout';
	public $mainLayoutActive="image";
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		unlink(Utilities::getUploadedImagePath() . $this->loadModel($id)->token);
		$this->loadModel($id)->delete();
		
		$this->redirect(array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		if(isset($_GET['renderImage'])) {
			ob_clean();
			$filename = $_GET['renderImage'];
			$filepath = Utilities::getUploadedImagePath() . $_GET['renderImage'];
			header('Content-Type: '. CFileHelper::getMimeType($filepath));
			header('Content-Length: ' . filesize($filepath));
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			readfile($filepath);
			exit;
		}
		
		$criteria = new CDbCriteria;
		$criteria->condition = "uploader=" . Yii::app()->user->id;
		
		$dataProvider=new CActiveDataProvider('Image', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC',
			),
			'pagination'=>array(
				'pageSize'=>20,
			)
		));
		
		$imageForm = new ImageForm;
		
		if(isset($_POST['ImageForm'])) {
			$imageForm->attributes = $_POST['ImageForm'];
			$imageForm->image = CUploadedFile::getInstance($imageForm, 'image');
			
			if($imageForm->validate()) {
				$image = new Image;
				$image->uploader = Yii::app()->user->id;
				$image->token = Utilities::generateToken(64);
				$image->name = $imageForm->image->getName();
				
				if($image->save()) {
					$imageForm->image->saveAs(Utilities::getUploadedImagePath() . $image->token);
				} else {
					Yii::app()->user->setFlash('error', 'Terjadi error.');
				}
			} else {
				Yii::app()->user->setFlash('error', 'File image tidak valid,');
			}
			
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'imageForm'=>$imageForm,
		));
	}

	/**
	 * Manages all models.
	 */
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Image the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Image::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
