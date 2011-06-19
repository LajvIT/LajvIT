<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intriger</h1>

<form action="index.php" method="post" enctype="multipart/form-data" name="plotDefaultForm">
	<table>
		<tbody>

<?php
			foreach ($this->plots as $plot) {
				if ($this->mergedrole->character_setstatus || $plot->creatorpersonid == $this->person->id ) {
				?>
			<tr>
				<td>
					<a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $plot->id; ?>">
						<?php echo $plot->heading;?>
					</a>
				</td><td><?php echo $plot->description; ?></td>
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
<?php
	if ($this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus || $this->mergedrole->registration_setrole) {
?>
	<input type="hidden" name="option" value="com_lajvit" />
	<input type="hidden" name="controller" value="plot" />
	<input type="hidden" name="eid" value="<? echo $this->eventId; ?>" />
<?php
	}
?>
</form>

