<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
?>

<h1><?php echo JText::_('COM_LAJVIT_GROUP_ADD_LEADER'); ?></h1>

  <table>
    <tbody>
      <?php
foreach ($this->persons as $object) {
  if (in_array($object->id, $this->leadersInGroup)) {
    continue;
  }
  echo "<tr>\n";
  echo "<td>";
  echo ' <a href="index.php?option=com_lajvit&controller=group&task=addLeaderToGroup';
  echo '&groupId=' . $this->groupId . '&personId=' . $object->id . '&Itemid=' . $this->itemId . '">';
  echo $object->givenname . ' ' . $object->surname;
  echo '</a>';
  echo "</td>";
  echo "</tr>";
}
?>
    </tbody>
  </table>

