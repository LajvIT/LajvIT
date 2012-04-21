<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1>Lägg till relation</h1>

  <table>
    <tbody>
      <?php
if (array_key_exists('relationAddedName', $this) && $this->relationAddedName != "") {
  echo "<tr>\n";
  echo "<td>";
  if ($this->errorMsg == TRUE) {
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
  echo '&pid=' . $this->plotId . '&poid=' . $this->plotObjectId . '&oid=' . $object->id . '&Itemid=' . $this->itemId . '">';
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

