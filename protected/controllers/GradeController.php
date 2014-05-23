<?php

/**
 * this controller will not render anything
 */
class GradeController extends Controller
{

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('delete','index','view','create','update', 'updateContestProblem', 'viewContestProblem', 'removeContestant', 'addContestant', 'rank','grade','gradeSubmission'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionManual($contestSubmissionId)
	{
		//find the updated contestSubmission field
		$contestSubmission = ContestSubmission::model()->findByPk($contestSubmissionId);
		//find the correct-wrong score
		$contest = Contest::model()->findByPk($contestSubmission->contest_id);
		
		//find all problems related to the contest. order by id (problem id)
		$criteria = new CDBCriteria;
		$criteria->order = 'id'; $criteria->condition = 'contest_id=:contest_id'; $criteria->params = array('contest_id'=>$contestId);
		$problems = Problem::model()->findAll($criteria);;
		//find all submission related to the contestSubmisssion.order by problem id
		$submissions = Submission::model()->findAll(array('order'=>'problem_id','condition'=>'contest_submission_id=:contest_submission_id','params'=>array('contest_submission_id'=>$contestSubmissionId)));
		
		$this->render('manual',array(
			'contest'=>$contest,
			'contestSubmission'=>$contestSubmission,
			'problems'=>$problems,
			'submission'=>$submissions,
			));
	}

	/*
	 * View the contest submission of the contest Id
	 */
	public function actionView($contestId)
	{
		$contestSubmissions = ContestSubmission::model()->findAll(array('condition'=>'contest_id=:contest_id','params'=>array('contest_id'=>$contestId)));
		$this->render('view',array(
				'contestSubmissions'=>$contestSubmissions,
				'contestId'=>$contestId,
			));
	}

	public function actionAuto($contestSubmissionId)
	{
		//find the updated contestSubmission field
		$contestSubmission = ContestSubmission::model()->findByPk($contestSubmissionId);
		//find the contest model field.
		$contest = Contest::model()->findByPk($contestSubmission->contest_id);
		
		//find all problems related to the contest. order by id (problem id)
		$criteria = new CDBCriteria;
		$criteria->order = 'id'; $criteria->condition = 'contest_id=:contest_id'; $criteria->params = array('contest_id'=>$contest->id);
		$problems = Problem::model()->findAll($criteria);;
		//find all submission related to the contestSubmisssion.order by problem id
		$submissions = Submission::model()->findAll(array('order'=>'problem_id','condition'=>'contest_submission_id=:contest_submission_id','params'=>array('contest_submission_id'=>$contestSubmissionId)));
		//sliding window
		$p = 0;
		$s = 0;
		$nSubmissions = count($submissions);
		$score = 0; $correct = 0; $wrong = 0; $blank = 0;

		foreach($problems as $problem){
			while ($s < $nSubmissions && $submissions[$s]->problem_id < $problem->id ){ $s++;}
			if ($s < $nSubmissions && $submissions[$s]->problem_id == $problem->id){
				echo $submissions[$s]->answer." ".$problem->answer."<br>";
				if ($submissions[$s]->answer==''){
					$blank++;
					$score += $score + $problem->blank_score;
				} else if ($submissions[$s]->answer == $problem->answer){
					$correct++;
					$score += $score + $problem->correct_score;
				} else {
					$wrong++;
					$score += $score + $problem->wrong_score;
				}
				$s++;
			}
		}
		//die($correct. " ".$wrong. " ".$blank);
		//update contestSubmission
		$contestSubmission->score = $score;
		$contestSubmission->correct = $correct;
		$contestSubmission->wrong = $wrong;
		$contestSubmission->blank = $blank;
		$contestSubmission->save();
		//die($nProblems." ".$nSubmissions);
		$this->redirect(array('view','contestId'=>$contest->id));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

}