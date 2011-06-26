<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Lägg till relation</h1>

	<table>
		<tbody>
<?php
			if ($this->relationAddedName != "") {
				echo "<tr>\n";
				echo "<td>";
				if ($this->errorMsg == true) {
					echo "Det gick inte att lägga till " . $this->relationAddedName;
				} else {
					echo $this->relationAddedName . " adderad till delintrigen";
				}
				echo "</td>";
				echo "</tr>";
			}
			foreach ($this->relationObjects as $object) {
				echo "<tr>\n";
				echo "<td>";
				echo ' <a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=' . $this->relationType . '&eid=' . $this->eventId;
				echo '&pid=' . $this->plotId . '&poid=' . $this->plotObjectId . '&oid=' . $object->id . '">';
				switch ($this->relationType) {
				case "char":
					echo $object->knownas;
					break;
				case "concept":
					echo $object->culturename . "-" . $object->name;
					break;
				default:
					echo $object->name;
					break;
				}
				echo '</a>';
				echo "</td>";
				echo "</tr>";

			}
?>
		</tbody>
	</table>


<?php

function printPlotObjectRelations($plotId, $plotObject, $eventId, $characterRelations, $conceptRelations, $cultureRelations, $factionRelations) {
	$characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
	$cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
	echo "<tr><td><h4>Karaktär</h4></td><td><h4>Koncept</h4></td></tr>\n";
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

