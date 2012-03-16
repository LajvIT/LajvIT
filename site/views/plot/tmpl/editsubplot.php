<?php
defined('_JEXEC') or die('Restricted access');
?>

<h1>Delintrig</h1>

<form action="index.php" method="post" enctype="multipart/form-data" name="plotDefaultForm">
  <table>
    <tbody>
      <tr>
        <td colspan="2">
            Rubrik: <input type="text" name="heading" value="<?php echo $this->heading; ?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2"><textarea style="width:300px; height:100px" name="description"><?php echo $this->description; ?></textarea>
      </tr>
      <tr><td colspan="2"></td></tr>
      <tr><td colspan="2"><?php
if (isAdminUser($this->mergedrole) || $this->plotEditableByCreator == 1) { ?>
  <input type="submit" value="Spara ändringar" />
  <input type="hidden" name="option" value="com_lajvit" />
  <input type="hidden" name="task" value="savePlotObject" />
  <input type="hidden" name="controller" value="plot" />
  <input type="hidden" name="eid" value="<?php echo $this->eventId; ?>" />
  <input type="hidden" name="pid" value="<?php echo $this->plotId; ?>" />
  <input type="hidden" name="poid" value="<?php echo $this->plotObjectId; ?>" />
  <input type="hidden" name="statusId" value="<?php echo $this->statusId; ?>" />
  <input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" /><?php
} ?>
      </td></tr>
      <tr><td colspan="2"></td></tr><?php
printPlotObjectRelations($this->plotId, $this->plotObject, $this->eventId,
    $this->characterRelations, $this->conceptRelations, $this->cultureRelations,
    $this->factionRelations, $this->mergedrole, $this->itemId); ?>
      <tr><td colspan="2"></td></tr>
      <tr>
        <td colspan="2">
          <a href="index.php?option=com_lajvit&view=plot&layout=editplot&eid=<?php echo $this->eventId; ?>&pid=<?php echo $this->plotId; ?>&Itemid=<?php echo $this->itemId; ?>">
            Tillbaka
          </a>
        </td>
      </tr>
    </tbody>
  </table>
</form>

<?php

function printPlotObjectRelations($plotId, $plotObject, $eventId, $characterRelations,
    $conceptRelations, $cultureRelations, $factionRelations, $mergedRole, $itemId) {
  $characterAndConceptHeight = max(count($characterRelations), count($conceptRelations));
  $cultureAndFactionHeight = max(count($cultureRelations), count($factionRelations));
  echo "<tr><td><h4>Karaktär";
    echo ' <a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=char&eid=' . $eventId;
    echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&Itemid=' . $itemId . '">';
    echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';
  echo "</h4></td><td><h4>Koncept";
    echo ' <a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=concept&eid=' . $eventId;
    echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&Itemid=' . $itemId . '">';
    echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';
  echo "</h4></td></tr>\n";
  for ($i = 0; $i < $characterAndConceptHeight; $i++) {
    echo "        <tr><td>";
    if (array_key_exists($i, $characterRelations)) {
      echo $characterRelations[$i]->name;
        echo ' <a href="index.php?option=com_lajvit&view=plot&layout=deletesubplotrelation&rel=char&eid=' . $eventId;
        echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&relid=' . $characterRelations[$i]->id . '&Itemid=' . $itemId . '" title="Delete">';
        echo '<img src="components/com_lajvit/delete.gif" alt="Ta bort" /></a>';
    }
    echo "</td><td>";
    if (array_key_exists($i, $conceptRelations)) {
      echo $conceptRelations[$i]->culturename . "-" . $conceptRelations[$i]->name;
        echo ' <a href="index.php?option=com_lajvit&view=plot&layout=deletesubplotrelation&rel=concept&eid=' . $eventId;
        echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&relid=' . $conceptRelations[$i]->id . '&Itemid=' . $itemId . '" title="Delete">';
        echo '<img src="components/com_lajvit/delete.gif" alt="Ta bort" /></a>';
    }
    echo "</td></tr>\n";
  }
  echo "<tr><td><h4>Kultur";
    echo ' <a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=culture&eid=' . $eventId;
    echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&Itemid=' . $itemId . '">';
    echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';
  echo "</h4></td><td><h4>Faktion";
    echo ' <a href="index.php?option=com_lajvit&view=plot&layout=addsubplotrelation&rel=faction&eid=' . $eventId;
    echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&Itemid=' . $itemId . '">';
    echo '<img src="components/com_lajvit/new.gif" alt="Lägg till" /></a>';
  echo "</h4></td></tr>\n";
  for ($i = 0; $i < $cultureAndFactionHeight; $i++) {
    echo "        <tr><td>";
    if (array_key_exists($i, $cultureRelations)) {
      echo $cultureRelations[$i]->name;
        echo ' <a href="index.php?option=com_lajvit&view=plot&layout=deletesubplotrelation&rel=culture&eid=' . $eventId;
        echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&relid=' . $cultureRelations[$i]->id . '&Itemid=' . $itemId . '" title="Delete">';
        echo '<img src="components/com_lajvit/delete.gif" alt="Ta bort" /></a>';
    }
    echo "</td><td>";
    if (array_key_exists($i, $factionRelations)) {
      echo $factionRelations[$i]->name;
        echo ' <a href="index.php?option=com_lajvit&view=plot&layout=deletesubplotrelation&rel=faction&eid=' . $eventId;
        echo '&pid=' . $plotId . '&poid=' . $plotObject->id . '&relid=' . $factionRelations[$i]->id . '&Itemid=' . $itemId . '" title="Delete">';
        echo '<img src="components/com_lajvit/delete.gif" alt="Ta bort" /></a>';
    }
    echo "</td></tr>\n";
  }
}

function isAdminUser($mergedRole) {
  if ($mergedRole->character_setstatus || $mergedRole->registration_setstatus || $mergedRole->registration_setrole) {
    return TRUE;
  } else {
    return FALSE;
  }
}

?>
