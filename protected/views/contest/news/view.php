<?php
/* @var $this ContestController */
/* @var $model Contest */
?>
<?php $this->renderPartial('_header',array('model'=>$model)); ?>
<?php $this->renderPartial('_menubar',array('activeMenuBar'=>'news')); ?>
<?php
	if ($listAnnouncement==null){
		echo "<br><i><center>Belum ada pengumuman</center></i>";
	} else {
		foreach($listAnnouncement as $announcement){
		echo "<h3>".$announcement->title."</h3><br>";
		echo "Ditulis oleh ".$announcement->author_id." pada ".Utilities::secondsToFormattedDate($announcement->created_date)."<br>";
		echo $announcement->content;
		}
	}
	
?>
