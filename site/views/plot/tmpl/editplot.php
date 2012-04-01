<?php
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
            Metarubrik: <input type="text" name="heading" value="<?php echo $this->heading; ?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2">
          Metainformation:<br/>
          <textarea style="width:300px; height:100px" name="description"><?php echo $this->description; ?></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2">Status: <?php
if ( ( $this->mergedrole->character_setstatus ||
        $this->mergedrole->registration_setstatus ||
        $this->mergedrole->registration_setrole ) ||
      $this->statusId == 100 || $this->statusId == 101 ) {
  ?>
          <select name="statusId"><?php
  foreach ($this->status as $status) {
    if ($status->id == 100 || $status->id == 101 ||
        ( $this->mergedrole->character_setstatus ||
            $this->mergedrole->registration_setstatus ||
            $this->mergedrole->registration_setrole ) ) {?>
            <option value="<?php echo $status->id; ?>" <?php
      if ($this->statusId == $status->id) {
        ?> selected="selected" <?php
      } ?> ><?php
      echo $status->name; ?>
            </option><?php
    }
  } ?>
          </select><?php
} else {
  echo $this->statusName;
}
?>
        </td>
      </tr>
      <tr>
          <td colspan="2"><?php

if ( ($this->mergedrole->character_setstatus ||
    $this->mergedrole->registration_setstatus ||
    $this->mergedrole->registration_setrole ) ||
    $this->statusId == 100 || $this->statusId == 101 ) { ?>
          <input type="submit" value="Spara ändringar" />
          <input type="hidden" name="option" value="com_lajvit" />
          <input type="hidden" name="task" value="savePlot" />
          <input type="hidden" name="controller" value="plot" />
          <input type="hidden" name="eid" value="<?php echo $this->eventId; ?>" />
          <input type="hidden" name="pid" value="<?php echo $this->plotId; ?>" />
          <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" /> <?php
} ?>
        </td>
      </tr><?php
if ($this->plotId > 0) { ?>
      <tr><td colspan="2"></td></tr>
      <tr><td colspan="2"><h2>Delintriger</h2></td></tr> <?php
  foreach ($this->plotObjects as $plotObject) {
    printPlotObjectHeaderAndDescription($plotObject, $this->eventId, $this->mergedrole, $this->statusId, $this->itemId);
    printPlotObjectRelations($plotObject->plotid, $plotObject, $this->eventId, $plotObject->characterRelations, $plotObject->conceptRelations, $plotObject->cultureRelations, $plotObject->factionRelations, $this->itemId);
  } ?>
      <tr><td colspan="2"></td></tr><?php
  if ( ($this->mergedrole->character_setstatus ||
      $this->mergedrole->registration_setstatus ||
      $this->mergedrole->registration_setrole ) ||
      $this->statusId == 100 || $this->statusId == 101 ) { ?>
      <tr>
        <td colspan="2">
          <a href="index.php?option=com_lajvit&view=plot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $this->plotId; ?>&layout=editsubplot&Itemid=<?php echo $this->itemId; ?>" title="Add subplot">Lägg till delintrig <img src="components/com_lajvit/new_character.png" alt="Lägg till" /></a>
        </td>
      </tr><?php
  }
} ?>
      <tr><td colspan="2"></td></tr>
      <tr>
        <td colspan="2">
          <a href="index.php?option=com_lajvit&view=plot&layout=listplots&eid=<?php echo $this->eventId; ?>&Itemid=<?php echo $this->itemId; ?>">
            Tillbaka
          </a>
        </td>
      </tr>
      <tr><td colspan="2"></td></tr>
      <tr>
        <td colspan="2">
          <p>Metarubrik och Metainformation är beskrivningar som kommer ses av intrigförfattaren och
            arrangören. Metarubrik ska med ett fåtal ord beskriva intrigen. Metainformationen ska
            mycket kort beskriva tanken med intrigen i stora drag. Här kan du också ange eventuell
            rekvisita och vem som ska ha den.</p>
          <p>Delintriger är texter och rubriker som kommer visas för deltagare när arrangör
            uppdaterat deras status till Distributed. Därför bör exempelvis intrigen inte avslöja
            för mycket.</p>
        </td>
      </tr>
    </tbody>
  </table>



</form>

<?php

function printPlotObjectHeaderAndDescription($plotObject, $eventId, $mergedrole, $statusId, $itemId) {
  echo "        <tr>\n";
  echo "          <td colspan=\"2\"><h3>" . $plotObject->heading;
  if ( ($mergedrole->character_setstatus ||
          $mergedrole->registration_setstatus ||
          $mergedrole->registration_setrole ) ||
        $statusId == 100 || $statusId == 101 ) {
    echo ' <a href="index.php?option=com_lajvit&view=plot&eid='. $eventId .'&pid='. $plotObject->plotid .'&layout=editsubplot&poid='. $plotObject->id .'&Itemid=' . $itemId . '" title="Edit subplot"><img src="components/com_lajvit/edit_character.png" alt="Redigera" /></a>';
  }
  echo "</h3></td>\n";
  echo "        </tr>\n";
  echo "        <tr>\n";
  echo "          <td colspan=\"2\">" . nl2br(htmlentities($plotObject->description)) . "</td>\n";
  echo "        </tr>\n";
}


function printPlotObjectRelations($plotId, $plotObject, $eventId, $characterRelations, $conceptRelations, $cultureRelations, $factionRelations, $itemId) {
  $characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
  $cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
  echo "<tr><td><h4>Karaktär";
  echo "</h4></td><td><h4>Koncept";
  echo "</h4></td></tr>\n";
  for ($i = 0; $i < $characterAndConceptHeight; $i++) {
    echo "        <tr><td>";
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
    echo "        <tr><td>";
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
