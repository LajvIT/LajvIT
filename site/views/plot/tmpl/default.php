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
      <tr><td></td></tr>
      <tr><td><h2>Delintriger</h2></td></tr><?php

foreach ($this->plotObjects as $plotObject) {
  printPlotObjectHeaderAndDescription($plotObject, $eventId);
  printPlotObjectRelations($plotObject, $eventId);
}
?>
      <tr><td></td></tr>
      <tr>
        <td>
          <a href="index.php?option=com_lajvit&view=plot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $this->plotId; ?>&layout=subplot" title="Add subplot">Lägg till delintrig <img src="components/com_lajvit/new_character.png" alt="Lägg till" /></a>
        </td>
      </tr>
      <tr><td></td></tr>
    </tbody>
  </table>

<?php
if ($this->mergedrole->character_setstatus || $this->mergedrole->registration_setstatus || $this->mergedrole->registration_setrole) { ?>
  <input type="submit" value="Spara ändringar" />
  <input type="hidden" name="option" value="com_lajvit" />
  <input type="hidden" name="task" value="save" />
  <input type="hidden" name="controller" value="plot" />
  <input type="hidden" name="eid" value="<?php echo $this->eventId; ?>" />
  <input type="hidden" name="pid" value="<?php echo $this->plotId; ?>" />
  <input type="hidden" name="statusId" value="<?php echo $this->statusId; ?>" /><?php
}
?>

</form>

<?php

function printPlotObjectHeaderAndDescription($plotObject, $eventId) {
  echo "        <tr>\n";
  echo '          <td><h3>' . $plotObject->heading . '</h3>';
  echo '<a href="index.php?option=com_lajvit&view=plot&eid='. $eventId .'&pid='. $plotObject->id .'&layout=subplot" title="Edit subplot"><img src="components/com_lajvit/edit_character.png" alt="Redigera" /></a>';
  echo "</td>\n";
  echo "        </tr>\n";
  echo "        <tr>\n";
  echo "          <td>" . htmlentities($plotObject->description) . "</td>\n";
  echo "        </tr>\n";
}

function printPlotObjectRelations($plotObject) {
  $characterRelations = array();
  $conceptRelations = array();
  $cultureRelations = array();
  $factionRelations = array();

  $characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
  $cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
  echo "<tr><td><h4>Karaktär</h4></td><td><h4>Koncept</h4></td></tr>\n";
  for ($i = 0; $i < $characterAndConceptHeight; $i++) {
    echo "        <tr><td>";
    if (array_key_exists($i, $characterRelations)) {
      echo $characterRelations[$i];
    }
    echo "</td><td>";
    if (array_key_exists($i, $conceptRelations)) {
      echo $conceptRelations[$i];
    }
    echo "</td></tr>\n";
  }
  echo "<tr><td><h4>Kultur</h4></td><td><h4>Faktion</h4></td></tr>\n";
  for ($i = 0; $i < $cultureAndFactionHeight; $i++) {
    echo "        <tr><td>";
    if (array_key_exists($i, $cultureRelations)) {
      echo $cultureRelations[$i];
    }
    echo "</td><td>";
    if (array_key_exists($i, $factionRelations)) {
      echo $factionRelations[$i];
    }
    echo "</td></tr>\n";
  }
}

?>
