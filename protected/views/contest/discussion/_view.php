<?php
if (isset($problem)){
	echo $problem->content;
	echo "<br>";
	echo "Answer : $problem->answer<br><br>";
	if ($problem->discussion !== '')
		echo "Discussion : $problem->discussion";
	else
		echo "<i>Tidak ada pembahasan</i>";
}
?>
