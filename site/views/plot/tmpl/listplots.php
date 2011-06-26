<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intriger</h1>

<table>
	<tbody style="vertical-align: top;">

<?php
			foreach ($this->plots as $plot) {
				if ($this->debug) { print_r($plot); echo "setstatus:".$this->mergedrole->character_setstatus . ",creator:". $plot->creatorpersonid .",person:" .$this->person->id ; }
				if ($this->mergedrole->character_setstatus || $plot->creatorpersonid == $this->person->id ) {
				?>
		<tr>
			<td>
				<a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $plot->id; ?>">
					<?php echo $plot->heading;?>
				</a>
			</td>
			<td><?php echo $plot->statusname; ?></td>
			<td><?php echo $plot->plotCreatorName; ?></td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left: 20px;"><?php echo nl2br($plot->description); ?></td>
		</tr>
<?php 	}
			} ?>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td colspan="2">
			<a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>">
					Lägg till ny intrig
				</a>
		</td></tr>

	</tbody>
</table>

