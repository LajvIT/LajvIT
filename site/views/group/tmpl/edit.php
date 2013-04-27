<?php
defined('_JEXEC') or die('Restricted access'); ?>

<h1>Redigera grupp</h1>
<?php
$groupStatusesAll = Array('created','approved','rejected','open','closed');
$groupStatusesCreated = Array('created');
$groupStatusesAccepted = Array('open','closed');
$groupStatusesRejected = Array('rejected');
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
<form action="index.php" method="post" name="groupCreateForm">
  <table>
    <tbody>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_NAME');?>:</strong>
        </td>
        <td><input type="text" name="groupName"
          value="<?php echo $this->groupName; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION');?>:</strong>
        </td>
        <td><textArea name="groupPublicDescription" cols="40"
        rows="5"><?php echo $this->groupPublicDescription; ?></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_DESCRIPTION_PRIVATE');?>:</strong>
        </td>
        <td><textArea name="groupPrivateDescription" cols="40"
        rows="5"><?php echo $this->groupPrivateDescription; ?></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_MAX_NO_MEMBERS');?>:</strong>
        </td>
        <td><input type="text" name="groupMaxParticipants"
          value="<?php echo $this->groupMaxParticipants; ?>" size="3"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_EXPECTED_NO_MEMBERS');?>:</strong>
        </td>
        <td><input type="text" name="groupExpectedParticipants"
          value="<?php echo $this->groupExpectedParticipants; ?>" size="3"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_INFO_FOR_ORGANIZER');?>:</strong>
        </td>
        <td><textArea name="groupAdminInfo" cols="40"
        rows="5"><?php echo $this->groupAdminInfo; ?></textArea></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_HOMEPAGE');?>:</strong>
        </td>
        <td><input type="text" name="groupUrl"
          value="<?php echo $this->groupUrl; ?>" size="40"></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_VISIBILITY');?>:</strong>
        </td>
        <td><select name="groupVisible">
            <option value="0"
            <?php echo $this->groupVisible == 0 ? "selected": "";?>>
              <?php echo JText::_('COM_LAJVIT_GROUP_HIDDEN'); ?>
            </option>
            <?php
  if ($this->groupStatus == 'open' || $this->groupStatus == 'closed') { ?>
            <option value="1"
            <?php echo $this->groupVisible == 1 ? "selected": "";?>>
              <?php echo JText::_('COM_LAJVIT_GROUP_VISIBLE'); ?>
            </option>
            <?php
  } ?>
        </select>
        </td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_STATUS');?>:</strong>
        </td>
        <td><select name="groupStatus"><?php
        if (!$canDo->get('core.edit')) {
    if ($this->groupStatus == 'created') {
      $groupStatuses = $groupStatusesCreated;
    } elseif ($this->groupStatus != 'created' && $this->groupStatus != 'rejected') {
      if ($this->groupStatus == 'approved') {
        $groupStatusesAccepted[] = 'approved';
      }
      $groupStatuses = $groupStatusesAccepted;
    } else {
      $groupStatuses = $groupStatusesRejected;
    }
  } else {
    $groupStatuses = $groupStatusesAll;
  }
  foreach ($groupStatuses as $status) {
    echo '<option value="' . $status . '"';
    if ($this->groupStatus == $status) {
      echo ' selected';
    }
    echo ' >' . JText::_('COM_LAJVIT_GROUP_STATUS_' . strtoupper($status)) . '</option>';
  }
  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_FACTION');?>:</strong>
        </td>
        <td><select name="groupFaction"><?php
        foreach ($this->factions as $faction) {
    echo '<option value="' . $faction->id . '"';
    if ($this->groupFaction == $faction->id) {
      echo ' selected';
    }
    echo ' >' . ucfirst($faction->name) . '</option>\n';
  }
  ?>
        </select></td>
      </tr>
      <tr>
        <td><strong><?php echo JText::_('COM_LAJVIT_GROUP_LEADER'); ?>:</strong>
        </td>
        <td><?php
        $first = TRUE;
        foreach ($this->groupLeaders as $groupLeader) {
          if (!$first) { echo ", "; }
          echo $groupLeader->groupLeaderPersonName;
          $first = FALSE;
        }
        ?></td>
      </tr>
    </tbody>
  </table>
  <input type="submit"
    value="<?php echo JText::_('COM_LAJVIT_GROUP_SAVE'); ?>" /> <input
    type="hidden" name="option" value="com_lajvit" /> <input type="hidden"
    name="task" value="edit" /> <input type="hidden" name="controller"
    value="group" /> <input type="hidden" name="eventId"
    value="<?php echo $this->eventId; ?>" /> <input type="hidden"
    name="groupId" value="<?php echo $this->groupId; ?>" /> <input
    type="hidden" name="groupLeaderPersonId"
    value="<?php echo $this->groupLeaderPersonId; ?>" /> <input
    type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" /> <br />
  <br />
  <?php
  echo '  <table>    <tbody>';
  echo '      <tr><td><strong style="float: left; margin-right: 5px;">' . JText::_('COM_LAJVIT_CHARACTERS') . '</strong> ';
  echo '<div class="icon new_character"><a class="icon" href="index.php?option=com_lajvit&view=group&layout=addchartogroup&groupId=' . $this->groupId . '&Itemid=' . $this->itemId . '" title="' .  JText::_('COM_LAJVIT_ADD_CHARACTER') . '"></a></div>';
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
    echo '<div class="text">';
    if (!$character->approvedMember) {
      echo '<div class="icon new_character"><a class="icon" ';
      echo 'href="index.php?option=com_lajvit&controller=group&task=approveMembership';
      echo '&groupId=' . $this->groupId . '&characterId=' . $character->id;
      echo '&Itemid=' . $this->itemId . '" title="' .JText::_('COM_LAJVIT_GROUP_APPROVE_MEMBER') . '"></a></div>';
    }
    echo '</div>';


    echo '<div class="icon delete_character"><a class="icon" ';
    echo 'href="index.php?option=com_lajvit&controller=group&task=removeCharacterFromGroup';
    echo '&groupId=' . $this->groupId . '&characterId=' . $character->id;
    echo '&Itemid=' . $this->itemId . '" title="' .JText::_('COM_LAJVIT_REMOVE_CHARACTER') . '"></a></div>';
  }
}
echo '</td></tr>';
echo '    </tbody>  </table>';
?>

</form>
