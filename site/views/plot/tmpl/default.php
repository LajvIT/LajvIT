<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Intrig</h1>

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
 				<tr><td>plots</td></tr>

<?php
				foreach ($this->plotObjects as $plotObject) {
					printPlotObjectHeaderAndDescription($plotObject);
					printPlotObjectRelations($plotObject);
				}
?>

		</tbody>
	</table>


<?php
	if ($this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus || $this->mergedrole->registration_setrole) {
?>
	<input type="submit" value="Spara ändringar" />
	<input type="hidden" name="option" value="com_lajvit" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="controller" value="plot" />
	<input type="hidden" name="eid" value="<? echo $this->eventid; ?>" />
	<input type="hidden" name="pid" value="<? echo $this->plotId; ?>" />
	<input type="hidden" name="statusId" value="<? echo $this->statusId; ?>" />
<?php
	}
?>

</form>

<?php

function printPlotObjectHeaderAndDescription($plotObject) {
	echo "				<tr>\n";
	echo "					<td>" . $plotObject->heading . "</td>\n";
	echo "				</tr>\n";
	echo "				<tr>\n";
	echo "					<td>" . htmlentities($plotObject->description) . "</td>\n";
	echo "				</tr>\n";
}

function printPlotObjectRelations($plotObject) {

}

?>

