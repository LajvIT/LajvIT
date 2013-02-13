<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Lägg till karaktär till gruppen</h1>

<?php
if (array_key_exists('charName', $this) && $this->charName != "") {
  if ($this->errorMsg == TRUE) {
    echo "Det gick inte att lägga till " . $this->charName;
  } else {
    echo $this->charName . " adderad till gruppen";
  }
  echo "<br/>\n";
}
?>

  <table>
    <tbody>
      <?php
foreach ($this->characters as $object) {
  echo "<tr>\n";
  echo "<td>";
  echo ' <a href="index.php?option=com_lajvit&controller=group&task=addCharacterToGroup&eid=' . $this->eventId;
  echo '&gid=' . $this->groupId . '&cid=' . $object->id . '&Itemid=' . $this->itemId . '">';
  echo $object->knownas;
  echo '</a>';
  echo "</td>";
  echo "</tr>";

}
?>
    </tbody>
  </table>

