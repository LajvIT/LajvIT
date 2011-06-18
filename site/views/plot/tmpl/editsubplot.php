<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Delintrig</h1>

<form action="index.php" method="post" enctype="multipart/form-data" name="plotDefaultForm">
	<table>
		<tbody>
			<tr>
				<td >
						Rubrik: <input type="text" name="heading" value="<?php echo $this->heading; ?>" />
				</td>
			</tr>
			<tr>
				<td><textarea style="width:300px; height:100px" name="description"><?php echo $this->description; ?></textarea>
			</tr>
			<tr><td></td></tr>
<?php
					printPlotObjectRelations($this->plotId, $this->plotObject, $this->eventId, $this->characterRelations, $this->conceptRelations, $this->cultureRelations, $this->factionRelations);
?>
			<tr><td></td></tr>
		</tbody>
	</table>

<?php
	if ($this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus || $this->mergedrole->registration_setrole) {
?>
	<input type="submit" value="Spara ändringar" />
	<input type="hidden" name="option" value="com_lajvit" />
	<input type="hidden" name="task" value="savePlotObject" />
	<input type="hidden" name="controller" value="plot" />
	<input type="hidden" name="eid" value="<? echo $this->eventId; ?>" />
	<input type="hidden" name="pid" value="<? echo $this->plotId; ?>" />
	<input type="hidden" name="poid" value="<? echo $this->plotObjectId; ?>" />
<?php
	}
?>

</form>

<?php

function printPlotObjectRelations($plotId, $plotObject, $eventId, $characterRelations, $conceptRelations, $cultureRelations, $factionRelations) {
	$characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
	$cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
	echo "<tr><td><h4>Karaktär</h4>";

	echo '<a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=char&eid=' . $eventId;
	echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '">';
	echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';

	echo "</td><td><h4>Koncept</h4>";
	echo '<a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=concept&eid=' . $eventId;
	echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '">';
	echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';
	echo "</td></tr>\n";
	for ($i = 0; $i < $characterAndConceptHeight; $i++) {
		echo "				<tr><td>";
		if (array_key_exists($i, $characterRelations)) {
			echo $characterRelations[$i]->name;
			echo ' <a href="index.php?option=com_lajvit&view=plot&layout=deletesubplotrelation&rel=char&eid=' . $eventId;
			echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&relid=' . $characterRelations[$i]->id . '" title="Delete">';
			echo '<img src="components/com_lajvit/delete.gif" alt="Ta bort" /></a>';
		}
		echo "</td><td>";
		if (array_key_exists($i, $conceptRelations)) {
			echo $conceptRelations[$i]->name;
		}
		echo "</td></tr>\n";
	}
	echo "<tr><td><h4>Kultur</h4></td><td><h4>Faktion</h4></td></tr>\n";
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

