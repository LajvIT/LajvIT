<?php
defined('_JEXEC') or die('Restricted access'); ?>

<?php
$user = JFactory::getUser();
if (isset($this->errorMsg) && $this->errorMsg != '') {
  echo '<div style="color: red; font-weight: bold;">' . JText::_($this->errorMsg) . '</div><br><br>';
}
if (isset($this->message) && $this->message != '') {
  if (isset($this->character)) {
    echo JText::_($this->message) . ": " . $this->character;
  } else {
    echo JText::_($this->message);
  }
  echo "<br><br>";
}
?>
  <table>
    <tbody>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_NAME');?>:</strong></td>
        <td><?php echo $this->groupName; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION');?>:</strong></td>
        <td><?php echo $this->groupDescription; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_MAX_NO_MEMBERS');?>:</strong></td>
        <td><?php echo $this->groupMaxParticipants; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_EXPECTED_NO_MEMBERS');?>:</strong></td>
        <td><?php echo $this->groupExpectedParticipants; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_INFO_FOR_ORGANIZER');?>:</strong></td>
        <td><?php echo $this->groupAdminInfo; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_HOMEPAGE');?>:</strong></td>
        <td><?php echo $this->groupUrl; ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_VISIBILITY');?>:</strong></td>
        <td><?php echo $this->groupVisible ? JText::_('COM_LAJVIT_GROUP_VISIBLE') : JText::_('COM_LAJVIT_GROUP_HIDDEN'); ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_FACTION');?>:</strong></td>
        <td><?php echo $this->groupFactionName ?></td>
      </tr>
    </tbody>
  </table>
  <br /><?php
echo '  <table>    <tbody>';
echo '      <tr><td><strong style="float: left; margin-right: 5px;">' . JText::_('COM_LAJVIT_CHARACTERS') . '</strong> ';
echo '<div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=' . $this->groupId . '" title="Lägg till karaktär"></a></div>';
echo '</td></tr>';
if (isset($this->charactersInGroup)) {
  foreach ($this->charactersInGroup as $character) {
    echo '<tr><td>';
    echo '<div class="text">';
    echo $character->knownas . " - " . $character->cultureName . ", " . $character->conceptName;
    echo '</div>';
    echo '<div class="icon info"><a class="icon" ';
    echo 'href="index.php?option=com_lajvit&view=character&eid=' . $this->eventId;
    echo '&cid=' . $character->id . '&Itemid=' . $this->itemId .'" title="Info"></a></div>';

    if ($this->lajvitModel->isCharacterOwnedByPerson($character->id, $user->id)) {
      echo '<div class="icon delete_character"><a class="icon" ';
      echo 'href="index.php?option=com_lajvit&controller=group&task=removeCharacterFromGroup';
      echo '&groupId=' . $this->groupId . '&characterId=' . $character->id;
      echo '&Itemid=' . $this->itemId . '" title="' .JText::_('COM_LAJVIT_REMOVE_CHARACTER') . '"></a></div>';
    }
  }
}
echo '</td></tr>';
echo '    </tbody>  </table>';
?>