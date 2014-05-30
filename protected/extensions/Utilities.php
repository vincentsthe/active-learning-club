<?php

Yii::import('ext.CTextHelper');
/**
 * This class list all utilities needed by the application
 * 
 * @author vincentsthe
 *
 */
class Utilities {
	
	/**
	 * Convert the string $formattedDate into timestamp
	 * The formattedDate is assumed to have format "%d-%m-%Y %H:%M"
	 * 
	 * @param string $formattedDate
	 * @return number timestamp
	 */
	public function formattedDateToTimestamp($formattedDate) {
		//$time = strptime($formattedDate, "%d-%m-%Y %H:%M");
		//return mktime($time['tm_hour'], $time['tm_min'], 0, $time['tm_mon'] + 1, $time['tm_mday'], $time['tm_year'] + 1900);
		$time = array();
		sscanf($formattedDate, "%d-%d-%d %d:%d",$time['tm_mday'],$time['tm_mon'],$time['tm_year'],$time['tm_hour'],$time['tm_min']);
		return mktime($time['tm_hour'], $time['tm_min'], 0, $time['tm_mon'], $time['tm_mday'], $time['tm_year']);
	}
	
	/**
	 * Convert timestamp to formatted date.
	 * Date format is "%d-%m-%Y %H:%M"
	 * 
	 * @param int $timestamp 	timestamp to be converted
	 * @return string			Formatted date
	 */
	public function timestampToFormattedDate($timestamp) {
		return date('d-m-Y G:i', $timestamp);
	}
	/**
	 * Convert seconds to formatted date.
	 * @param int $seconds tau lah ya
	 * @return string
	 */
	public function secondsToFormattedDate($seconds){
		return Utilities::timestampToFormattedDate(mktime(0,0,$seconds,0,0,0));
	}
	
	public function generateToken($length = 64) {
		return CTextHelper::random('alnum', $length);;
	}
	
	public function getUploadedImagePath() {
		return Yii::app()->basePath . '/../images/uploaded/';
	}
	
	public function getEssaySubmissionPath() {
		return Yii::app()->basePath . '/../images/essay/';
	}
	
}