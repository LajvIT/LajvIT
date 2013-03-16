<?php
defined('_JEXEC') or die('Restricted access'); ?>

<?php
$user = JFactory::getUser();
$canDo = GroupHelper::getActions($this->groupId);
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
        <td><div class="text"><?php echo $this->groupName; ?></div><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $this->groupLeaderPersonId == $user->id) { ?>
      <div class="icon edit_group"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=edit&groupId=<?php echo $this->groupId; ?>&Itemid=<?php echo $this->itemId; ?>" title="<?php echo JText::_('COM_LAJVIT_GROUP_EDIT'); ?>"></a></div><?php
  }
  ?>

      </td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION');?>:</strong></td>
        <td><?php echo $this->groupPublicDescription; ?></td>
      </tr><?php
  if ($canDo->get('core.edit') ||
      $canDo->get('core.edit.own') && $this->groupLeaderPersonId == $user->id ||
      $this->groupModel->hasPersonCharacterInGroup($user->id, $this->groupId)) { ?>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION_PRIVATE');?>:</strong></td>
        <td><?php echo $this->groupPrivateDescription; ?></td>
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
      </tr><?php
  } ?>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_FACTION');?>:</strong></td>
        <td><?php echo $this->groupFactionName ?></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_LEADER'); ?>:</strong></td>
        <td><?php echo $this->groupLeaderPersonName; ?></td>
      </tr>
    </tbody>
  </table>
  <br /><?php
echo '  <table>    <tbody>';
echo '      <tr><td><strong style="float: left; margin-right: 5px;">' . JText::_('COM_LAJVIT_CHARACTERS') . '</strong> ';
echo '<div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=' . $this->groupId . '&Itemid=' . $this->itemId . '" title="' . JText::_('COM_LAJVIT_ADD_CHARACTER') .'"></a></div>';
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
    echo '<div class="text">';
    echo ' (' . $character->personGivenName . ' ' . $character->personLastName;
    echo '</div>';
    echo '<div class="icon info"><a class="icon" ';
    echo 'href="index.php?option=com_lajvit&view=person&eid=' . $this->eventId;
    echo '&pid=' . $character->personId . '&Itemid=' . $this->itemId .'" title="Info"></a></div>';
    echo '<div class="text">';
    echo ')';
    echo '</div>';

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