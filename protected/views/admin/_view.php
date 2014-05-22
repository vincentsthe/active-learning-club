<?php
/* @var $this AdminController */
/* @var $data Admin */
?>

<tr>
	<td><?php echo $data->id ?></td>
	<td><?php echo $data->username ?></td>
	<td><?php echo $data->fullname ?></td>
	<td><?php echo $data->getBidangName() ?></td>
</tr>