<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intrig</h1>

<form action="index.php" method="post" enctype="multipart/form-data" name="plotDefaultForm">
	<table>
		<tbody>
			<tr>
				<td colspan="2">
						Skapad av: <?php echo $this->plotCreatorName; ?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
						Rubrik: <input type="text" name="heading" value="<?php echo $this->heading; ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2"><textarea style="width:300px; height:100px" name="description"><?php echo $this->description; ?></textarea>
			</tr>
			<tr>
				<td colspan="2">Status: <?php
	if ( ( $this->mergedrole->character_setstatus ||
					$this->mergedrole->registration_setstatus ||
					$this->mergedrole->registration_setrole ) ||
				$this->statusId == 100 || $this->statusId == 101 ) {
?>
					<select name="statusId">
<?php
		foreach ($this->status as $status) {
			if ($status->id == 100 || $status->id == 101 ||
						 ( $this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus || $this->mergedrole->registration_setrole ) ) {
	?>
						<option value="<?echo $status->id; ?>" <?php if ($this->statusId == $status->id) { ?> selected="selected" <?php } ?> >
<?php												echo $status->name; ?>
						</option>
<?php
			}
		}
		?>
					</select>
<?php
	} else {
		echo $this->statusName;
	}
?>
				</td>
			</tr>
			<tr>
					<td colspan="2">

			<?php
	if ( ($this->mergedrole->character_setstatus ||
					$this->mergedrole->registration_setstatus ||
					$this->mergedrole->registration_setrole ) ||
				$this->statusId == 100 || $this->statusId == 101 ) {

?>
					<input type="submit" value="Spara ändringar" />
					<input type="hidden" name="option" value="com_lajvit" />
					<input type="hidden" name="task" value="savePlot" />
					<input type="hidden" name="controller" value="plot" />
					<input type="hidden" name="eid" value="<? echo $this->eventId; ?>" />
					<input type="hidden" name="pid" value="<? echo $this->plotId; ?>" />

<?php
	}
?>
				</td>
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr><td colspan="2"><h2>Delintriger</h2></td></tr>

<?php
				foreach ($this->plotObjects as $plotObject) {
					printPlotObjectHeaderAndDescription($plotObject, $this->eventId, $this->mergedrole, $this->statusId);
					printPlotObjectRelations($plotObject->plotid, $plotObject, $this->eventId, $plotObject->characterRelations, $plotObject->conceptRelations, $plotObject->cultureRelations, $plotObject->factionRelations);
				}
?>
			<tr><td colspan="2"></td></tr><?php
				if ( ($this->mergedrole->character_setstatus ||
						$this->mergedrole->registration_setstatus ||
						$this->mergedrole->registration_setrole ) ||
					$this->statusId == 100 || $this->statusId == 101 ) {
			?>
			<tr>
				<td colspan="2">
					<a href="index.php?option=com_lajvit&view=plot&eid=<? echo $this->eventId; ?>&pid=<? echo $this->plotId; ?>&layout=editsubplot" title="Add subplot">Lägg till delintrig <img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>
				</td>
			</tr><?php
				}
				?>
			<tr><td colspan="2"></td></tr>
			<tr>
				<td colspan="2">
					<a href="index.php?option=com_lajvit&view=plot&layout=listplots&eid=<?php echo $this->eventId; ?>">
						Tillbaka
					</a>
				</td>
			</tr>
		</tbody>
	</table>



</form>

<?php

function printPlotObjectHeaderAndDescription($plotObject, $eventId, $mergedrole, $statusId) {
	echo "				<tr>\n";
	echo "					<td colspan=\"2\"><h3>" . $plotObject->heading;
	if ( ($mergedrole->character_setstatus ||
					$mergedrole->registration_setstatus ||
					$mergedrole->registration_setrole ) ||
				$statusId == 100 || $statusId == 101 ) {
		echo ' <a href="index.php?option=com_lajvit&view=plot&eid='. $eventId .'&pid='. $plotObject->plotid .'&layout=editsubplot&poid='. $plotObject->id .'" title="Edit subplot"><img src="components/com_lajvit/edit.gif" alt="Redigera" /></a>';
	}
	echo "</h3></td>\n";
	echo "				</tr>\n";
	echo "				<tr>\n";
	echo "					<td>" . htmlentities($plotObject->description) . "</td>\n";
	echo "				</tr>\n";
}


function printPlotObjectRelations($plotId, $plotObject, $eventId, $characterRelations, $conceptRelations, $cultureRelations, $factionRelations) {
	$characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
	$cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
	echo "<tr><td><h4>Karaktär";
	echo "</h4></td><td><h4>Koncept";
	echo "</h4></td></tr>\n";
	for ($i = 0; $i < $characterAndConceptHeight; $i++) {
		echo "				<tr><td>";
		if (array_key_exists($i, $characterRelations)) {
			echo $characterRelations[$i]->name;
		}
		echo "</td><td>";
		if (array_key_exists($i, $conceptRelations)) {
			echo $conceptRelations[$i]->culturename . "-" . $conceptRelations[$i]->name;
		}
		echo "</td></tr>\n";
	}
	echo "<tr><td><h4>Kultur";
	echo "</h4></td><td><h4>Faktion";
	echo "</h4></td></tr>\n";
	for ($i = 0; $i < $cultureAndFactionHeight; $i++) {
		echo "				<tr><td>";
		if (array_key_exists($i, $cultureRelations)) {
			echo $cultureRelations[$i]->name;
		}
		echo "</td><td>";
		if (array_key_exists($i, $factionRelations)) {
			echo $factionRelations[$i]->name;
		}
		echo "</td></tr>\n";
	}
}

?>

